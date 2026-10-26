<?php
if(PHP_SAPI!=='cli'||!preg_match('/^qc_demo_.*verify$/D',getenv('DB_NAME')?:'')) exit('로컬 검증 DB 전용입니다.');
ob_start(); require __DIR__.'/reporting_test.php'; ob_end_clean();
require __DIR__.'/../admin/inc/dbcon.php';
$pg_file=tempnam(sys_get_temp_dir(),'qc-recovery-');
$orders=[]; $coupon_id=null; $user_coupon=null;
// 외부 네트워크를 차단한 실제 엔드포인트를 별도 PHP 요청으로 실행한다.
function recovery_probe(array $input) {
    global $pg_file;
    $input+=['pg_file'=>$pg_file,'mode'=>'normal'];
    $process=proc_open([PHP_BINARY,'-d','disable_functions=curl_init,curl_setopt,curl_exec,curl_getinfo,curl_error,curl_close',__DIR__.'/payment_recovery_probe.php',base64_encode(json_encode($input))],[1=>['pipe','w'],2=>['pipe','w']],$pipes);
    $output=stream_get_contents($pipes[1]); $errors=stream_get_contents($pipes[2]); fclose($pipes[1]); fclose($pipes[2]);
    if(proc_close($process)!==0||$errors!=='') throw new RuntimeException($output.$errors);
    return json_decode($output,true,512,JSON_THROW_ON_ERROR);
}

// 유일한 외부 주문번호와 결제 키로 테스트 주문 및 항목을 만든다.
function recovery_order(array $courses,int $status,int $total,?int $coupon=null) {
    global $mysqli,$orders;
    $key='recovery-'.bin2hex(random_bytes(8));
    $insert=$mysqli->prepare('INSERT INTO lecture_order(mid,lid,order_id,payment_key,pay_method,total_price,status,cid) VALUES(?,?,?,?,?,?,?,?)');
    $insert->execute(['portfolio01@example.com',implode(',',$courses),$key,'pg-'.$key,'카드',$total,$status,$coupon]);
    $id=(int)$mysqli->insert_id; $orders[]=$id; $items=[];
    foreach($courses as $course) {
        $statement=$mysqli->prepare('INSERT INTO lecture_order_item(odid,lid,price,paid_price,status,refund_reason) VALUES(?,?,?,?,?,?)');
        $statement->execute([$id,$course,30000,intdiv($total,count($courses)),$status,'회귀 환불']);
        $items[]=(int)$mysqli->insert_id;
    }
    return ['id'=>$id,'key'=>$key,'payment_key'=>'pg-'.$key,'items'=>$items,'total'=>$total];
}

// PG의 실제 취소 횟수와 DB 항목 상태를 따로 검사한다.
function recovery_cancel_count() {
    global $pg_file;
    $state=json_decode(file_get_contents($pg_file),true);
    return count(array_filter($state['calls'],static fn($call)=>$call['method']==='POST'&&$call['cancel']));
}
try {
    $courses=array_map('intval',$mysqli->query("SELECT lid FROM lecture_list WHERE title LIKE '[체험]%' ORDER BY lid LIMIT 2")->fetch_all(MYSQLI_NUM)[0]);
    $course_rows=$mysqli->query("SELECT lid FROM lecture_list WHERE title LIKE '[체험]%' ORDER BY lid LIMIT 2")->fetch_all(MYSQLI_NUM);
    $courses=array_map(static fn($row)=>(int)$row[0],$course_rows);
    $order=recovery_order($courses,4,60000);
    $payment=['orderId'=>$order['key'],'paymentKey'=>$order['payment_key'],'totalAmount'=>60000,'balanceAmount'=>60000,'status'=>'DONE','cancels'=>[]];
    file_put_contents($pg_file,json_encode(['payments'=>[$order['payment_key']=>$payment],'calls'=>[],'idempotency'=>[]]));
    $post=['oiid'=>[(string)$order['items'][0]],'action'=>'approve'];
    recovery_probe(['operation'=>'refund','mode'=>'lost','post'=>$post]);
    recovery_probe(['operation'=>'refund','mode'=>'query_failed','post'=>['oiid'=>[(string)$order['items'][0]],'action'=>'reject']]);
    check_same(4,(int)$mysqli->query('SELECT status FROM lecture_order_item WHERE oiid='.$order['items'][0])->fetch_row()[0]);
    recovery_probe(['operation'=>'refund','mode'=>'query_failed','post'=>['oiid'=>[(string)$order['items'][1]],'action'=>'approve']]);
    check_same(1,recovery_cancel_count());
    check_same('success',recovery_probe(['operation'=>'refund','post'=>$post])['status']);
    check_same(1,recovery_cancel_count());
    check_same(3,(int)$mysqli->query('SELECT status FROM lecture_order_item WHERE oiid='.$order['items'][0])->fetch_row()[0]);
    check_same('success',recovery_probe(['operation'=>'refund','post'=>['oiid'=>[(string)$order['items'][1]],'action'=>'approve']])['status']);
    check_same(2,recovery_cancel_count());
    check_same(3,(int)$mysqli->query('SELECT status FROM lecture_order WHERE odid='.$order['id'])->fetch_row()[0]);
    echo "cancel recovery: lost response/reject/selection change/requery: OK\n";

    $coupon=$mysqli->prepare("INSERT INTO coupons(coupon_name,coupon_image,coupon_content,coupon_type,coupon_price,status,enddate,userid) VALUES(?,'','회귀','fixed',5000,1,'2099-12-31','portfolio_demo')");
    $coupon->execute(['[회귀] '.bin2hex(random_bytes(5))]); $coupon_id=(int)$mysqli->insert_id;
    $assign=$mysqli->prepare("INSERT INTO coupons_usercp(couponid,userid,status,use_max_date,reason) VALUES(?,'portfolio01@example.com',1,'2099-12-31','결제 회귀')");
    $assign->execute([$coupon_id]); $user_coupon=(int)$mysqli->insert_id;
    $first=recovery_order([$courses[0]],0,25000,$user_coupon);
    $second=recovery_order([$courses[1]],0,25000,$user_coupon);
    $mysqli->query('UPDATE lecture_order SET payment_key=NULL WHERE odid IN ('.$first['id'].','.$second['id'].')');
    $state=['payments'=>[],'calls'=>[],'idempotency'=>[]];
    foreach([$first,$second] as $row) $state['payments'][$row['payment_key']]=['orderId'=>$row['key'],'paymentKey'=>$row['payment_key'],'totalAmount'=>25000,'balanceAmount'=>25000,'status'=>'IN_PROGRESS','cancels'=>[]];
    file_put_contents($pg_file,json_encode($state));
    $confirm=['operation'=>'confirm','order'=>$first['key'],'payment_key'=>$first['payment_key'],'amount'=>25000];
    check_same(false,recovery_probe(array_merge($confirm,['mode'=>'invalid','payment_key'=>'invalid-key']))['paid']);
    check_same(null,$mysqli->query('SELECT payment_key FROM lecture_order WHERE odid='.$first['id'])->fetch_row()[0]);
    check_same(false,recovery_probe(array_merge($confirm,['mode'=>'confirm_lost']))['paid']);
    check_same(false,recovery_probe(['operation'=>'confirm','order'=>$second['key'],'payment_key'=>$second['payment_key'],'amount'=>25000])['paid']);
    check_same(true,recovery_probe($confirm)['paid']);
    check_same(false,recovery_probe(['operation'=>'confirm','order'=>$second['key'],'payment_key'=>$second['payment_key'],'amount'=>25000])['paid']);
    // 과거 중복 사용 이력이 있어도 다른 유효 주문이 남으면 쿠폰을 복구하지 않는다.
    $mysqli->query('UPDATE lecture_order SET status=1 WHERE odid='.$second['id']);
    $mysqli->query('UPDATE lecture_order_item SET status=1 WHERE odid='.$second['id']);
    $mysqli->query('UPDATE lecture_order SET status=4 WHERE odid='.$first['id']);
    $mysqli->query('UPDATE lecture_order_item SET status=4 WHERE odid='.$first['id']);
    check_same('success',recovery_probe(['operation'=>'refund','post'=>['oiid'=>array_map('strval',$first['items']),'action'=>'approve']])['status']);
    check_same(0,(int)$mysqli->query('SELECT status FROM coupons_usercp WHERE ucid='.$user_coupon)->fetch_row()[0]);
    echo "coupon recovery: duplicate legacy waiting orders blocked; other paid order prevents restore: OK\n";
} finally {
    foreach($orders as $id) $mysqli->query('DELETE FROM lecture_order WHERE odid='.(int)$id);
    if($user_coupon) $mysqli->query('DELETE FROM coupons_usercp WHERE ucid='.$user_coupon);
    if($coupon_id) $mysqli->query('DELETE FROM coupons WHERE cid='.$coupon_id);
    unlink($pg_file);
}

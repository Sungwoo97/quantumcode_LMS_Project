<?php
if (PHP_SAPI !== 'cli' || getenv('DEMO_MODE') !== '1' || !preg_match('/^qc_demo_.*verify$/D', getenv('DB_NAME') ?: '')) {
    exit('로컬 검증 DB 전용입니다.');
}
ob_start();
require __DIR__ . '/reporting_test.php';
ob_end_clean();
require __DIR__ . '/../admin/inc/dbcon.php';
// 실제 요청 처리와 HTML 화면을 별도 세션으로 실행하고 외부 PG 호출은 금지한다.
function request_probe(string $file, array $post = [], bool $token = true) {
    $root=dirname(__DIR__);
    $code='function curl_init($url=null) { throw new RuntimeException("PG 호출 금지"); } session_start(); '
        . '$_SERVER["REQUEST_METHOD"]="POST"; $_SERVER["HTTP_HOST"]="localhost"; $_SERVER["REMOTE_ADDR"]="192.0.2.123"; '
        . '$_SERVER["DOCUMENT_ROOT"]=' . var_export(dirname($root),true) . '; '
        . '$_SESSION=' . var_export(['MemEmail'=>'portfolio01@example.com','MemId'=>1,'MUNAME'=>'체험학습자1','qc_csrf_token'=>str_repeat('b',64)],true) . '; '
        . '$_POST=' . var_export(array_merge($post,['csrf_token'=>$token ? str_repeat('b',64) : '']),true) . '; '
        . 'require ' . var_export($root . '/' . $file,true) . ';';
    $process=proc_open([PHP_BINARY,'-d','disable_functions=curl_init','-r',$code],[1=>['pipe','w'],2=>['pipe','w']],$pipes);
    $output=stream_get_contents($pipes[1]);
    $errors=stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    if(proc_close($process)!==0 || $errors!=='') {
        throw new RuntimeException($output . $errors);
    }
    return $output;
}
foreach(['lecture/lecture_payment.php','users/refund_request_ok.php','admin/sales/order_refund_ok.php','lecture/lecture_order_del.php'] as $file) {
    check_same('error',json_decode(request_probe($file,[],false),true,512,JSON_THROW_ON_ERROR)['status']);
}
$order=$mysqli->query("SELECT * FROM lecture_order WHERE order_id='portfolio-seed-120' AND mid='portfolio01@example.com'")->fetch_assoc();
if(!$order) throw new RuntimeException('최근 환불 체험 주문이 없습니다.');
$item=$mysqli->query('SELECT * FROM lecture_order_item WHERE odid='.(int)$order['odid'])->fetch_assoc();
$created=null;
try {
    $html=request_probe('users/myPayments.php');
    check_same(true,str_contains($html,'class="refund_check mt-1" value="'.$item['oiid'].'"'));
    $before=(int)$mysqli->query('SELECT SUM(paid_price) FROM lecture_order_item WHERE status IN(1,4)')->fetch_row()[0];
    $request=json_decode(request_probe('users/refund_request_ok.php',['oiid'=>[(string)$item['oiid']],'reason'=>'체험 환불 요청']),true,512,JSON_THROW_ON_ERROR);
    check_same('success',$request['status']);
    check_same(4,(int)$mysqli->query('SELECT status FROM lecture_order_item WHERE oiid='.(int)$item['oiid'])->fetch_row()[0]);
    check_same($before,(int)$mysqli->query('SELECT SUM(paid_price) FROM lecture_order_item WHERE status IN(1,4)')->fetch_row()[0]);
    $course=(int)$mysqli->query("SELECT lid FROM lecture_list WHERE title='[체험] 개발 실습 03'")->fetch_row()[0];
    $result=json_decode(request_probe('lecture/lecture_payment.php',['lid'=>(string)$course,'ucid'=>'0','phone'=>'','total_price'=>'1']),true,512,JSON_THROW_ON_ERROR);
    check_same('success',$result['status']);
    check_same(32000,$result['amount']);
    $lookup=$mysqli->prepare('SELECT odid,total_price FROM lecture_order WHERE order_id=?');
    $lookup->execute([$result['orderId']]);
    $created=$lookup->get_result()->fetch_assoc();
    check_same(32000,(int)$created['total_price']);
    echo "request boundaries: missing CSRF blocked; UI and recent refund eligible; pending refund stays revenue; server purchase amount: OK\n";
} finally {
    $restore=$mysqli->prepare('UPDATE lecture_order_item SET status=?,refund_date=?,refund_reason=? WHERE oiid=?');
    $restore->execute([$item['status'],$item['refund_date'],$item['refund_reason'],$item['oiid']]);
    $restore=$mysqli->prepare('UPDATE lecture_order SET status=?,refund_date=?,refund_reason=? WHERE odid=?');
    $restore->execute([$order['status'],$order['refund_date'],$order['refund_reason'],$order['odid']]);
    if($created) $mysqli->query('DELETE FROM lecture_order WHERE odid='.(int)$created['odid']);
}
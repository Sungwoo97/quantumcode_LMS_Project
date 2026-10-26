<?php
if (PHP_SAPI !== 'cli' || !preg_match('/^qc_demo_.*verify$/D', getenv('DB_NAME') ?: '') || function_exists('curl_init')) {
    exit('로컬 DB의 cURL 비활성 테스트 프로세스 전용입니다.');
}
$probe=json_decode(base64_decode($argv[1]),true,512,JSON_THROW_ON_ERROR);
if (!function_exists('curl_init')) {
    // PG 상태는 파일에 남겨 PHP 요청이 종료되어도 응답 유실 이후 상태를 재현한다.
    function curl_init($url=null) { return (object)['url'=>$url,'options'=>[],'code'=>0]; }

    // 실제 처리 코드의 헤더와 본문을 모의 PG에 전달한다.
    function curl_setopt($request,$option,$value) { $request->options[$option]=$value; return true; }

    // 같은 멱등 키는 한 번만 취소하고 응답 유실·재조회 실패를 별도로 재현한다.
    function curl_exec($request) {
        global $probe;
        $state=json_decode(file_get_contents($probe['pg_file']),true,512,JSON_THROW_ON_ERROR);
        $post=$request->options[CURLOPT_POST]??false;
        $cancel=str_ends_with($request->url,'/cancel');
        $body=json_decode($request->options[CURLOPT_POSTFIELDS]??'{}',true);
        $headers=$request->options[CURLOPT_HTTPHEADER]??[];
        $key='';
        foreach($headers as $header) if(str_starts_with($header,'Idempotency-Key: ')) $key=substr($header,17);
        $payment_key=$cancel ? rawurldecode(basename(dirname($request->url))) : ($post ? $body['paymentKey'] : rawurldecode(basename($request->url)));
        $state['calls'][]=['method'=>$post?'POST':'GET','cancel'=>$cancel,'key'=>$key,'payment'=>$payment_key];
        if(!$post && ($probe['mode']==='query_failed' || (in_array($probe['mode'], ['lost','confirm_lost'], true) && !empty($state['lost'])))) {
            $request->code=503;
            file_put_contents($probe['pg_file'],json_encode($state));
            return false;
        }
        if($post && $key==='') throw new RuntimeException('PG 멱등 키 누락');
        if($probe['mode']==='invalid') {
            $request->code=$post?400:404;
            file_put_contents($probe['pg_file'],json_encode($state));
            return json_encode(['code'=>'NOT_FOUND_PAYMENT']);
        }
        if($post && $cancel && $probe['mode']==='not_sent') {
            $state['lost']=true;
            $request->code=0;
            file_put_contents($probe['pg_file'],json_encode($state));
            return false;
        }
        $payment=$state['payments'][$payment_key];
        if($post && $cancel && !isset($state['idempotency'][$key])) {
            $payment['cancels'][]=['cancelAmount'=>$body['cancelAmount'],'cancelReason'=>$body['cancelReason'],'cancelStatus'=>'DONE','transactionKey'=>'txn-'.count($state['calls'])];
            $payment['balanceAmount']-=$body['cancelAmount'];
            $payment['status']=$payment['balanceAmount']===0?'CANCELED':'PARTIAL_CANCELED';
            $state['idempotency'][$key]=true;
        } elseif($post && !$cancel) {
            $payment['status']='DONE';
        }
        $state['payments'][$payment_key]=$payment;
        if($post && $cancel && $probe['mode']==='lost') $state['lost']=true;
        if($post && !$cancel && $probe['mode']==='confirm_lost') $state['lost']=true;
        file_put_contents($probe['pg_file'],json_encode($state));
        $request->code=$post && (($cancel && $probe['mode']==='lost') || (!$cancel && $probe['mode']==='confirm_lost'))?0:200;
        return $request->code===0?false:json_encode($payment);
    }

    // 모의 응답의 상태 코드만 반환한다.
    function curl_getinfo($request,$option) { return $request->code; }

    // 모의 연결에는 외부 네트워크 오류 문자열이 없다.
    function curl_error($request) { return ''; }

    // 모의 연결은 해제할 네트워크 자원이 없다.
    function curl_close($request) { }
}
session_start();
$_SERVER['DOCUMENT_ROOT']=dirname(dirname(__DIR__));
$_SERVER['HTTP_HOST']='localhost';
$_SERVER['REQUEST_METHOD']='POST';
$_SERVER['REMOTE_ADDR']='192.0.2.170';
$_SESSION=['AUID'=>'portfolio_demo','MemEmail'=>'portfolio01@example.com','qc_csrf_token'=>str_repeat('r',64)];
$_POST=array_merge($probe['post']??[],['csrf_token'=>str_repeat('r',64)]);
if($probe['operation']==='refund') require __DIR__.'/../admin/sales/order_refund_ok.php';
elseif($probe['operation']==='create') require __DIR__.'/../lecture/lecture_payment.php';
else {
    require __DIR__.'/../inc/toss_config.php';
    require __DIR__.'/../inc/payment_confirm.php';
    require __DIR__.'/../admin/inc/dbcon.php';
    $result=confirm_lecture_payment($mysqli,'portfolio01@example.com',$probe['order'],$probe['payment_key'],$probe['amount']);
    echo json_encode(['paid'=>$result['paid']]);
}

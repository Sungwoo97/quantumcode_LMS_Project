<?php
if (PHP_SAPI !== 'cli' || !preg_match('/^qc_demo_.*verify$/D', getenv('DB_NAME') ?: '')) {
    exit('로컬 검증 DB 전용입니다.');
}
ob_start();
require __DIR__ . '/reporting_test.php';
ob_end_clean();
require __DIR__ . '/../inc/payment_boundary.php';
require __DIR__ . '/../admin/inc/dbcon.php';
// 별도 프로세스가 실제 승인 처리 함수를 호출하며 cURL만 테스트 응답으로 대체한다.
function confirm_probe(array $input) {
    $process = proc_open([PHP_BINARY, '-d', 'disable_functions=curl_init,curl_setopt,curl_exec,curl_getinfo,curl_close', __DIR__ . '/payment_confirm_probe.php', base64_encode(json_encode($input))], [1 => ['pipe','w'], 2 => ['pipe','w']], $pipes);
    $output = stream_get_contents($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    if (proc_close($process) !== 0 || $error !== '') {
        throw new RuntimeException($output . $error);
    }
    return json_decode($output, true, 512, JSON_THROW_ON_ERROR);
}
$created = [];
try {
    $course = (int) $mysqli->query("SELECT lid FROM lecture_list WHERE title LIKE '[체험]%' ORDER BY lid LIMIT 1")->fetch_row()[0];
    foreach (['normal','timeout','unknown','duplicate'] as $scenario) {
        $key = 'boundary-' . $scenario . '-' . bin2hex(random_bytes(5));
        $insert = $mysqli->prepare('INSERT INTO lecture_order(mid,lid,order_id,total_price,status) VALUES(?,?,?,?,0)');
        $insert->execute(['portfolio01@example.com', (string) $course, $key, 30000]);
        $order_id = (int) $mysqli->insert_id;
        $created[] = $order_id;
        $mysqli->query("INSERT INTO lecture_order_item(odid,lid,price,paid_price,status) VALUES($order_id,$course,30000,30000,0)");
        $input = ['scenario'=>$scenario,'order'=>$key,'real_order'=>$key,'email'=>'portfolio01@example.com','amount'=>30000];
        if ($scenario === 'normal') {
            $attack = $input;
            $attack['order'] = "' OR 1=1 -- ";
            check_same(false, confirm_probe($attack)['paid']);
            $attack = $input;
            $attack['email'] = 'portfolio02@example.com';
            check_same(false, confirm_probe($attack)['paid']);
            $attack = $input;
            $attack['amount'] = 1;
            check_same(false, confirm_probe($attack)['paid']);
            lock_payment_order($mysqli,$order_id);
            check_same('error', confirm_probe($input)['status']);
            $lock_name = 'qc:' . substr(hash('sha256',getenv('DB_NAME') . ':' . $order_id), 0, 60);
            $release = $mysqli->prepare('SELECT RELEASE_LOCK(?)');
            $release->execute([$lock_name]);
            $release->get_result()->fetch_row();
        }
        $first = confirm_probe($input);
        if ($scenario === 'unknown') {
            check_same(false,$first['paid']);
            check_same(0,(int)$mysqli->query("SELECT status FROM lecture_order WHERE odid=$order_id")->fetch_row()[0]);
            $input['scenario']='normal';
            $retry=confirm_probe($input);
            check_same(true,$retry['paid']);
            check_same($first['calls'][0]['idempotency'],$retry['calls'][0]['idempotency']);
        } else {
            check_same(true,$first['paid']);
        }
        $again=confirm_probe($input);
        check_same(true,$again['paid']);
        check_same([], $again['calls']);
        check_same(1,(int)$mysqli->query("SELECT status FROM lecture_order_item WHERE odid=$order_id")->fetch_row()[0]);
    }
    echo "payment confirm: SQLi/ownership/amount/lock/timeout/requery/idempotency/duplicate: OK\n";
} finally {
    foreach ($created as $order_id) {
        $mysqli->query('DELETE FROM lecture_order WHERE odid=' . (int)$order_id);
    }
}
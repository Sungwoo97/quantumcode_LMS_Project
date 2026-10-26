<?php
if (PHP_SAPI !== 'cli' || getenv('DEMO_MODE') !== '1' || !preg_match('/^qc_demo_.*verify$/D', getenv('DB_NAME') ?: '')) {
    exit("로컬 검증 DB 전용입니다.\n");
}
ob_start();
require_once __DIR__ . '/reporting_test.php';
ob_end_clean();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require __DIR__ . '/../admin/inc/dbcon.php';
$order = $mysqli->query("SELECT * FROM lecture_order WHERE order_id='portfolio-seed-004'")->fetch_assoc();
if (!$order || $order['pay_method'] !== 'DEMO' || $order['payment_key'] !== null || $order['cid'] !== null) {
    throw new RuntimeException('가상 환불 테스트 주문이 필요합니다.');
}
$item = $mysqli->query('SELECT * FROM lecture_order_item WHERE odid=' . (int) $order['odid'])->fetch_assoc();
$root = dirname(__DIR__);
// curl_init 호출을 강제로 실패시켜 외부 PG에 접속하지 않는 환불 분기만 검증한다.
function refund_probe(string $root, int $item_id, bool $authenticated, bool $with_token = true) {
    $code = 'function curl_init($url=null) { throw new RuntimeException("PG 호출 금지"); } '
        . 'session_start(); $_SERVER["REQUEST_METHOD"]="POST"; $_SERVER["DOCUMENT_ROOT"]=' . var_export(dirname($root), true) . '; $_SERVER["HTTP_HOST"]="localhost"; '
        . '$_SESSION=' . var_export($authenticated ? ['AUID' => 'portfolio_demo', 'qc_csrf_token' => str_repeat('a',64)] : ['qc_csrf_token' => str_repeat('a',64)], true) . '; '
        . '$_POST=' . var_export(['oiid' => [(string) $item_id], 'action' => 'approve', 'csrf_token' => $with_token ? str_repeat('a',64) : ''], true) . '; '
        . 'require ' . var_export($root . '/admin/sales/order_refund_ok.php', true) . ';';
    $process = proc_open([PHP_BINARY, '-d', 'disable_functions=curl_init', '-r', $code], [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
    $output = stream_get_contents($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    if (proc_close($process) !== 0 || $error !== '') {
        throw new RuntimeException($output . $error);
    }
    return $output;
}
try {
    $mysqli->query('UPDATE lecture_order_item SET status=4 WHERE oiid=' . (int) $item['oiid']);
    $mysqli->query('UPDATE lecture_order SET status=4 WHERE odid=' . (int) $order['odid']);
    refund_probe($root, (int) $item['oiid'], true, false);
    check_same(4, (int) $mysqli->query('SELECT status FROM lecture_order_item WHERE oiid=' . (int) $item['oiid'])->fetch_row()[0]);
    refund_probe($root, (int) $item['oiid'], false);
    check_same(4, (int) $mysqli->query('SELECT status FROM lecture_order_item WHERE oiid=' . (int) $item['oiid'])->fetch_row()[0]);
    require_once __DIR__ . '/../inc/payment_boundary.php';
    lock_payment_order($mysqli, (int)$order['odid']);
    $blocked = json_decode(refund_probe($root, (int)$item['oiid'], true), true, 512, JSON_THROW_ON_ERROR);
    check_same('error', $blocked['status']);
    check_same(4,(int)$mysqli->query('SELECT status FROM lecture_order_item WHERE oiid='.(int)$item['oiid'])->fetch_row()[0]);
    $lock_name='qc:' . substr(hash('sha256',getenv('DB_NAME').':'.$order['odid']),0,60);
    $release=$mysqli->prepare('SELECT RELEASE_LOCK(?)');
    $release->execute([$lock_name]);
    $release->get_result()->fetch_row();
    $response = json_decode(refund_probe($root, (int) $item['oiid'], true), true, 512, JSON_THROW_ON_ERROR);
    check_same('success', $response['status']);
    check_same((int) $item['paid_price'], $response['cancelAmount']);
    check_same(3, (int) $mysqli->query('SELECT status FROM lecture_order_item WHERE oiid=' . (int) $item['oiid'])->fetch_row()[0]);
    check_same(3, (int) $mysqli->query('SELECT status FROM lecture_order WHERE odid=' . (int) $order['odid'])->fetch_row()[0]);
    $again = json_decode(refund_probe($root, (int) $item['oiid'], true), true, 512, JSON_THROW_ON_ERROR);
    check_same('fail', $again['status']);
    echo "virtual refund: no PG; auth required; amount and status correct; duplicate blocked: OK\n";
} finally {
    $restore = $mysqli->prepare('UPDATE lecture_order_item SET status=?,refund_date=?,refund_reason=? WHERE oiid=?');
    $restore->execute([$item['status'], $item['refund_date'], $item['refund_reason'], $item['oiid']]);
    $restore = $mysqli->prepare('UPDATE lecture_order SET status=?,refund_date=? WHERE odid=?');
    $restore->execute([$order['status'], $order['refund_date'], $order['odid']]);
}
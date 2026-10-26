<?php
if (PHP_SAPI !== 'cli' || !preg_match('/^qc_demo_.*verify$/D', getenv('DB_NAME') ?: '')) {
    http_response_code(403);
    exit('검증 DB CLI 전용입니다.');
}
$probe = json_decode(base64_decode($argv[1]), true, 512, JSON_THROW_ON_ERROR);
$calls = [];
if (function_exists('curl_init')) {
    exit('cURL을 비활성화한 전용 테스트 프로세스로 실행해주세요.');
}
if (!function_exists('curl_init')) {
    // 테스트 프로세스에서만 cURL 함수를 대체해 실제 외부 결제 호출을 금지한다.
    function curl_init($url = null) {
        return (object) ['url' => $url, 'options' => [], 'code' => 0];
    }

    // 요청 옵션을 보관해 POST 본문과 멱등 헤더를 확인한다.
    function curl_setopt($request, $option, $value) {
        $request->options[$option] = $value;
        return true;
    }

    // 응답 유실·중복 오류·조회 성공을 실제 결제 처리 함수에 전달한다.
    function curl_exec($request) {
        global $probe, $calls;
        $post = $request->options[CURLOPT_POST] ?? false;
        $headers = $request->options[CURLOPT_HTTPHEADER] ?? [];
        $idempotency = array_values(array_filter($headers, static fn($header) => str_starts_with($header, 'Idempotency-Key:')));
        if ($post && count($idempotency) !== 1) {
            throw new RuntimeException('멱등 키 누락');
        }
        $calls[] = ['method' => $post ? 'POST' : 'GET', 'idempotency' => $idempotency[0] ?? ''];
        if ($post && in_array($probe['scenario'], ['timeout', 'unknown', 'duplicate'], true)) {
            $request->code = $probe['scenario'] === 'duplicate' ? 409 : 0;
            return false;
        }
        if (!$post && $probe['scenario'] === 'unknown') {
            $request->code = 404;
            return '{}';
        }
        $request->code = 200;
        return json_encode(['status' => 'DONE', 'orderId' => $probe['real_order'], 'paymentKey' => 'test_probe_key', 'totalAmount' => 30000, 'method' => '카드']);
    }

    // 테스트 응답의 HTTP 상태를 돌려준다.
    function curl_getinfo($request, $option) {
        return $request->code;
    }

    // 테스트 요청은 네트워크 자원이 없어 해제할 내용이 없다.
    function curl_close($request) {
    }

}
require __DIR__ . '/../inc/payment_confirm.php';
require __DIR__ . '/../admin/inc/dbcon.php';
$toss_client_key = 'test_ck_probe';
$toss_secret_key = 'test_sk_probe';
$toss_confirm_url = 'https://api.tosspayments.com/v1/payments/confirm';
$toss_api_base = 'https://api.tosspayments.com/v1/payments';
$result = confirm_lecture_payment($mysqli, $probe['email'], $probe['order'], 'test_probe_key', $probe['amount']);
echo json_encode(['paid' => $result['paid'], 'calls' => $calls]);
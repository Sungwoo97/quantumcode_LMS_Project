<?php
// 방문자 세션마다 토큰을 발급하고 여러 탭에서도 같은 값을 사용한다.
function csrf_token() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['qc_csrf_token'])) {
        $_SESSION['qc_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['qc_csrf_token'];
}

// 배열 입력과 빈 토큰을 거절한 뒤 상수 시간으로 비교한다.
function csrf_valid($token) {
    return is_string($token) && $token !== '' && hash_equals(csrf_token(), $token);
}

// 결제사 콜백은 서명 대신 세션에 연결된 토큰이 든 복귀 URL을 검증한다.
function require_payment_csrf(string $method = 'POST') {
    $token = $method === 'GET' ? ($_GET['csrf_token'] ?? '') : ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? '');
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== $method || !csrf_valid($token)) {
        http_response_code(403);
        exit(json_encode(['status' => 'error', 'message' => '요청 토큰이 유효하지 않습니다. 화면을 새로고침해주세요.'], JSON_UNESCAPED_UNICODE));
    }
}

// 항목 선택 순서가 달라도 같은 승인·취소 재시도에는 같은 멱등 키를 쓴다.
function payment_idempotency_key(string $action, string $payment_reference, array $items = []) {
    sort($items, SORT_NUMERIC);
    return 'qc-' . $action . '-' . hash('sha256', $payment_reference . ':' . implode(',', $items));
}

// 서로 다른 세션도 같은 주문의 확인·취소·실패 처리를 동시에 실행하지 못하게 한다.
function lock_payment_order(mysqli $db, int $order_id) {
    lock_payment_resource($db, (string) $order_id);
}

// 쿠폰과 주문은 같은 DB 안에서 서로 다른 이름으로 직렬화한다.
function lock_payment_resource(mysqli $db, string $reference) {
    $name = 'qc:' . substr(hash('sha256', $db->query('SELECT DATABASE()')->fetch_row()[0] . ':' . $reference), 0, 60);
    $statement = $db->prepare('SELECT GET_LOCK(?, 0)');
    $statement->execute([$name]);
    if ((int) $statement->get_result()->fetch_row()[0] !== 1) {
        http_response_code(409);
        exit(json_encode(['status' => 'error', 'message' => '같은 주문을 처리 중입니다. 잠시 후 다시 확인해주세요.'], JSON_UNESCAPED_UNICODE));
    }
    register_shutdown_function(static function () use ($db, $name) {
        try {
            $release = $db->prepare('SELECT RELEASE_LOCK(?)');
            $release->execute([$name]);
        } catch (Throwable $error) {
            // 연결 종료 시 MySQL이 잠금을 해제하므로 중복 종료 오류는 무시한다.
        }
    });
}

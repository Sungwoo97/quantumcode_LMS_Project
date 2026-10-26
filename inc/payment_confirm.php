<?php
require_once __DIR__ . '/payment_boundary.php';
require_once __DIR__ . '/payment_safety.php';
require_once __DIR__ . '/order_status.php';

// 모든 승인·재조회 호출은 서버에서 검증한 테스트 키만 사용한다.
function toss_payment_request(string $method, string $url, ?array $body = null, string $idempotency = '') {
    global $toss_client_key, $toss_secret_key;
    require_test_payment_keys($toss_client_key, $toss_secret_key);
    $request = curl_init($url);
    $headers = ['Authorization: Basic ' . base64_encode($toss_secret_key . ':'), 'Content-Type: application/json'];
    if ($idempotency !== '') {
        $headers[] = 'Idempotency-Key: ' . $idempotency;
    }
    curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
    if ($method === 'POST') {
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($body));
    }
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($request, CURLOPT_TIMEOUT, 30);
    $raw = curl_exec($request);
    $code = (int) curl_getinfo($request, CURLINFO_HTTP_CODE);
    $data = is_string($raw) ? json_decode($raw, true) : null;
    return ['code' => $code, 'data' => is_array($data) ? $data : []];
}

// 네트워크 오류와 달리 PG가 미존재·다른 주문·최종 미결제를 확인한 키는 해제한다.
function payment_attempt_rejected(array $response, object $order, string $payment_key): bool {
    $payment = $response['data'];
    if ($response['code'] === 404 && ($payment['code'] ?? '') === 'NOT_FOUND_PAYMENT') return true;
    if ($response['code'] !== 200 || ($payment['paymentKey'] ?? '') !== $payment_key
        || !is_string($payment['orderId'] ?? null)) return false;
    return $payment['orderId'] !== $order->order_id
        || in_array($payment['status'] ?? '', ['ABORTED', 'EXPIRED', 'CANCELED'], true);
}

// 주문 잠금과 PG 멱등·재조회를 거친 뒤 항목·쿠폰·장바구니를 원자적으로 확정한다.
function confirm_lecture_payment(mysqli $db, string $email, string $order_id, string $payment_key, int $amount) {
    global $toss_confirm_url, $toss_api_base;
    $failure = ['paid' => false, 'message' => '주문 정보를 확인할 수 없습니다.', 'order' => null];
    if ($email === '' || $order_id === '' || $payment_key === '' || $amount <= 0) {
        return $failure;
    }
    $lookup = $db->prepare('SELECT * FROM lecture_order WHERE order_id=? AND mid=?');
    $lookup->execute([$order_id, $email]);
    $order = $lookup->get_result()->fetch_object();
    if (!$order) {
        return $failure;
    }
    lock_payment_order($db, (int) $order->odid);
    $lookup->execute([$order_id, $email]);
    $order = $lookup->get_result()->fetch_object();
    if ($order->pay_method === 'DEMO' || (int) $order->total_price !== $amount) {
        $failure['message'] = '결제 대상 또는 주문 금액이 올바르지 않습니다.';
        return $failure;
    }
    if ((int) $order->status === 1) {
        return !empty($order->payment_key) && hash_equals($order->payment_key, $payment_key)
            ? ['paid' => true, 'message' => '', 'order' => $order] : $failure;
    }
    if ((int) $order->status !== 0) {
        return $failure;
    }
    if (!empty($order->cid)) {
        lock_payment_resource($db, 'coupon:' . (int) $order->cid);
        $coupon = $db->prepare('SELECT status FROM coupons_usercp WHERE ucid=? AND userid=?');
        $coupon->execute([$order->cid, $email]);
        $available = $coupon->get_result()->fetch_object();
        $paid = $db->prepare('SELECT 1 FROM lecture_order o JOIN lecture_order_item oi ON oi.odid=o.odid WHERE o.cid=? AND o.odid<>? AND oi.status IN (1,4) LIMIT 1');
        $paid->execute([$order->cid, $order->odid]);
        $used_elsewhere = (bool) $paid->get_result()->fetch_row();
        $pending = $db->prepare('SELECT MIN(odid) AS first_order FROM lecture_order WHERE cid=? AND status=0 AND payment_key IS NOT NULL');
        $pending->execute([$order->cid]);
        $first = $pending->get_result()->fetch_object()->first_order;
        if (!$available || (int) $available->status !== 1 || $used_elsewhere
            || ($first !== null && (int) $first !== (int) $order->odid)) {
            $failure['message'] = '쿠폰을 다른 주문에서 사용했거나 결제 확인 중입니다.';
            return $failure;
        }
    }
    if (!empty($order->payment_key) && !hash_equals($order->payment_key, $payment_key)) {
        $previous = toss_payment_request('GET', $toss_api_base.'/'.rawurlencode($order->payment_key));
        if (!payment_attempt_rejected($previous, $order, $order->payment_key)) return $failure;
    }
    // PG 응답이 유실되어도 다른 주문이 같은 쿠폰을 쓰지 못하도록 시도 키를 남긴다.
    $attempt = $db->prepare('UPDATE lecture_order SET payment_key=? WHERE odid=? AND status=0');
    $attempt->execute([$payment_key, $order->odid]);
    $response = toss_payment_request('POST', $toss_confirm_url, ['paymentKey' => $payment_key, 'orderId' => $order_id, 'amount' => $amount], payment_idempotency_key('confirm', $order->order_id . ':' . $payment_key));
    $payment = $response['data'];
    if ($response['code'] !== 200 || ($payment['status'] ?? '') !== 'DONE') {
        // 응답 유실이나 중복 승인 오류도 실제 PG 상태를 조회해서 확정 여부를 판단한다.
        $lookup_response = toss_payment_request('GET', $toss_api_base . '/' . rawurlencode($payment_key));
        if ($lookup_response['code'] === 200) {
            $payment = $lookup_response['data'];
        }
    }
    if (($payment['status'] ?? '') !== 'DONE' || ($payment['orderId'] ?? '') !== $order_id
        || ($payment['paymentKey'] ?? '') !== $payment_key || (int) ($payment['totalAmount'] ?? -1) !== $amount) {
        if (isset($lookup_response) && payment_attempt_rejected($lookup_response, $order, $payment_key)) {
            $release = $db->prepare('UPDATE lecture_order SET payment_key=NULL WHERE odid=? AND status=0 AND payment_key=?');
            $release->execute([$order->odid, $payment_key]);
            $failure['message'] = '결제 키가 올바르지 않거나 결제가 종료되었습니다. 다시 결제해주세요.';
            return $failure;
        }
        // 타임아웃·조회 실패는 결제 실패로 단정하지 않고 같은 멱등 키로 재확인한다.
        $failure['message'] = '결제 확정 여부를 확인하지 못했습니다. 잠시 후 같은 완료 화면에서 다시 확인해주세요.';
        return $failure;
    }
    $db->begin_transaction();
    try {
        $update = $db->prepare('UPDATE lecture_order SET payment_key=?,pay_method=? WHERE odid=? AND status=0');
        $method = $payment['method'] ?? '카드';
        $update->execute([$payment_key, $method, $order->odid]);
        $items = $db->prepare('UPDATE lecture_order_item SET status=1 WHERE odid=? AND status=0');
        $items->execute([$order->odid]);
        if ($items->affected_rows === 0) {
            throw new RuntimeException('확정할 대기 주문 항목이 없습니다.');
        }
        sync_order_status($db, $order->odid);
        if (!empty($order->cid)) {
            $coupon = $db->prepare('UPDATE coupons_usercp SET status=0,usedate=NOW() WHERE ucid=?');
            $coupon->execute([$order->cid]);
        }
        $cart = $db->prepare('DELETE c FROM lecture_cart c JOIN lecture_order_item oi ON oi.lid=c.lid WHERE c.mid=? AND oi.odid=?');
        $cart->execute([$email, $order->odid]);
        $db->commit();
        $order->pay_method = $method;
        return ['paid' => true, 'message' => '', 'order' => $order];
    } catch (Throwable $error) {
        $db->rollback();
        throw $error;
    }
}

<?php
require_once __DIR__.'/payment_confirm.php';

// 결제사 응답은 주문·결제 키·금액을 대조한 뒤에만 취소 근거로 사용한다.
function refund_payment_matches(array $payment, object $order): bool {
    return ($payment['orderId'] ?? '') === $order->order_id
        && ($payment['paymentKey'] ?? '') === $order->payment_key
        && (int) ($payment['totalAmount'] ?? -1) === (int) $order->total_price
        && isset($payment['balanceAmount']);
}

// 이전에 없던 완료 취소 내역의 금액·사유까지 맞아야 해당 요청으로 확정한다.
function refund_intent_completed(array $payment, object $order, array $intent): bool {
    if (!refund_payment_matches($payment, $order)
        || (int) $payment['balanceAmount'] !== $intent['before'] - $intent['body']['cancelAmount']
        || !in_array($payment['status'] ?? '', ['PARTIAL_CANCELED', 'CANCELED'], true)) return false;
    foreach ($payment['cancels'] ?? [] as $cancel) {
        if (($cancel['cancelStatus'] ?? '') === 'DONE' && !empty($cancel['transactionKey'])
            && !in_array($cancel['transactionKey'], $intent['seen'], true)
            && (int) ($cancel['cancelAmount'] ?? -1) === $intent['body']['cancelAmount']
            && ($cancel['cancelReason'] ?? '') === $intent['body']['cancelReason']) return true;
    }
    return false;
}

// 영속화한 동일 요청만 재시도하고 응답 유실은 PG 잔액 재조회로 복구한다.
function verify_payment_cancel(mysqli $db, object $order, array $item_ids, string $action, int $amount, string $reason): array {
    global $toss_api_base;
    sort($item_ids, SORT_NUMERIC);
    $intent = empty($order->cancel_request) ? null : json_decode($order->cancel_request, true, 512, JSON_THROW_ON_ERROR);
    if (!$intent && $action === 'reject') return ['ready'=>true, 'items'=>$item_ids, 'reject'=>true];
    $url = $toss_api_base.'/'.rawurlencode($order->payment_key);
    $response = toss_payment_request('GET', $url);
    $payment = $response['data'];
    $valid = $response['code'] === 200 && refund_payment_matches($payment, $order);
    if (!$intent) {
        if (!$valid || !in_array($payment['status'] ?? '', ['DONE', 'PARTIAL_CANCELED'], true)
            || (int) $payment['balanceAmount'] < $amount) {
            return ['ready'=>false];
        }
        $intent = ['items'=>$item_ids, 'body'=>['cancelReason'=>$reason, 'cancelAmount'=>$amount],
            'before'=>(int) $payment['balanceAmount'], 'started'=>time(),
            'seen'=>array_column($payment['cancels'] ?? [], 'transactionKey'),
            'key'=>payment_idempotency_key('cancel', $order->order_id.':'.$order->payment_key, $item_ids)];
        $save = $db->prepare('UPDATE lecture_order SET cancel_request=? WHERE odid=?');
        $save->execute([json_encode($intent, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), $order->odid]);
    }
    $expected = $intent['before'] - $intent['body']['cancelAmount'];
    if ($valid && refund_intent_completed($payment, $order, $intent)) {
        return ['ready'=>true, 'items'=>$intent['items'], 'reject'=>false];
    }
    if ($action !== 'approve' || $item_ids !== $intent['items'] || !$valid
        || (int) $payment['balanceAmount'] !== $intent['before']
        || time() - $intent['started'] >= 14 * 86400) {
        return ['ready'=>false];
    }
    $response = toss_payment_request('POST', $url.'/cancel', $intent['body'], $intent['key']);
    if ($response['code'] !== 200 || !refund_payment_matches($response['data'], $order)
        || (int) $response['data']['balanceAmount'] !== $expected) {
        $response = toss_payment_request('GET', $url);
    }
    $payment = $response['data'];
    return $response['code'] === 200 && refund_intent_completed($payment, $order, $intent)
        ? ['ready'=>true, 'items'=>$intent['items'], 'reject'=>false] : ['ready'=>false];
}

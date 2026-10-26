<?php
// 공개 체험에서는 실결제 키로 승인·취소 API를 호출하지 않는다.
function require_test_payment_keys(string $client_key, string $secret_key) {
    if (!preg_match('/^test_ck_[A-Za-z0-9]+$/D', $client_key)
        || !preg_match('/^test_sk_[A-Za-z0-9]+$/D', $secret_key)) {
        throw new RuntimeException('공개 데모에서는 테스트 결제 키만 사용할 수 있습니다.');
    }
}
// PG 승인 이력이 없는 시드 주문은 세 가지 서버 저장값으로 식별한다.
function is_demo_order(object $order) {
    return ($order->pay_method ?? '') === 'DEMO'
        && preg_match('/^portfolio-seed-[0-9]{3}$/D', $order->order_id ?? '') === 1
        && empty($order->payment_key);
}
<?php
require_once __DIR__ . '/../inc/payment_safety.php';
require_once __DIR__ . '/reporting_test.php';

require_test_payment_keys('test_ck_example', 'test_sk_example');
foreach ([['live_ck_example', 'test_sk_example'], ['test_ck_example', 'live_sk_example'], ['', ''], ['test_ck_', 'test_sk_']] as $keys) {
    $blocked = false;
    try {
        require_test_payment_keys(...$keys);
    } catch (RuntimeException $error) {
        $blocked = true;
    }
    check_same(true, $blocked);
}
echo "payment safety: OK\n";
check_same(true, is_demo_order((object) ['pay_method' => 'DEMO', 'order_id' => 'portfolio-seed-001', 'payment_key' => null]));
check_same(false, is_demo_order((object) ['pay_method' => '카드', 'order_id' => 'portfolio-seed-001', 'payment_key' => null]));
check_same(false, is_demo_order((object) ['pay_method' => 'DEMO', 'order_id' => 'qc123', 'payment_key' => null]));
check_same(false, is_demo_order((object) ['pay_method' => 'DEMO', 'order_id' => 'portfolio-seed-001', 'payment_key' => 'external']));
echo "virtual order: OK\n";
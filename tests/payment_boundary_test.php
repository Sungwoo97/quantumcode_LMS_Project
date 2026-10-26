<?php
require_once __DIR__ . '/../inc/payment_boundary.php';
ob_start();
require_once __DIR__ . '/reporting_test.php';
ob_end_clean();
$token = csrf_token();
check_same(64, strlen($token));
check_same($token, csrf_token());
check_same(true, csrf_valid($token));
check_same(false, csrf_valid(''));
check_same(false, csrf_valid(str_repeat('x', 64)));
check_same(false, csrf_valid([$token]));
check_same(payment_idempotency_key('cancel', 12, [4, 3]), payment_idempotency_key('cancel', 12, [3, 4]));
check_same(false, payment_idempotency_key('cancel', 12, [3]) === payment_idempotency_key('cancel', 12, [4]));
check_same(false, payment_idempotency_key('confirm', 12) === payment_idempotency_key('cancel', 12));
echo "payment boundary: OK\n";
check_same(false, payment_idempotency_key('confirm','qc-order-one:payment-one') === payment_idempotency_key('confirm','qc-order-two:payment-two'));
check_same(false, payment_idempotency_key('confirm','qc-order-one:payment-one') === payment_idempotency_key('confirm','qc-order-one:payment-two'));
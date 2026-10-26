<?php
require __DIR__.'/../inc/payment_refund.php';
ob_start();
require __DIR__.'/reporting_test.php';
ob_end_clean();
$order = (object) ['order_id'=>'cancel-evidence', 'payment_key'=>'test-payment', 'total_price'=>60000];
$intent = ['before'=>60000, 'body'=>['cancelAmount'=>30000, 'cancelReason'=>'선택 강의 환불'], 'seen'=>['old-transaction']];
$payment = ['orderId'=>'cancel-evidence', 'paymentKey'=>'test-payment', 'totalAmount'=>60000,
    'balanceAmount'=>30000, 'status'=>'PARTIAL_CANCELED', 'cancels'=>[
        ['transactionKey'=>'new-transaction', 'cancelStatus'=>'DONE', 'cancelAmount'=>30000, 'cancelReason'=>'다른 외부 취소']]];
check_same(false, refund_intent_completed($payment, $order, $intent));
$payment['cancels'][0]['cancelReason'] = '선택 강의 환불';
check_same(true, refund_intent_completed($payment, $order, $intent));
$payment['cancels'][0]['transactionKey'] = 'old-transaction';
check_same(false, refund_intent_completed($payment, $order, $intent));
echo "PASS 취소 잔액·거래 식별자·금액·사유 대조\n";

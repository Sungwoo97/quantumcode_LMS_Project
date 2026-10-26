<?php
require_once __DIR__ . '/../inc/payment_boundary.php';
require_payment_csrf('GET');
$title = '결제 완료';
$lecture_css = '<link href="/qc/css/lecture.css" rel="stylesheet">';
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');
require_once __DIR__ . '/../inc/toss_config.php';
require_once __DIR__ . '/../inc/payment_confirm.php';
$order_id = is_string($_GET['orderId'] ?? null) ? $_GET['orderId'] : '';
$payment_key = is_string($_GET['paymentKey'] ?? null) ? $_GET['paymentKey'] : '';
$amount = filter_var($_GET['amount'] ?? null, FILTER_VALIDATE_INT) ?: 0;
$result = confirm_lecture_payment($mysqli, $_SESSION['MemEmail'] ?? '', $order_id, $payment_key, $amount);
$is_paid = $result['paid'];
$result_title = $is_paid ? '결제가 완료되었습니다' : '결제를 확인해주세요';
$result_message = $result['message'];
$order_data = $result['order'];
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="payment p-4 text-center">
        <h3 class="font mb-3"><?= $result_title ?></h3>

        <?php if ($is_paid) { ?>
          <dl class="text-start mt-4">
            <dt>주문번호</dt>
            <dd><?= htmlspecialchars($order_id, ENT_QUOTES, 'UTF-8') ?></dd>
            <dt>결제수단</dt>
            <dd><?= htmlspecialchars($order_data->pay_method ?: '카드', ENT_QUOTES, 'UTF-8') ?></dd>
            <dt>결제금액</dt>
            <dd><?= number_format($amount) ?> 원</dd>
          </dl>
          <div class="control m-3">
            <a href="//<?= $_SERVER['HTTP_HOST']; ?>/qc/users/mylectures.php" class="btn btn-primary w-100" role="button">내 강의실로 이동</a>
          </div>
        <?php } else { ?>
          <p class="normal-font mt-3"><?= htmlspecialchars($result_message, ENT_QUOTES, 'UTF-8') ?></p>
          <div class="control m-3">
            <a href="//<?= $_SERVER['HTTP_HOST']; ?>/qc/lecture/lecture_order.php" class="btn btn-secondary w-100" role="button">장바구니로 돌아가기</a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>

<?php
require_once __DIR__ . '/../inc/payment_boundary.php';
require_payment_csrf('GET');

$title = "결제 실패";

$lecture_css = "<link href=\"//{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/order_status.php');

if ($email === '') {
  echo "<script>
  alert('로그인 이후 이용 가능한 기능입니다');
  history.back();
  </script>";
}

// 결제창에서 취소하거나 승인 전에 실패하면 이 주소로 돌아온다
$fail_code = $_GET['code'] ?? '';
$fail_message = $_GET['message'] ?? '결제가 취소되었습니다.';
$order_id = $_GET['orderId'] ?? '';

// 실패 콜백만으로는 PG 승인 여부를 알 수 없으므로 주문 상태를 변경하지 않는다.
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="payment p-4 text-center">
        <h3 class="font mb-3">결제가 완료되지 않았습니다</h3>
        <p class="normal-font mt-3"><?= htmlspecialchars(is_string($fail_message) ? $fail_message : '', ENT_QUOTES, 'UTF-8') ?></p>
        <?php if ($fail_code !== '') { ?>
          <p class="normal-font">오류코드: <?= htmlspecialchars(is_string($fail_code) ? $fail_code : '', ENT_QUOTES, 'UTF-8') ?></p>
        <?php } ?>
        <div class="control m-3">
          <a href="//<?= $_SERVER['HTTP_HOST']; ?>/qc/lecture/lecture_order.php" class="btn btn-primary w-100" role="button">장바구니로 돌아가기</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>

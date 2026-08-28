<?php
$title = "결제 실패";

$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

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

// 결제대기로 남아 있는 주문을 실패로 정리
if ($order_id !== '') {
  $up_sql = "UPDATE lecture_order SET status = 2 WHERE order_id = '$order_id' AND mid = '$email' AND status = 0";
  $mysqli->query($up_sql);
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="payment p-4 text-center">
        <h3 class="font mb-3">결제가 완료되지 않았습니다</h3>
        <p class="normal-font mt-3"><?= $fail_message ?></p>
        <?php if ($fail_code !== '') { ?>
          <p class="normal-font">오류코드: <?= $fail_code ?></p>
        <?php } ?>
        <div class="control m-3">
          <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/lecture/lecture_order.php" class="btn btn-primary w-100" role="button">장바구니로 돌아가기</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>

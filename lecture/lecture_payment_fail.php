<?php
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

// 결제대기로 남아 있는 주문을 실패로 정리. 상태는 항목에 먼저 쓰고 주문으로 파생시킨다
if ($order_id !== '') {
  $wait_sql = "SELECT odid FROM lecture_order WHERE order_id = '$order_id' AND mid = '$email' AND status = 0";
  $wait_result = $mysqli->query($wait_sql);
  $wait_row = $wait_result ? $wait_result->fetch_object() : null;
  if ($wait_row) {
    $mysqli->query("UPDATE lecture_order_item SET status = 2 WHERE odid = {$wait_row->odid}");
    sync_order_status($mysqli, $wait_row->odid);
  }
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
          <a href="//<?= $_SERVER['HTTP_HOST']; ?>/qc/lecture/lecture_order.php" class="btn btn-primary w-100" role="button">장바구니로 돌아가기</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>

<?php
$title = "결제 완료";

$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/toss_config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/order_status.php');

if ($email === '') {
  echo "<script>
  alert('로그인 이후 이용 가능한 기능입니다');
  history.back();
  </script>";
}

// 토스 결제창이 붙여서 돌려주는 값들
$payment_key = $_GET['paymentKey'] ?? '';
$order_id = $_GET['orderId'] ?? '';
$amount = $_GET['amount'] ?? 0;

$is_paid = false;      // 결제가 최종 확정됐는지
$result_title = '결제에 실패했습니다';
$result_message = '';
$order_data = null;

if ($payment_key === '' || $order_id === '' || $amount <= 0) {
  $result_message = '결제 정보가 올바르지 않습니다.';
} else {
  // 결제 준비(lecture_payment.php)에서 만들어 둔 주문을 주문번호로 다시 찾는다
  $order_sql = "SELECT * FROM lecture_order WHERE order_id = '$order_id' AND mid = '$email'";
  $order_result = $mysqli->query($order_sql);
  $order_data = $order_result ? $order_result->fetch_object() : null;

  if (!$order_data) {
    $result_message = '주문 정보를 찾을 수 없습니다.';
  } else if ($order_data->status == 1) {
    // 완료 화면에서 새로고침한 경우. 승인을 다시 부르지 않고 완료로 보여준다
    $is_paid = true;
    $result_title = '결제가 완료되었습니다';
  } else if ($order_data->status != 0) {
    $result_message = '이미 종료된 주문입니다.';
  } else if ((int) $order_data->total_price !== (int) $amount) {
    // 결제창으로 넘어간 금액이 주문 금액과 다르면 승인하지 않는다
    $mysqli->query("UPDATE lecture_order_item SET status = 2 WHERE odid = {$order_data->odid}");
    sync_order_status($mysqli, $order_data->odid);
    $result_message = '결제 금액이 주문 금액과 일치하지 않습니다.';
  } else {
    // 토스페이먼츠 결제 승인 요청
    $post_data = json_encode([
      'paymentKey' => $payment_key,
      'orderId' => $order_id,
      'amount' => (int) $amount,
    ]);

    $ch = curl_init($toss_confirm_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Basic ' . base64_encode($toss_secret_key . ':'),
      'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $confirm_raw = curl_exec($ch);
    $confirm_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    $confirm_data = json_decode($confirm_raw, true);

    if ($confirm_code == 200 && !empty($confirm_data['paymentKey'])) {
      $pay_method = $confirm_data['method'] ?? '';
      $lids = $order_data->lid;
      $ucid = $order_data->cid;

      // 주문 확정. 결제정보는 주문에 남기고, 상태는 항목에 쓴 뒤 주문으로 파생시킨다
      $up_sql = "UPDATE lecture_order
                 SET payment_key = '$payment_key', pay_method = '$pay_method'
                 WHERE order_id = '$order_id'";
      $mysqli->query($up_sql);

      $mysqli->query("UPDATE lecture_order_item SET status = 1 WHERE odid = {$order_data->odid} AND status = 0");
      sync_order_status($mysqli, $order_data->odid);

      // 쿠폰을 사용완료로 변경, 0은 이미 사용한 쿠폰
      if (!empty($ucid)) {
        $cp_sql = "UPDATE coupons_usercp SET status = 0, usedate = now() WHERE ucid = $ucid";
        $mysqli->query($cp_sql);
      }

      // 결제한 강의를 장바구니에서 비운다
      $del_sql = "DELETE FROM lecture_cart WHERE mid = '$email' AND lid IN ($lids)";
      $mysqli->query($del_sql);

      // 아래 결과 화면이 갱신된 값을 쓰도록 맞춰둔다
      $order_data->pay_method = $pay_method;

      $is_paid = true;
      $result_title = '결제가 완료되었습니다';
    } else {
      // 승인이 거절되면 주문을 실패로 남긴다
      $mysqli->query("UPDATE lecture_order_item SET status = 2 WHERE odid = {$order_data->odid}");
      sync_order_status($mysqli, $order_data->odid);
      if ($curl_error !== '') {
        $result_message = '결제 서버와 통신하지 못했습니다. (' . $curl_error . ')';
      } else {
        $result_message = $confirm_data['message'] ?? '결제 승인이 거절되었습니다.';
      }
    }
  }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="payment p-4 text-center">
        <h3 class="font mb-3"><?= $result_title ?></h3>

        <?php if ($is_paid) { ?>
          <dl class="text-start mt-4">
            <dt>주문번호</dt>
            <dd><?= $order_id ?></dd>
            <dt>결제수단</dt>
            <dd><?= $order_data->pay_method ?: '카드' ?></dd>
            <dt>결제금액</dt>
            <dd><?= number_format($amount) ?> 원</dd>
          </dl>
          <div class="control m-3">
            <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/users/mylectures.php" class="btn btn-primary w-100" role="button">내 강의실로 이동</a>
          </div>
        <?php } else { ?>
          <p class="normal-font mt-3"><?= $result_message ?></p>
          <div class="control m-3">
            <a href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/lecture/lecture_order.php" class="btn btn-secondary w-100" role="button">장바구니로 돌아가기</a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>

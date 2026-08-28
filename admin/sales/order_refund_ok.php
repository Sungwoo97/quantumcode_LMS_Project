<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/toss_config.php');

// 관리자만 처리할 수 있다
if (!isset($_SESSION['AUID'])) {
  echo json_encode(['status' => 'error', 'message' => '관리자로 로그인해주세요.']);
  exit;
}

$odid = ctype_digit($_POST['odid'] ?? '') ? $_POST['odid'] : 0;
$action = $_POST['action'] ?? '';
if (empty($odid) || ($action !== 'approve' && $action !== 'reject')) {
  echo json_encode(['status' => 'error', 'message' => '요청이 올바르지 않습니다.']);
  exit;
}

$order_sql = "SELECT odid, mid, lid, cid, status, payment_key, total_price, refund_reason FROM lecture_order WHERE odid = $odid";
$order_result = $mysqli->query($order_sql);
$order_data = $order_result ? $order_result->fetch_object() : null;

if (!$order_data) {
  echo json_encode(['status' => 'error', 'message' => '주문 정보를 찾을 수 없습니다.']);
  exit;
}
if ($order_data->status != 4) {
  echo json_encode(['status' => 'fail', 'message' => '환불요청 상태인 주문만 처리할 수 있습니다.']);
  exit;
}

// 거절하면 결제완료 상태로 되돌린다
if ($action === 'reject') {
  $mysqli->query("UPDATE lecture_order SET status = 1 WHERE odid = $odid AND status = 4");
  echo json_encode(['status' => 'success', 'message' => '환불 요청을 거절했습니다. 주문은 결제완료 상태로 되돌렸습니다.']);
  exit;
}

if (empty($order_data->payment_key)) {
  echo json_encode(['status' => 'fail', 'message' => '결제 정보가 없어 취소할 수 없습니다.']);
  exit;
}

// 토스페이먼츠 결제 취소 요청
$cancel_reason = $order_data->refund_reason !== '' ? $order_data->refund_reason : '고객 환불 요청';
$post_data = json_encode(['cancelReason' => $cancel_reason]);

$ch = curl_init($toss_api_base . '/' . $order_data->payment_key . '/cancel');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Authorization: Basic ' . base64_encode($toss_secret_key . ':'),
  'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$cancel_raw = curl_exec($ch);
$cancel_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

$cancel_data = json_decode($cancel_raw, true);

if ($cancel_code != 200) {
  if ($curl_error !== '') {
    echo json_encode(['status' => 'error', 'message' => '결제 서버와 통신하지 못했습니다. (' . $curl_error . ')']);
  } else {
    echo json_encode(['status' => 'fail', 'message' => $cancel_data['message'] ?? '결제 취소가 거절되었습니다.']);
  }
  exit;
}

// 취소가 끝나면 주문을 환불완료로 바꾼다. 수강 권한도 여기서 사라진다
$up_sql = "UPDATE lecture_order SET status = 3, refund_date = NOW() WHERE odid = $odid AND status = 4";
$mysqli->query($up_sql);

// 사용했던 쿠폰이 있으면 다시 쓸 수 있게 되돌린다
$order_cid = (int) $order_data->cid;
if (!empty($order_cid)) {
  $mysqli->query("UPDATE coupons_usercp SET status = 1, usedate = NULL WHERE ucid = $order_cid");
}

echo json_encode(['status' => 'success', 'message' => '환불 처리가 완료되었습니다.']);

$mysqli->close();

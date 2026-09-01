<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/auth_guard.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/toss_config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/order_status.php');

// 관리자만 처리할 수 있다
if (!isset($_SESSION['AUID'])) {
  echo json_encode(['status' => 'error', 'message' => '관리자로 로그인해주세요.']);
  exit;
}

// 강의 단위로 처리하므로 주문 항목 번호를 여러 개 받는다
$oiidArray = [];
foreach ((array) ($_POST['oiid'] ?? []) as $one_oiid) {
  $one_oiid = trim($one_oiid);
  if (ctype_digit($one_oiid)) {
    $oiidArray[] = (int) $one_oiid;
  }
}
$oiidArray = array_values(array_unique($oiidArray));

$action = $_POST['action'] ?? '';
if (empty($oiidArray) || ($action !== 'approve' && $action !== 'reject')) {
  echo json_encode(['status' => 'error', 'message' => '요청이 올바르지 않습니다.']);
  exit;
}

$oiids = implode(',', $oiidArray);
$item_sql = "SELECT oiid, odid, status, paid_price, refund_reason
             FROM lecture_order_item WHERE oiid IN ($oiids)";
$item_result = $mysqli->query($item_sql);

$items = [];
if ($item_result) {
  while ($item_row = $item_result->fetch_object()) {
    $items[] = $item_row;
  }
}

if (count($items) !== count($oiidArray)) {
  echo json_encode(['status' => 'error', 'message' => '주문 정보를 찾을 수 없습니다.']);
  exit;
}

// 결제 취소는 결제건 단위라 한 번에 한 주문만 처리한다
$odid = (int) $items[0]->odid;
$cancel_amount = 0;
$cancel_reason = '고객 환불 요청';
foreach ($items as $item) {
  if ((int) $item->odid !== $odid) {
    echo json_encode(['status' => 'error', 'message' => '한 번에 한 주문의 강의만 처리할 수 있습니다.']);
    exit;
  }
  if ($item->status != 4) {
    echo json_encode(['status' => 'fail', 'message' => '환불요청 상태인 강의만 처리할 수 있습니다.']);
    exit;
  }
  $cancel_amount += (int) $item->paid_price;
  if (!empty($item->refund_reason)) {
    $cancel_reason = $item->refund_reason;
  }
}

// 거절하면 결제완료 상태로 되돌린다
if ($action === 'reject') {
  $mysqli->query("UPDATE lecture_order_item SET status = 1, refund_reason = NULL WHERE oiid IN ($oiids) AND status = 4");
  sync_order_status($mysqli, $odid);
  echo json_encode(['status' => 'success', 'message' => '환불 요청을 거절했습니다. 해당 강의는 결제완료 상태로 되돌렸습니다.']);
  exit;
}

$order_sql = "SELECT odid, cid, payment_key, total_price FROM lecture_order WHERE odid = $odid";
$order_result = $mysqli->query($order_sql);
$order_data = $order_result ? $order_result->fetch_object() : null;

if (!$order_data || empty($order_data->payment_key)) {
  echo json_encode(['status' => 'fail', 'message' => '결제 정보가 없어 취소할 수 없습니다.']);
  exit;
}

// 이번 취소 뒤에 살아남는 강의가 없으면 전액 취소다.
// 전액이면 cancelAmount 를 빼서 토스가 남은 잔액을 통째로 취소하게 한다.
// (앞서 부분 취소가 있었어도 잔액 기준으로 맞아떨어진다)
$rest_sql = "SELECT COUNT(*) AS cnt FROM lecture_order_item
             WHERE odid = $odid AND status IN (1, 4) AND oiid NOT IN ($oiids)";
$rest_result = $mysqli->query($rest_sql);
$rest_cnt = $rest_result ? (int) $rest_result->fetch_object()->cnt : 0;
$is_full_cancel = ($rest_cnt === 0);

// 토스페이먼츠 결제 취소 요청
$cancel_body = ['cancelReason' => $cancel_reason];
if (!$is_full_cancel) {
  $cancel_body['cancelAmount'] = $cancel_amount;
}
$post_data = json_encode($cancel_body);

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

// 취소가 끝나면 해당 강의를 환불완료로 바꾼다. 수강 권한도 여기서 사라진다
$mysqli->query("UPDATE lecture_order_item SET status = 3, refund_date = NOW() WHERE oiid IN ($oiids) AND status = 4");
$order_status = sync_order_status($mysqli, $odid);

// 쿠폰은 주문 전체가 환불됐을 때만 되돌린다.
// 일부만 환불하고 쿠폰까지 돌려주면 남은 강의를 할인가로 가진 채 쿠폰을 다시 쓰게 된다
$order_cid = (int) $order_data->cid;
if ($order_status === 3 && !empty($order_cid)) {
  $mysqli->query("UPDATE coupons_usercp SET status = 1, usedate = NULL WHERE ucid = $order_cid");
}

$done_message = $is_full_cancel
  ? '환불 처리가 완료되었습니다.'
  : '선택한 강의만 부분 환불했습니다. (' . number_format($cancel_amount) . '원)';

echo json_encode(['status' => 'success', 'message' => $done_message, 'cancelAmount' => $cancel_amount]);

$mysqli->close();

<?php
require_once __DIR__ . '/../../inc/payment_boundary.php';
require_payment_csrf();
require_once __DIR__ . '/../../inc/demo_safety.php';
require_demo_rate('payment');



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
$lock_result = $mysqli->query('SELECT odid FROM lecture_order_item WHERE oiid=' . (int) $oiidArray[0]);
$lock_order = $lock_result->fetch_object();
if ($lock_order) {
  lock_payment_order($mysqli, (int) $lock_order->odid);
}
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

$order_sql = "SELECT odid, cid, payment_key, pay_method, order_id, total_price, cancel_request FROM lecture_order WHERE odid = $odid";
$order_result = $mysqli->query($order_sql);
$order_data = $order_result ? $order_result->fetch_object() : null;

$virtual_order = $order_data && is_demo_order($order_data);
if (!$order_data || (empty($order_data->payment_key) && !$virtual_order)
    || (($order_data->pay_method ?? '') === 'DEMO' && (!$virtual_order || getenv('DEMO_MODE') !== '1'))) {
  echo json_encode(['status' => 'fail', 'message' => '결제 정보가 없어 취소할 수 없습니다.']);
  exit;
}

if (!empty($order_data->cid)) {
  lock_payment_resource($mysqli, 'coupon:' . (int) $order_data->cid);
}
// PG 취소 시도가 남아 있으면 거절·다른 선택보다 실제 취소 결과를 먼저 복구한다.
if (!$virtual_order) {
  require_once __DIR__ . '/../../inc/payment_refund.php';
  $verified = verify_payment_cancel($mysqli, $order_data, $oiidArray, $action, $cancel_amount, $cancel_reason);
  if (!$verified['ready']) {
    http_response_code(409);
    echo json_encode(['status'=>'fail', 'message'=>'이전 취소 결과를 확인 중입니다. 선택을 바꾸거나 거절하지 말고 같은 항목으로 다시 확인해주세요.']);
    exit;
  }
  $oiidArray = $verified['items'];
  $oiids = implode(',', $oiidArray);
  $action = $verified['reject'] ? 'reject' : 'approve';
}
$cancel_amount = (int) $mysqli->query("SELECT SUM(paid_price) FROM lecture_order_item WHERE odid=$odid AND oiid IN ($oiids)")->fetch_row()[0];
$is_full_cancel = (int) $mysqli->query("SELECT COUNT(*) FROM lecture_order_item WHERE odid=$odid AND status IN (1,4) AND oiid NOT IN ($oiids)")->fetch_row()[0] === 0;
$mysqli->begin_transaction();
try {
  if ($action === 'reject') {
    $mysqli->query("UPDATE lecture_order_item SET status=1,refund_reason=NULL WHERE oiid IN ($oiids) AND status=4");
  } else {
    $mysqli->query("UPDATE lecture_order_item SET status=3,refund_date=NOW() WHERE oiid IN ($oiids) AND status=4");
    $mysqli->query("UPDATE lecture_order SET cancel_request=NULL WHERE odid=$odid");
  }
  $order_status = sync_order_status($mysqli, $odid);
  // 과거 중복 사용이나 확인 중인 결제가 남아 있으면 쿠폰을 재발급하지 않는다.
  $order_cid = (int) $order_data->cid;
  if ($order_status === 3 && $order_cid) {
    $other = $mysqli->prepare('SELECT 1 FROM lecture_order o WHERE o.cid=? AND o.odid<>? AND ((o.status=0 AND o.payment_key IS NOT NULL) OR EXISTS (SELECT 1 FROM lecture_order_item oi WHERE oi.odid=o.odid AND oi.status IN (1,4))) LIMIT 1');
    $other->execute([$order_cid, $odid]);
    if (!$other->get_result()->fetch_row()) {
      $mysqli->query("UPDATE coupons_usercp SET status=1,usedate=NULL WHERE ucid=$order_cid");
    }
  }
  $mysqli->commit();
} catch (Throwable $error) {
  $mysqli->rollback();
  throw $error;
}
$done_message = $action === 'reject' ? '환불 요청을 거절했습니다.' : ($is_full_cancel
  ? '환불 처리가 완료되었습니다.'
  : '선택한 강의만 부분 환불했습니다. (' . number_format($cancel_amount) . '원)');

echo json_encode(['status' => 'success', 'message' => $done_message, 'cancelAmount' => $cancel_amount]);

$mysqli->close();

<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// 환불을 신청하는 회원은 화면에서 받지 않고 세션에서 가져온다
$mid = $_SESSION['MemEmail'] ?? '';
if ($mid === '') {
  echo json_encode(['status' => 'error', 'message' => '로그인 이후 이용 가능한 기능입니다.']);
  exit;
}

$odid = ctype_digit($_POST['odid'] ?? '') ? $_POST['odid'] : 0;
$reason = trim($_POST['reason'] ?? '');
if (empty($odid) || $reason === '') {
  echo json_encode(['status' => 'error', 'message' => '환불 사유를 입력해주세요.']);
  exit;
}

// 사유는 컬럼 길이에 맞춰 자른다
$reason = mb_substr($reason, 0, 255);
$reason = $mysqli->real_escape_string($reason);

// 본인 주문인지 확인하면서 환불 가능 여부 판단에 필요한 값을 같이 조회
$order_sql = "SELECT odid, status, payment_key, lid, mid,
              DATEDIFF(NOW(), createdate) AS days_passed
              FROM lecture_order
              WHERE odid = $odid AND mid = '$mid'";
$order_result = $mysqli->query($order_sql);
$order_data = $order_result ? $order_result->fetch_object() : null;

if (!$order_data) {
  echo json_encode(['status' => 'error', 'message' => '주문 정보를 찾을 수 없습니다.']);
  exit;
}
if ($order_data->status != 1) {
  echo json_encode(['status' => 'fail', 'message' => '결제 완료된 주문만 환불할 수 있습니다.']);
  exit;
}
if (empty($order_data->payment_key)) {
  echo json_encode(['status' => 'fail', 'message' => '결제 정보가 없어 환불할 수 없습니다. 관리자에게 문의해주세요.']);
  exit;
}
if ($order_data->days_passed > 7) {
  echo json_encode(['status' => 'fail', 'message' => '결제 후 7일이 지나 환불할 수 없습니다.']);
  exit;
}

// 한 번이라도 시청 기록이 있으면 환불 대상이 아니다
$watch_sql = "SELECT COUNT(*) AS cnt FROM lecture_watch
              WHERE mid = '$mid' AND FIND_IN_SET(lid, '{$order_data->lid}')";
$watch_result = $mysqli->query($watch_sql);
$watch_data = $watch_result ? $watch_result->fetch_object() : null;
if ($watch_data && $watch_data->cnt > 0) {
  echo json_encode(['status' => 'fail', 'message' => '이미 수강을 시작한 강의는 환불할 수 없습니다.']);
  exit;
}

// 여기서는 요청만 남긴다. 실제 결제 취소는 관리자가 승인할 때 처리
$up_sql = "UPDATE lecture_order SET status = 4, refund_reason = '$reason' WHERE odid = $odid AND status = 1";
$up_result = $mysqli->query($up_sql);

if ($up_result && $mysqli->affected_rows > 0) {
  echo json_encode(['status' => 'success', 'message' => '환불 요청이 접수되었습니다. 관리자 확인 후 처리됩니다.']);
} else {
  echo json_encode(['status' => 'error', 'message' => '환불 요청에 실패했습니다.']);
}

$mysqli->close();

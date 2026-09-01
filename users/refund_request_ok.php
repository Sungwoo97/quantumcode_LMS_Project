<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/order_status.php');

// 환불을 신청하는 회원은 화면에서 받지 않고 세션에서 가져온다
$mid = $_SESSION['MemEmail'] ?? '';
if ($mid === '') {
  echo json_encode(['status' => 'error', 'message' => '로그인 이후 이용 가능한 기능입니다.']);
  exit;
}

// 강의 단위로 환불하므로 주문 항목 번호를 여러 개 받는다
$oiidArray = [];
foreach ((array) ($_POST['oiid'] ?? []) as $one_oiid) {
  $one_oiid = trim($one_oiid);
  if (ctype_digit($one_oiid)) {
    $oiidArray[] = (int) $one_oiid;
  }
}
$oiidArray = array_values(array_unique($oiidArray));

$reason = trim($_POST['reason'] ?? '');
if (empty($oiidArray)) {
  echo json_encode(['status' => 'error', 'message' => '환불할 강의를 선택해주세요.']);
  exit;
}
if ($reason === '') {
  echo json_encode(['status' => 'error', 'message' => '환불 사유를 입력해주세요.']);
  exit;
}

// 사유는 컬럼 길이에 맞춰 자른다
$reason = mb_substr($reason, 0, 255);
$reason = $mysqli->real_escape_string($reason);

// 본인 주문인지 확인하면서 환불 가능 여부 판단에 필요한 값을 같이 조회한다.
// 수강 여부는 주문 전체가 아니라 강의 하나하나로 따진다
$oiids = implode(',', $oiidArray);
$item_sql = "SELECT oi.oiid, oi.odid, oi.lid, oi.status, l.title, o.payment_key,
             DATEDIFF(NOW(), o.createdate) AS days_passed,
             (SELECT COUNT(*) FROM lecture_watch lw WHERE lw.mid = o.mid AND lw.lid = oi.lid) AS watch_count
             FROM lecture_order_item oi
             JOIN lecture_order o ON o.odid = oi.odid
             LEFT JOIN lecture_list l ON l.lid = oi.lid
             WHERE oi.oiid IN ($oiids) AND o.mid = '$mid'";
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
foreach ($items as $item) {
  if ((int) $item->odid !== $odid) {
    echo json_encode(['status' => 'error', 'message' => '한 번에 한 주문의 강의만 환불 요청할 수 있습니다.']);
    exit;
  }
}

// 조건이 강의마다 다르므로 하나씩 확인한다
foreach ($items as $item) {
  $title = $item->title !== null ? $item->title : ('강의 ' . $item->lid);
  if ($item->status != 1) {
    echo json_encode(['status' => 'fail', 'message' => "[{$title}] 결제 완료된 강의만 환불할 수 있습니다."]);
    exit;
  }
  if (empty($item->payment_key)) {
    echo json_encode(['status' => 'fail', 'message' => '결제 정보가 없어 환불할 수 없습니다. 관리자에게 문의해주세요.']);
    exit;
  }
  if ($item->days_passed > 7) {
    echo json_encode(['status' => 'fail', 'message' => '결제 후 7일이 지나 환불할 수 없습니다.']);
    exit;
  }
  if ($item->watch_count > 0) {
    echo json_encode(['status' => 'fail', 'message' => "[{$title}] 이미 수강을 시작한 강의는 환불할 수 없습니다."]);
    exit;
  }
}

// 여기서는 요청만 남긴다. 실제 결제 취소는 관리자가 승인할 때 처리
$up_sql = "UPDATE lecture_order_item SET status = 4, refund_reason = '$reason'
           WHERE oiid IN ($oiids) AND status = 1";
$up_result = $mysqli->query($up_sql);

if ($up_result && $mysqli->affected_rows > 0) {
  // 관리자 목록이 주문 단위로도 사유를 보여주고 있어 주문에도 같이 남긴다
  $mysqli->query("UPDATE lecture_order SET refund_reason = '$reason' WHERE odid = $odid");
  sync_order_status($mysqli, $odid);
  echo json_encode(['status' => 'success', 'message' => '환불 요청이 접수되었습니다. 관리자 확인 후 처리됩니다.']);
} else {
  echo json_encode(['status' => 'error', 'message' => '환불 요청에 실패했습니다.']);
}

$mysqli->close();

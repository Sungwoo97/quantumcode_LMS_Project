<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/toss_config.php');

// 결제할 회원은 화면에서 받지 않고 세션에서 가져온다
$mid = $_SESSION['MemEmail'] ?? '';
if ($mid === '') {
  echo json_encode(['status' => 'error', 'message' => '로그인 이후 이용 가능한 기능입니다.']);
  exit;
}

// 강의 번호는 숫자만 남기고 걸러낸다
$lidsArray = [];
foreach (explode(',', $_POST['lid'] ?? '') as $one_lid) {
  $one_lid = trim($one_lid);
  if (ctype_digit($one_lid)) {
    $lidsArray[] = $one_lid;
  }
}
if (empty($lidsArray)) {
  echo json_encode(['status' => 'error', 'message' => '결제할 강의가 없습니다.']);
  exit;
}

$ucid = ctype_digit($_POST['ucid'] ?? '') ? $_POST['ucid'] : 0;
$phone = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
$lids = implode(',', $lidsArray);


$lidArr = [];
$placeholders = $lids; // lid 값들 문자열로 결합
// 결제완료(status = 1) 된 주문만 중복으로 본다. 결제대기/실패 건은 다시 살 수 있어야 함
$sql = "SELECT lid FROM lecture_order WHERE mid = '$mid' AND status = 1 AND lid IN ($placeholders)";

// 쿼리 실행
$result = $mysqli->query($sql);

$purchased = [];
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $purchased[] = $row['lid'];
  }
}

//array_intersect는 중복된 값을 리턴해준다
$duplicates = array_intersect($lidsArray, $purchased);
if (!empty($duplicates)) {
  echo json_encode([
    'status' => 'fail',
    'message' => '중복된 강의가 있습니다.',
    'duplicates' => $duplicates,
  ]);
  exit;
}

// 결제 금액은 화면에서 받지 않고 강의 정보로 다시 계산한다
$sum_price = 0;
$order_name = '강의 결제';
$lecture_count = 0;
$price_sql = "SELECT title, tuition, dis_tuition FROM lecture_list WHERE lid IN ($placeholders)";
$price_result = $mysqli->query($price_sql);
while ($price_row = $price_result->fetch_object()) {
  $sum_price += $price_row->dis_tuition > 0 ? $price_row->dis_tuition : $price_row->tuition;
  if ($lecture_count === 0) {
    $order_name = $price_row->title;
  }
  $lecture_count++;
}

if ($lecture_count !== count($lidsArray)) {
  echo json_encode(['status' => 'error', 'message' => '존재하지 않는 강의가 포함되어 있습니다.']);
  exit;
}

// 결제창에 띄울 주문명. 강의가 여러 개면 '첫 강의 외 N건' 으로 표기
if ($lecture_count > 1) {
  $order_name .= ' 외 ' . ($lecture_count - 1) . '건';
}

// 쿠폰도 화면 값을 믿지 않고, 본인 소유의 사용가능한 쿠폰인지 확인한 뒤 할인액을 계산한다
$discount = 0;
if (!empty($ucid)) {
  $cp_sql = "SELECT c.coupon_type, c.coupon_price, c.coupon_ratio
             FROM coupons_usercp cu
             JOIN coupons c ON c.cid = cu.couponid
             WHERE cu.ucid = $ucid AND cu.userid = '$mid' AND cu.status = 1 AND c.status = 1";
  $cp_result = $mysqli->query($cp_sql);
  $cp_data = $cp_result ? $cp_result->fetch_object() : null;
  if (!$cp_data) {
    echo json_encode(['status' => 'fail', 'message' => '사용할 수 없는 쿠폰입니다.']);
    exit;
  }
  if ($cp_data->coupon_type === 'fixed') {
    $discount = (int) $cp_data->coupon_price;
  } else {
    $discount = (int) floor($sum_price * $cp_data->coupon_ratio / 100);
  }
}

$total_price = $sum_price - $discount;
if ($total_price < 0) {
  $total_price = 0;
}

// 토스페이먼츠는 0원 결제를 받지 않는다
if ($total_price < 1) {
  echo json_encode(['status' => 'fail', 'message' => '결제 금액이 0원인 주문은 아직 지원하지 않습니다.']);
  exit;
}

// 결제 진행을 위해 입력받은 연락처를 회원정보에 반영
if ($phone !== '') {
  $mysqli->query("UPDATE memberskakao SET number = '$phone' WHERE memEmail = '$mid'");
}

// 결제 도중 사용자 정보를 다시 넘겨야 해서 회원 이름을 같이 조회
$customer_name = '';
$name_sql = "SELECT memName FROM memberskakao WHERE memEmail = '$mid'";
$name_result = $mysqli->query($name_sql);
if ($name_result && $name_row = $name_result->fetch_assoc()) {
  $customer_name = $name_row['memName'];
}

// 토스에 넘길 주문번호. 승인 단계에서 이 값으로 주문을 다시 찾는다
$order_id = 'qc' . date('YmdHis') . mt_rand(1000, 9999);

// 쿠폰 소진과 장바구니 삭제는 결제 승인이 끝난 뒤(lecture_payment_ok.php)에 처리한다.
// 여기서 처리하면 결제가 취소됐을 때 쿠폰만 사라진다
$sql = "INSERT INTO lecture_order (mid, lid, total_price, cid, order_id, status) VALUES ('$mid', '$lids', $total_price, $ucid, '$order_id', 0)";
$result = $mysqli->query($sql);
if (!$result) {

  echo json_encode(['status' => 'error', 'message' => $mysqli->error]);
  exit;
} else {
  $response = [
    'status' => 'success',
    'message' => '결제창을 엽니다.',
    'orderId' => $order_id,
    'orderName' => $order_name,
    'amount' => $total_price,
    'customerName' => $customer_name,
    'customerEmail' => $mid,
  ];
}


echo json_encode($response);
$mysqli->close();

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

if (empty($_POST['lid']) || empty($_POST['mid']) || empty($_POST['total_price'])) {
  echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
  exit;
}
$ucid = $_POST['ucid'] ?? '';
$lids = $_POST['lid'];
$mid = $_POST['mid'];
$total_price = $_POST['total_price'];

// $lid = explode(',', $lids);
if(!empty($ucid)){
  $del_sql = "UPDATE coupons_usercp SET status = 2, usedate = now() WHERE ucid = $ucid";
  $del_result = $mysqli->query($del_sql);
}

$sql = "INSERT INTO lecture_order (mid, lid, total_price, status) VALUES ($mid, '$lids', $total_price, 1)";
$result = $mysqli->query($sql);
if (!$result) {
  echo json_encode(['status' => 'error', 'message' => $stmt->error]);
  exit;
}


$response = [
  'status' => 'success',
  'message' => 'Payment processed successfully.',
];

echo json_encode($response);
$mysqli->close();

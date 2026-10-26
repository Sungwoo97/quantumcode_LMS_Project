<?php
require_once __DIR__ . '/../inc/payment_boundary.php';
require_payment_csrf();


include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');


$mid = $_SESSION['MemEmail'] ?? '';
$lids = array_values(array_filter(explode(',', $_POST['lid'] ?? ''), 'ctype_digit'));
if ($mid === '' || !$lids) {
  http_response_code(403);
  exit(json_encode(['status' => 'error', 'message' => '본인의 장바구니만 변경할 수 있습니다.'], JSON_UNESCAPED_UNICODE));
}
$placeholders = implode(',', array_fill(0, count($lids), '?'));
$statement = $mysqli->prepare("DELETE FROM lecture_cart WHERE mid=? AND lid IN ($placeholders)");
$result = $statement->execute(array_merge([$mid], $lids));

if ($result) {
  $response = [
    'status' => 'success',
    'message' => 'Payment processed successfully.',
  ];
} else {
  $response = [
    'status' => 'fail',
    'message' => 'no-result',
  ];
}

echo json_encode($response);

$mysqli->close();

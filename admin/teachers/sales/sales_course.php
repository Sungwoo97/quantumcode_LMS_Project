<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 로그인한 강사 본인 강의만 집계한다. 전에는 sales_course 라는 고정 표를 뿌렸다
$teacher_id = $mysqli->real_escape_string($_SESSION['TUID'] ?? '');
if ($teacher_id === '') {
  echo json_encode([], JSON_UNESCAPED_UNICODE);
  exit;
}

// 매출 상위 4개 강의. 강의별 매출은 항목별 결제액(paid_price)으로 낸다
$top_sql = "SELECT l.lid
  FROM lecture_order_item oi
  JOIN lecture_list l ON l.lid = oi.lid
  WHERE oi.status = 1 AND l.t_id = '$teacher_id'
  GROUP BY l.lid
  ORDER BY SUM(oi.paid_price) DESC
  LIMIT 4";
$top_result = $mysqli->query($top_sql);

$top_data = [];
while ($row = $top_result->fetch_object()) {
  $top_data[] = $row->lid;
}

// 팔린 강의가 하나도 없으면 IN () 이 문법 오류가 되므로 빈 배열로 끝낸다
if (empty($top_data)) {
  echo json_encode([], JSON_UNESCAPED_UNICODE);
  exit;
}

$top_lid = implode(',', $top_data);

// 월 표기에 연도를 넣어야 해가 바뀌어도 같은 달끼리 합쳐지지 않는다
$sql = "SELECT l.title, l.lid,
    DATE_FORMAT(lo.createdate, '%Y-%m') AS month,
    SUM(oi.paid_price) AS total_sales
  FROM lecture_order_item oi
  JOIN lecture_order lo ON lo.odid = oi.odid
  JOIN lecture_list l ON l.lid = oi.lid
  WHERE oi.status = 1 AND l.lid IN ($top_lid)
  GROUP BY l.lid, l.title, DATE_FORMAT(lo.createdate, '%Y-%m')
  ORDER BY month ASC";

$result = $mysqli->query($sql);

$data = [];
while ($row = $result->fetch_object()) {
  $data[] = [
    'lid' => $row->lid,
    'course_name' => $row->title,
    'month' => $row->month,
    'sales' => $row->total_sales
  ];
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

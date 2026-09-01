<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 강의별 매출은 주문 총액이 아니라 항목별 결제액(paid_price)으로 낸다.
// 전에는 주문 총액을 강의마다 통째로 더해 여러 강의 주문이 중복 계산됐다.
$top_sql = "SELECT l.lid
  FROM lecture_order_item oi
  JOIN lecture_list l ON l.lid = oi.lid
  WHERE oi.status = 1
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

<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// header('application/x-www-form-urlencoded');
// $date = mktime(0, 0, 0, date("m"), 1, date("Y"));
// $prev_month = strtotime("-1 month", $date);
// echo $date("m");

$data = [];

$top_data = [];

// 강의별 매출은 주문 총액이 아니라 항목별 결제액(paid_price)으로 낸다.
// 전에는 주문 총액을 강의마다 통째로 더해 여러 강의 주문이 중복 계산됐다
$top_sql = "SELECT l.lid
FROM lecture_order_item oi
JOIN lecture_list l ON l.lid = oi.lid
WHERE oi.status = 1
GROUP BY l.lid
ORDER BY SUM(oi.paid_price) DESC
LIMIT 4";
$top_result = $mysqli->query($top_sql);
while ($row = $top_result->fetch_object()){
  $top_data[] = $row->lid;
}

$top_lid = implode(',' , $top_data);

$sql = "SELECT l.title, l.lid, DATE_FORMAT(lo.createdate, '%c월') AS month, SUM(oi.paid_price) AS total_sales
    FROM lecture_order_item oi
    JOIN lecture_order lo ON lo.odid = oi.odid
    JOIN lecture_list l ON l.lid = oi.lid
    WHERE oi.status = 1 AND l.lid IN ($top_lid)
    GROUP BY l.lid, l.title, MONTH(lo.createdate), DATE_FORMAT(lo.createdate, '%c월')
    ORDER BY MONTH(lo.createdate)
";

$result = $mysqli->query($sql);

while ($row = $result->fetch_object()){
  $data[] = [
    'lid' => $row->lid,
    'course_name' => $row->title,
    'month' => $row->month,
    'sales' => $row->total_sales
  ];
}
  
  





// if ($result) {
//     while ($row = $result->fetch_object()) {
//       array_push($data, $row);
//     }
// } else {
//     die("Query failed: " . $mysqli->error);
// }



echo json_encode($data, JSON_UNESCAPED_UNICODE);

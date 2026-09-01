<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 월별 매출. 연도까지 묶어야 해가 바뀌었을 때 같은 달끼리 합쳐지지 않는다.
// 매출이 있는 최근 12개월만 뽑고, 차트가 그대로 그리도록 오름차순으로 돌려준다.
$sql = "SELECT month, sales FROM (
    SELECT DATE_FORMAT(o.createdate, '%Y-%m') AS month,
           SUM(oi.paid_price) AS sales
    FROM lecture_order_item oi
    JOIN lecture_order o ON o.odid = oi.odid
    WHERE oi.status = 1
    GROUP BY DATE_FORMAT(o.createdate, '%Y-%m')
    ORDER BY month DESC
    LIMIT 12
  ) recent
  ORDER BY month ASC";

$result = $mysqli->query($sql);

$data = [];
if ($result) {
  while ($row = $result->fetch_object()) {
    $data[] = $row;
  }
} else {
  die("Query failed: " . $mysqli->error);
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

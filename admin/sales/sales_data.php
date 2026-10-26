<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
require_once __DIR__ . '/../../inc/reporting.php';
$report_period = reporting_period();
$period_start = $report_period['start'];
$period_end = $report_period['end'];
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 월별 매출. 연도까지 묶어야 해가 바뀌었을 때 같은 달끼리 합쳐지지 않는다.
// 최근 12개월을 조회하고 빈 달은 0으로 채운다.
$sql = "
    SELECT DATE_FORMAT(o.createdate, '%Y-%m') AS month,
           SUM(oi.paid_price) AS sales
    FROM lecture_order_item oi
    JOIN lecture_order o ON o.odid = oi.odid
    WHERE oi.status IN (1,4) AND o.createdate >= '$period_start' AND o.createdate < '$period_end'
    GROUP BY DATE_FORMAT(o.createdate, '%Y-%m')

  ORDER BY month ASC";

$result = $mysqli->query($sql);

$data = [];
if ($result) {
  while ($row = $result->fetch_object()) {
    $data[] = (array) $row;
  }
} else {
  die("Query failed: " . $mysqli->error);
}

echo json_encode(reporting_months($data, $report_period), JSON_UNESCAPED_UNICODE);

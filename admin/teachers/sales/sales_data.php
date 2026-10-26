<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
require_once __DIR__ . '/../../../inc/reporting.php';
$report_period = reporting_period();
$period_start = $report_period['start'];
$period_end = $report_period['end'];
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 로그인한 강사 본인 강의만 집계한다. 전에는 sales_monthly 라는 고정 12행 표를 뿌렸다
$teacher_id = $mysqli->real_escape_string($_SESSION['TUID'] ?? '');
if ($teacher_id === '') {
  echo json_encode([], JSON_UNESCAPED_UNICODE);
  exit;
}

// 월 표기에 연도를 넣어야 해가 바뀌어도 같은 달끼리 합쳐지지 않는다.
// 최근 12개월을 조회하고 빈 달은 0으로 채운다
$sql = "
    SELECT DATE_FORMAT(o.createdate, '%Y-%m') AS month,
           SUM(oi.paid_price) AS sales
    FROM lecture_order_item oi
    JOIN lecture_order o ON o.odid = oi.odid
    JOIN lecture_list l ON l.lid = oi.lid
    WHERE oi.status IN (1,4) AND o.createdate >= '$period_start' AND o.createdate < '$period_end' AND l.t_id = '$teacher_id'
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

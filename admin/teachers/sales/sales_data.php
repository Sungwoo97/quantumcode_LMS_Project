<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 로그인한 강사 본인 강의만 집계한다. 전에는 sales_monthly 라는 고정 12행 표를 뿌렸다
$teacher_id = $mysqli->real_escape_string($_SESSION['TUID'] ?? '');
if ($teacher_id === '') {
  echo json_encode([], JSON_UNESCAPED_UNICODE);
  exit;
}

// 월 표기에 연도를 넣어야 해가 바뀌어도 같은 달끼리 합쳐지지 않는다.
// 매출이 있는 최근 12개월만 뽑고, 차트가 그대로 그리도록 오름차순으로 돌려준다
$sql = "SELECT month, sales FROM (
    SELECT DATE_FORMAT(o.createdate, '%Y-%m') AS month,
           SUM(oi.paid_price) AS sales
    FROM lecture_order_item oi
    JOIN lecture_order o ON o.odid = oi.odid
    JOIN lecture_list l ON l.lid = oi.lid
    WHERE oi.status = 1 AND l.t_id = '$teacher_id'
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

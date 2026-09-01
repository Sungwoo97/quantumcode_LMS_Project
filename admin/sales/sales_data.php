<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$data = [];

// 부분환불이 있으면 주문 총액이 과대계상되므로 항목별 결제액으로 합산한다
$sql = "SELECT 
  DATE_FORMAT(o.createdate, '%c월') AS month,
  SUM(oi.paid_price) AS sales
  FROM lecture_order_item oi
  JOIN lecture_order o ON o.odid = oi.odid
  WHERE oi.status = 1
  GROUP BY DATE_FORMAT(o.createdate, '%c월'), MONTH(o.createdate)
  ORDER BY MONTH(o.createdate) DESC LIMIT 6
";

$result = $mysqli->query($sql);

if ($result) {
    while ($row = $result->fetch_object()) {
      array_push($data, $row);
    }
} else {
    die("Query failed: " . $mysqli->error);
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

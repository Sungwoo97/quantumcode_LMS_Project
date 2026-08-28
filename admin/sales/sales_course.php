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

$top_sql = "SELECT l.lid
FROM lecture_order lo
JOIN lecture_list l ON FIND_IN_SET(l.lid, lo.lid)
WHERE lo.status = 1
GROUP BY l.lid
ORDER BY SUM(lo.total_price) DESC
LIMIT 4";
$top_result = $mysqli->query($top_sql);
while ($row = $top_result->fetch_object()){
  $top_data[] = $row->lid;
}

$top_lid = implode(',' , $top_data);

$sql = "SELECT l.title, l.lid, DATE_FORMAT(lo.createdate, '%c월') AS month, SUM(lo.total_price) AS total_sales
    FROM lecture_order lo
    JOIN lecture_list l
    ON FIND_IN_SET(l.lid, lo.lid)
    WHERE lo.status = 1 AND l.lid IN ($top_lid)
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

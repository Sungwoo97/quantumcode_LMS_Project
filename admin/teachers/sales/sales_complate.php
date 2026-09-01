<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
header('Content-Type: application/json');

// 이 화면은 로그인한 강사 본인 강의만 집계한다
$teacher_id = $mysqli->real_escape_string($_SESSION['TUID'] ?? '');
if ($teacher_id === '') {
  echo json_encode([], JSON_UNESCAPED_UNICODE);
  exit;
}

// 완강률 = 실제로 완료한 영상 수 / (수강생 수 x 강의 영상 수)
// 전에는 lecture_data 라는 고정 6행 표의 값을 그대로 뿌렸다
$sql = "SELECT l.title AS lecture_name,
    ROUND(IFNULL(watch.completed_count, 0) / (buyer.student_count * video.video_count) * 100) AS lecture_completion
  FROM lecture_list l
  JOIN (SELECT lid, COUNT(*) AS video_count
        FROM lecture_video GROUP BY lid) video ON video.lid = l.lid
  JOIN (SELECT oi.lid, COUNT(DISTINCT o.mid) AS student_count
        FROM lecture_order_item oi
        JOIN lecture_order o ON o.odid = oi.odid
        WHERE oi.status = 1
        GROUP BY oi.lid) buyer ON buyer.lid = l.lid
  LEFT JOIN (SELECT lid, COUNT(*) AS completed_count
             FROM (SELECT DISTINCT lid, mid, lvid FROM lecture_watch WHERE event_type = 'completed') done
             GROUP BY lid) watch ON watch.lid = l.lid
  WHERE l.t_id = '$teacher_id'
  ORDER BY lecture_completion DESC, buyer.student_count DESC
  LIMIT 3";

$result = $mysqli->query($sql);

$data = [];
while ($row = $result->fetch_object()) {
  $data[] = $row;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

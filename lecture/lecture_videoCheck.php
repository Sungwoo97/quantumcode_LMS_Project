<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
$data = json_decode(file_get_contents('php://input'), true);

$lid = $data['lid'];
$mid = $data['mid'];
$lvid = $data['lvid'];
$eventType = $data['eventType'];
$timestamp = $data['timestamp'];

// PHP에서 timestamp를 한국 시간(KST)으로 변환
$datetime = new DateTime($timestamp, new DateTimeZone('UTC'));  // UTC로 입력받은 timestamp
$datetime->setTimezone(new DateTimeZone('Asia/Seoul'));  // KST로 변환
$timestamp_kst = $datetime->format('Y-m-d H:i:s');  // MySQL에 맞는 형식으로 변환

$sql = "INSERT INTO lecture_watch (lid, mid, lvid, event_type, timestamp) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("issss", $lid, $mid, $lvid, $eventType, $timestamp_kst);

if ($stmt->execute()) {
  echo json_encode(['status' => 'success']);
} else {
  echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

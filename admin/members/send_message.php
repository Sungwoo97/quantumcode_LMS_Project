<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// POST 데이터 받기
$sender_idx = $_POST['sender_idx']; // 관리자 ID
$receiver_mid = $_POST['receiver_mid']; // 수신자 ID
$message = $_POST['message']; // 메시지 내용

if (empty($sender_idx) || empty($receiver_mid) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => '모든 필드를 입력하세요.']);
    exit;
}

// 메시지 저장 쿼리 실행
$sql = "INSERT INTO messages (sender_idx, receiver_mid, message, sent_at) VALUES (?, ?, ?, NOW())";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iis", $sender_idx, $receiver_mid, $message);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => '쪽지를 성공적으로 보냈습니다.']);
} else {
    echo json_encode(['status' => 'error', 'message' => '쪽지 전송 중 오류가 발생했습니다.']);
}

$stmt->close();
$mysqli->close();
?>
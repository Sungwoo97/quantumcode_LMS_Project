<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// POST 데이터 가져오기
$data = json_decode(file_get_contents("php://input"), true);
$receiver_id = $data['receiver_id'] ?? null;

if ($receiver_id) {
    // `is_read` 업데이트 쿼리
    $sql = "UPDATE tomembermessages SET is_read = 1 WHERE receiver_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $receiver_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid receiver ID"]);
}
?>
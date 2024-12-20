<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/db_connect.php'); // DB 연결 파일

header('Content-Type: application/json');

// 로그인 여부 확인
if (!isset($_SESSION['MemEmail'])) {
    echo json_encode([
        'status' => 'error',
        'message' => '로그인이 필요합니다.'
    ]);
    exit;
}

$userEmail = $_SESSION['MemEmail'];
$memId = $_SESSION['MemId'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form 데이터 수집
    $memName = isset($_POST['memName']) ? trim($_POST['memName']) : '';
    $birth = isset($_POST['birth']) ? trim($_POST['birth']) : '';
    $memAddr = isset($_POST['memAddr']) ? trim($_POST['memAddr']) : '';
    $number = isset($_POST['number']) ? trim($_POST['number']) : '';

    // 파일 업로드 처리
    $profilePath = null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/qc/uploads/profiles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['cover_image']['tmp_name'];
        $fileName = basename($_FILES['cover_image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedExtensions)) {
            $newFileName = $memId . '_' . time() . '.' . $fileExt;
            $uploadFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                $profilePath = '/qc/uploads/profiles/' . $newFileName;
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => '프로필 이미지 업로드 실패.'
                ]);
                exit;
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '허용되지 않은 파일 형식입니다.'
            ]);
            exit;
        }
    }

    // SQL 업데이트 준비
    $sql = "UPDATE membersKakao SET memName = ?, birth = ?, memAddr = ?, number = ?";

    if ($profilePath) {
        $sql .= ", memProfilePath = ?";
    }

    $sql .= " WHERE memEmail = ?";

    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => '쿼리 준비 실패: ' . $mysqli->error
        ]);
        exit;
    }

    if ($profilePath) {
        $stmt->bind_param("ssssss", $memName, $birth, $memAddr, $number, $profilePath, $userEmail);
    } else {
        $stmt->bind_param("sssss", $memName, $birth, $memAddr, $number, $userEmail);
    }

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => '정보가 성공적으로 수정되었습니다.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '정보 수정 실패: ' . $stmt->error
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '잘못된 요청입니다.'
    ]);
}

$mysqli->close();
?>

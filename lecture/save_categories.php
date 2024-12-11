<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 로그인된 사용자의 이메일 가져오기
    if (!isset($_SESSION['MemEmail'])) {
        die("로그인이 필요합니다.");
    }
    $userEmail = $_SESSION['MemEmail'];

    // 선택된 카테고리 데이터 가져오기
    if (isset($_POST['selectedCategories'])) {
        $categories = json_decode($_POST['selectedCategories'], true); // JSON -> 배열 변환

        if (!empty($categories)) {
            $stmt = $mysqli->prepare("INSERT INTO user_categories (user_email, category) VALUES (?, ?)");
            foreach ($categories as $category) {
                $stmt->bind_param("ss", $userEmail, $category);
                $stmt->execute();
            }
            $stmt->close();
            echo "카테고리가 성공적으로 저장되었습니다.";
        } else {
            echo "선택된 카테고리가 없습니다.";
        }
    } else {
        echo "데이터가 유효하지 않습니다.";
    }
} else {
    echo "잘못된 요청입니다.";
}
?>
<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memId = $_SESSION['MemId'];
    $memName = $_POST['memName'];
    $birth = $_POST['birth'];
    $memAddr = $_POST['memAddr'];
    $number = $_POST['number'];

    // SQL 쿼리 준비
    $sql = "UPDATE membersKakao 
            SET memName = ?, birth = ?, memAddr = ?, number = ? 
            WHERE memId = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi", $memName, $birth, $memAddr, $number, $memId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('정보가 성공적으로 수정되었습니다.'); location.href = '/qc/users_view.php';</script>";
    } else {
        echo "<script>alert('정보 수정에 실패했습니다. 다시 시도해주세요.'); history.back();</script>";
    }

    $stmt->close();
}
?>
<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';
// $password = hash('sha512', $password);
$password = $_POST['password'];
$memCreateAt = $_POST['memCreateAt'] ?? '';

$sql = "INSERT INTO membersKakao
(memName, memPassword, memEmail, number, memCreatedAt)
VALUES
('$name', '$password', '$email', '$number', '$memCreatedAt')";

echo $sql;

$member_result = $mysqli->query($sql);
if ($member_result) {
  echo "<script>
    alert('이메일이 전송되었습니다. 메일 인증을 해주세요.');
    location.href = 'loginTest2.php';
    </script>";
} else {
  echo "<script>
    alert('회원등록에 실패했습니다.');
    history.back();
  </script>";
}

$mysqli->close();
?>





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
    alert('강사가 등록되었습니다.');
    location.href = 'teacher_list.php';
    </script>";
} else {
  echo "<script>
    alert('등록에 실패했습니다.');
    history.back();
  </script>";
}

$mysqli->close();
?>





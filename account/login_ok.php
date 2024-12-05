<?php

// include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');
$mysqli = require __DIR__ . "/database.php";

$email = $_POST['email'];
$userpw = $_POST['password'];
$password = hash('sha512',$userpw);
$lastLoginAt = $_POST['lastLoginAt'] ?? '';

$sql = "SELECT * FROM memberskakao WHERE memEmail='$email' and mempassword = '$password'";
$result = $mysqli->query($sql);
$data = $result ->fetch_object();

if ($data) {
  // 마지막 로그인 시간 업데이트
  $update_sql = "UPDATE membersKakao SET lastLoginAt = now() WHERE memEmail = ?";
  $update_stmt = $mysqli->prepare($update_sql);
  $update_stmt->bind_param("s", $data->memEmail);
  $update_stmt->execute();

  // 세션 설정
  $_SESSION['MemEmail'] = $data->memEmail;
  $_SESSION['MUID'] = $data->memid;
  $_SESSION['MUNAME'] = $data->memName;
  $_SESSION['Mgrade'] = $data->grade;

  echo "<script>
      alert('회원님 반갑습니다.');
      location.href='loginTest2.php';
  </script>";
} else {
  echo "<script>
      alert('아이디 또는 비번이 맞지 않습니다.');
      location.href='loginTest2.php';
  </script>";
}
?>
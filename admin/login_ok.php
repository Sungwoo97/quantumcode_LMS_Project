<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');

$userid = $_POST['userid'];
$userpw = $_POST['userpw'];
$password = hash('sha512',$userpw);

// 아이디를 쿼리에 직접 넣으면 ' OR '1'='1 로 로그인을 우회할 수 있어 prepared statement 로 바꿈
$stmt = $mysqli->prepare("SELECT * FROM admins WHERE userid = ? AND passwd = ?");
$stmt->bind_param("ss", $userid, $password);
$stmt->execute();
$data = $stmt->get_result()->fetch_object();

if($data){
  $update_sql = "UPDATE admins SET last_login = now() WHERE idx = $data->idx";
  $update_result = $mysqli->query($update_sql);
  $_SESSION['AUIDX'] = $data->idx;
  $_SESSION['AUID'] = $data->userid;
  $_SESSION['AUNAME'] = $data->username;
  $_SESSION['AULEVEL'] = $data->level;

  echo "<script>
    alert('관리자님 반갑습니다.');
    location.href='index.php';
  </script>";

}else{
  echo "<script>
    alert('아이디 또는 비번이 맞지 않습니다.');
    history.back();
  </script>";
}


?>
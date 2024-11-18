<?php
// session_start(); 이거 살려야함? 지워야함?? header.php에 있으니깐 중복이라고 자꾸 나와서 일단 지워봄

include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');

$id = $_POST['id'];
$password = $_POST['password'];
$sql = "SELECT * FROM teachers WHERE id='$id' and password = '$password'";
$result = $mysqli->query($sql);
$data = $result ->fetch_object();

if($data){
  $update_sql = "UPDATE teachers SET last_login = now() WHERE tid = $data->tid";
  $update_result = $mysqli->query($update_sql);
  $_SESSION['AUID'] = $data->id;
  $_SESSION['AUNAME'] = $data->name;

  echo "<script>
    alert('$data->name 님 반갑습니다. 아이디는 $data->id 입니다.');
    location.href='index.php';
  </script>";

}else{
  echo "<script>
    alert('아이디 또는 비번이 맞지 않습니다.');
    history.back();
  </script>";
}


?>
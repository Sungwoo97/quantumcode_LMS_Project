<?php
// session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');

$id = $_POST['id'];
$password = $_POST['password'];
$password = hash('sha512',$password);

$sql = "SELECT * FROM teachers WHERE id='$id' and password = '$password'";
$result = $mysqli->query($sql);
$data = $result ->fetch_object();

if($data){
  $update_sql = "UPDATE teachers SET last_login = now() WHERE tid = $data->tid";
  $update_result = $mysqli->query($update_sql);
  $_SESSION['AUIDX'] = $data->tid;
  $_SESSION['AUID'] = $data->id;
  $_SESSION['AUNAME'] = $data->name;

  echo "<script>
    alert('강사님 반갑습니다.');
    location.href='index.php';
  </script>";

}else{
  echo "<script>
    alert('아이디 또는 비번이 맞지 않습니다.');
    history.back();
  </script>";
}


?>
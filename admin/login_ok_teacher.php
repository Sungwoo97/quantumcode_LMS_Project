<?php
// session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/teachers/inc/header.php');

$id = $_POST['id'];
$password = $_POST['password'];
$password = hash('sha512',$password);

// 아이디를 쿼리에 직접 넣으면 로그인을 우회할 수 있어 prepared statement 로 바꿈
$stmt = $mysqli->prepare("SELECT * FROM teachers WHERE id = ? AND password = ?");
$stmt->bind_param("ss", $id, $password);
$stmt->execute();
$data = $stmt->get_result()->fetch_object();

if($data){
  $update_sql = "UPDATE teachers SET last_login = now() WHERE tid = $data->tid";
  $update_result = $mysqli->query($update_sql);
  $_SESSION['TUIDX'] = $data->tid;
  $_SESSION['TUID'] = $data->id;
  $_SESSION['TUNAME'] = $data->name;

  echo "<script>
    alert('강사님 반갑습니다.');
    location.href = '/qc/admin/teachers/lecture/lecture_list.php';
  </script>";

}else{
  echo "<script>
    alert('아이디 또는 비번이 맞지 않습니다.');
    history.back();
  </script>";
}


?>
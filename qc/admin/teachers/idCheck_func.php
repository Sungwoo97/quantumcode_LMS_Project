<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

$id = $_POST['id'] ?? '';


//중복 id 개수 조회
$id_sql = "SELECT COUNT(*) AS cnt FROM teachers WHERE id='$id' ";
$id_result = $mysqli->query($id_sql);


$row = $id_result -> fetch_object(); // $row->cnt
$row_num = $row['cnt'];

if($row_num >= 1){
  $return_data = array('result'=>'error');
  echo json_encode($return_data);
}else if($row_num == 0){ 
  $return_data = array('result'=>'ok');
  echo json_encode($return_data);
}

$mysqli->close();
?>






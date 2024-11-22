<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');

$pid = $_GET['pid'];
$category = $_GET['category'];

echo $pid;

$sql = "SELECT pid,status FROM board WHERE pid=$pid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

echo $data -> status;

if($data->status == 0 ){
  $update_sql = "UPDATE board SET status = status +1 WHERE pid=$pid";
  $update_result = $mysqli->query($update_sql);
};


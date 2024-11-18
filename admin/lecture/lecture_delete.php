<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

$lid = $_GET['lid'];

$sql = "SELECT * FROM lecture_list WHERE lid = $lid";
if (!isset($lid)) {
  echo "<script>alert('상품정보가 없습니다.'); location.href = 'lecture_list.php';</script>";
}

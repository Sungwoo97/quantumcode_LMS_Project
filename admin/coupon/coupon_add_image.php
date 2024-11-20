<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/common.php');

$fileUploadResult = fileUpload($_FILES['savefile'],'image');
$cid = $_POST['cid'];
if($fileUploadResult) {
  $sql = "INSERT INTO coupons_image (cid, image_coupon) VALUES ($cid ,'$fileUploadResult')";
  $result = $mysqli->query($sql);
  $imgid = $mysqli->insert_id; //테이블에 자동으로 저장되는 고유번호 조회
  $return_data = array('result'=>'성공', 'imgid'=>$imgid, 'savefile'=>$fileUploadResult); //연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
} else {
  $return_data = array('result'=>'error'); //연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
}

$mysqli->close();
?>
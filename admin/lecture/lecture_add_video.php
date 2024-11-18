<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/common.php');

$fileUploadResult = fileUpload($_FILES['savefile'], 'video');
$lid = $_POST['lid'];
if ($fileUploadResult) {
  $sql = "INSERT INTO lecture_video (lid, video_lecture) VALUES ($lid ,'$fileUploadResult')";
  $result = $mysqli->query($sql);
  $vidid = $mysqli->insert_id; //테이블에 자동으로 저장되는 고유번호 조회
  $return_data = array('result' => '성공', 'vidid' => $vidid, 'savefile' => $fileUploadResult); //연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
} else {
  $return_data = array('result' => 'error'); //연관배열
  echo json_encode($return_data); //연관배열 -> 객체
  exit;
}

$mysqli->close();

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/dbcon.php');

$category = $_GET['category'];
$idx = $_GET['idx'];
$pid_column = '';

switch ($category) {
  case 'qna':
      $table = 'board_qna';
      $like_column = 'qb_like';
      $pid_column = 'qb_pid';
      break;
  case 'notice':
      $table = 'board_notice';
      $like_column = 'nb_like';
      $pid_column = 'nb_pid';
      break;
  case 'event':
      $table = 'board_event';
      $like_column = 'eb_like';
      $pid_column = 'eb_pid';
      break;
  case 'free':
      $table = 'board_free';
      $like_column = 'fb_like';
      $pid_column = 'fb_pid';
      break;
  default:
      die("유효하지 않은 카테고리입니다.");
}

$sql = "SELECT $like_column FROM $table WHERE $pid_column = $idx";
$result = $mysqli->query($sql);
$data = $result->fetch_object();
$likes = $data->{$like_column}+1;

// 추천수 증가 SQL 쿼리
$likeSql = "UPDATE $table SET $like_column = $likes WHERE $pid_column = $idx";
if ($mysqli->query($likeSql)) {
  echo json_encode(['status' => 'success', 'likes' => $likes]);  // 추천수 반환
} else {
  echo json_encode(['status' => 'error', 'message' => '추천 실패']);
}
?>
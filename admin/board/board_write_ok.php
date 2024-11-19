<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');


$user_id = $_SESSION['AUID'] ?? '';

$category = $_POST['category'];
$title1 = $_POST['title'];
$content = $_POST['content'];
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
//print_r($_FILES['file']['name']);

//파일 업로드
$file_name = $_FILES['file']['name'];
$temp_path = $_FILES['file']['tmp_name'];
$upload_path = './upload/'.$file_name;
move_uploaded_file($temp_path,$upload_path);

strpos($_FILES['file']['type'], 'image') !== false ? $is_img = 1 : $is_img = 0;



$max_file_size = 10*1024*1024;

if($_FILES['file']['size'] >$max_file_size ){
  echo "<script>
      alert('10MB 이상은 첨부할수 없습니다.');
      history.back();
  </script>";
}


$sql = "INSERT INTO board (category, title, content, img, is_img, start_date, end_date, user_id) VALUES ('$category', '$title1', '$content', '$upload_path', $is_img, '$start_date', '$end_date','$user_id')";
$result = $mysqli->query($sql);

switch ($category) {
  case 'qna':
      $redirect_url = '/qc/admin/board/board_list.php?category=qna';
      break;
  case 'notice':
      $redirect_url = '/qc/admin/board/board_list.php?category=notice';
      break;
  case 'event':
      $redirect_url = '/qc/admin/board/board_list.php?category=event';
      break;
  case 'free':
      $redirect_url = '/qc/admin/board/board_list.php?category=free';
      break;
  default:
      die("카테고리를 선택 해주세요.");
}

if ($result) {
  echo "<script>
      alert('글 작성 완료');
      location.href='$redirect_url';
  </script>";
} else {
  echo "<script>
      alert('글 작성 실패');
      history.back();
  </script>";
}
?>
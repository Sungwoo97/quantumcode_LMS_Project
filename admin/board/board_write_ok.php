<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');

// board_write_ok.php 예시
$category = $_POST['category'];
$title1 = $_POST['title'];
$content = $_POST['content'];
$image = $_POST['image'];

$sql = "INSERT INTO board (category, title, content) VALUES ('$category', '$title1', '$content')";
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


if($result){
  echo "<script>
    alert('글 작성 완료');
    location.href='$redirect_url';
    </script>";
}else{
  echo "<script>
  alert('글 작성 실패');
   history.back();
  </script>";
}
?>
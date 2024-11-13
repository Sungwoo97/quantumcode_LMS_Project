<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/dbcon.php');
$category = $_POST['category'];
$pid = $_POST['pid'];
$title1 = $_POST['title'];
$content = $_POST['content'];

switch ($category) {
    case 'all':
        $redirect_url = "/admin/board/read.php?pid=".$pid."&category=all";
        break;
    case 'qna':
        $redirect_url = '/admin/board/read.php?pid='.$pid.'&category=qna'; 
        break;
    case 'notice':
        $redirect_url = '/admin/board/read.php?pid='.$pid.'&category=notice'; 
        break;
    case 'event':
        $redirect_url = '/admin/board/read.php?pid='.$pid.'&category=event'; 
        break;
    case 'free':
        $redirect_url = '/admin/board/read.php?pid='.$pid.'&category=free'; 
        break;
    default:
        die("유효하지 않은 카테고리입니다.");
}

$sql = "UPDATE board SET title='$title1',content='$content' WHERE pid= $pid";
$result = $mysqli->query($sql);
if($result){
  echo "<script>
    alert('글 수정 완료');
    location.href='$redirect_url';
    </script>";
}else{
  echo "<script>
  alert('글 수정 실패');
   history.back();
  </script>";
}
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/dbcon.php');

// POST 데이터 수신
$category = $_POST['category'];
$title = $_POST['title'];
$content = $_POST['content'];

// 카테고리에 맞는 테이블 선택
$table = ''; 
$title_column = '';
$content_column = '';
switch ($category) {
    case 'qna':
        $table = 'board_qna';
        $title_column = 'qb_title';
        $content_column = 'qb_content';
        $redirect_url = '/admin/board/qna_list.php';
        break;
    case 'notice':
        $table = 'board_notice';
        $title_column = 'nb_title';
        $content_column = 'nb_content';
        $redirect_url = '/admin/board/notice_list.php';
        break;
    case 'event':
        $table = 'board_event';
        $title_column = 'eb_title';
        $content_column = 'eb_content';
        $redirect_url = '/admin/board/event_list.php';
        break;
    case 'free':
        $table = 'board_free';
        $title_column = 'fb_title';
        $content_column = 'fb_content';
        $redirect_url = '/admin/board/free_list.php';
        break;
    default:
        die("카테고리를 선택 해주세요.");
}

$sql = "INSERT INTO $table ($title_column, $content_column) VALUES ('$title','$content')";
$result = $mysqli -> query($sql);

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
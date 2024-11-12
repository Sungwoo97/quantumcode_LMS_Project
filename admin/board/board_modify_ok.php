<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/dbcon.php');
$category = $_POST['category'];
$idx = $_POST['idx'];
$title = $_POST['title'];
$content = $_POST['content'];

$table = '';
$pid_column = '';  // 각 카테고리에 맞는 ID 컬럼명 추가
$title_column = ''; // 제목 컬럼
$user_id_column = '';  // 글쓴이 컬럼
$content_column = '';  // 컨텐츠 컬럼
switch ($category) {
    case 'qna':
        $table = 'board_qna';
        $pid_column = 'qb_pid';
        $title_column = 'qb_title';
        $user_id_column = 'qb_user_id';
        $content_column = 'qb_content';
        $redirect_url = '/admin/board/qna_list.php'; 
        break;
    case 'notice':
        $table = 'board_notice';
        $pid_column = 'nb_pid';
        $title_column = 'nb_title'; 
        $user_id_column = 'nb_user_id'; 
        $content_column = 'nb_content';
        $redirect_url = '/admin/board/notice_list.php';
        break;
    case 'event':
        $table = 'board_event';
        $pid_column = 'eb_pid';
        $title_column = 'eb_title'; 
        $user_id_column = 'eb_user_id';  
        $content_column = 'eb_content';
        $redirect_url = '/admin/board/event_list.php';
        break;
    case 'free':
        $table = 'board_free';
        $pid_column = 'fb_pid';
        $title_column = 'fb_title'; 
        $user_id_column = 'fb_user_id'; 
        $content_column = 'fb_content';
        $redirect_url = '/admin/board/free_list.php';
        break;
    default:
        die("유효하지 않은 카테고리입니다.");
}

$sql = "UPDATE $table SET $title_column='$title',$content_column='$content' WHERE $pid_column= $idx";
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
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/dbcon.php');

$idx = $_GET['idx'];

// GET 데이터 수신
$category = $_GET['category'];
$pid_column ='';

// 카테고리에 맞는 테이블 선택
$table = ''; 
switch ($category) {
    case 'qna':
        $table = 'board_qna';
        $pid_column = 'qb_pid';
        $redirect_url = '/admin/board/qna_list.php';        
        $un_redirect_url = '/admin/board/read.php';        
        break;
    case 'notice':
        $table = 'board_notice';
        $pid_column = 'nb_pid';
        $redirect_url = '/admin/board/notice_list.php';
        $un_redirect_url = '/admin/board/read.php';      
        break;
    case 'event':
        $table = 'board_event';
        $pid_column = 'eb_pid';
        $redirect_url = '/admin/board/event_list.php';
        $un_redirect_url = '/admin/board/read.php';      
        break;
    case 'free':
        $table = 'board_free';
        $pid_column = 'fb_pid';
        $redirect_url = '/admin/board/free_list.php';
        $un_redirect_url = '/admin/board/read.php';      
        break;
    default:
        die("침몰");
}

$sql = "DELETE FROM $table WHERE $pid_column = $idx";
if($mysqli->query($sql) === true){
  echo "<script>
  alert('글 삭제 성공');
  location.href='$redirect_url';
  </script>";
}else{
  echo "<script>
  alert('글 삭제 실패');
  location.href='$un_redirect_url';
  </script>";
}



?>
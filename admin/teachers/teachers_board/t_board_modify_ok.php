<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');
$category = $_POST['category'];
$pid = $_POST['pid'];
$title1 = $_POST['title'];  // 제목
$content = $_POST['content'];  // 내용
$img = $_POST['old_img'];  // 기존 이미지값 (새 이미지가 없으면 기존값 사용)
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

echo $start_date;
echo $end_date;

// 새 이미지가 업로드 되었을 경우
if (!empty($_FILES['file']['name'])) {
    $target_dir = "./upload/";
    $target_file = $target_dir . basename($_FILES['file']['name']);

    // 이미지 파일 업로드 처리
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        $img = $target_file;  // 새 이미지 경로로 변경
    } else {
        // 업로드 실패 처리 (optional)
        echo "파일 업로드에 실패했습니다.";
    }
}


switch ($category) {
    case 'all':
        $redirect_url = "/qc/admin/teachers/teachers_board/t_read.php?pid=".$pid."&category=all";
        break;
    case 'qna':
        $redirect_url = '/qc/admin/teachers/teachers_board/t_read.php?pid='.$pid.'&category=qna'; 
        break;
    case 'notice':
        $redirect_url = '/qc/admin/teachers/teachers_board/t_read.php?pid='.$pid.'&category=notice'; 
        break;
    case 'event':
        $redirect_url = '/qc/admin/teachers/teachers_board/t_read.php?pid='.$pid.'&category=event'; 
        break;
    case 'free':
        $redirect_url = '/qc/admin/teachers/teachers_board/t_read.php?pid='.$pid.'&category=free'; 
        break;
    default:
        die("유효하지 않은 카테고리입니다.");
}

$sql = "UPDATE board SET title='$title1',content='$content', img='$img', start_date='$start_date', end_date = '$end_date' WHERE pid= $pid";
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
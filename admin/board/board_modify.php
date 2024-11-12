<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');

$category = $_GET['category'];
$idx = $_GET['idx']; 

// 카테고리에 맞는 테이블과 컬럼 설정
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

$sql = "SELECT * FROM $table WHERE $pid_column = $idx";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

?>

<h1>게시판 수정</h1>

<form action="board_modify_ok.php" method="POST">
  <input type="hidden" name="idx" value="<?=$data->{$pid_column}?>">
  <select class="form-select" name="category" aria-label="Default select example" required >
    <option value="notice" <?= ($category == 'notice') ? 'selected' : ''; ?>>공지사항</option>
    <option value="free" <?= ($category == 'free') ? 'selected' : ''; ?>>자유게시판</option>
    <option value="event" <?= ($category == 'event') ? 'selected' : ''; ?>>이벤트</option>
    <option value="qna" <?= ($category == 'qna') ? 'selected' : ''; ?>>질문과답변</option>
  </select>
  <div class="mb-3">
    <label for="title" class="form-label">제목:</label>
    <input type="text" class="form-control" name="title" id="title" value="<?=$data->{$title_column}?>" placeholder="제목입력">
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">내용:</label>
    <textarea class="form-control" id="content" name="content" rows="3" value=""><?=$data->{$content_column}?></textarea>
  </div>
  <div class="d-flex justify-content-end">
    <button class="btn btn-primary">등록</button>
    <button class="btn btn-danger">취소</button>
  </div  d-flex justify-content-end>
</form>



<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
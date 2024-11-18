<?php
$title = "게시판 수정";
$board_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/board.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');

$category = $_GET['category'];
$pid = $_GET['pid']; 

$sql = "SELECT * FROM board WHERE pid = $pid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

$cate_sql = "SELECT category FROM board WHERE pid=$pid";
$cate_result = $mysqli->query($cate_sql);
$cate_data = $cate_result->fetch_object();

$category = $cate_data->category ?? 'all';


switch ($category) {
  case 'all':
      $redirect_url = "/qc/admin/board/read.php?pid=" . $pid . "&category=all";
      break;
  case 'qna':
      $redirect_url = "/qc/admin/board/read.php?pid=" . $pid . "&category=qna"; 
      break;
  case 'notice':
      $redirect_url = "/qc/admin/board/read.php?pid=" . $pid . "&category=notice"; 
      break;
  case 'event':
      $redirect_url = "/qc/admin/board/read.php?pid=" . $pid . "&category=event"; 
      break;
  case 'free':
      $redirect_url = "/qc/admin/board/read.php?pid=" . $pid . "&category=free"; 
      break;
  default:
      die("유효하지 않은 카테고리입니다.");
}


?>


<form action="board_modify_ok.php" method="POST" class="row">
  <input type="hidden" name="pid" value="<?=$data->pid?>">
  <div class="mb-3 col-4">
    <div class="box mb-3">
      <img id="imgPreview" src="#" alt="이미지 미리보기" style="display:none; width: 100%; height: 100%; object-fit: contain;">
    </div>
    <input class="form-control" accept="image/*" name="file" type="file" id="file" onchange="previewImage(event)">
  </div>
  <div class="col-8">
    <select class="form-select w-25 mb-3" name="category" aria-label="Default select example" required >
      <option value="notice" <?= ($category == 'notice') ? 'selected' : ''; ?>>공지사항</option>
      <option value="free" <?= ($category == 'free') ? 'selected' : ''; ?>>자유게시판</option>
      <option value="event" <?= ($category == 'event') ? 'selected' : ''; ?>>이벤트</option>
      <option value="qna" <?= ($category == 'qna') ? 'selected' : ''; ?>>질문과답변</option>
    </select>
    <div class="mb-3 d-flex gap-3">
      <label for="title" class="form-label">제목:</label>
      <input type="text" class="form-control w-50" name="title" id="title" value="<?=$data->title?>" placeholder="제목입력">
    </div>
    <div class="mb-3 d-flex gap-3">
      <label for="content" class="form-label">내용:</label>
      <textarea class="form-control w-50" id="content" name="content" rows="3" value=""><?=$data->content?></textarea>
    </div>
  </div>
  <div class="d-flex justify-content-end gap-3">
    <button class="btn btn-primary">등록</button>
    <a href="<?=$redirect_url?>" class="btn btn-danger">취소</a>
  </div>
</form>




<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?>
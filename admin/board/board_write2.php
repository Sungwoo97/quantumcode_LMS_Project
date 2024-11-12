<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');
?>

<h1>게시판 글등록</h1>

<form action="board_write2_ok.php" method="POST">
  <select class="form-select" name="category" aria-label="Default select example" required >
    <option value="" selected>카테고리 선택</option>
    <option value="notice">공지사항</option>
    <option value="free">자유게시판</option>
    <option value="event">이벤트</option>
    <option value="qna">질문과답변</option>
  </select>
  <div class="mb-3">
    <label for="title" class="form-label">제목:</label>
    <input type="text" class="form-control" name="title" id="title" placeholder="제목입력" required>
  </div>
  <div class="mb-3">
    <label for="content" class="form-label">내용:</label>
    <textarea class="form-control" id="content" name="content" rows="3" value="" required></textarea>
  </div>
  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">등록</button>
    <button class="btn btn-danger">취소</button>
  </div  d-flex justify-content-end>
</form>
 
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
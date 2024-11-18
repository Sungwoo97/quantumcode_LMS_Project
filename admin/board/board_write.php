<?php
$title = '게시판 글등록';
$board_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/board.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');
?>


<form action="board_write_ok.php" method="POST" enctype="multipart/form-data" class="row">
  <div class="mb-3 col-4">
    <div class="box mb-3">
      <img id="imgPreview" src="#" alt="이미지 미리보기" style="display:none; width: 100%; height: 100%; object-fit: contain;">
    </div>
    <input class="form-control" accept="image/*" name="file" type="file" id="file" onchange="previewImage(event)">
  </div>
  <div class="col-8">
    <select class="form-select w-25 mb-3" name="category" aria-label="Default select example" required >
      <option value="" selected>카테고리 선택</option>
      <option value="notice">공지사항</option>
      <option value="free">자유게시판</option>
      <option value="event">이벤트</option>
      <option value="qna">질문과답변</option>
    </select>
    <div class="mb-3 d-flex gap-3">
      <label for="title" class="form-label">제목:</label>
      <input type="text" class="form-control w-75" name="title" id="title" placeholder="제목입력" required>
    </div>
    <div class="mb-3 d-flex gap-3">
      <label for="content" class="form-label">내용:</label>
      <textarea class="form-control w-75" id="content" name="content" rows="3" value="" required></textarea>
    </div>
    <div class="d-flex justify-content-end gap-3">
      <button type="submit" class="btn btn-primary">등록</button>
      <button id="cancle" class="btn btn-danger">취소</button>
    </div>
  </div>
</form>
<script>
  // 취소 버튼 클릭 시 이전 페이지로 돌아가기
  document.getElementById('cancle').addEventListener('click', function() {
    window.history.back();  // 이전 페이지로 돌아가기
  });


  //이미지 미리보기
  function previewImage(event){
    const file = event.target.files[0]; //선택한 파일을 가져옴
    const reader = new FileReader(); // 파일리더 객체 생성

    reader.onload = function(e){
      const imgPreview = document.querySelector('#imgPreview');
      imgPreview.src = e.target.result; //미리보기 이미지 설정
      imgPreview.style.display="block";
    }

    if(file) {
      reader.readAsDataURL(file); //파일을 data url 형식으로 ㅇ릭음
    }

  }


</script>
 
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?>
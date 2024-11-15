<?php
$title = '카테고리 관리';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.php');
?>

<div class="container">
  <div class="row d-flex  category">
    <div class="col-3 mb-5 text-center">
      <h5>Platforms</h5>
      <div class="d-flex gap-2 mt-4">
        <select class="form-select" name="platforms" required>
          <option value="" selected>Platforms</option>
          <!-- <option value="A0001">Web</option> -->
        </select>
        <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="platforms_btn">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 text-center">
      <h5>Development</h5>
      <div class="d-flex gap-2 mt-4">
        <select class="form-select " name="development" required>
          <option value="" selected>Development</option>
          <!-- <option value="B0001">Front-End</option> -->
        </select>
        <button class=" btn btn-primary ">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 text-center">
      <h5>Technologies</h5>
      <div class="d-flex gap-2 mt-4">
        <select class="form-select " name="technologies" required>
          <option value="" selected>Technologies</option>
          <!-- <option value="C0001">React</option> -->
        </select>
        <button class=" btn btn-primary ">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 d-flex align-items-end gap-2">
      <input type="text" name="keywords" class="form-control ">
      <button class=" btn btn-secondary ">검색</button>
    </div>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">제목</th>
        <th scope="col">글쓴이</th>
        <th scope="col">내용</th>
        <th scope="col">등록일</th>
        <th scope="col">추천수</th>
        <th scope="col">조회수</th>
        <th scope="col">Edit</th>
      </tr>
    </thead>
    <tbody>
</div>
<div class="modal fade" id="exampleModal" tabindex="1001" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <h5>Platforms</h5>
        <form action="">
          <div class="row">
            <div class="d-flex gap-2 col-10">
              <input type="text" class="form-control ">
              <button class=" btn btn-secondary ">등록</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<script>
  $('.platforms_modal').hide();
  $('#platforms_btn').click(() => {
    $('.platforms_modal').fadeIn();
    $('.modal-bg').removeClass('hidden');
  })
  $('.close').click(() => {
    $('.platforms_modal').fadeOut();
  })
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/footer.php');
?>
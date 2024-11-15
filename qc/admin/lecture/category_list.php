<?php
$title = '카테고리 관리';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

?>

<div class="container">
  <div class="row d-flex  category">
    <div class="col-3 mb-5 text-center">
      <h5>Platforms</h5>
      <div class="d-flex gap-2 mt-4">
        <select class="form-select" name="platforms">
          <option value="" selected>Platforms</option>
          <!-- <option value="A0001">Web</option> -->
        </select>
        <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#platformsModal" id="platforms_btn">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 text-center">
      <h5>Development</h5>
      <div class="d-flex gap-2 mt-4">
        <select class="form-select " name="development">
          <option value="" selected>Development</option>
          <!-- <option value="B0001">Front-End</option> -->
        </select>
        <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#developmentModal" id="development_btn">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 text-center">
      <h5>Technologies</h5>
      <div class="d-flex gap-2 mt-4">
        <select class="form-select " name="technologies">
          <option value="" selected>Technologies</option>
          <!-- <option value="C0001">React</option> -->
        </select>
        <button class=" btn btn-primary " data-bs-toggle="modal" data-bs-target="#technologiesModal" id="technologies_btn">등록</button>
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
<div class="modal fade" id="platformsModal" tabindex="1001" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Platforms</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" data-step="1" class="platforms">
          <div class="row d-flex justify-content-center">
            <div class="d-flex justify-content-center gap-2 w-100">
              <input type="text" name="platform" id="platform" class="form-control w-75">
              <button class=" btn btn-primary ">등록</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="developmentModal" tabindex="1001" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Development</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" data-step="2" class="development">
          <div class="row d-flex flex-column gap-3">
            <div>
              <select class="form-select w-50" name="platforms" id="pcode2">
                <option value="" selected>Platforms</option>
                <option value="A0001">Web</option>
              </select>
            </div>
            <div class="d-flex gap-2 w-100">
              <input type="text" id="development" class="form-control w-75">
              <button class=" btn btn-primary ">등록</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="technologiesModal" tabindex="1001" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Technologies</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" data-step="3" class="technologies">
          <div class="row d-flex d-flex flex-column gap-3">
            <div class="d-flex gap-2 w-100">
              <select class="form-select flex-fill" name="platforms" id="pcode2">
                <option value="" selected>Platforms</option>
                <option value="A0001">Web</option>
              </select>
              <select class="form-select flex-fill" name="development" id="pcode3">
                <option value="" selected>Development</option>
                <option value="B0001">FrontEnd</option>
              </select>
            </div>
            <div class="d-flex justify-content-center gap-2 w-100">
              <input type="text" id="technologies" class="form-control w-75">
              <button class=" btn btn-primary ">등록</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('.platforms').submit(function(e) {
    e.preventDefault();
    console.log($(this).find('input[type="text"]'));
    let step = Number($(this).attr('data-step'));
    let pcode = null;
    let name = $(this).find('input[type="text"]').val();

    let data = {
      name: name,
      pcode: pcode,
      step: step
    }
    $.ajax({
      data: data,
      type: 'POST',
      async: false,
      dataType: 'json',
      url: 'category_insert.php',
      success: function(r_data) {
        console.log(r_data);
        if (r_data.result == 1) {
          alert('등록완료');
          location.reload(); //새로고침
        } else {
          alert('등록 실패');
        }
      },
      error: function(err) {
        console.log(err);
      }
    })
  })

  $('.technologies').submit(function(e) {
    e.preventDefault();
    let step = Number($(this).attr('data-step'));
    let pcode = $(`#pcode${step}`).val();
    let name = $('#technologies').val();

    let data = {
      name: name,
      pcode: pcode,
      step: step
    }
    console.log(data);
    $.ajax({
      data: data,
      type: 'POST',
      async: false,
      dataType: 'json',
      url: 'category_insert.php',
      success: function(r_data) {
        console.log(r_data);
        if (r_data.result == 1) {
          alert('등록완료');
          location.reload(); //새로고침
        } else {
          alert('등록 실패');
        }
      },
      error: function(err) {
        console.log(err);
      }
    })
  })
  $('.development').submit(function(e) {
    e.preventDefault();
    let step = Number($(this).attr('data-step'));
    let pcode = $(`#pcode${step}`).val();
    let name = $('#development').val();

    let data = {
      name: name,
      pcode: pcode,
      step: step
    }
    console.log(data);
    $.ajax({
      data: data,
      type: 'POST',
      async: false,
      dataType: 'json',
      url: 'category_insert.php',
      success: function(r_data) {
        console.log(r_data);
        if (r_data.result == 1) {
          alert('등록완료');
          location.reload(); //새로고침
        } else {
          alert('등록 실패');
        }
      },
      error: function(err) {
        console.log(err);
      }
    })
  })


  function addCategory() {

  }
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
<?php
$title = '카테고리 관리';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

if (!isset($_SESSION['AUID'])) {
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

$sql = "SELECT * FROM lecture_category WHERE step = 1 ";
$result = $mysqli->query($sql);
while ($data = $result->fetch_object()) { //조회된 값들 마다 할일, 값이 있으면 $data할당
  $cate[] = $data; //$cate1배열에 $data할당
}

// $cate_sql = "SELECT * FROM lecture_category WHERE step = 2 ";
// $cate_result = $mysqli->query($cate_sql) ;
// while($data = $cate_result->fetch_object()){ //조회된 값들 마다 할일, 값이 있으면 $data할당
//   $cateArr[]= $data; //$cate1배열에 $data할당
// }
$html = '';
$list = array();
$list_sql = "SELECT * FROM lecture_category WHERE step = 3";
$list_result = $mysqli->query($list_sql);
while ($list_data = $list_result->fetch_object()) { //조회된 값들 마다 할일, 값이 있으면 $data할당
  $list[] = $list_data; //$cate1배열에 $data할당
}

if (count($list) > 0) {
  $i = 1;
  foreach ($list as $list) {
    $pcode_name_sql = "SELECT name FROM lecture_category WHERE code = '{$list->pcode}' AND pcode = '{$list->ppcode}'";
    $ppcode_name_sql = "SELECT name FROM lecture_category WHERE code = '{$list->ppcode}'";

    $pcode_result = $mysqli->query($pcode_name_sql);
    $ppcode_result = $mysqli->query($ppcode_name_sql);

    $pcode_name = ($pcode_result && $pcode_result->num_rows > 0) ? $pcode_result->fetch_object()->name : "Unknown";
    $ppcode_name = ($ppcode_result && $ppcode_result->num_rows > 0) ? $ppcode_result->fetch_object()->name : "Unknown";

    $html .= "<tr class=\"border-bottom border-secondary-subtitle\">
        <th >{$i}</th>
        <td>{$ppcode_name}</td>
        <td>{$pcode_name}</td>
        <td>{$list->name}</td>
        <td><img src=\"../img/icon-img/Edit.svg\" id=\"edit{$i}\" width=\"20\"></td>
      </tr>";
    $i++;
  }
}


?>

<div class="container">
  <div class="row d-flex  category">
    <div class="col-3 mb-5 text-center">
      <h5>Platforms</h5>
      <div class="d-flex gap-2 mt-4" id="plat">
        <select class="form-select plat" name="platforms">
          <option value="" selected>Platforms</option>
          <?php
          if (!empty($cate)) {
            foreach ($cate as $plat) {
          ?>
              <option value="<?= $plat->code; ?>"><?= $plat->name; ?></option>
          <?php
            }
          }
          ?>
        </select>
        <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#platformsModal" id="platforms_btn">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 text-center">
      <h5>Development</h5>
      <div class="d-flex gap-2 mt-4" id="dev">
        <select class="form-select dev" name="development">
          <option value="" selected>Development</option>
          <!-- <option value="B0001">Front-End</option> -->
        </select>
        <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#developmentModal" id="development_btn">등록</button>
      </div>
    </div>
    <div class="col-3 mb-5 text-center">
      <h5>Technologies</h5>
      <div class="d-flex gap-2 mt-4" id="tech">
        <select class="form-select tech" name="technologies">
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
  <table class="table table-hover text-center">
    <thead>
      <tr class="border-bottom border-secondary-subtitle thline">
        <th scope="col">No</th>
        <th scope="col">Platforms</th>
        <th scope="col">Development</th>
        <th scope="col">Technologies</th>
        <th scope="col">Edit</th>
      </tr>
    </thead>
    <tbody>
      <?= $html; ?>
    </tbody>
  </table>
</div>
<div class="modal fade" id="platformsModal" tabindex="1001" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Platforms</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" data-step="1" class="platform">
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
                <?php
                if (!empty($cate)) {
                  foreach ($cate as $plat) {
                ?>
                    <option value="<?= $plat->code; ?>"><?= $plat->name; ?></option>
                <?php
                  }
                }
                ?>
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
              <select class="form-select flex-fill plats" name="platforms" id="pcode2">

                <?php
                if (!empty($cate)) {
                  foreach ($cate as $plat) {
                ?>
                    <option value="<?= $plat->code; ?>"><?= $plat->name; ?></option>
                <?php
                  }
                }
                ?>
              </select>
              <select class="form-select flex-fill devs" name="development" id="pcode3">

                <option value="" selected>Development</option>
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
<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/js/common.js"></script>
<script>
  $('.platform').submit(function(e) {
    e.preventDefault();
    let step = Number($(this).attr('data-step'));
    let pcode = null;
    let ppcode = null;
    let name = $('#platform').val();
    addCategory(name, pcode, ppcode, step);
  })

  $('.development').submit(function(e) {
    e.preventDefault();
    let step = Number($(this).attr('data-step'));
    console.log(step);
    let pcode = $(`#pcode${step}`).val();
    let ppcode = null;
    let name = $('#development').val();
    addCategory(name, pcode, ppcode, step);
  })

  $('.technologies').submit(function(e) {
    e.preventDefault();
    let step = Number($(this).attr('data-step'));
    let pcode = $(`#pcode${step}`).val();
    let ppcode = $('.plats').val();

    let name = $('#technologies').val();
    addCategory(name, pcode, ppcode, step);
  })

  makeOption($('.plats'), 2, $('.devs'), '');


  // submit 이벤트, input의 값, 
  function addCategory(name, pcode, ppcode, step) {

    let data = {
      name: name,
      pcode: pcode,
      ppcode: ppcode,
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
  }

  $('#plat').on('change', '.plat', function() {
    let platValue = $(this).val();
    makeOption($(this), 2, $('.dev'), '').then(() => {
      $('.dev').trigger('change'); // dev의 change 이벤트 실행
    })
  });

  $('#dev').on('change', '.dev', function() {
    //console.log('platValue received in dev change:', platValue);
    makeOption($(this), 3, $('.tech'), $('.plat').val());
  });


  $(document).on('change', '.plats', function() {
    makeOption($(this), 2, $('.devs'), '');
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
<?php
$title = "강의 목록";

$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');


$sql = "SELECT * FROM lecture_list ";
$result = $mysqli->query($sql);
$dataArr = [];
while ($data = $result->fetch_object()) {
  $dataArr[] = $data;
}

$plat_sql = "SELECT * FROM lecture_category WHERE pcode = '' AND ppcode = '' ";
$plat_result = $mysqli->query($plat_sql);
$platArr = [];
while ($data = $plat_result->fetch_object()) {
  $platArr[] = $data;
}

$dev_sql = "SELECT * FROM lecture_category WHERE ppcode = '' AND pcode <> '' ";
$dev_result = $mysqli->query($dev_sql);
$devArr = [];
while ($data = $dev_result->fetch_object()) {
  $devArr[] = $data;
}

$tech_sql = "SELECT * FROM lecture_category WHERE ppcode <> '' AND pcode <> '' ";
$tech_result = $mysqli->query($tech_sql);
$techArr = [];
while ($data = $tech_result->fetch_object()) {
  $techArr[] = $data;
}


$tag_sql = "SELECT DISTINCT lecture_tag FROM lecture_list ";
$tag_result = $mysqli->query($tag_sql);
$tagArr = [];
while ($data = $tag_result->fetch_object()) {
  $tagArr[] = $data;
}


?>
<form id="filterForm" class="row">
  <div class="col-4 col-lg-2">
    <select class="form-select" name="status" id="status">
      <option value="" selected>Status</option>
      <option value="1">진행중</option>
      <option value="2">진행완료</option>
      <option value="3">진행전</option>
    </select>
  </div>
  <div class="col-4 col-lg-2">
    <select class="form-select" name="tag" id="tag">
      <option value="" selected>Tag</option>
      <?php
      if (!empty($tagArr)) {
        foreach ($tagArr as $tag) {
      ?>
          <option value="<?= $tag->lecture_tag ?>"><?= $tag->lecture_tag ?></option>
      <?php
        }
      }
      ?>
    </select>
  </div>
  <div class="col-4 col-lg-2">
    <select class="form-select" name="plat" id="plat">
      <option value="" selected>platform</option>
      <?php
      if (!empty($platArr)) {
        foreach ($platArr as $pa) {
      ?>
          <option value="<?= $pa->code ?>"><?= $pa->name ?></option>
      <?php
        }
      }
      ?>
    </select>
  </div>
  <div class="col-4 col-lg-2">
    <select class="form-select" name="dev" id="dev">
      <option value="" selected>Development</option>
      <?php
      if (!empty($devArr)) {
        foreach ($devArr as $da) {
      ?>
          <option value="<?= $da->code ?>"><?= $da->name ?></option>
      <?php
        }
      }
      ?>
    </select>
  </div>
  <div class="col-4 col-lg-2">
    <select class="form-select" name="tech" id="tech">
      <option value="" selected>Technologies</option>
      <?php
      if (!empty($techArr)) {
        foreach ($techArr as $ta) {
      ?>
          <option value="<?= $ta->lcid ?>"><?= $ta->name ?></option>
      <?php
        }
      }
      ?>
    </select>
  </div>
  <div class="col-4 col-lg-2">
    <select class="form-select" name="option" id="option">
      <option value="" selected>노출옵션</option>
      <option value="ispopular">인기</option>
      <option value="isrecom">추천</option>
      <option value="ispremium">프리미엄</option>
      <option value="isfree">무료</option>
    </select>
  </div>
</form>
<div class="row print mt-3">
  <?php
  foreach ($dataArr as $item) {
    $tuition = '';
    if ($item->dis_tuition > 0) {
      $tui_val = number_format($item->tuition);
      $distui_val = number_format($item->dis_tuition);
      $tuition .= "<p class=\"text-decoration-line-through tui \"> $tui_val 원 </p><p class=\"active-font \"> $distui_val 원 </p>";
    } else {
      $tui_val = number_format($item->tuition);
      $tuition .=  "<p class=\"active-font \"> $tui_val 원 </p>";
    }
  ?>
    <section class="col-md-3 mb-3 list d-flex flex-column justify-content-between">
      <div>
        <div class="cover mb-2">
          <img src="<?= $item->cover_image ?>" alt="">
        </div>
        <div class="title mb-2">
          <h5 class="small-font mb-0"><a href="lecture_view.php?lid=<?= $item->lid ?>"><?= $item->title ?></a></h5>
          <p class="name text-decoration-underline"><?= $item->t_id ?></p>
        </div>
        <div class="d-flex flex-column-reverse justify-content-start tuition">
          <?= $tuition ?>
        </div>
      </div>
      <ul>
        <li class="d-flex align-items-center gap-2"> <img src="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/img/icon-img/review.svg" alt=""> 5점 </li>
        <li class="like d-flex align-items-center"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/img/icon-img/Heart.svg" width="10" height="10" alt="">500+</li>
        <li class="tag"><?= !empty($item->lecture_tag) ? "<span> {$item->lecture_tag}</span>" : '' ?> </li>
      </ul>
    </section>
  <?php
  }
  ?>
</div>

<script>
  const filterselect = document.querySelectorAll('#filterForm select');
  const print = document.querySelector('.print');
  filterselect.forEach(select => {
    select.addEventListener('change', () => {
      const formData = new FormData(document.querySelector("#filterForm"));
      fetch('lecture_filter.php', {
          method: 'post',
          body: formData
        }).then(res => res.text())
        .then(data => {
          console.log(data);
          print.innerHTML = data;
        }).catch((error) => console.error("Error:", error));;
    })
  })
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
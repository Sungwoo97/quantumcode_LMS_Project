<?php
$title = '강의 보기';
$reset_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/reset.css\" rel=\"stylesheet\">";
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$id = isset($_SESSION['AUID']) ? $_SESSION['AUID']  : $_SESSION['TUID'];
if (!isset($id)) {
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}



$tuition = '';

$lid = $_GET['lid'];

$sql = "SELECT * FROM lecture_list WHERE lid = $lid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

$tuition .= isset($data->dis_tuition) ? "
<p class=\"text-decoration-line-through \"> $data->tuition </p><p class=\"active-font\"> $data->dis_tuition </p>"
  :
  "<p class=\"active-font\"> $data->tuition </p>";
$category = $data->category; // A0001B0001C0001

$plat = substr($category, 0, 5);
$dev = substr($category, 5, 5);
$tech = substr($category, 10, 5);

$cate = [$plat, $dev, $tech];

// 배열을 SQL IN 조건에 맞게 변환
$cateArr = implode("','", $cate);
$cate_sql = "
    SELECT 
        c1.code AS code,
        c1.name AS name,
        c2.name AS pcode_name,
        c3.name AS ppcode_name
    FROM lecture_category c1
    LEFT JOIN lecture_category c2 ON c1.pcode = c2.code
    LEFT JOIN lecture_category c3 ON c1.ppcode = c3.code
    WHERE c1.code IN ('$cateArr')
";

$cate_result = $mysqli->query($cate_sql);
$cate_data = [];
while ($row = $cate_result->fetch_object()) {
  $cate_data[] = $row;
}
if (count($cate_data) > 0) {
  foreach ($cate_data as $list) {
    if (count($cate_data) > 0) {
      foreach ($cate_data as $list) {
      }
    }
  }
}

?>

<section class="info">
  <div>
    <div class="catogory mb-1 ">
      <!-- <p class="small-font"><?= $ppcode . ' / ' . $pcode . ' / ' . $code ?></p> -->
    </div>
    <div class="title mb-2">
      <h4 class="normal-font"><?= $data->title ?></h4>
      <p class="name text-decoration-underline"><?= $data->t_id ?></p>
    </div>
    <div class="learnObj">
      <h6>학습 목표</h6>
      <p class="small-font"><?= $data->learning_obj ?></p>
    </div>
  </div>
  <ul>
    <li class="review"> <img src="../img/icon-img/review.svg" alt=""> 5점 <span class="text-decoration-underline small-font">수강평 보기</span></li>
    <li class="like"><img src="../img/icon-img/Heart.svg" alt="">500+</li>
    <li class="tag"><?= !empty($data->lecture_tag) ? "<span> {$data->lecture_tag}</span>" : '' ?> </li>
  </ul>
</section>
<section class="desc row mt-5">
  <div class="col-8">
    <h3 class="subtitle mb-5"><?= $data->sub_title ?></h3>
    <hr>
    <p class="description mb-5"><?= $data->description ?></p>
  </div>
</section>

<aside>
  <div class="lecture_coverImg">
    <img src="<?= $data->cover_image ?>" alt="">
  </div>
  <div class="tuition">
    <div class="tuitionInfo">
      <h4>수강료</h4>
      <div>
        <?= $tuition ?>
      </div>
    </div>
    <div class="asideDesc">
      <dl class="tuitionDesc">
        <dt>강의시간</dt>
        <dd>2시간 40분</dd>
      </dl>
      <dl class="tuitionDesc">
        <dt>난이도</dt>
        <dd><?= $data->difficult ?></dd>
      </dl>
      <dl class="tuitionDesc">
        <dt>등록일</dt>
        <dd><?= $data->regist_day ?></dd>
      </dl>
      <dl class="tuitionDesc">
        <dt>마감일</dt>
        <dd><?= $data->expiration_day ?></dd>
      </dl>
    </div>
  </div>
</aside>


<div class="d-flex gap-3 justify-content-end lecture_button">
  <a href="lecture_modify.php?lid=<?= $lid ?>" class=" btn btn-primary insert">수정</a>
  <a href="lecture_delete.php?lid=<?= $lid ?>" class=" btn btn-danger insert">삭제</a>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
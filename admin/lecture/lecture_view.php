<?php
$title = '상품 목록';
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


$lid = $_GET['lid'];

$sql = "SELECT * FROM lecture_list WHERE lid = $lid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();
?>
<div class="container">
  <section class="info">
    <div class="catogory">web / frontEnd / javascript</div>
    <div class="title">신나는 자바스크립트</div>
    <div class="name">곽</div>
    <div class="learnObj">
      <h3>학습 목표</h3>
      <p>자바스크립트 잘배우기</p>
    </div>
    <div class="review">review</div>
    <div class="like">like</div>
    <div class="tag">tag</div>
  </section>
  <section class="desc">
    <div class="subtitle"></div>
    <div class="description"></div>
  </section>
    
  <aside>
    <div class="coverImage"></div>
    <div class="tuitionInfo">
      <div class="tuition"></div>
      <div class="tuition"></div>
    </div>
  </aside>
</div>

<ul>
  <li><?= $data->category ?></li>
  <li><?= $data->title ?></li>
  <li><?= $data->t_id ?></li>
  <li><?= $data->sub_title ?></li>
  <li>수강평</li>
  <li>추천 수</li>
  <li><?= $data->learning_obj ?></li>
</ul>

<h5><?= $data->sub_title ?> </h5>
<h5><?= $data->description ?> </h5>
<h5><?= $data->tuition ?> </h5>
<h5><?= $data->dis_tuition ?> </h5>
<h5><?= $data->difficult ?> </h5>
<h5><?= $data->regist_day ?> </h5>
<div class="d-flex gap-3 justify-content-end">
  <a href="lecture_modify.php?lid=<?= $lid ?>" class=" btn btn-primary insert">수정</a>
  <a href="lecture_delete.php?lid=<?= $lid ?>" class=" btn btn-danger insert">삭제</a>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
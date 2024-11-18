<?php
$title = '상품 목록';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$lid = $_GET['lid'];

$sql = "SELECT * FROM lecture_list WHERE lid = $lid";
$result = $mysqli->query($sql);
$data = $result->fetch_object();
?>

<ul>
  <li><?= $data->category ?></li>
  <li><?= $data->title ?></li>
  <li><?= $data->tid ?></li>
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
  <a href="lecture_del.php?lid=<?= $lid ?>" class=" btn btn-danger insert">삭제</a>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
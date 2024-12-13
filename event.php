<?php 
$title = "EVENT";
$community_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/community.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

?>

<div class="event_box">
  <div class="container">
    <h2><?= $title ?></h2>  
    <p>지금 진행중인 다채로운 혜택 모음!<br>두 눈으로 확인하세요.</p>  
  </div>  
</div>

<div class="community container">
  <div class="row">
    <div class="event content col-10">
      <div class="d-flex gap-3">
        <button class="btn active">전체</button>
        <button class="btn">추천 이벤트</button>
        <button class="btn">종료 임박</button>
        <button class="btn">종료</button>
      </div>
      <ul>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
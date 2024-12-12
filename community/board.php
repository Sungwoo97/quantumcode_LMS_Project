<?php 
$title = "자유게시판";
$community_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/community.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

?>

<div class="search_box">
  <div class="container">
    <h2><?= $title ?></h2>
    <form action="" class="d-flex">
      <input type="text" class="form-control" id="search_box" placeholder="검색어를 입력하세요.">
      <button type="submit" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>  
</div>


<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
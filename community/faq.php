<?php 
$title = "FAQ";
$community_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/community.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

?>

<div class="title_box">
  <div class="container">
    <h2><?= $title ?></h2>  
  </div>  
</div>


<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
<?php
/*
여기서 기존과 다르게 바로 admin/inc/header.php로 들어가는점은, 이전htdocs/abcmall/admin/inc/header.php 
경우에는 DOCUMENT_ROOT가 htdocs이지만 우리의 경우, DOCUMENT_ROOT가 3nd_projecct 이후 별도의 폴더 없이
바로 프로젝트를 실행해서 이렇게 실행됩니다. 
*/

include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');
?>

<div>
  <h1>관리자단 페이지입니다. </h1>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?> 

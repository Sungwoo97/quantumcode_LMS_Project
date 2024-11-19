<?php
$title = '매출 관리';
$sales_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/sales.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');
?>
<pre>
  매출 관리 테이블
  총 강의 수
  총 수강생 
  평점 
  총 매출 
  
  매월 매출 테이블 
  달 마다 수익
  
  매월 강의 테이블 
  상위 4개의 강의 수료율 ? 매출 ?
  
  강의 정보 테이블
  강의 수료율 ( 영상 시청 시간과 시청 시간을 비교? )
  강의명
  영상시간
  영상 갯수
  영상 시청 기간
  평균 시청 시간 
  
  강사 테이블은 따로 ? 
  혹은 기존 테이블에 추가 ?
  => 현재 강사 총괄은 어드민 화면인데
  
</pre>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
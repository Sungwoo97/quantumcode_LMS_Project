<?php
$title = '매출 관리';
$sales_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/sales.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');
?>

<div class="container sales my-4">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
      <div class="sales_box">
        <dl>
          <dt>강의 수</dt>
          <dd>23 개</dd>
        </dl>
      </div>
    </div>
    <div class="col">
      <div class="sales_box">
        <dl>
          <dt>총 수강생</dt>
          <dd>200 명</dd>
        </dl>
      </div>
    </div>
    <div class="col">
      <div class="sales_box">
        <dl>
          <dt>평점</dt>
          <dd>4.5 점</dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 sales_box">
      <dl>
        <dt>총 매출</dt>
        <dd>10,580,000 원</dd>
      </dl>
    </div>
  </div>
  <div class="row">
    <div class="col-6 sales_chart">
      <dl>
        <dt>이번 달 수익</dt>
        <dd>2,020,000 원</dd>
        <dd>991,000원 (96%) </dd>
      </dl>
    </div>
    <div class="col-6 sales_chart">
      <dl>
        <dt>종합 매출</dt>
        <dd>종합 바 차트</dd>
      </dl>
    </div>
  </div>
  <div class="row">
    <div class="col-6 sales_chart">
      <dl>
        <dt>강의 완강률</dt>
        <dd>도넛 그래프</dd>
      </dl>
    </div>
    <div class="col-6 sales_chart">
      <dl>
        <dt>강의 정보</dt>
        <dd>1</dd>
        <dd>2</dd>
        <dd>3</dd>
        <dd>4</dd>
        <dd>5</dd>
        <dd>6</dd>
      </dl>
    </div>
  </div>
  <div class="row">
    <div class="col-12 sales_chart">
      <dl>
        <dt>종합 데이터</dt>
        <dd>라인 차트</dd>
      </dl>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
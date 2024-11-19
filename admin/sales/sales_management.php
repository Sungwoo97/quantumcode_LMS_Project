<?php
$title = '매출 관리';
$sales_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/sales.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');
?>

<div class="container sales my-4">
  <!-- 강의 정보 섹션 -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="sales_box">
        <dl class="">
          <dt>강의 수</dt>
          <dd>23 개</dd>
        </dl>
      </div>
    </div>
    <div class="col-md-4">
      <div class="sales_box">
        <dl>
          <dt>총 수강생</dt>
          <dd><span>200 명</span></dd>
        </dl>
      </div>
    </div>
    <div class="col-md-4">
      <div class="sales_box">
        <dl>
          <dt>평점</dt>
          <dd><span>4.5 점</span></dd>
        </dl>
      </div>
    </div>
  </div>

  <!-- 총 매출 섹션 -->
  <div class="row g-4">
    <div class="col-12">
      <div class="sales_box w-100">
        <dl>
          <dt>총 매출</dt>
          <dd><span>10,580,000 원</span></dd>
        </dl>
      </div>
    </div>
  </div>

  <!-- 차트 섹션 -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="sales_chart">
        <dl>
          <dt>이번 달 수익</dt>
          <dd><span>2,020,000 원
              <br> 991,000원 (96%)</span></dd>
        </dl>
      </div>
    </div>
    <div class="col-md-6">
      <div class="sales_chart">
        <dl>
          <dt>종합 매출</dt>
          <dd>종합 바 차트</dd>
        </dl>
      </div>
    </div>
  </div>

  <!-- 강의 정보 섹션 -->
  <div class="row g-4">
    <div class="col-md-6">
      <div class="sales_chart">
        <dl>
          <dt>강의 완강률</dt>
          <dd>도넛 그래프</dd>
        </dl>
      </div>
    </div>
    <div class="col-md-6">
      <div class="sales_chart">
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
  </div>

  <!-- 종합 데이터 섹션 -->
  <div class="row g-4">
    <div class="col-12">
      <div class="sales_chart">
        <dl>
          <dt>종합 데이터</dt>
          <dd>라인 차트</dd>
        </dl>
      </div>
    </div>
  </div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
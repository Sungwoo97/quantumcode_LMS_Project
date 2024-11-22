<?php
$title = '대시보드';
$admin_index_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/admin_index.css\" rel=\"stylesheet\">";
$chart_js = "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/teachers/inc/header.php');


?>

<div class="dashboard container m-0">
  <!-- Summary Section -->
  <div class="row">
    <div class="col-md-4 amount_teacher">
      <div class="card border-0 shadow-sm p-3">
        <div class="card-header bg-white border-0 pb-2 d-flex">
          <h6 class="mb-0 fw-bold text-primary">아직 구현 전</h6>
          <small class="ms-2">X</small>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-4">
              <h6 class="text-primary">X</h6>
              <p class="mb-0">
                <span class="text-primary d-block">X</span>
                <span class="text-dark d-block">X</span>
              </p>
            </div>
            <div class="col-4">
              <h6 class="text-primary">X</h6>

            </div>
            <div class="col-4">
              <h6 class="text-danger">X</h6>
              <p class="mb-0">
                <span class="text-danger"></span>
                <span class="text-dark">X</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 amount_member">
      <div class="card border-0 shadow-sm p-3">
        <div class="card-header bg-white border-0 pb-2 d-flex">
          <h6 class="mb-0 fw-bold text-primary">아직 구현 전</h6>
          <small class="ms-2">2024년 11월 기준 10월 달 대비 증감량</small>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-4">
              <h6 class="sub_tt text-primary">전체 회원</h6>
              <p class="mb-0">
                <span class="text-primary d-block">X</span>
                <span class="text-dark d-block">X</span>
              </p>
            </div>
            <div class="col-4">
              <h6 class="text-primary">신규 회원</h6>
            </div>
            <div class="col-4">
              <h6 class="text-danger">X</h6>
              <p class="mb-0">
                <span class="text-dark">X</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 amount_sales">
      <div class="card border-0 shadow-sm p-3">
        <div class="card-header bg-white border-0 pb-2 d-flex">
          <h6 class="mb-0 fw-bold  text-primary">아직 구현 전</h6>
        </div>
        <div class="card-body">
          <canvas id="top5TeachersChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>






<script>
 

</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/teachers/inc/footer.php');
?>
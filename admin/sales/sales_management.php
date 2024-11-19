<?php
$title = '매출 관리';
$sales_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/sales.css\" rel=\"stylesheet\">";
$chart_css = "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');
?>

<div class="container sales my-4">
  <!-- 강의 정보 섹션 -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="sales_box">
        <dl class="">
          <dt>강의 수</dt>
          <dd>
            <div>23 개</div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="col-md-4">
      <div class="sales_box">
        <dl>
          <dt>총 수강생</dt>
          <dd>
            <div>200 명</div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="col-md-4">
      <div class="sales_box">
        <dl>
          <dt>평점</dt>
          <dd>
            <div>4.5 점</div>
          </dd>
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
          <dd>
            <div>10,580,000 원</div>
          </dd>
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
          <dd>
            <div class="mt-5">2,020,000 원
              <br><span> 991,000원 (96%)</span>
            </div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="col-md-6">
      <div class="sales_chart">
        <dl>
          <dt>종합 매출</dt>
          <dd class="mt-5"><canvas id="monthly_data"></canvas></dd>
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
          <dd class="mt-5">
            <div class="chart-box">
              <canvas id="chart1"></canvas>
            </div>
            <div class="chart-box">
              <canvas id="chart2"></canvas>
            </div>
            <div class="chart-box">
              <canvas id="chart3"></canvas>
            </div>
          </dd>
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
<script>
  fetch('sales_data.php')
    .then(response => response.json())
    .then(data => {

      const months = data.map(item => item.month);
      const sales = data.map(item => item.sales);

      const monthly_data = document.getElementById('monthly_data')

      new Chart(monthly_data, {
        type: 'bar', // 막대 차트
        data: {
          labels: months, // x축 레이블
          datasets: [{
            label: 'Monthly Sales',
            data: sales, // y축 데이터
            backgroundColor: 'rgba(112, 134, 253, 0.2)',
            borderColor: 'rgba(112, 134, 253, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }).catch(error => console.error('Error fetching data:', error));

  fetch('sales_complate.php')
    .then(response => response.json())
    .then(data => {
      console.log(data);
      const colors = ['#4CAF50', '#FF9800', '#2196F3'];
      data.forEach((item, index) => {
        const ctx = document.getElementById(`chart${index + 1}`).getContext('2d');

        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: ['완강률', '미강률'], // 레이블 설정
            datasets: [{
              data: [parseFloat(item.lecture_completion), 100 - parseFloat(item.lecture_completion)],
              backgroundColor: [colors[index], '#DDDDDD'], // 색상
            }]
          },
          options: {
            plugins: {
              title: {
                display: true,
                text: item.lecture_name // 강의 이름
              },
              legend: {
                display: false // 범례 비활성화
              },
              tooltip: {
                callbacks: {
                  label: function(tooltipItem) {
                    const value = tooltipItem.raw;
                    const total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / total) * 100).toFixed(1);
                    return `${value} (${percentage}%)`;
                  }
                }
              }
            },
            cutout: '70%' // 도넛 가운데 비율
          }
        });
      });


    }).catch(error => console.error('Error fetching data:', error));


  // 공통 설정
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
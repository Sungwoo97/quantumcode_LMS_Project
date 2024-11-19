<?php
$title = '대시보드';
$admin_index_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/admin_index.css\" rel=\"stylesheet\">";
$chart_js="<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');
?>

<div class="dashboard container mt-4">
    <!-- Summary Section -->
    <div class="row">
        <div class="col-md-4 amount_teacher">
          <div class="card border-0 shadow-sm p-3">
            <div class="card-header bg-white border-0 pb-2 d-flex">
                <h6 class="mb-0 fw-bold text-primary">강사</h6>
                <small class="ms-2">2024년 11월 기준 전년 대비 증감량</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h6 class="text-primary">전체 강사</h6>
                        <p class="mb-0">
                            <span class="text-primary">↑50(10%)</span> 
                            <span class="text-dark">500명</span>
                        </p>
                    </div>
                    <div class="col-4">
                        <h6 class="text-primary">신규 강사</h6>
                        <p class="mb-0">
                            <span class="text-primary">↑10(20%)</span> 
                            <span class="text-dark">50명</span>
                        </p>
                    </div>
                    <div class="col-4">
                        <h6 class="text-danger">탈퇴 강사</h6>
                        <p class="mb-0">
                            <span class="text-danger">↑2(4%)</span> 
                            <span class="text-dark">5명</span>
                        </p>
                    </div>
                </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4 amount_member">
          <div class="card border-0 shadow-sm p-3">
            <div class="card-header bg-white border-0 pb-2 d-flex">
                <h6 class="mb-0 fw-bold  text-primary">회원</h6>
                <small class="ms-2">2024년 11월 기준 10월 달 대비 증감량</small>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h6 class="sub_tt text-primary">전체 회원</h6>
                        <p class="mb-0">
                            <span class="text-primary fw-bold">↑120(15%)</span> 
                            <span class="text-dark">3500명</span>
                        </p>
                    </div>
                    <div class="col-4">
                        <h6 class="text-primary">신규 회원</h6>
                        <p class="mb-0">
                            <span class="text-primary fw-bold">↑10(20%)</span> 
                            <span class="text-dark">250명</span>
                        </p>
                    </div>
                    <div class="col-4">
                        <h6 class="text-danger">탈퇴 회원</h6>
                        <p class="mb-0">
                            <span class="text-danger fw-bold">↑16(6%)</span> 
                            <span class="text-dark">35명</span>
                        </p>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 amount_sales">
        <div class="card border-0 shadow-sm p-3">
          <div class="card-header bg-white border-0 pb-2 d-flex">
            <h6 class="mb-0 fw-bold  text-primary">강사 매출 누적 순위</h6>
          </div>
          <div class="card-body">
              <canvas id="salesChart" height="150"></canvas>
          </div>
        </div>
    </div>

    <!-- Popular Courses -->
    <div class="row">
      <div class="row col-md-6">
        <div class="mb-4">
            <div class="chart-container">
            <canvas id="popularCoursesChart"></canvas>
        </div>
      </div>
  
        <div class="QnA">
            <h6>Q&A</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>등록일</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>title</td>
                        <td>name</td>
                        <td>2024-11-01</td>
                        <td><button class="btn btn-primary btn-sm">Edit</button></td>
                    </tr>
                    <tr>
                        <td>title</td>
                        <td>name</td>
                        <td>2024-11-02</td>
                        <td><button class="btn btn-primary btn-sm">Edit</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
  
      <!-- Revenue Section -->
      <div class="col-md-4">
        <h6>월별 매출</h6>
        <h5 class="text-end mt-3">12,020,000원 <span class="text-success">(+10%)</span></h5>
        <canvas id="monthlyChart"></canvas>
      </div>
    </div>
</div>







<!-- Chart.js Scripts -->
<script>
  // Sales Chart
  const salesCtx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(salesCtx, {
    type: 'bar',
    data: {
      labels: ['강사1', '강사2', '강사3', '강사4', '강사5'],
      datasets: [{
        label: '강사 매출',
        data: [7000000, 6000000, 5500000, 5000000, 4500000],
        backgroundColor: 'rgba(54, 162, 235, 0.5)'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });

  //most popular chart
  const ctx = document.getElementById('popularCoursesChart').getContext('2d');

      const popularCoursesChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
            '프론트엔드를 위한 자바스크립트 첫 걸음',
            '고농축 프론트엔드 풀코스',
            '코어 자바스크립트',
            'A-Z부터 따라하며 배우는 리액트',
            'Vue.js 시작하기'
          ],
          datasets: [{
            label: '인기 강의',
            data: [3102, 2497, 2459, 2270, 1989],
            backgroundColor: [
              '#FF6B6B', // 첫 번째 막대 색상
              '#6BCBFF', // 두 번째 막대 색상
              '#A28DFF', // 세 번째 막대 색상
              '#6BD1FF', // 네 번째 막대 색상
              '#3666FF'  // 다섯 번째 막대 색상
            ],
            borderWidth: 0,
            borderRadius: 5 // 막대 끝을 둥글게
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {display: false},// 범례 비활성화
            tooltip: {enabled: true }// 툴팁 활성화
          },
          scales: {
            x: {
              grid: {display: false}, // X축 격자 숨김
              ticks: {font: {size: 12} // X축 폰트 크기
              }
            },
            y: {
              grid: {display: false // Y축 격자 숨김
              },
              ticks: {
                align: 'start', // Y축 레이블 좌측 정렬
                padding: 10, // 여백 추가 (선택사항)
                  font: {
                  size: 14}, // Y축 폰트 크기
                color: '#333'}// Y축 텍스트 색상
            }
          }
        }
      });

  // Monthly Revenue Chart
  const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
  const monthlyChart = new Chart(monthlyCtx, {
    type: 'line',
    data: {
      labels: ['7월', '8월', '9월', '10월', '11월', '12월'],
      datasets: [{
        label: '월별 매출',
        data: [8000000, 8500000, 9000000, 9500000, 10000000, 12020000],
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 2,
        fill: false
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      }
    }
  });

</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?> 

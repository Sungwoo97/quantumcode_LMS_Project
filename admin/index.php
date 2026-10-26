<?php
require_once __DIR__ . '/../inc/reporting.php';
$report_period = reporting_period();
$period_start = $report_period['start'];
$period_end = $report_period['end'];

$title = '대시보드';
$admin_index_css = "<link href=\"//{$_SERVER['HTTP_HOST']}/qc/admin/css/admin_index.css\" rel=\"stylesheet\">";
$chart_js = "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$id = isset($_SESSION['AUID']) ? $_SESSION['AUID']  : $_SESSION['TUID'];
if (!isset($id)) {
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = './login.php';
    </script>
  ";
}

require_once __DIR__ . '/../inc/reporting.php';
$report_period = reporting_period();
$current_year = $report_period['year'];
$previous_year = $report_period['previous_year'];
//강사 관련. 모든 강사 수
$teacher_count_sql = "SELECT COUNT(*) AS total_teachers FROM teachers";
$teacher_count = $mysqli->query($teacher_count_sql);
$t_count = $teacher_count->fetch_object();
// 현재 연도에 가입한 강사 수
$teacher_current_register = "SELECT COUNT(*) AS total_current_teachers FROM teachers WHERE YEAR(reg_date) = $current_year";
$teacher_current_count = $mysqli->query($teacher_current_register);
$teacher_current = $teacher_current_count->fetch_object();
// 이전 연도에 가입한 강사 수
$teacher_previous_register = "SELECT COUNT(*) AS total_previous_teachers FROM teachers WHERE YEAR(reg_date) = $previous_year";
$teacher_previous_count = $mysqli->query($teacher_previous_register);
$teacher_previous = $teacher_previous_count->fetch_object();

$previous_teacher_count = intval(($teacher_previous->total_previous_teachers));
$current_teacher_count = intval(($teacher_current->total_current_teachers));

$increasePercentage = reporting_change($current_teacher_count, $previous_teacher_count);

// 매출 관련. 전에는 sales_management / sales_monthly 라는 고정 시드 표를 뿌려서
// 매출관리 화면(2,926,000원)과 대시보드(12,020,000원)가 서로 다르게 나왔다.
// 실제 결제 항목(paid_price, status=1)으로 통일한다.
$total_sql = "SELECT SUM(oi.paid_price) AS total FROM lecture_order_item oi JOIN lecture_order o ON o.odid=oi.odid WHERE oi.status IN (1,4) AND o.createdate >= '$period_start' AND o.createdate < '$period_end'";
$total_result = $mysqli->query($total_sql);
$total_sales = $total_result ? (int) $total_result->fetch_object()->total : 0;

// 이번 달과 지난 달 매출. 연도까지 맞춰 봐야 해가 바뀌었을 때 같은 달끼리 섞이지 않는다
$this_month = $report_period['month'];
$prev_month = $report_period['previous_month'];

$month_sql = "SELECT DATE_FORMAT(o.createdate, '%Y-%m') AS month,
  SUM(oi.paid_price) AS sales
  FROM lecture_order_item oi
  JOIN lecture_order o ON o.odid = oi.odid
  WHERE oi.status IN (1,4) AND DATE_FORMAT(o.createdate, '%Y-%m') IN ('$this_month', '$prev_month')
  GROUP BY DATE_FORMAT(o.createdate, '%Y-%m')";
$month_result = $mysqli->query($month_sql);

// 매출이 없는 달은 행이 안 나오므로 0 으로 채워둔다
$month_sales = [$this_month => 0, $prev_month => 0];
if ($month_result) {
  while ($month_row = $month_result->fetch_object()) {
    $month_sales[$month_row->month] = (int) $month_row->sales;
  }
}

$current_month = $month_sales[$this_month];
$previous_month = $month_sales[$prev_month];
$month_diff = $current_month - $previous_month;

// 지난 달 매출이 0이면 증감률을 낼 수 없다 (전에는 0으로 나눠 경고가 났다)
$rate_text = ' (' . reporting_change($current_month, $previous_month) . ')';

if ($month_diff > 0) {
  $inc_sales = "<span class='blue'>" . number_format($month_diff) . "원{$rate_text} <i class=\"fa-solid fa-arrow-up\"></i></span>";
} else if ($month_diff < 0) {
  $inc_sales = "<span class='red'>" . number_format($month_diff) . "원{$rate_text} <i class=\"fa-solid fa-arrow-down\"></i></span>";
} else {
  $inc_sales = "<span>지난 달과 같음{$rate_text}</span>";
}


// 회원 관련. 실제 로그인·구매가 쓰는 표는 members(레거시)가 아니라 memberskakao 다.
// 전에는 members(50명)를 세서 매출/구매자 숫자와 앞뒤가 안 맞았다.
$member_count_sql = "SELECT COUNT(*) AS total_members FROM memberskakao";
$member_count = $mysqli->query($member_count_sql);
$m_count = $member_count->fetch_object();

// 현재 연도에 가입한 회원 수
$member_current_register = "SELECT COUNT(*) AS total_current_members FROM memberskakao WHERE YEAR(memCreatedAt) = $current_year";
$member_current_count = $mysqli->query($member_current_register);
$member_current = $member_current_count->fetch_object();

// 이전 연도에 가입한 회원 수
$member_previous_register = "SELECT COUNT(*) AS total_previous_members FROM memberskakao WHERE YEAR(memCreatedAt) = $previous_year";
$member_previous_count = $mysqli->query($member_previous_register);
$member_previous = $member_previous_count->fetch_object();

//회원수 증가율
$previous_member_count = intval(($member_previous->total_previous_members));
$current_member_count = intval(($member_current->total_current_members));

$M_increasePercentage = reporting_change($current_member_count, $previous_member_count);

//인기 강의 출력
$popular_data = [];
$popular_label = [];
$popularCnt_sql = "SELECT l.title AS title, l.lid AS lid, COUNT(DISTINCT lo.mid) AS member_count
FROM lecture_order_item oi
JOIN lecture_order lo ON lo.odid = oi.odid
JOIN lecture_list l ON l.lid = oi.lid
WHERE oi.status = 1
GROUP BY l.lid, l.title
ORDER BY member_count DESC";
$popularCnt_result = $mysqli->query($popularCnt_sql);
while ($popularCnt_row = $popularCnt_result->fetch_object()) {
  $popular_data[] = $popularCnt_row->member_count;
  $popular_label[] = $popularCnt_row->title;
}

// 매출 상위 5명 강사. 전에는 teachers.year_sales(실제와 무관한 고정 컬럼)를 그대로 썼다.
// 강사 강의(t_id)에 걸린 실제 결제 항목으로 집계한다.
$sql = "SELECT t.name, SUM(oi.paid_price) AS sales
        FROM lecture_order_item oi
        JOIN lecture_order o ON o.odid = oi.odid
        JOIN lecture_list l ON l.lid = oi.lid
        JOIN teachers t ON t.id = l.t_id
        WHERE oi.status IN (1,4) AND o.createdate >= '$period_start' AND o.createdate < '$period_end'
        GROUP BY t.id, t.name
        ORDER BY sales DESC
        LIMIT 5";

$result = $mysqli->query($sql);

$name = [];
$sale = [];

while ($data = $result->fetch_object()) {
  $name[] = $data->name; // x축에 사용할 강사 이름
  $sale[] = (int) $data->sales; // y축에 사용할 매출 데이터
}

$board_sql = "SELECT * FROM board WHERE category = 'qna' ORDER BY date DESC LIMIT 5";
$board_result = $mysqli->query($board_sql);
?>



<div class="dashboard container m-0">
  <!-- Summary Section -->
  <div class="row">
    <div class="col-md-4 amount_teacher">
      <div class="card border-0 shadow-sm p-3">
        <div class="card-header bg-white border-0 pb-2 d-flex">
          <h6 class="mb-0 fw-bold text-primary">강사</h6>
          <small class="ms-2"><?= $current_year ?>년 / <?= $previous_year ?>년 가입자 비교</small>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-4">
              <h6 class="text-primary">전체 강사</h6>
              <p class="mb-0">
                <span class="text-primary d-block"><?= $increasePercentage ?></span>
                <span class="text-dark d-block">총 <?= $t_count->total_teachers ?> 명</span>
              </p>
            </div>
            <div class="col-4">
              <h6 class="text-primary">신규 강사</h6>
              <?php
              if ($teacher_current->total_current_teachers) {

              ?>
                <p class="mb-0">
                  <span class="text-primary">↑</span>
                  <span class="text-dark"><?= $teacher_current->total_current_teachers ?>명</span>
                </p>
              <?php
              }
              ?>
            </div>
            <div class="col-4">
              <h6 class="text-danger">탈퇴 강사</h6>
              <p class="mb-0">
                <span class="text-danger"></span>
                <span class="text-dark">0명</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 amount_member">
      <div class="card border-0 shadow-sm p-3">
        <div class="card-header bg-white border-0 pb-2 d-flex">
          <h6 class="mb-0 fw-bold text-primary">회원</h6>
          <small class="ms-2"><?= $current_year ?>년 / <?= $previous_year ?>년 가입자 비교</small>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-4">
              <h6 class="sub_tt text-primary">전체 회원</h6>
              <p class="mb-0">
                <span class="text-primary d-block"><?= $M_increasePercentage ?></span>
                <span class="text-dark d-block">총 <?= $m_count->total_members ?> 명</span>
              </p>
            </div>
            <div class="col-4">
              <h6 class="text-primary">신규 회원</h6>
              <?php
              if ($member_current->total_current_members) {

              ?>
                <p class="mb-0">
                  <span class="text-primary">↑</span>
                  <span class="text-dark"><?= $member_current->total_current_members ?>명</span>
                </p>
              <?php
              }
              ?>
            </div>
            <div class="col-4">
              <h6 class="text-danger">탈퇴 회원</h6>
              <p class="mb-0">
                <span class="text-dark">0명</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 amount_sales">
      <div class="card border-0 shadow-sm p-3">
        <div class="card-header bg-white border-0 pb-2 d-flex">
          <h6 class="mb-0 fw-bold  text-primary">최근 12개월 강사 매출 순위</h6>
        </div>
        <div class="card-body">
          <canvas id="top5TeachersChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- <div class="col-md-4 amount_sales">
  <div class="card border-0 shadow-sm p-3">
    <div class="card-header bg-white border-0 pb-2 d-flex">
      <h6 class="mb-0 fw-bold  text-primary">최근 12개월 강사 매출 순위</h6>
    </div>
    <div class="card-body">
      <canvas id="salesChart" height="150"></canvas>
    </div>
  </div>
</div>
</div> -->

<!-- Popular Courses -->
<div class="row mt-4 ms-0 me-0 d-flex justify-content-between">
  <div class="row col-md-8">
    <div class="mb-4 card p-3 border-0 bg-light">
      <h6>인기 강의</h6>
      <div class="chart-container">
        <canvas id="popularCoursesChart" height="150"></canvas>
      </div>
    </div>

    <div class="QnA card p-3 border-0 bg-light">
      <div class="d-flex justify-content-between">
        <h6>Q&A</h6>
        <a href="board/board_list.php?category=qna" style="padding-right: 2.8rem; text-decoration:none; color:black;">&#43;더보기</a>
      </div>
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
          <?php
          while ($board_data = $board_result->fetch_object()) {
          ?>
            <tr>
              <td><a href="board/read.php?pid=<?= $board_data->pid ?>&category=<?= $board_data->category ?>" style="text-decoration:none; color:black;"><?= $board_data->title ?></a></td>
              <td><?= $board_data->user_id ?></td>
              <td><?= $board_data->date ?></td>
              <td>
                <a href="board/board_modify.php?pid=<?= $board_data->pid ?>&category=<?= $board_data->category ?>"><i class="fa-regular fa-pen-to-square" style="color:black;"></i></a>
                <a href="board/delete.php?pid=<?= $board_data->pid ?>&category=<?= $board_data->category ?>"><i class="fa-regular fa-trash-can" style="color:black;"></i></a>
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Revenue Section -->
  <div class="Revenue col-md-4 card p-3 border-0 bg-light">
    <h6>최근 12개월 매출</h6>
    <h3 class="text-center mt-3"><?= number_format($total_sales) ?>원</h3>
    <h6 class="text-center text-primary"><?= $inc_sales ?></h6>
    <canvas id="monthlyChart" height="400"></canvas>
  </div>
</div>
</div>



<!-- Chart.js Scripts -->
<script>
  fetch('sales/sales_data.php')
    .then(response => response.json())
    .then(data => {
      const months = data.map(item => item.month);
      const sales = data.map(item => item.sales);
      const salesSorted = sales;
      const monthly_data = document.getElementById('monthlyChart');
      new Chart(monthly_data, {
        type: 'bar', // 막대 차트
        data: {
          labels: months, // x축 레이블
          datasets: [{
            label: '월 별 매출',
            data: salesSorted, // y축 데이터
            backgroundColor: 'rgba(112, 134, 253, 1)',

          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: false
            }
          }
          // scales: {
          //   y: {
          //     beginAtZero: true
          //   }
          // }
        }
      });
    }).catch(error => console.error('Error fetching data:', error));


  //most popular chart
  const ctx = document.getElementById('popularCoursesChart').getContext('2d');


  const popularLabel = <?php echo json_encode($popular_label); ?>; // 강사 이름 배열
  const popularData = <?php echo json_encode($popular_data); ?>;

  const popularCoursesChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: popularLabel,
      datasets: [{
        label: '수강생',
        data: popularData,
        backgroundColor: [
          '#FF6B6B', // 첫 번째 막대 색상
          '#6BCBFF', // 두 번째 막대 색상
          '#A28DFF', // 세 번째 막대 색상
          '#6BD1FF', // 네 번째 막대 색상
          '#3666FF' // 다섯 번째 막대 색상
        ],
        borderWidth: 0,
        borderRadius: 10 // 막대 끝을 둥글게
      }]
    },
    options: {
      categoryPercentage: 0.6, // 기본값: 0.8
      barPercentage: 1, // 기본값: 0.9
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }, // 범례 비활성화
        tooltip: {
          enabled: true
        } // 툴팁 활성화
      },
      scales: {
        x: {
          grid: {
            display: false,
            drawBorder: false
          },
          ticks: {
            display: false,
            align: 'start',
          }
        },
        y: {
          grid: {
            display: false
          },
          ticks: {
            padding: 20,
            font: {
              size: 12
            }, // Y축 폰트 크기
            color: '#333'
          } // Y축 텍스트 색상
        }
      }
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    // top5 강사 매출 차트
    const teacherNames = <?php echo json_encode($name); ?>; // 강사 이름 배열
    const teacherSales = <?php echo json_encode($sale); ?>; // 매출 데이터 배열

    const ctx = document.getElementById('top5TeachersChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar', // 차트 유형: 막대형
      data: {
        labels: teacherNames, // x축 레이블 (강사 이름)
        datasets: [{
          label: '매출 (원)', // 범례
          data: teacherSales, // y축 데이터 (매출)
          backgroundColor: [
            '#FF6B6B', // 첫 번째 막대 색상
            '#6BCBFF', // 두 번째 막대 색상
            '#A28DFF', // 세 번째 막대 색상
            '#6BD1FF', // 네 번째 막대 색상
            '#3666FF' // 다섯 번째 막대 색상
          ],
          borderWidth: 0, // 테두리 두께 없음
          borderRadius: 10 // 막대 끝을 둥글게
        }]
      },
      options: {
        responsive: true, // 반응형
        maintainAspectRatio: false, // 그래프 비율 유지 해제
        plugins: {
          legend: {
            display: false // 범례 비활성화
          },
          title: {
            display: true,
            text: '강사 매출 상위 5명',
            font: {
              size: 14, // 제목 폰트 크기
              weight: 'bold' // 제목 폰트 굵기
            },
            padding: {
              top: 10,
              bottom: 30 // 제목과 그래프 간격
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                // 툴팁에 콤마(,)를 추가하여 읽기 쉽게 표시
                return `매출: ${context.raw.toLocaleString()} 원`;
              }
            }
          }
        },
        scales: {
          x: {
            grid: {
              display: false // x축 격자선 비활성화
            },
            ticks: {
              font: {
                size: 14 // x축 폰트 크기
              },
              color: '#333' // x축 텍스트 색상
            }
          },
          y: {
            beginAtZero: true, // y축 0부터 시작
            grid: {
              borderDash: [7, 7], // 점선 형태의 격자선
              color: '#ccc' // y축 격자선 색상
            },
            ticks: {
              font: {
                size: 12 // y축 폰트 크기
              },
              color: '#333', // y축 텍스트 색상
              callback: function(value) {
                // y축 숫자에 콤마(,) 추가
                return `${value.toLocaleString()} 원`;
              }
            }
          }
        }
      }
    });
  });
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
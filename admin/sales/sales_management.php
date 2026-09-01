<?php
$title = '매출 관리';
$sales_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/sales.css\" rel=\"stylesheet\">";
$chart_js = "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

// 실제 수강생 수. 전에는 전체 회원 수를 그대로 '총 수강생' 으로 보여줬다
$student_sql = "SELECT COUNT(DISTINCT o.mid) AS total_students
  FROM lecture_order_item oi
  JOIN lecture_order o ON o.odid = oi.odid
  WHERE oi.status = 1";
$student_result = $mysqli->query($student_sql);
$student_count = $student_result ? $student_result->fetch_object()->total_students : 0;

$avg_sql = "SELECT AVG(review) AS review FROM lecture_review ";
$avg_result = $mysqli->query($avg_sql);
if ($avg_result) {
  $avg_data = $avg_result->fetch_object();
}

$total_sql = "SELECT SUM(paid_price) AS total FROM lecture_order_item WHERE status = 1";
$total_result = $mysqli->query($total_sql);
if ($total_result) {
$total = $total_result->fetch_object()->total;
}
// 초를 사람이 읽는 표기로 바꾼다. 영상이 짧으면 '시간 분' 만으로는 전부 0으로 보인다
function format_duration($seconds) {
  $seconds = (int) $seconds;
  if ($seconds >= 3600) {
    return intdiv($seconds, 3600) . "시간 " . intdiv($seconds % 3600, 60) . "분";
  }
  if ($seconds >= 60) {
    return intdiv($seconds, 60) . "분 " . ($seconds % 60) . "초";
  }
  return $seconds . "초";
}

// 강의 정보. 전에는 lecture_data 라는 고정 6행 표를 뿌렸고 lecture_list 와 연결도 안 돼 있었다.
// 지금은 영상 목록 / 구매 내역 / 시청 기록에서 뽑는다.
// '평균 수강 분량' 은 완료한 영상들의 길이 합을 수강생 수로 나눈 값이다.
// lecture_watch 가 재생 시간을 남기지 않아 실제 시청 시간은 낼 수 없다.
$data_sql = "SELECT l.title,
    IFNULL(video.video_count, 0) AS video_count,
    IFNULL(video.total_seconds, 0) AS total_seconds,
    DATEDIFF(l.expiration_day, l.regist_day) AS period_days,
    buyer.student_count,
    IFNULL(watch.watched_seconds, 0) AS watched_seconds
  FROM lecture_list l
  LEFT JOIN (SELECT lid, COUNT(*) AS video_count, SUM(TIME_TO_SEC(video_duration)) AS total_seconds
             FROM lecture_video GROUP BY lid) video ON video.lid = l.lid
  JOIN (SELECT oi.lid, COUNT(DISTINCT o.mid) AS student_count
        FROM lecture_order_item oi
        JOIN lecture_order o ON o.odid = oi.odid
        WHERE oi.status = 1
        GROUP BY oi.lid) buyer ON buyer.lid = l.lid
  LEFT JOIN (SELECT done.lid, SUM(TIME_TO_SEC(v.video_duration)) AS watched_seconds
             FROM (SELECT DISTINCT lid, mid, lvid FROM lecture_watch WHERE event_type = 'completed') done
             JOIN lecture_video v ON v.lvid = done.lvid
             GROUP BY done.lid) watch ON watch.lid = l.lid
  ORDER BY buyer.student_count DESC, l.title ASC";
$data_result = $mysqli->query($data_sql);
$html = '';
while ($data_row = $data_result->fetch_object()) {
  $lectureTime = format_duration($data_row->total_seconds);
  $lectureAvgwatch = format_duration($data_row->watched_seconds / $data_row->student_count);
  $periodDays = $data_row->period_days !== null ? $data_row->period_days . "일" : "-";

  $html .= " <tr class=\"border-bottom border-secondary-subtitle\">
        <th>{$data_row->title}</th>
        <td>{$lectureTime}</td>
        <td>{$data_row->video_count}개</td>
        <td>{$periodDays}</td>
        <td>{$lectureAvgwatch}</td>
      </tr>";
}


// 이번 달과 지난 달 매출. 연도까지 맞춰 봐야 해가 바뀌었을 때 같은 달끼리 섞이지 않는다.
// 전에는 '%c월' 로만 비교해서 2024년 9월 매출이 2026년 9월 매출로 잡혔다.
$this_month = date('Y-m');
$prev_month = date('Y-m', strtotime('-1 month'));

$month_sql = "SELECT DATE_FORMAT(o.createdate, '%Y-%m') AS month,
  SUM(oi.paid_price) AS sales
  FROM lecture_order_item oi
  JOIN lecture_order o ON o.odid = oi.odid
  WHERE oi.status = 1 AND DATE_FORMAT(o.createdate, '%Y-%m') IN ('$this_month', '$prev_month')
  GROUP BY DATE_FORMAT(o.createdate, '%Y-%m')";
$month_result = $mysqli->query($month_sql);
if (!$month_result) {
  die("Query failed: " . $mysqli->error);
}

// 매출이 없는 달은 행 자체가 안 나오므로 0 으로 채워둔다
$month_sales = [$this_month => 0, $prev_month => 0];
while ($month_row = $month_result->fetch_object()) {
  $month_sales[$month_row->month] = (int) $month_row->sales;
}

$current_month = $month_sales[$this_month];
$previous_month = $month_sales[$prev_month];
$month_diff = $current_month - $previous_month;

// 지난 달 매출이 0이면 증감률을 낼 수 없다 (전에는 0으로 나눠 경고가 났다)
$rate_text = $previous_month > 0 ? ' (' . floor($month_diff / $previous_month * 100) . '%)' : '';

if ($month_diff > 0) {
  $inc_sales = "<span class='blue'>" . number_format($month_diff) . "원{$rate_text} <i class=\"fa-solid fa-arrow-up\"></i></span>";
} else if ($month_diff < 0) {
  $inc_sales = "<span class='red'>" . number_format($month_diff) . "원{$rate_text} <i class=\"fa-solid fa-arrow-down\"></i></span>";
} else {
  $inc_sales = "<span>지난 달과 같음</span>";
}

//강의관련
$lecture_num = "SELECT COUNT(*) AS total_lectures FROM `lecture_list`";
$lecture_nums = $mysqli->query($lecture_num);
$lecture_counts = $lecture_nums->fetch_object();
?>





<div class="container sales my-4">
  <!-- 강의 정보 섹션 -->
  <div class="row g-4">
    <div class="col-md-4">
      <div class="sales_box">
        <dl class="">
          <dt>강의 수</dt>
          <dd>
            <div><?= $lecture_counts->total_lectures ?> 개</div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="col-md-4">
      <div class="sales_box">
        <dl>
          <dt>총 수강생</dt>
          <dd>
            <div><?= number_format($student_count) ?> 명</div>
          </dd>
        </dl>
      </div>
    </div>
    <div class="col-md-4">
      <div class="sales_box">
        <dl>
          <dt>평점</dt>
          <dd>
            <div><?= number_format($avg_data->review, 1) ?> 점</div>
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
            <div><?= number_format($total) ?>원 </div>
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
            <div class="mt-5"><?= number_format($current_month) ?> 원
              <br><?= $inc_sales ?>
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
          <dd>
            <table class="table table-hover data_table">
              <thead>
                <tr>
                  <th scope="col">강의명</th>
                  <th scope="col">영상 시간</th>
                  <th scope="col">영상 개수</th>
                  <th scope="col">기간</th>
                  <th scope="col">평균 수강 분량</th>
                </tr>
              </thead>
              <tbody>
                <?= $html ?>
              </tbody>
            </table>
          </dd>

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
          <dd>
            <canvas id="salesChart" width="1200" height="300"></canvas>
          </dd>
        </dl>
      </div>
    </div>
  </div>
</div>
<script>
  fetch('sales_data.php')
    .then(response => response.json())
    .then(data => {
      // 서버가 '2024-12' 형식으로 연도까지 붙여 오름차순으로 보내주므로 그대로 쓴다
      const months = data.map(item => item.month);
      const salesSorted = data.map(item => item.sales);
      const monthly_data = document.getElementById('monthly_data');
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
      const colors = ['#0E5FD9', '#64A2FF', '#0040A1'];
      data.forEach((item, index) => {
        const ctx = document.getElementById(`chart${index + 1}`).getContext('2d');

        new Chart(ctx, {

          type: 'doughnut',
          data: {
            labels: ['완강률', '미강률'], // 레이블 설정
            datasets: [{
              data: [parseFloat(item.lecture_completion), 100 - parseFloat(item.lecture_completion)],
              backgroundColor: [colors[index], '#ffffff'], // 색상
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

  fetch('sales_course.php')
    .then(response => response.json())
    .then(data => {
      // 서버가 연도까지 붙여 오름차순으로 보내므로 등장 순서가 곧 시간 순서다
      const months = [...new Set(data.map(item => item.month))];
      const names = [...new Set(data.map(item => item.course_name))];
      const colors = ['#0E5FD9', '#64A2FF', '#0040A1', '#4F38FF'];
      const datasets = names.map(course => {
        const sales = months.map(month => {
        // 해당 강의의 각 월에 대한 매출 값 찾기
          const item = data.find(item => item.course_name === course && item.month === month);
          return item ? item.sales : 'null';  // 데이터가 없으면 null으로 처리
      });

        return {
          label: course,
          data: sales,
          borderColor: colors,

        };
      });

      var ctx = document.getElementById('salesChart').getContext('2d');
      var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: months, // x축: 월
          datasets: datasets, // y축: 강의 매출
          fill: false,
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            },
            title: {
              display: true,
              text: '1년간 강의 매출 차트'
            }
          }
        }
      });

    }).catch(error => console.error('Error fetching data:', error));
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
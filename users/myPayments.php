<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// 세션에서 사용자 이메일 가져오기
if (!isset($_SESSION['MemEmail'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href = '/qc/index.php';</script>";
    exit;
}

$userEmail = $_SESSION['MemEmail'];

// lecture_order.status 를 화면에 보여줄 이름으로 바꾸는 표
$order_status_name = [
  0 => '결제대기',
  1 => '완료',
  2 => '결제실패',
  3 => '환불완료',
  4 => '환불요청',
];

// SQL 쿼리 준비 (회원이 주문한 강의 정보 가져오기)
$sql = "
    SELECT 
        o.odid AS order_id,
        o.total_price,
        o.status AS order_status,
        o.createdate AS order_date,
        GROUP_CONCAT(l.title SEPARATOR ', ') AS lecture_title,
        GROUP_CONCAT(DISTINCT l.category SEPARATOR ', ') AS lecture_category,
        GROUP_CONCAT(DISTINCT l.t_id SEPARATOR ', ') AS instructor_name,
        SUM(l.tuition) AS original_price,
        SUM(l.dis_tuition) AS discounted_price,
        GROUP_CONCAT(l.sub_title SEPARATOR ' / ') AS lecture_summary,
        GROUP_CONCAT(DISTINCT l.difficult SEPARATOR ', ') AS difficulty,
        o.refund_reason,
        o.refund_date,
        DATEDIFF(NOW(), o.createdate) AS days_passed,
        (SELECT COUNT(*) FROM lecture_watch AS lw WHERE lw.mid = o.mid AND FIND_IN_SET(lw.lid, o.lid)) AS watch_count
    FROM
        lecture_order AS o
    JOIN
        lecture_list AS l
    ON
        FIND_IN_SET(l.lid, o.lid)
    WHERE
        o.mid = ? AND o.status IN (1, 3, 4)
    GROUP BY
        o.odid
    ORDER BY
        o.odid DESC
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $userEmail); // 사용자 이메일 바인딩
$stmt->execute();

// 결과 가져오기
$result = $stmt->get_result();

// 데이터 저장
$lectures = [];
while ($row = $result->fetch_assoc()) {
    $lectures[] = $row;
}

// 스테이트먼트 닫기
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>내 강의 주문 정보</title>
  <!-- 캐싱 문제 방지 -->
  <link rel="stylesheet" href="/qc/css/core-style.css?v=<?= time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> -->
  <style>
    .profile-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ccc;
    }
    p {
      margin-top: 0;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div class="container mt-2">
    <h3>나의 강의 주문 정보</h3>
    <?php if (!empty($lectures)): ?>
      <div class="row mt-4">
        <!-- 강의 주문 정보 출력 -->
        <?php foreach ($lectures as $lecture): ?>
          <div class="col-md-6 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">강의 제목: <?= htmlspecialchars($lecture['lecture_title']); ?></h5>
                <p class="card-text"><strong>카테고리:</strong> <?= htmlspecialchars($lecture['lecture_category']); ?></p>
                <p class="card-text"><strong>강사:</strong> <?= htmlspecialchars($lecture['instructor_name']); ?></p>
                <p class="card-text"><strong>난이도:</strong> <?= htmlspecialchars($lecture['difficulty']); ?></p>
                <p class="card-text"><strong>강의 요약:</strong> <?= htmlspecialchars($lecture['lecture_summary']); ?></p>
                <p class="card-text"><strong>가격:</strong> <?= number_format($lecture['original_price']); ?>원</p>
                <hr>
                <p class="card-text"><strong>주문 ID:</strong> <?= htmlspecialchars($lecture['order_id']); ?></p>
                <p class="card-text"><strong>실제 결제 금액:</strong> <?= number_format($lecture['total_price']); ?>원</p>
                <p class="card-text"><strong>주문 상태:</strong> <?= $order_status_name[$lecture['order_status']] ?? '대기'; ?></p>
                <p class="card-text"><strong>주문 날짜:</strong> <?= htmlspecialchars($lecture['order_date']); ?></p>

                <?php if ($lecture['order_status'] == 1) { ?>
                  <?php if ($lecture['watch_count'] > 0) { ?>
                    <p class="card-text text-muted">이미 수강을 시작한 강의는 환불할 수 없습니다.</p>
                  <?php } else if ($lecture['days_passed'] > 7) { ?>
                    <p class="card-text text-muted">결제 후 7일이 지나 환불할 수 없습니다.</p>
                  <?php } else { ?>
                    <button type="button" class="btn btn-outline-danger btn-sm refund_btn" data-odid="<?= $lecture['order_id']; ?>">환불 요청</button>
                  <?php } ?>
                <?php } else if ($lecture['order_status'] == 4) { ?>
                  <p class="card-text text-muted">환불 요청이 접수되었습니다. 관리자 확인 후 처리됩니다.</p>
                  <p class="card-text"><strong>요청 사유:</strong> <?= htmlspecialchars($lecture['refund_reason']); ?></p>
                <?php } else if ($lecture['order_status'] == 3) { ?>
                  <p class="card-text"><strong>환불 완료일:</strong> <?= htmlspecialchars($lecture['refund_date']); ?></p>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>주문한 강의가 없습니다.</p>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // 환불 요청. 실제 취소는 관리자가 승인할 때 처리된다
    document.querySelectorAll('.refund_btn').forEach(button => {
      button.addEventListener('click', () => {
        const reason = prompt('환불 사유를 입력해주세요.');
        if (reason === null) {
          return;
        }
        if (reason.trim() === '') {
          alert('환불 사유를 입력해주세요.');
          return;
        }

        const data = new URLSearchParams({
          odid: button.getAttribute('data-odid'),
          reason: reason,
        });
        fetch('refund_request_ok.php', {
            method: 'post',
            body: data,
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
          })
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
          })
          .then(result => {
            alert(result.message);
            if (result.status === 'success') {
              location.reload();
            }
          })
          .catch(error => {
            console.error('Error:', error); // 네트워크나 JSON 변환 에러 처리
          });
      })
    })
  </script>
</body>
</html>
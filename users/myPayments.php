<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// 세션에서 사용자 이메일 가져오기
if (!isset($_SESSION['MemEmail'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href = '/qc/index.php';</script>";
    exit;
}

$userEmail = $_SESSION['MemEmail'];

// 주문/항목 공통으로 쓰는 상태 이름표
$order_status_name = [
  0 => '결제대기',
  1 => '완료',
  2 => '결제실패',
  3 => '환불완료',
  4 => '환불요청',
];

// 주문 단위 정보. 결제금액과 주문일은 여기서 가져온다
$order_sql = "
    SELECT
        o.odid,
        o.total_price,
        o.status AS order_status,
        o.createdate AS order_date,
        o.refund_date,
        DATEDIFF(NOW(), o.createdate) AS days_passed
    FROM
        lecture_order AS o
    WHERE
        o.mid = ? AND o.status IN (1, 3, 4)
    ORDER BY
        o.odid DESC
";

$order_stmt = $mysqli->prepare($order_sql);
$order_stmt->bind_param("s", $userEmail);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

$orders = [];
while ($order_row = $order_result->fetch_assoc()) {
    $orders[$order_row['odid']] = $order_row;
}
$order_stmt->close();

// 강의 단위 정보. 환불은 강의 하나하나로 하므로 수강 여부도 강의별로 본다
$item_sql = "
    SELECT
        oi.oiid,
        oi.odid,
        oi.lid,
        oi.price,
        oi.paid_price,
        oi.status AS item_status,
        oi.refund_reason,
        oi.refund_date,
        l.title,
        l.category,
        l.t_id,
        l.sub_title,
        l.difficult,
        (SELECT COUNT(*) FROM lecture_watch AS lw WHERE lw.mid = ? AND lw.lid = oi.lid) AS watch_count
    FROM
        lecture_order_item AS oi
    JOIN
        lecture_order AS o ON o.odid = oi.odid
    LEFT JOIN
        lecture_list AS l ON l.lid = oi.lid
    WHERE
        o.mid = ? AND o.status IN (1, 3, 4)
    ORDER BY
        oi.odid DESC, oi.oiid ASC
";

$item_stmt = $mysqli->prepare($item_sql);
$item_stmt->bind_param("ss", $userEmail, $userEmail);
$item_stmt->execute();
$item_result = $item_stmt->get_result();

// 주문번호로 묶어둔다
$items_by_order = [];
while ($item_row = $item_result->fetch_assoc()) {
    $items_by_order[$item_row['odid']][] = $item_row;
}
$item_stmt->close();
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
    .item_row {
      border-top: 1px solid #eee;
      padding: 8px 0;
    }
  </style>
</head>
<body>
  <div class="container mt-2">
    <h3>나의 강의 주문 정보</h3>
    <?php if (!empty($orders)): ?>
      <div class="row mt-4">
        <?php foreach ($orders as $odid => $order): ?>
          <?php
            $order_items = $items_by_order[$odid] ?? [];

            // 환불 요청 버튼을 띄울 강의가 하나라도 있는지
            $has_refundable = false;
            foreach ($order_items as $order_item) {
              if ($order_item['item_status'] == 1 && $order_item['watch_count'] == 0 && $order['days_passed'] <= 7) {
                $has_refundable = true;
              }
            }
          ?>
          <div class="col-md-6 mb-4">
            <div class="card order_card" data-odid="<?= $odid; ?>">
              <div class="card-body">
                <p class="card-text"><strong>주문 ID:</strong> <?= htmlspecialchars($odid); ?></p>
                <p class="card-text"><strong>실제 결제 금액:</strong> <?= number_format($order['total_price']); ?>원</p>
                <p class="card-text"><strong>주문 상태:</strong> <?= $order_status_name[$order['order_status']] ?? '대기'; ?></p>
                <p class="card-text"><strong>주문 날짜:</strong> <?= htmlspecialchars($order['order_date']); ?></p>
                <hr>

                <?php foreach ($order_items as $order_item): ?>
                  <div class="item_row">
                    <div class="d-flex align-items-start gap-2">
                      <?php if ($order_item['item_status'] == 1 && $order_item['watch_count'] == 0 && $order['days_passed'] <= 7): ?>
                        <input type="checkbox" class="refund_check mt-1" value="<?= $order_item['oiid']; ?>">
                      <?php endif; ?>
                      <div>
                        <p class="card-text"><strong><?= htmlspecialchars($order_item['title'] ?? ('강의 ' . $order_item['lid'])); ?></strong>
                          <span class="text-muted">(<?= $order_status_name[$order_item['item_status']] ?? '대기'; ?>)</span>
                        </p>
                        <p class="card-text"><small>
                          <?= htmlspecialchars($order_item['category']); ?> ·
                          강사 <?= htmlspecialchars($order_item['t_id']); ?> ·
                          난이도 <?= htmlspecialchars($order_item['difficult']); ?>
                        </small></p>
                        <p class="card-text"><small>정가 <?= number_format($order_item['price']); ?>원 /
                          결제 <?= number_format($order_item['paid_price']); ?>원</small></p>

                        <?php if ($order_item['item_status'] == 1): ?>
                          <?php if ($order_item['watch_count'] > 0): ?>
                            <p class="card-text text-muted"><small>이미 수강을 시작해 환불할 수 없습니다.</small></p>
                          <?php elseif ($order['days_passed'] > 7): ?>
                            <p class="card-text text-muted"><small>결제 후 7일이 지나 환불할 수 없습니다.</small></p>
                          <?php endif; ?>
                        <?php elseif ($order_item['item_status'] == 4): ?>
                          <p class="card-text text-muted"><small>환불 요청 접수됨 · 사유: <?= htmlspecialchars($order_item['refund_reason']); ?></small></p>
                        <?php elseif ($order_item['item_status'] == 3): ?>
                          <p class="card-text text-muted"><small>환불 완료일: <?= htmlspecialchars($order_item['refund_date']); ?></small></p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

                <?php if ($has_refundable): ?>
                  <button type="button" class="btn btn-outline-danger btn-sm mt-3 refund_btn">선택한 강의 환불 요청</button>
                <?php endif; ?>
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
    // 강의 단위 환불 요청. 실제 취소는 관리자가 승인할 때 처리된다
    document.querySelectorAll('.refund_btn').forEach(button => {
      button.addEventListener('click', () => {
        const card = button.closest('.order_card');
        const checked = card.querySelectorAll('.refund_check:checked');
        if (checked.length === 0) {
          alert('환불할 강의를 선택해주세요.');
          return;
        }

        const reason = prompt('환불 사유를 입력해주세요.');
        if (reason === null) {
          return;
        }
        if (reason.trim() === '') {
          alert('환불 사유를 입력해주세요.');
          return;
        }

        const data = new URLSearchParams();
        checked.forEach(box => data.append('oiid[]', box.value));
        data.append('reason', reason);

        fetch('refund_request_ok.php', {
            method: 'post',
            body: data,
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('HTTP error! Status: ' + response.status);
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

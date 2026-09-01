<?php
$title = "주문 / 환불 관리";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$id = $_SESSION['AUID'];
if (!isset($id)) {
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

// 목록 상태 필터. 기본은 환불요청 건만 보여준다
$view = $_GET['view'] ?? 'refund';
if ($view === 'refund') {
  $status_where = "AND o.status = 4";
} else if (ctype_digit($view)) {
  $status_where = "AND o.status = $view";
} else {
  $status_where = "";
}

$order_sql = "SELECT o.*, m.memName
  FROM lecture_order o
  LEFT JOIN memberskakao m ON m.memEmail = o.mid
  WHERE 1=1 $status_where
  ORDER BY o.odid DESC
  LIMIT 200";
$order_result = $mysqli->query($order_sql);
$dataArr = [];
$odidArr = [];
while ($order_row = $order_result->fetch_object()) {
  $dataArr[] = $order_row;
  $odidArr[] = (int) $order_row->odid;
}

// 화면에 뜬 주문의 강의 목록을 한 번에 읽어 주문번호로 묶는다
$items_by_order = [];
if (!empty($odidArr)) {
  $odids = implode(',', $odidArr);
  $item_sql = "SELECT oi.oiid, oi.odid, oi.lid, oi.paid_price, oi.status, oi.refund_reason, oi.refund_date, l.title
    FROM lecture_order_item oi
    LEFT JOIN lecture_list l ON l.lid = oi.lid
    WHERE oi.odid IN ($odids)
    ORDER BY oi.odid DESC, oi.oiid ASC";
  $item_result = $mysqli->query($item_sql);
  while ($item_row = $item_result->fetch_object()) {
    $items_by_order[$item_row->odid][] = $item_row;
  }
}

// 환불요청이 몇 건 밀려 있는지 (강의 단위로 센다)
$wait_sql = "SELECT COUNT(*) AS cnt FROM lecture_order_item WHERE status = 4";
$wait_result = $mysqli->query($wait_sql);
$wait_cnt = $wait_result ? $wait_result->fetch_object()->cnt : 0;

// 주문/항목 공통 상태 이름표
$order_status_name = [
  0 => '결제대기',
  1 => '결제완료',
  2 => '결제실패',
  3 => '환불완료',
  4 => '환불요청',
];
?>

<div class="container">
  <div class="d-flex gap-3 mt-3 align-items-center">
    <h3>주문 / 환불 관리</h3>
    <span class="ms-auto">처리 대기중인 환불요청 : <strong><?= $wait_cnt ?></strong> 건</span>
  </div>

  <div class="d-flex gap-2 mt-3">
    <a href="order_list.php?view=refund" class="btn btn-sm <?= $view === 'refund' ? 'btn-primary' : 'btn-secondary' ?>">환불요청</a>
    <a href="order_list.php?view=1" class="btn btn-sm <?= $view === '1' ? 'btn-primary' : 'btn-secondary' ?>">결제완료</a>
    <a href="order_list.php?view=3" class="btn btn-sm <?= $view === '3' ? 'btn-primary' : 'btn-secondary' ?>">환불완료</a>
    <a href="order_list.php?view=all" class="btn btn-sm <?= $view === 'all' ? 'btn-primary' : 'btn-secondary' ?>">전체</a>
  </div>

  <hr>
  <table class="table align-middle">
    <thead>
      <tr>
        <th scope="col">주문번호</th>
        <th scope="col">회원</th>
        <th scope="col">강의 (환불할 강의를 선택)</th>
        <th scope="col">결제금액</th>
        <th scope="col">결제수단</th>
        <th scope="col">주문일</th>
        <th scope="col">상태</th>
        <th scope="col">처리</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($dataArr as $item) { ?>
        <?php
          $order_items = $items_by_order[$item->odid] ?? [];

          // 승인/거절 버튼은 환불요청 상태인 강의가 있을 때만 띄운다
          $has_request = false;
          foreach ($order_items as $order_item) {
            if ($order_item->status == 4) {
              $has_request = true;
            }
          }
        ?>
        <tr class="order_row" data-odid="<?= $item->odid ?>">
          <th scope="row"><?= $item->odid ?></th>
          <td><?= $item->memName ?><br><small><?= $item->mid ?></small></td>
          <td>
            <?php foreach ($order_items as $order_item) { ?>
              <div class="mb-1">
                <?php if ($order_item->status == 4) { ?>
                  <input type="checkbox" class="refund_check" value="<?= $order_item->oiid ?>" checked>
                <?php } ?>
                <?= $order_item->title !== null ? $order_item->title : ('강의 ' . $order_item->lid) ?>
                <small class="text-muted">
                  (<?= $order_status_name[$order_item->status] ?? $order_item->status ?> ·
                  <?= number_format($order_item->paid_price) ?>원<?= $order_item->status == 3 && $order_item->refund_date ? ' · ' . $order_item->refund_date : '' ?>)
                </small>
              </div>
            <?php } ?>
          </td>
          <td><?= number_format($item->total_price) ?> 원</td>
          <td><?= $item->pay_method ?></td>
          <td><?= $item->createdate ?></td>
          <td><?= $order_status_name[$item->status] ?? $item->status ?></td>
          <td>
            <?php if ($has_request) { ?>
              <div class="mb-1"><small><?= $item->refund_reason ?></small></div>
              <button type="button" class="btn btn-danger btn-sm refund_btn" data-action="approve">선택 환불 승인</button>
              <button type="button" class="btn btn-secondary btn-sm refund_btn" data-action="reject">선택 요청 거절</button>
            <?php } else if ($item->status == 3) { ?>
              <?= $item->refund_date ?>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php if (empty($dataArr)) { ?>
    <p class="text-center my-5">해당하는 주문이 없습니다.</p>
  <?php } ?>
</div>

<script>
  // 환불 승인은 토스페이먼츠 결제 취소까지 같이 처리된다.
  // 선택한 강의만 취소하므로, 남는 강의가 있으면 부분 취소로 나간다
  document.querySelectorAll('.refund_btn').forEach(button => {
    button.addEventListener('click', () => {
      const action = button.getAttribute('data-action');
      const row = button.closest('.order_row');
      const checked = row.querySelectorAll('.refund_check:checked');

      if (checked.length === 0) {
        alert('처리할 강의를 선택해주세요.');
        return;
      }

      const message = action === 'approve' ?
        '선택한 ' + checked.length + '개 강의를 환불 처리할까요? 토스페이먼츠 결제도 함께 취소됩니다.' :
        '선택한 ' + checked.length + '개 강의의 환불 요청을 거절할까요? 결제완료 상태로 되돌아갑니다.';
      if (!confirm(message)) {
        return;
      }

      const data = new URLSearchParams();
      checked.forEach(box => data.append('oiid[]', box.value));
      data.append('action', action);

      fetch('order_refund_ok.php', {
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

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>

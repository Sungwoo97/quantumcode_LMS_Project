<?php

// 주문 상태를 항목 상태에서 다시 계산해 맞춘다.
// 부분환불이 생기면서 lecture_order_item 이 진실의 원천이 되었지만,
// 기존 화면들이 여전히 lecture_order.status 를 보고 있어서 항목이 바뀔 때마다 여기서 따라가게 한다.
// 반환값은 새로 정해진 주문 상태. 항목이 하나도 없으면 null.
function sync_order_status($mysqli, $odid) {
  $odid = (int) $odid;

  $count_sql = "SELECT status, COUNT(*) AS cnt FROM lecture_order_item WHERE odid = $odid GROUP BY status";
  $count_result = $mysqli->query($count_sql);
  if (!$count_result) {
    return null;
  }

  $status_count = [0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0];
  $item_total = 0;
  while ($count_row = $count_result->fetch_object()) {
    $status_count[(int) $count_row->status] = (int) $count_row->cnt;
    $item_total += (int) $count_row->cnt;
  }
  if ($item_total === 0) {
    return null;
  }

  if ($status_count[4] > 0) {
    // 처리해야 할 환불요청이 남아 있으면 관리자 목록에 걸리도록 환불요청으로 둔다
    $order_status = 4;
  } else if ($status_count[1] > 0) {
    // 결제완료가 하나라도 남아 있으면 결제완료. 부분환불된 주문도 여기에 들어간다
    $order_status = 1;
  } else if ($status_count[3] > 0) {
    $order_status = 3;
  } else if ($status_count[2] > 0) {
    $order_status = 2;
  } else {
    $order_status = 0;
  }

  // 전액 환불로 넘어가는 순간에만 주문 환불일을 남긴다
  if ($order_status === 3) {
    $mysqli->query("UPDATE lecture_order SET status = 3, refund_date = IFNULL(refund_date, NOW()) WHERE odid = $odid");
  } else {
    $mysqli->query("UPDATE lecture_order SET status = $order_status WHERE odid = $odid");
  }

  return $order_status;
}

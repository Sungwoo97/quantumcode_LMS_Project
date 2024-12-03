<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

/*
$userid = $_SESSION['UID'];
if (!isset($userid)) {
  echo "
    <script>
      alert('로그인해주세요');
      location.href = history.back();
    </script>
  ";
}*/
$lid = $_GET['lid'];

$sql = "SELECT * FROM lecture_list WHERE lid = $lid";
$result = $mysqli->query($sql);
if ($row = $result->fetch_object()) {
  if ($row->dis_tuition) {
    $tuition = $row->dis_tuition;
  } else {
    $tuition = $row->tuition;
  }
}

echo $tuition;

// 임시로 mid는 홍길동(5) 입력
$cart_sql = "INSERT INTO lecture_cart (mid, lid, price) VALUES ( 5, $lid, $tuition )";
$cart_result = $mysqli->query($cart_sql);


if ($cart_result) {
  echo "<script>
    alert('강의가 등록되었습니다.');
    location.href = 'lecture_order.php';
    </script>";
}

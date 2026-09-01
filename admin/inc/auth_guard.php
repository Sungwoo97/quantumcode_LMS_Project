<?php
// 로그인한 관리자만 이 스크립트를 실행할 수 있게 막는다.
// 처리(삭제/수정/등록) 엔드포인트들은 dbcon.php 만 include 하고 session_start() 를 안 해서
// 세션이 로드조차 안 됐다. 여기서 세션을 열고 로그인 여부를 확인한다.
// 각 엔드포인트의 dbcon.php include 바로 뒤에 이 파일을 include 한다.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['AUID'])) {
  http_response_code(403);
  echo "<script>alert('관리자 로그인이 필요합니다.'); location.href='/qc/admin/login.php';</script>";
  exit;
}

<?php
// 로그인한 강사(또는 관리자)만 이 스크립트를 실행할 수 있게 막는다.
// 처리 엔드포인트들은 session_start() 를 안 해서 세션이 로드조차 안 됐다.
// 여기서 세션을 열고 로그인 여부를 확인한다.
// 주의: 이 가드는 '로그인 여부' 만 본다. 강사가 남의 강의를 건드리는 것(소유권)은
// 아직 막지 않는다. 그건 별도 작업이다.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['TUID']) && !isset($_SESSION['AUID'])) {
  http_response_code(403);
  echo "<script>alert('강사 로그인이 필요합니다.'); location.href='/qc/admin/login_teacher.php';</script>";
  exit;
}

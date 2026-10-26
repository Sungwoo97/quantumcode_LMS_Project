<?php
// 별도 생성한 공개 계정만 안내하며 기존 최고관리자 자격증명은 읽지 않는다.
if (getenv('DEMO_MODE') === '1' && strlen(getenv('DEMO_PASSWORD') ?: '') >= 8) {
    $demo_password = htmlspecialchars(getenv('DEMO_PASSWORD'), ENT_QUOTES, 'UTF-8');
?>
<div class="alert alert-info text-start" role="note">
  <strong>공개 업무 체험 계정</strong><br>
  관리자: <code>portfolio_demo</code> / 수강생: <code>portfolio01@example.com</code><br>
  공통 비밀번호: <code><?= $demo_password ?></code><br>
  <a href="/qc/admin/login.php">관리자 로그인</a> · <a href="/qc/account/loginTest2.php">수강생 로그인</a><br>
  관리자는 매출·회원·강의를 조회하고 가상 주문 및 테스트 결제 환불을 처리할 수 있습니다.
  수강생은 테스트 구매·수강·환불 요청을 체험할 수 있습니다.
  계정 변경·관리 데이터 쓰기·업로드·외부 메일 발송은 제한됩니다.<br>
  여러 방문자가 함께 쓰는 가상 데이터이며, 초기화 시 체험 내용이 사라질 수 있습니다.
</div>
<?php
}
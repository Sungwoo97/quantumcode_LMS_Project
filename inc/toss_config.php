<?php
// 토스페이먼츠 연동 설정
// 아래 두 키는 토스페이먼츠 공식 샘플에 공개되어 있는 테스트 키.
// 공개 데모는 서버에서도 테스트 키 이외의 설정을 거절한다.
$toss_client_key = 'test_ck_D5GePWvyJnrK0W0k6q8gLzN97Eoq';
$toss_secret_key = 'test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R';

require_once __DIR__ . '/payment_safety.php';
require_test_payment_keys($toss_client_key, $toss_secret_key);

// 결제 승인 API 주소
$toss_confirm_url = 'https://api.tosspayments.com/v1/payments/confirm';

// 결제 취소는 주소에 paymentKey 가 들어간다 ($toss_api_base . '/' . $payment_key . '/cancel')
$toss_api_base = 'https://api.tosspayments.com/v1/payments';

require_once __DIR__ . '/payment_boundary.php';
$callback_token = urlencode(csrf_token());
// 결제 결과가 돌아올 주소
// 토스에 넘기는 절대 URL 이라 스킴이 필요하다. TLS 종료 프록시 뒤에서는
// $_SERVER['HTTPS'] 가 비어 있을 수 있어 X-Forwarded-Proto 도 함께 본다.
$toss_scheme = (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https'
  || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')) ? 'https' : 'http';
$toss_success_url = "{$toss_scheme}://{$_SERVER['HTTP_HOST']}/qc/lecture/lecture_payment_ok.php?csrf_token={$callback_token}";
$toss_fail_url = "{$toss_scheme}://{$_SERVER['HTTP_HOST']}/qc/lecture/lecture_payment_fail.php?csrf_token={$callback_token}";

// lecture_order.status 값
// 0 = 결제대기(결제창 띄우기 전 생성), 1 = 결제완료, 2 = 결제실패/취소

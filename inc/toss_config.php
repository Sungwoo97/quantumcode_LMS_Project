<?php
// 토스페이먼츠 연동 설정
// 아래 두 키는 토스페이먼츠 공식 샘플에 공개되어 있는 테스트 키.
// 운영 전환 시 개발자센터에서 발급받은 라이브 키로 교체할 것.
$toss_client_key = 'test_ck_D5GePWvyJnrK0W0k6q8gLzN97Eoq';
$toss_secret_key = 'test_sk_zXLkKEypNArWmo50nX3lmeaxYG5R';

// 결제 승인 API 주소
$toss_confirm_url = 'https://api.tosspayments.com/v1/payments/confirm';

// 결제 취소는 주소에 paymentKey 가 들어간다 ($toss_api_base . '/' . $payment_key . '/cancel')
$toss_api_base = 'https://api.tosspayments.com/v1/payments';

// 결제 결과가 돌아올 주소
$toss_success_url = "http://{$_SERVER['HTTP_HOST']}/qc/lecture/lecture_payment_ok.php";
$toss_fail_url = "http://{$_SERVER['HTTP_HOST']}/qc/lecture/lecture_payment_fail.php";

// lecture_order.status 값
// 0 = 결제대기(결제창 띄우기 전 생성), 1 = 결제완료, 2 = 결제실패/취소

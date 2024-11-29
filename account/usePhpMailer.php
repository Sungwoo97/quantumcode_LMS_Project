<?php
// PHPMailer 로드 (Composer 설치 시)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Composer 설치 경로

// PHPMailer 인스턴스 생성
$mail = new PHPMailer(true);

try {
    // 서버 설정
    $mail->isSMTP();                          // SMTP 사용
    $mail->Host       = 'smtp.gmail.com';     // SMTP 서버 주소 (Gmail)
    $mail->SMTPAuth   = true;                 // SMTP 인증 사용
    $mail->Username   = 'haemilyjh@gmail.com'; // Gmail 주소
    $mail->Password   = 'dkskWP12!@';       // Gmail 비밀번호 또는 앱 비밀번호
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS 암호화
    $mail->Port       = 587;                  // TLS 포트 번호

    // 송신자 및 수신자 설정
    $mail->setFrom('haemilyjh@gmail.com', 'junho');  // 보내는 사람
    $mail->addAddress('recipient_email@example.com', 'Recipient Name'); // 받는 사람
    $mail->addReplyTo('haemilyjh@gmail.com', 'junho'); // 회신 이메일

    // 이메일 내용
    $mail->isHTML(true);                      // HTML 메일 사용
    $mail->Subject = '테스트 이메일 제목';     // 이메일 제목
    $mail->Body    = '<h1>테스트 이메일 내용</h1>'; // HTML 형식 이메일 내용
    $mail->AltBody = '테스트 이메일 내용 (HTML 미지원 클라이언트용)'; // 텍스트 형식

    // 이메일 전송
    $mail->send();
    echo '이메일이 성공적으로 전송되었습니다.';
} catch (Exception $e) {
    echo "이메일 전송 실패: {$mail->ErrorInfo}";
}
?>
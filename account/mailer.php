<!-- php Mailer를 사용해서 이메일을 보내는 부분 -->

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . "/qc/vendor/autoload.php";

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();                               // SMTP 사용
$mail->Host = getenv('MAIL_HOST');             // Naver SMTP 서버
$mail->SMTPAuth = true;                        // SMTP 인증 사용
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL 암호화 사용
$mail->Port = (int) getenv('MAIL_PORT');       // SSL 포트
$mail->Username = getenv('MAIL_USERNAME');     // 계정 정보는 레포 밖 .env 에 있음
$mail->Password = getenv('MAIL_PASSWORD');



$mail->isHtml(true);

return $mail;
<!-- php Mailer를 사용해서 이메일을 보내는 부분 -->

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . "../vendor/autoload.php";  //왜 에러...?

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.example.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->Username = "haemilyjh@gmail.com";
$mail->Password = "dkskWP12!@";

$mail->isHtml(true);

return $mail;
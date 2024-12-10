<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';
$password = $_POST['password'];
$password = hash('sha512', $password);
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

// SQL 쿼리에서 memCreatedAt 포함
$sql = "INSERT INTO membersKakao
(memName, memPassword, memEmail, number, memCreatedAt, account_activation_token)
VALUES
(?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// memCreatedAt에 현재 타임스탬프 제공
$memCreatedAt = date("Y-m-d H:i:s");

$stmt->bind_param("ssssss", $name, $password, $email, $number, $memCreatedAt, $activation_token_hash);

if ($stmt->execute()) {
  $mail = require __DIR__ . "/mailer.php";

  $mail->setFrom("haemilyjh@naver.com"); // 발신 이메일
  $mail->addAddress($_POST["email"]);
  $mail->Subject = "Account Activation";
  $mail->Body = <<<END

  <a href="http://localhost/qc/account/active_account.php?token=$activation_token">here</a> 
  Click There, if you want To Confirm. It is not a SpamMail. From QuantumCode.

  END;

  try {
      $mail->send();
      echo "메세지가 보내졌습니다. 방금 작성하신 이메일을 확인해주세요.";
  } catch (Exception $e) {
      echo "메세지가 보내지지 않았습니다.. Mailer error: {$mail->ErrorInfo}";
  }

  echo <<<HTML
    <br>
    <p id="countdown">5초 후에 로그인 페이지로 이동합니다...</p>
    <script>
        let countdown = 5;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown + "초 후에 로그인 페이지로 이동합니다...";
            if (countdown === 0) {
                clearInterval(interval);
                window.location.href = "http://localhost/qc/account/loginTest2.php";
            }
        }, 1000);
    </script>
    HTML;

    exit(); // 리다이렉션 후 추가 코드 실행 방지
} else {
    echo "이메일이 데이터베이스에 존재하지 않습니다.";
}

$stmt->close();
$mysqli->close();



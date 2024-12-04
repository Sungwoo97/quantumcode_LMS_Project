<?php
//랜덤으로 보내서 디비에 저장

// include_once("../admin/inc/dbcon.php");

$email = $_POST["email"];

//랜덤 16개를 해시로 저장하고 암호화
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);  //인증시간 30분 

$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE membersKakao
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE memEmail = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);  //string 3번

$stmt->execute();

// 토큰 보내기 까지 잘 된다. 하지만, 디비에 없는 정보가 보내지면 안된다. 
if ($mysqli->affected_rows) {
    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("haemilyjh@naver.com"); // 발신 이메일
    $mail->addAddress($email);    // 받는 사람 이메일(즉 비번 찾는사람)
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    <a href="http://localhost/qc/account/reset_password.php?token=$token">here</a> 
    Click There, if you want To Change Password. From QuantumCode
    The Error is occured by using Korean Language. It is not a SpemMail.

    END;

    try {
        $mail->send();
        echo "메세지가 보내졌습니다. 방금 작성하신 이메일을 확인해주세요.";
    } catch (Exception $e) {
        echo "메세지가 보내지지 않았습니다.. Mailer error: {$mail->ErrorInfo}";
    }

    // 동적 카운트다운과 리다이렉션
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
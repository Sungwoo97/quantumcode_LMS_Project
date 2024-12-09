<?php
// Database 연결
include_once("../admin/inc/dbcon.php");

$email = $_POST["email"] ?? '';

if (empty($email)) {
    die("이메일을 입력해주세요.");
}

try {
    // 랜덤 토큰 생성 및 해시 처리
    do {
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);

        // 데이터베이스에 동일한 해시가 있는지 확인
        $check_sql = "SELECT COUNT(*) FROM membersKakao WHERE reset_token_hash = ?";
        $check_stmt = $mysqli->prepare($check_sql);
        $check_stmt->bind_param("s", $token_hash);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();
    } while ($count > 0); // 중복된 토큰이 있을 경우 반복

    // 토큰 만료 시간 설정 (30분)
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // 업데이트 쿼리
    $sql = "UPDATE membersKakao
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE memEmail = ?";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        throw new Exception("쿼리 준비 실패: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    if ($mysqli->affected_rows > 0) {
        // 이메일 전송
        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("haemilyjh@naver.com"); // 발신 이메일
        $mail->addAddress($email); // 받는 사람 이메일
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END

        <a href="http://localhost/qc/account/reset_password.php?token=$token">here</a> 
        Click There, if you want To Change Password. It is not a SpamMail. From QuantumCode.

        END;

        try {
            $mail->send();
            echo "메세지가 보내졌습니다. 방금 작성하신 이메일을 확인해주세요.";
        } catch (Exception $e) {
            echo "메세지가 보내지지 않았습니다.. Mailer error: {$mail->ErrorInfo}";
        }

        // 동적 카운트다운 및 리다이렉션
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

        exit();
    } else {
        echo "입력하신 이메일이 데이터베이스에 존재하지 않습니다.";
    }
} catch (Exception $e) {
    echo "오류가 발생했습니다: " . $e->getMessage();
} finally {
    $stmt->close();
    $mysqli->close();
}

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
//토큰 보내기 까지 잘 된다. 하지만, 디비에 없는 정보가 보내지면 안된다. 

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@example.com"); //일반적으로는 이렇게 해놓는다함
    $mail->addAddress($email);    //받는 사람 이메일(즉 비번 찾는사람)
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://example.com/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}

echo "Message sent, please check your inbox.";
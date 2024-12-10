<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$userpw = $_POST['password'];
$password = hash('sha512',$userpw);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM membersKakao
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}


//다시 토큰 초기화
$sql = "UPDATE membersKakao
        SET mempassword = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE memEmail = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password, $user["memEmail"]);

$stmt->execute();

echo "비밀번호가 재설정 되었습니다. 다시 로그인 해 주세요.";
<?php
//토큰을 파라미터로 사용하자
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

//해당 토큰을 갖고 있는 계정을 수정해야 하므로..
$sql = "SELECT * FROM membersKakao  
        WHERE account_activation_token = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);  //token_hash가 스트링이고 1개이므로 s하나만
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("토큰을 찾기 못했습니다.");
}

$sql = "UPDATE membersKakao
        SET account_activation_token = NULL
        WHERE memEmail = ?";   //★

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $user["memEmail"]);

$stmt->execute();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Activated</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <h1>계정이 활성화 되었습니다.</h1>

    <p>계정이 성공적으로 활성화 되었습니다. 로그인 하실 수 있습니다.
       <a href="loginTest2.php">log in</a>.</p>

</body>
</html>
<?php
//토큰을 파라미터로 사용하자
$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

//해당 토큰을 갖고 있는 계정을 수정해야 하므로..
$sql = "SELECT * FROM membersKakao  
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);  //token_hash가 스트링이고 1개이므로 s하나만
$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("토큰이 없습니다. 다시 확인해주세요");
}
if (strtotime($user["reset_token_expires_at"]) <= time()) { //토큰 만기시간
    die("기간이 만기하셨습니다. 다시 확인해주세요");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>비밀번호 재설정</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

    <!-- 다시 한번 재설정 해줘야한다. -->
    <h1>비밀번호 재설정</h1>

    <form method="post" action="process_reset_password.php">

        <input type="hidden" name="token" id="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New password</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Repeat password</label>
        <input type="password" id="password_confirmation"
               name="password_confirmation">
        <button>저장하기</button>
    </form>

</body>
</html>
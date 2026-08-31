<?php
// 그냥 확인용으로 넣어봄. 확인 후 변경할것
// 접속 정보는 레포 밖 .env 에 있고 docker compose 가 환경변수로 주입한다
$hostname = getenv('DB_HOST');
$username = getenv('DB_USER');
$dbpassword = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// 주입이 안 되면 mysqli 접속 오류 대신 원인을 바로 알 수 있게 중단
if ($hostname === false || $username === false || $dbname === false) {
    throw new RuntimeException('DB 환경변수가 없습니다. .env 와 docker compose 의 env_file 설정을 확인하세요.');
}

$mysqli = new mysqli($hostname, $username, $dbpassword, $dbname);

if ($mysqli->connect_errno) { 
    throw new RuntimeException('연결에러: ' . $mysqli->connect_error);
}

/* Set the desired charset after establishing a connection */
$mysqli->set_charset('utf8mb4');
if ($mysqli->errno) {
    throw new RuntimeException('연결후 에러: ' . $mysqli->error);
}
?>
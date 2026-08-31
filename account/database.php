<?php

// 접속 정보는 레포 밖 .env 에 있고 docker compose 가 환경변수로 주입한다
$hostname = getenv('DB_HOST');
$username = getenv('DB_USER');
$dbpassword = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// 주입이 안 되면 mysqli 접속 오류 대신 원인을 바로 알 수 있게 중단
if ($hostname === false || $username === false || $dbname === false) {
  die("DB 환경변수가 없습니다. .env 와 docker compose 의 env_file 설정을 확인하세요.");
}

$mysqli = new mysqli($hostname, $username, $dbpassword, $dbname);

if ($mysqli->connect_errno) {
  die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

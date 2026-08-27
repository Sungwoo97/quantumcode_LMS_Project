<?php
// 그냥 확인용으로 넣어봄. 확인 후 변경할것
$hostname = 'db';        // Docker MySQL 컨테이너 서비스명
$username = 'quantumcode';
$dbpassword = '12345';
$dbname = 'quantumcode';

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
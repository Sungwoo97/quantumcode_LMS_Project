<?php

$hostname = 'db';        // Docker MySQL 컨테이너 서비스명
$username = 'quantumcode';
$dbpassword = '12345';
$dbname = 'quantumcode';

$mysqli = new mysqli($hostname, $username, $dbpassword, $dbname);

if ($mysqli->connect_errno) {
  die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

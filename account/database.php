<?php

$hostname = '3.39.192.39';
$username = 'quantumcode';
$dbpassword = '12345';
$dbname = 'quantumcode';

$mysqli = new mysqli($hostname, $username, $dbpassword, $dbname);

if ($mysqli->connect_errno) {
  die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;

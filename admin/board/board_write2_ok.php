<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/dbcon.php');

// board_write_ok.php 예시
$category = $_POST['category'];
$title = $_POST['title'];
$content = $_POST['content'];

$sql = "INSERT INTO posts (category, title, content) VALUES ('$category', '$title', '$content')";
$result = $mysqli->query($sql);


?>
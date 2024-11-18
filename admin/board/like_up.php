<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');

$pid = $_GET['pid'];
$category=$_GET['category'];


$sql = "SELECT * FROM board_like WHERE pid=$pid";
$result = $mysqli -> query($sql);





?>
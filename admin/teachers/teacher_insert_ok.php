<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/dbcon.php');

// if(!isset($_SESSION['AUID'])){
//   echo"
//   <script>
//     alert('관리자로 로그인 해 주세요.');
//     location.href = '../login.php';
//   </script>
//   ";
// }

$name = $_FILES['name'] ?? '';
$id = $_FILES['id'] ?? '';
$birth = $_FILES['birth'] ?? '';
$password = $_FILES['password'] ?? '';
// $passwordCheck = $_FILES['passwordCheck'] ?? '';
$email = $_FILES['email'] ?? '';
$number = $_FILES['number'] ?? '';
$reg_date = $_FILES['reg_date'] ?? '';
$teacher_detail = $_FILES['teacher_detail'] ?? '';


$grade = $_FILES['grade'] ?? '';
$cover_image = $_FILES['cover_image'] ?? '';

?>
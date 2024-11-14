<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/common.php');

// if(!isset($_SESSION['AUID'])){
//   echo"
//   <script>
//     alert('관리자로 로그인 해 주세요.');
//     location.href = '../login.php';
//   </script>
//   ";
// }

$name = $_POST['name'] ?? '';
$id = $_POST['id'] ?? '';
$birth = $_POST['birth'] ?? '';
$password = $_POST['password'] ?? '';
// $passwordCheck = $_FILES['passwordCheck'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';
$reg_date = $_POST['reg_date'] ?? '';
$teacher_detail =$_POST['teacher_detail'] ?? '';
$grade = $_POST['grade'] ?? '';
$cover_image = $_FILES['cover_image'] ?? '';
print_r($cover_image);


if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
  $fileUploadResult = fileUpload($_FILES['cover_image'], 'image');
  if ($fileUploadResult) {
    $teacher_coverImage = $fileUploadResult;
  } else {
    echo "<script>
              alert('파일 첨부할 수 없습니다.');
              history.back();
          </script>";
  }
}


$sql = "INSERT INTO teachers
(name, id, birth, password, email, number, reg_date, teacher_detail, grade, cover_image)
VALUES
($name, $id, $birth, $password, $email, $number, $reg_date, $teacher_detail, $grade, $cover_image)";

echo $sql;

$teacher_result = $mysqli->query($sql);
if ($teacher_data = $teacher_result->fetch_object()) {
  "<script>
    alert('강사가 등록되었습니다.');
    </script>";
}



$mysqli->close() ;
?>
<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/common.php');

$name = $_POST['name'] ?? '';
$id = $_POST['id'] ?? '';
$birth = $_POST['birth'] ?? '';
$password = $_POST['password'];
$password = hash('sha512', $password);
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';
$reg_date = $_POST['reg_date'] ?? '';
$teacher_detail = $_POST['teacher_detail'] ?? '';
$grade = $_POST['grade'] ?? '';
$cover_image = $_FILES['cover_image'] ?? '';
$tid = $_POST['tid'] ?? ''; // 수정 대상의 tid를 받아옴

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
  $fileUploadResult = fileUpload($_FILES['cover_image'], 'image');
  if ($fileUploadResult) {
    $cover_image = $fileUploadResult; // 업로드된 파일 경로를 변수에 저장
  } else {
    echo "<script>
              alert('파일 첨부할 수 없습니다.');
              history.back();
          </script>";
    exit;
  }
}

$sql = "UPDATE teachers
        SET name = '$name',
            id = '$id',
            birth = '$birth',
            password = '$password',
            email = '$email',
            number = '$number',
            reg_date = '$reg_date',
            teacher_detail = '$teacher_detail',
            grade = '$grade',
            cover_image = '$cover_image'
        WHERE tid = '$tid'";

echo $sql;

$teacher_result = $mysqli->query($sql);
if ($teacher_result) {
  echo "<script>
    alert('강사 정보가 수정 되었습니다.');
    history.back();
    </script>";
} else {
  echo "<script>
    alert('수정에 실패했습니다.');
    history.back();
  </script>";
}

$mysqli->close();
?>
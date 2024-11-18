<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/common.php');


$lecture_title = $_POST['title'];
$lecture_platforms = $_POST['platforms'] ?? '';
$lecture_development = $_POST['development'] ?? '';
$lecture_technologies = $_POST['technologies'] ?? '';
$lecture_tuition = $_POST['tuition'] ?? 0;
$lecture_disTuition = $_POST['dis_tuition'] ?? 0;
$lecture_registDay = $_POST['regist_day'] ?? 0;
$lecture_difficult = $_POST['difficult'] ?? '';
$lecture_ispremium = $_POST['ispremium'] ?? 0;
$lecture_ispopular = $_POST['ispopular'] ?? 0;
$lecture_isrecom = $_POST['isrecom'] ?? 0;
$lecture_isfree = $_POST['isfree'] ?? 0;
$lecture_subTitle = $_POST['sub_title'] ?? '';
$lecture_desc = rawurldecode($_POST['lecture_description']);

$lucture_objectives = $_POST['objectives'] ?? '';
$lecture_tag = $_POST['tag'] ?? '';

$lecture_coverImage = $_FILES['cover_image'] ?? null;
$lecture_prVideo = null;
$lecture_prVideoUrl = $_POST['pr_videoUrl'] ?? '';
// $lecture_addVideosUrl = $_FILES['add_videosUrl'];
print_r($_POST);

$expiration_day = date("Y-m-d", strtotime("+3 months", strtotime($lecture_registDay)));

$lecture_cate = $lecture_platforms . $lecture_development . $lecture_technologies;

if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
  $fileUploadResult = fileUpload($_FILES['cover_image'], 'image');
  if ($fileUploadResult) {
    $lecture_coverImage = $fileUploadResult;
  } else {
    echo "<script>
              alert('파일 첨부할 수 없습니다.');
              history.back();
          </script>";
  }
}

if (isset($_FILES['pr_video']) && $_FILES['pr_video']['error'] == UPLOAD_ERR_OK) {
  $fileUploadResult = fileUpload($_FILES['pr_video'], 'video');
  if ($fileUploadResult) {
    $lecture_prVideo = $fileUploadResult;
  } else {
    echo "<script>
              alert('파일 첨부할 수 없습니다.');
              history.back();
          </script>";
  }
}


$sql = "INSERT INTO  lecture_list
    (category, title, cover_image, tid, isfree, ispremium, ispopular, isrecom, tuition, dis_tuition, regist_day, expiration_day, sub_title, description, learning_obj, difficult, lecture_tag, pr_video )
    VALUES
    ('$lecture_cate', '$lecture_title', '$lecture_coverImage', '{$_SESSION['AUID']}', $lecture_isfree, $lecture_ispremium, $lecture_ispopular, $lecture_isrecom, $lecture_tuition, $lecture_disTuition, '$lecture_registDay', '$expiration_day', '$lecture_subTitle', '$lecture_desc', '$lucture_objectives', $lecture_difficult, '$lecture_tag', '$lecture_prVideo')
    ";

$lecture_result = $mysqli->query($sql);
if ($lecture_result) {
  "<script>
    alert('강의가 등록되었습니다.');
    location.href = 'lecture_list.php';
    </script>";
}

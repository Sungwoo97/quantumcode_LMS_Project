<?php
$title = "수강 신청";

$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$lid = $_GET['lid'];
// $userid = $_SESSION['UID'];

$sql = "SELECT * FROM lecture_list WHERE lid = $lid";
$result = $mysqli->query($sql);
if ($row = $result->fetch_object()) {
  if ($row->dis_tuition) {
    $tuition = $row->dis_tuition;
  } else {
    $tuition = $row->tuition;
  }
}

echo $tuition

?>




<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
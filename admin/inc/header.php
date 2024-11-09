<?php
/*
여기서 기존과 다르게 바로 admin/inc/header.php로 들어가는점은, 이전htdocs/abcmall/admin/inc/header.php 
경우에는 DOCUMENT_ROOT가 htdocs이지만 우리의 경우, DOCUMENT_ROOT가 3nd_projecct 이후 별도의 폴더 없이
바로 프로젝트를 실행해서 이렇게 실행됩니다. 
*/

include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/dbcon.php');
if (!isset($title)) {
  $title = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QuantumCode</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/common.css">
  <?php 
    if(isset($summernote_css)){
        echo $summernote_css;
      }
    if(isset($lecture_css)){
      echo $lecture_css;
    }
  ?>
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  -->
  <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <?php
  if(isset($summernote_js)){
      echo $summernote_js;
    }
  ?>
</head>

<body>
  <h2><?= $title ?> </h2>
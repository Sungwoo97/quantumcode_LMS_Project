<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/dbcon.php');

  $mysqli->autocommit(FALSE);//커밋이 안되도록 지정, 일단 바로 저장하지 못하도록

  try{

    $lecture_title = $_POST['title'];
    $lecture_platforms = $_POST['platforms'] ?? '';
    $lecture_development = $_POST['development'] ?? '';
    $lecture_technologies = $_POST['technologies'] ?? '';
    $lecture_tuition = $_POST['tuition'] ?? 0;
    $lecture_disTuition = $_POST['dis_tuition'] ?? 0;
    $lecture_regist_day = $_POST['regist_day'] ?? 0;
    $lecture_difficult = $_POST['difficult'] ?? '';
    $lecture_ispremium = $_POST['ispremium'] ?? 0;
    $lecture_ispopular = $_POST['ispopular'] ?? 0;
    $lecture_isrecom = $_POST['isrecom'] ?? 0;
    $lecture_isfree = $_POST['isfree'] ?? 0;
    $lecture_subTitle = $_POST['sub_title'] ?? '';
    $lecture_desc = $_POST['desc'];
    $lucture_objectives = $_POST['objectives'] ?? '';
    $lecture_tag = $_POST['tag'] ?? '';

    $lecture_coverImage = $_FILES['cover_image'] ?? '';
    $lecture_prVideo = $_FILES['pr_video'] ?? '';
    $lecture_prVideoUrl = $_POST['pr_videoUrl'] ?? '';
    // $lecture_addVideosUrl = $_FILES['add_videosUrl'];

    $expiration_day = strtotime("{$lecture_regist_day}-1 months");

    $lecture_cate = $lecture_platforms.$lecture_development.$lecture_technologies;
  
    

    $lecture_Sql = "INSERT INTO lecture_list 
    (category, title, cover_image, isfree, ispremium, ispopular, isrecom, tuition, dis_tuition, regist_day, expiration_day, sub_title, description, learning_obj, difficult, lecture tag, pr_video )
    VALUES
    ()
    ";

    echo $lecture_Sql;

  }catch (Exception $e) {
    $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.
    //에러문구
    exit;
  }
  $mysqli->close();
?>
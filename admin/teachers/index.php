<?php
session_start();
//print_r($_SESSION); Array ( [TUIDX] => 22 [TUID] => kwak [TUNAME] => 곽튜브 ) 이런식
if (!isset($title)) {
  $title = '';
}
isset($coupon_css) ? $coupon_css : '';
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

//강사의 로그인 데이터로 강사의 db에 있는 정보를 활용하려고 이렇게 넣어두었습니다.
$tid = $_SESSION['TUIDX'];
$it = $_SESSION['TUID'];
$name = $_SESSION['TUNAME'];
$tid = $_SESSION['TUIDX'];
// print_r($tid);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title> <?= $title; ?> - quantumcode</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/css/common.css">
    <!-- Core Style CSS -->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/css/core-style.css">
    <?php
    if (isset($summernote_css)) {
      echo $summernote_css;
    }
    if (isset($lecture_css)) {
      echo $lecture_css;
    }
    if (isset($teacher_css)) {
      echo $teacher_css;
    }
    if (isset($member_css)) {
      echo $member_css;
    }
    if (isset($board_css)) {
      echo $board_css;
    }
    ?>


  </head>
  <!-- Favicon -->


  <!-- Bootstrap, jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <?php
  if (isset($summernote_js)) {
    echo $summernote_js;
  }
  ?>
</head>

<body>
  <nav class="d-flex flex-column align-items-center justify-content-between">
    <div class="nav_aside_menu">
      <h1 class="top_logo d-flex justify-content-center">
        <a href="<?php echo isset($_SESSION['TUID']) ? '/qc/admin/teachers/index.php' : '/qc/admin/login.php'; ?>">
          <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/core-img/Normal_Logo.svg" alt="탑 로고">
        </a>
      </h1>
      <h6 class="top_logo d-flex justify-content-center">이 페이지는 <?= $_SESSION['TUID'] ?>강사의 개인 페이지 입니다.</h6>
      <h6 class="top_logo d-flex justify-content-center">[TUIDX] => <?= $_SESSION['TUIDX'] ?> [TUID] => <?= $_SESSION['TUID'] ?> [TUNAME] => <?= $_SESSION['TUNAME'] ?> 추후 지울예정. </h6>

      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav_cate_dashboard" aria-expanded="false" aria-controls="nav_cate_dashboard" id="dashboardButton">
              <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/icon-img/SquaresFour.svg" alt="대시보드 아이콘">대시보드
            </button>
          </h2>
          <ul id="nav_cate_dashboard" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <li>대시보드</li>
          </ul>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav_cate_Sales" aria-expanded="false" aria-controls="nav_cate_Sales">
              <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/icon-img/ChartLineUp.svg" alt="매출관리 아이콘">매출관리
            </button>
          </h2>
          <ul id="nav_cate_Sales" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <li><a href="">매출현황</a></li>
          </ul>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav_cate_lecture" aria-expanded="false" aria-controls="nav_cate_lecture">
              <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/icon-img/Book.svg" alt="강의 관리 아이콘">내 강의 관리
            </button>
          </h2>
          <ul id="nav_cate_lecture" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/teachers/lecture/lecture_list.php">나의 강의 목록</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/teachers/lecture/lecture_insert.php">강의 등록</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/teachers/lecture/category_list.php">카테고리 관리</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/teachers/lecture/lecture_review.php">수강평</a></li>
          </ul>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav_cate_member" aria-expanded="false" aria-controls="nav_cate_member">
              <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/icon-img/UsersFour.svg" alt="회원 관리 아이콘">내 회원 관리
            </button>
          </h2>
          <ul id="nav_cate_member" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/members/member_list.php">회원 목록</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/members/member_overview.php">회원 총괄</a></li>
          </ul>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav_cate_coupon" aria-expanded="false" aria-controls="nav_cate_coupon">
              <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/icon-img/Ticket.svg" alt="쿠폰 관리 아이콘">쿠폰 관리
            </button>
          </h2>
          <ul id="nav_cate_coupon" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/coupon/coupon_list.php">쿠폰 목록</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/coupon/coupon_regis.php">쿠폰 등록</a></li>
          </ul>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav_cate_board" aria-expanded="false" aria-controls="nav_cate_board">
              <img src="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/icon-img/Article.svg" alt="게시판 관리 아이콘">게시판 관리
            </button>
          </h2>
          <ul id="nav_cate_board" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/board/board_list.php?category=notice">공지사항</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/board/board_list.php?category=event">이벤트</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/board/board_list.php?category=qna">Q&A</a></li>
            <li><a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/board/board_list.php?category=free">자유게시판</a></li>
          </ul>
        </div>
      </div>
    </div>

    <?php
    if (!isset($_SESSION['AUIDX']) && !isset($_SESSION['TUIDX'])) {
    ?>
      <div class="admin_account d-flex gap-3 align-items-center">
        <p class="tt_02">로그인 이전입니다.</p>
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/login.php">로그인</a>
      </div>

    <?php
    } else {  //즉, auidx가 있다면...(로그인되었다면)
      if (isset($_SESSION['AUIDX'])) {
        $sql = "SELECT * FROM admins WHERE idx = {$_SESSION['AUIDX']}";  //지금 접속한 사람의 id값
      } else {
        $sql = "SELECT * FROM teachers WHERE tid = {$_SESSION['TUIDX']}";  //지금 접속한 사람의 id값
      }
      $result = $mysqli->query($sql);
      $data = $result->fetch_object()
    ?>
      <div class="admin_account">
        <div class="d-flex gap-3 align-items-center mb-4">
          <img src="<?= $data->cover_image; ?>" alt="" width="150" height="150">
          <?php
          if (isset($_SESSION['TUIDX'])) {
          ?>
            <h6 class="tt_02"><?= $_SESSION['TUID'] ?></h6>
          <?php
          }
          ?>

        </div>
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/logout.php">로그아웃</a>
      </div>
    <?php
    }
    ?>
  </nav>

  <div class="nav_header">
    <h2 class="main_tt"> <?= $title ?></h2>
  </div>

  <div class="page_wapper">
    <div class="content">



    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


  <script>
    // 대시보드 버튼 클릭 시 index.php로 이동
    document.addEventListener("DOMContentLoaded", () => {
      const dashboardButton = document.getElementById("dashboardButton");

      dashboardButton.addEventListener("click", (e) => {
        e.preventDefault();
        dashboardButton.classList.remove("collapsed");

        setTimeout(() => {
          window.location.href = "http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/teachers/index.php";
        }, 5000);
      });
    });
  </script>
</body>

</html>
<?php
$mysqli->close();
?>
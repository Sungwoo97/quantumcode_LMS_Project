<?php
session_start();
//print_r($_SESSION); //Array ( [MemEmail] => haemilyjh@naver.com [MUNAME] => 윤준호 [Mgrade] => bronze )
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

//처음 회원 가입했을때(즉 login_count가 0->1로 바뀌는 순간), 모달창 튀어나오게
$showModal = false; // 모달 표시 여부

if (isset($_SESSION['MemEmail'])) {
    $email = $_SESSION['MemEmail'];

    // `login_count`와 `first_coupon_issued`를 가져오기
    $sql = "SELECT login_count, first_coupon_issued FROM memberskakao WHERE memEmail = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($loginCount, $firstCouponIssued);
    $stmt->fetch();
    $stmt->close();

    // `login_count`가 1이고 `first_coupon_issued`가 0인 경우 모달 표시
    if ($loginCount == 1 && $firstCouponIssued == 0) {
        $showModal = true;
    }
}

?>

<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quantum Code</title>
  <!-- 제이쿼리랑 폰트어썸 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/css/common.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/css/core-style.css">
  <?php
  if (isset($slick_css)) {
    echo $slick_css;
  }
  if (isset($lecture_css)) {
    echo $lecture_css;
  }
  if (isset($video_css)) {
    echo $video_css;
  }
  if (isset($main_css)) {
    echo $main_css;
  }

  ?>
  <!-- Favicon 기본 설정 -->
  <link rel="apple-touch-icon" sizes="57x57" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/admin/img/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">

  <!-- 커스텀css... 필요하면 작성하나 비추 -->

  <style>

  </style>
</head>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<?php
if (isset($slick_js)) {
  echo $slick_js;
}
?>

<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
      <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/index.php">
        <img src="./img/main_logo1.png" alt="Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <div class="d-flex gap-3 align-items-center">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown ms-3">
              <a class="nav-link" href="#" id="lectureDropdown" role="button" aria-expanded="false">
                강의
              </a>
              <ul class="dropdown-menu" aria-labelledby="lectureDropdown">
                <li><a class="dropdown-item" href="#">프론트엔드</a></li>
                <li><a class="dropdown-item" href="#">백엔드</a></li>
                <li><a class="dropdown-item" href="#">게임</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#">커뮤니티</a>
              <ul class="dropdown-menu" aria-labelledby="communityDropdown">
                <li><a class="dropdown-item" href="#">공지사항</a></li>
                <li><a class="dropdown-item" href="#">FAQ</a></li>
                <li><a class="dropdown-item" href="#">QnA</a></li>
                <li><a class="dropdown-item" href="#">자유게시판</a></li>
                <li><a class="dropdown-item" href="#">질문게시판</a></li>
                <li><a class="dropdown-item" href="#">스터디 모집</a></li> <!--커뮤니티 이벤트는 추후 작성-->
              </ul> <!-- <= href 알아서 수정바람 -->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">이벤트</a> <!-- <= href 알아서 수정바람 -->
            </li>
          </ul>
          <form class="d-flex search-form">
            <input class="form-control me-2" type="search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
        <div class="ms-3 nav_sign d-flex gap-3">
          <?php if (isset($_SESSION['MUNAME'])): ?>
            <!-- 로그인된 경우 -->
            <span class="text-primary me-3"><?php echo htmlspecialchars($_SESSION['MUNAME']); ?>님</span>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/account/logout.php" class="btn btn-secondary">로그아웃</a>
          <?php else: ?>
            <!-- 로그인되지 않은 경우 -->
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/account/logintest2.php" class="btn btn-primary">로그인</a>
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/account/signup.php" class="btn btn-secondary">회원가입</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>


  <!-- 모달 HTML 위치는 자유롭게 변경 가능합니다. -->
  <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="welcomeModalLabel">환영합니다!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Quantum Code에 처음 오신 것을 환영합니다! 첫 방문을 기념하여 관심있는 분야를 선택하고 쿠폰을 발급받아 보세요!
        </div>
        <div class="modal-footer">
          <!-- 다음 버튼 -->
          <button type="button" class="btn btn-primary" id="nextButton">다음</button>
          <!-- 닫기 버튼 -->
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
        </div>
      </div>
    </div>
  </div>

  <!-- 두 번째 모달 HTML -->
  <div class="modal fade" id="secondModal" tabindex="-1" aria-labelledby="secondModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="categoryForm" method="POST" action="../qc/lecture/save_categories.php">
          <div class="modal-header">
            <h5 class="modal-title" id="secondModalLabel">카테고리 선택</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>관심 있는 학습 카테고리를 선택하세요:</p>
            <div id="categoryButtons" class="d-flex flex-wrap gap-2">
              <button type="button" class="btn btn-outline-primary category-btn" data-value="JavaScript">JavaScript</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="TypeScript">TypeScript</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="Python">Python</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="Docker">Docker</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="React">React</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="Java">Java</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="MySQL">MySQL</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="PHP">PHP</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="C">C</button>
              <button type="button" class="btn btn-outline-primary category-btn" data-value="NodeJs">NodeJs</button>
            </div>
            <!-- 숨겨진 필드로 선택한 카테고리 저장 -->
            <input type="hidden" name="selectedCategories" id="selectedCategories" value="">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            <button type="submit" class="btn btn-primary">저장</button>
          </div>
        </form>
      </div>
    </div>
  </div>



  <!-- JavaScript -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  <?php if ($showModal): ?>
    // 첫 번째 모달 표시
    const welcomeModal = new bootstrap.Modal(document.getElementById("welcomeModal"), {
      keyboard: true,
      backdrop: "static",
    });
    welcomeModal.show();

    // "다음" 버튼 클릭 시 두 번째 모달 표시
    document.getElementById("nextButton").addEventListener("click", function () {
      welcomeModal.hide(); // 첫 번째 모달 닫기
      const secondModal = new bootstrap.Modal(document.getElementById("secondModal"));
      secondModal.show(); // 두 번째 모달 열기
    });
  <?php endif; ?>

  const categoryButtons = document.querySelectorAll(".category-btn");
  const selectedCategoriesInput = document.getElementById("selectedCategories");
  const form = document.getElementById("categoryForm");
  let selectedCategories = []; // 선택된 카테고리 저장

  // 버튼 클릭 이벤트
  categoryButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const value = this.getAttribute("data-value");
      if (this.classList.contains("selected")) {
        // 선택 해제
        this.classList.remove("selected");
        selectedCategories = selectedCategories.filter((item) => item !== value);
      } else {
        // 선택
        this.classList.add("selected");
        selectedCategories.push(value);
      }
      console.log("Selected Categories:", selectedCategories); // 선택된 항목 확인용
    });
  });

  // 폼 제출 전에 숨겨진 필드에 선택된 카테고리 저장
  form.addEventListener("submit", function (event) {
    if (selectedCategories.length === 0) {
      event.preventDefault(); // 선택이 없으면 제출 막기
      alert("적어도 하나의 카테고리를 선택해주세요.");
    } else {
      selectedCategoriesInput.value = JSON.stringify(selectedCategories); // JSON 형식으로 저장
      console.log("폼 제출 데이터:", selectedCategoriesInput.value);
    }
  });
});






    
  </script>
<?php
session_start();
//print_r($_SESSION); //Array ( [MemEmail] => haemilyjh@naver.com [MUNAME] => 윤준호 [Mgrade] => bronze )
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

//처음 회원 가입했을때(즉 login_count가 0->1로 바뀌는 순간), 모달창 튀어나오게
$showModal = false; // 모달 표시 여부
if (isset($_SESSION['MemEmail'])) {
    $email = $_SESSION['MemEmail'];
    $sql = "SELECT login_count FROM memberskakao WHERE memEmail = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($loginCount);
    $stmt->fetch();
    $stmt->close();

    // `login_count`가 1인 경우 모달 표시
    if ($loginCount == 1) {
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
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/index.php">
             <img src="./img/main_logo1.png" alt="Logo" >
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link" href="#" id="lectureDropdown" role="button" aria-expanded="false">
                            강의
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="lectureDropdown">
                            <li><a class="dropdown-item" href="#">프론트엔드</a></li>
                            <li><a class="dropdown-item" href="#">백엔드</a></li>
                            <li><a class="dropdown-item" href="#">게임</a></li>   <!--커뮤니티 이벤트는 추후 작성-->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">커뮤니티</a>  <!-- <= href 알아서 수정바람 -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">이벤트</a>  <!-- <= href 알아서 수정바람 -->
                    </li>
                </ul>
                <form class="d-flex search-form">
                    <input class="form-control me-2" type="search" placeholder="검색" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">검색</button>
                </form>
                <div class="ms-3">
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
    <!-- 모달 HTML -->
    <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="welcomeModalLabel">환영합니다!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Quantum Code에 처음 오신 것을 환영합니다! 첫 방문을 기념하여 새로운 기능을 확인해보세요.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">확인</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 모달 표시 -->
    <?php if ($showModal): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'), {
                keyboard: true,
                backdrop: 'static'
            });
            welcomeModal.show();
        });
    </script>
    <?php endif; ?>
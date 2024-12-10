<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantum Code</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar img {
            height: 45px; /* 이미지 높이 조정 */
            width: auto; /* 비율 유지 */
        }
        .search-form .form-control {
        width: 150px; /* 검색창 너비 */
        height: 30px; /* 검색창 높이 */
        font-size: 14px; /* 글씨 크기 */
        }
        .search-form .btn {
            height: 30px; /* 버튼 높이 */
            font-size: 14px; /* 버튼 글씨 크기 */
            padding: 0 10px; /* 버튼 안쪽 여백 */
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 30px 20px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
        .footer a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }
        .footer a:hover {
            color: #0056b3;
        }
        .footer .social-icons a {
            margin: 0 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/index2.php">
             <img src="./img/main_logo1.png" alt="Logo" >
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">강의</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">커뮤니티</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">이벤트</a>
                    </li>
                </ul>
                <form class="d-flex search-form">
                    <input class="form-control me-2" type="search" placeholder="검색" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">검색</button>
                </form>
                <div class="ms-3">
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/account/logintest2.php" class="btn btn-primary">로그인</a>
                    <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/account/signup.php" class="btn btn-secondary">회원가입</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Placeholder for Main Content -->
    <main class="container my-5">
        <!-- 메인 콘텐츠는 나중에 추가 -->
        <div class="text-center">
            <p>메인 콘텐츠는 여기에 추가됩니다.</p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-md-start mb-3 mb-md-0">
                    <a href="#">공지사항</a>
                    <a href="#">이용약관</a>
                    <a href="#">FAQ</a>
                    <a href="#">개인정보 처리방침</a>
                    <a href="#">환불 규정</a>
                    <a href="#">고객센터</a>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <p>대표이사: 이코딩 | 개인정보보호관리자: 김코드<br>
            사업자번호: 000-00-00000 | 사업자정보확인<br>
            서울특별시 서대문구 가로수밑길 123, 코딩타워 10층 (우편번호: 12345)</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

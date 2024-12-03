<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 페이지</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 455px; /* 넓이 유지 */
            margin: 80px auto; /* 세로 간격 */
            padding: 65px 35px; /* 세로 길이를 더 늘림 */
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .kakao-btn {
            background-color: #fee500;
            color: #3c1e1e;
            font-weight: bold;
            border: none;
        }
        .kakao-btn:hover {
            background-color: #ffd700;
        }
        .btn-login {
            background-color: #007bff; /* 기본 파란색 */
            color: #fff;
            border: none;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #0056b3; /* 호버 시 어두운 파란색 */
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container text-center">
            <!-- Logo -->
            <img src="https://via.placeholder.com/150x50" alt="Logo" class="mb-4">
            
            <!-- Title -->
            <h4 class="mb-3">학습의 경계를 허물다,</h4>
            <h5 class="mb-4">퀀텀 코드</h5>

            <!-- Kakao Login -->
            <button class="btn kakao-btn w-100 mb-3"> 
                <img src="https://img.icons8.com/ios-filled/20/000000/chat--v1.png" alt="Kakao Icon" style="margin-right: 8px;">
                카카오로 1초 만에 시작하기
            </button>

            <hr class="my-4">

            <!-- Email Login Form -->
            <form action="process_login.php" method="POST">
                <div class="form-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="이메일" required>
                </div>
                <div class="form-group mb-3 position-relative">
                    <input type="password" class="form-control" name="password" placeholder="비밀번호" required>
                    <!-- <a href="#" class="position-absolute end-0 top-50 translate-middle-y me-3 text-decoration-none" style="font-size: 12px;">비밀번호 찾기</a> -->
                </div>
                <button type="submit" class="btn btn-login w-100 mb-3">로그인</button>
            </form>

            <!-- Sign Up Button -->
            <a href="signup.php" class="btn btn-light w-100">이메일로 회원가입</a>

            <!-- Footer -->
            <p class="mt-5" style="font-size: 12px;">혹시 아이디 / 비밀번호가 기억이 안나신다면? </p>
            <p class="mt-1" style="font-size: 12px;"><a href="#" class="text-decoration-none">아이디 / 비밀번호 재설정하기</a></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
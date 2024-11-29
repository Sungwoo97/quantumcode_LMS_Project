<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .signup-container {
            max-width: 480px;
            margin: 80px auto;
            padding: 40px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
        }
        .btn-submit:hover {
          background-color: #0056b3; /* 호버 시 어두운 파란색 */
          color: white;

        }
        .form-check-label {
            font-size: 14px;
        }
        .text-link {
            color: #007bff;
            text-decoration: none;
        }
        .text-link:hover {
            text-decoration: underline;
        }
        .form-text {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signup-container text-center">
            <!-- 로고 -->
            <img src="https://via.placeholder.com/150x50" alt="Logo" class="mb-4">
            
            <!-- 제목 -->
            <h4 class="mb-3">인생을 바꾸는 교육,</h4>
            <h5 class="mb-4">퀀텀 코드 회원가입</h5>

            <!-- 회원가입 양식 -->
            <form action="process_signup.php" method="POST">
                <!-- 이름 -->
                <div class="form-group mb-3">
                    <input type="text" class="form-control" name="name" placeholder="이름" required style="border-radius: 8px;">
                </div>
                
                <!-- 이메일 입력과 인증메일 보내기 버튼 -->
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" placeholder="이메일" required style="border-radius: 8px;">
                        <button class="btn btn-outline-secondary ms-2" type="button" style="border-radius: 8px;">중복체크</button>
                    </div>
                </div>

                <!-- 휴대폰 번호 입력과 중복체크 버튼 -->
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input type="tel" class="form-control" name="phone" placeholder="휴대폰 번호 (숫자만)" required style="border-radius: 8px;">
                        <button class="btn btn-outline-secondary ms-2" type="button" style="border-radius: 8px;">중복체크</button>
                    </div>
                </div>

                <!-- 비밀번호 -->
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="비밀번호" required style="border-radius: 8px;">
                    <!-- 비밀번호 안내 문구 -->
                    <div class="form-text">8자 이상, 숫자와 특수문자 포함을 권장합니다.</div>
                </div>

                <!-- 비밀번호 확인 -->
                <div class="form-group mb-3">
                    <input type="password" class="form-control" name="confirm_password" placeholder="비밀번호 확인" required style="border-radius: 8px;">
                </div>

                <!-- 약관 동의 -->
                <div class="form-check mb-2 text-start">
                    <input class="form-check-input" type="checkbox" id="agree_all" required>
                    <label class="form-check-label" for="agree_all">전체 동의</label>
                </div>
                <div class="form-check mb-2 text-start">
                    <input class="form-check-input" type="checkbox" id="agree_terms" required>
                    <label class="form-check-label" for="agree_terms">
                        서비스 이용약관 동의 (필수) <a href="#" class="text-link">보기</a>
                    </label>
                </div>
                <div class="form-check mb-2 text-start">
                    <input class="form-check-input" type="checkbox" id="agree_privacy" required>
                    <label class="form-check-label" for="agree_privacy">
                        개인정보 수집 및 이용 동의 (필수) <a href="#" class="text-link">보기</a>
                    </label>
                </div>
                <div class="form-check mb-4 text-start">
                    <input class="form-check-input" type="checkbox" id="agree_marketing">
                    <label class="form-check-label" for="agree_marketing">
                        마케팅 수신 동의 (선택) <a href="#" class="text-link">보기</a>
                    </label>
                </div>

                <!-- 회원가입 버튼 -->
                <button type="submit" class="btn btn-submit w-100" style="border-radius: 8px;">회원가입하기</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 로그인된 사용자의 이메일 가져오기
    if (!isset($_SESSION['MemEmail'])) {
        die("로그인이 필요합니다.");
    }
    $userEmail = $_SESSION['MemEmail'];

    // 선택된 카테고리 데이터 가져오기
    if (isset($_POST['selectedCategories'])) {
        $categories = json_decode($_POST['selectedCategories'], true); // JSON -> 배열 변환

        if (!empty($categories)) {
            // 카테고리를 다시 JSON 형식으로 변환하여 저장
            $categoriesJson = json_encode($categories, JSON_UNESCAPED_UNICODE);

            // 기존 레코드가 있는지 확인
            $checkQuery = "SELECT id FROM user_categories WHERE user_email = ?";
            $stmt = $mysqli->prepare($checkQuery);
            $stmt->bind_param("s", $userEmail);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // 기존 레코드 업데이트
                $updateQuery = "UPDATE user_categories SET category = ?, created_at = NOW() WHERE user_email = ?";
                $updateStmt = $mysqli->prepare($updateQuery);
                $updateStmt->bind_param("ss", $categoriesJson, $userEmail);
                $updateStmt->execute();
                $updateStmt->close();
            } else {
                // 새 레코드 삽입
                $insertQuery = "INSERT INTO user_categories (user_email, category, created_at) VALUES (?, ?, NOW())";
                $insertStmt = $mysqli->prepare($insertQuery);
                $insertStmt->bind_param("ss", $userEmail, $categoriesJson);
                $insertStmt->execute();
                $insertStmt->close();
            }

            $stmt->close();

            // membersKakao 테이블의 first_coupon_issued 값을 1로 업데이트
            $updateCouponQuery = "UPDATE membersKakao SET first_coupon_issued = 1 WHERE memEmail = ?";
            $couponStmt = $mysqli->prepare($updateCouponQuery);
            $couponStmt->bind_param("s", $userEmail);
            $couponStmt->execute();
            $couponStmt->close();

            // 성공 메시지 출력 및 리디렉션
            echo "<!DOCTYPE html>
                  <html lang='ko'>
                  <head>
                      <meta charset='UTF-8'>
                      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                      <title>저장 성공</title>
                      <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet'>
                      <style>
                          body {
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              height: 100vh;
                              background-color: #f8f9fa;
                              font-family: Arial, sans-serif;
                          }
                          .message-box {
                              text-align: center;
                              padding: 20px;
                              border-radius: 10px;
                              background-color: #ffffff;
                              box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                          }
                          .message-box h1 {
                              color: #28a745;
                              font-size: 24px;
                              margin-bottom: 15px;
                          }
                          .message-box p {
                              color: #6c757d;
                              font-size: 18px;
                          }
                          .spinner {
                              display: inline-block;
                              width: 40px;
                              height: 40px;
                              margin-top: 15px;
                              border: 4px solid #e9ecef;
                              border-radius: 50%;
                              border-top-color: #28a745;
                              animation: spin 1s linear infinite;
                          }
                          @keyframes spin {
                              to {
                                  transform: rotate(360deg);
                              }
                          }
                      </style>
                  </head>
                  <body>
                      <div class='message-box'>
                          <h1>저장 성공!</h1>
                          <p>카테고리와 쿠폰 정보가 성공적으로 저장되었습니다.</p>
                          <div class='spinner'></div>
                          <p>잠시 후 메인 페이지로 이동합니다...</p>
                      </div>
                      <script>
                          setTimeout(function() {
                              window.location.href = '/qc/index.php'; // 메인 페이지로 리디렉션
                          }, 3000); // 333초 후 리디렉션
                      </script>
                  </body>
                  </html>";
            exit;
        } else {
            echo "선택된 카테고리가 없습니다.";
        }
    } else {
        echo "데이터가 유효하지 않습니다.";
    }
} else {
    echo "잘못된 요청입니다.";
}

?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/common.php');

if (!isset($_SESSION['AUID'])) {
    echo "
      <script>
        alert('관리자로 로그인해주세요');
        location.href = '../login.php';
      </script>
    ";
    exit;
}

$mysqli->autocommit(FALSE);

try {
    $coupon_name = $_POST['coupon_name'] ?? '';
    $coupon_content = $_POST['coupon_content'] ?? '';
    $coupon_type = $_POST['coupon_type'] ?? '1';
    $coupon_price = $_POST['coupon_price'] ?? 0;
    $coupon_ratio = $_POST['coupon_ratio'] ?? 0;
    $status = isset($_POST['coupon_activate']) ? 1 : 0;
    $startdate = $_POST['startdate'] ?? date('Y-m-d');
    $enddate = $_POST['enddate'] ?? date('Y-m-d', strtotime('+1 year'));
    $userid = $_SESSION['AUID'] ?? 'admin';
    $max_value = $_POST['max_value'] ?? 0;
    $couponImage = '';

    // 이미지 업로드 처리
    if (isset($_FILES['coupon_image']) && $_FILES['coupon_image']['error'] == UPLOAD_ERR_OK) {
        $fileUploadResult = fileUpload($_FILES['coupon_image']);
        if ($fileUploadResult) {
            $couponImage = $fileUploadResult;
        } else {
            echo "<script>
                alert('파일 첨부할 수 없습니다.');
                history.back();
            </script>";
            exit;
        }
    }

    // 데이터 삽입 쿼리
    $sql = "INSERT INTO coupons 
            (coupon_name, coupon_content, coupon_image, coupon_type, coupon_price, coupon_ratio, status, userid, startdate, enddate, max_value) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        throw new Exception("SQL Prepare Error: " . $mysqli->error);
    }

    $stmt->bind_param(
        'ssssddsissi',
        $coupon_name,
        $coupon_content,
        $couponImage,
        $coupon_type,
        $coupon_price,
        $coupon_ratio,
        $status,
        $userid,
        $startdate,
        $enddate,
        $max_value
    );

    if ($stmt->execute()) {
        $mysqli->commit();
        echo "
          <script>
            alert('쿠폰 등록 완료');
            location.href = 'coupon_list.php';
          </script>
        ";
    } else {
        throw new Exception("SQL Execution Error: " . $stmt->error);
    }

} catch (Exception $e) {
    $mysqli->rollback();
    echo "<script>alert('오류가 발생했습니다: " . $e->getMessage() . "'); history.back();</script>";
}

$mysqli->close();
?>

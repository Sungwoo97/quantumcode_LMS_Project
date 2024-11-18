<?php
session_start();
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
    $coupon_image = $_POST['coupon_image'] ?? '';
    $coupon_type = $_POST['coupon_type'] ?? '';
    $coupon_price = $_POST['coupon_price'] ?? 0;
    $coupon_ratio = $_POST['coupon_ratio'] ?? 0;
    $status = isset($_POST['coupon_activate']) ? 1 : 0;
    $startdate = $_POST['startdate'] ?? date('Y-m-d');
    $enddate = $_POST['enddate'] ?? date('Y-m-d', strtotime('+1 year'));
    $userid = $_SESSION['AUID'] ?? 'admin';

    // 이미지 업로드 처리
    if (isset($_FILES['coupon_image']) && $_FILES['coupon_image']['error'] == UPLOAD_ERR_OK) {
        $fileUploadResult = fileUpload($_FILES['coupon_image']);
        if ($fileUploadResult) {
            $coupon_image = $fileUploadResult;
        } else {
            echo "<script>
                alert('파일 첨부할 수 없습니다.');
                history.back();
            </script>";
            exit;
        }
    }

    $sql = "INSERT INTO coupons 
    (coupon_name, coupon_content, coupon_image, coupon_type, coupon_price, coupon_ratio, status, userid) 
    VALUES
    ('$coupon_name', '$coupon_content', '$coupon_image', '$coupon_type', $coupon_price, $coupon_ratio, $status, '{$_SESSION['AUID']}')";
  
    $result = $mysqli->query($sql); 
  
    //입력성공하면 쿠폰등록 완료 경고창 띄우고 쿠폰목록 페이지로 이동
    if($result){
      echo "
        <script>
          alert('쿠폰 등록 완료');
          location.href = 'coupon_list.php';
        </script>
      ";
      $mysqli->commit();//디비에 커밋한다.
    }
  
   
  }catch (Exception $e) {
      $mysqli->rollback();//저장한 테이블이 있다면 롤백한다.
      exit;
  }
  
  $mysqli->close();
  ?>
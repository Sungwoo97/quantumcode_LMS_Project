<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/dbcon.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/common.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

$mysqli->autocommit(FALSE);//커밋이 안되도록 지정, 일단 바로 저장하지 못하도록

try{

  $coupon_name = $_POST['coupon_name'] ?? '';
  $coupon_content = $_POST['coupon_content'] ?? '';
  $coupon_type = $_POST['coupon_type'] ?? '1';
  $coupon_price = $_POST['coupon_price'] ?? 0;
  $coupon_ratio = $_POST['coupon_ratio'] ?? 0;
  $status = isset($_POST['coupon_activate']) ? 1 : 0;
  $startdate = $_POST['startdate'] ?? date('Y-m-d');
  $enddate = $_POST['enddate'] ?? '';
  $userid = $_SESSION['AUID'] ?? 'admin';
  $max_value = $_POST['max_value'] ?? 0;

  //쿠폰이미지 업로드
  if (isset($_FILES['coupon_image']) && $_FILES['coupon_image']['error'] == UPLOAD_ERR_OK)  {

    $fileUploadResult = fileUpload($_FILES['coupon_image']);

    if($fileUploadResult) {
        $couponImage = $fileUploadResult;
    } else {
        echo "<script>
            alert('파일 첨부할 수 없습니다.');
            history.back();
        </script>";
    }
  }
  //쿠폰 테이블에 입력
  $sql = "INSERT INTO coupons 
  (coupon_name, coupon_content, coupon_image, coupon_type, coupon_price, coupon_ratio, status, userid, startdate, enddate, max_value) 
  VALUES
  ('$coupon_name', '$coupon_content', '$couponImage', '$coupon_type', $coupon_price, $coupon_ratio, $status, '{$_SESSION['AUID']}', $startdate, $enddate $max_value)";

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
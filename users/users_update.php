<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

// 세션에서 사용자 이메일 가져오기
if (!isset($_SESSION['MemEmail'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href = '/qc/index.php';</script>";
    exit;
}

$userEmail = $_SESSION['MemEmail'];
$memId = $_SESSION['MemId'];
// SQL 쿼리 준비
$sql = "SELECT * FROM membersKakao WHERE memEmail = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $userEmail); // 사용자 이메일 바인딩
$stmt->execute();

// 결과 가져오기
$result = $stmt->get_result();
$data = $result->fetch_assoc(); // 결과를 배열로 가져오기

// 스테이트먼트 닫기
$stmt->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>내 정보 수정하기</title>
  <!-- 캐싱문제 방지 -->
  <link rel="stylesheet" href="/qc/css/core-style.css?v=<?= time(); ?>">
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
  <style>
    /* .profile-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ccc;
    } */
  </style>
</head>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<body>
  <div class="container mt-3">
    <h3 class="ms-5">나의 정보 수정하기</h3>
    <div class="row mt-4">
      <!-- 프로필 섹션 -->
      <div class="col-md-4 text-center">
      <?php 
        $profileImage = $data['memProfilePath'] ?? '../img/icon-img/no-image.png';
      ?>
      <img src="<?= htmlspecialchars($profileImage); ?>" alt="프로필 이미지" class="profile-img mb-3" style="width: 200px; height: 200px; object-fit: cover; border-radius: 25%; border: 2px solid #ccc;">
      <div class="input-group" style="width: 300px; margin: 0 auto;">
          <input type="file" class="form-control" accept="image/*" name="cover_image" id="cover_image" >
        </div>
        <p class="mt-3">등급 : <?= htmlspecialchars($data['grade']); ?></p>
        <p style="font-size: 12px;" class="mt-1">등급은 적립금과 매월 발행되는 쿠폰에 영향을 미칩니다.</p>
      </div>

      <!-- 정보 섹션 -->
      <div class="col-md-8">
        <table class="table table-bordered">
        <tbody>
          <tr>
            <th scope="row">이름</th>
            <td>
              <input type="text" class="form-control" name="memName" id="memName" placeholder="<?= htmlspecialchars($data['memName']); ?>" required maxlength="10">
            </td>
          </tr>
          <tr>
            <th scope="row">이메일</th>
            <td>
              <input type="text" class="form-control" name="memEmail" id="memEmail" placeholder="<?= htmlspecialchars($data['memEmail']); ?>" disabled>
            </td>
          </tr>
          <tr>
            <th scope="row">생년월일</th>
            <td>
              <input type="text" class="form-control" name="birth" id="birth" placeholder="<?= $data['birth'] ? htmlspecialchars($data['birth']) : '정보 없음'; ?>" disabled>
            </td>
          </tr>
          <tr>
            <th scope="row">주소</th>
            <td>
              <div class="input-group">
                <input type="text" class="form-control" name="memAddr" id="memAddr" placeholder="<?= $data['memAddr'] ? htmlspecialchars($data['memAddr']) : '정보 없음'; ?>" required maxlength="40">
                <button type="button" class="btn btn-outline-secondary" id="findAddressBtn">주소 찾기</button>
              </div>
            </td>
          </tr>
          <tr>
            <th scope="row">가입일</th>
            <td>
              <input type="text" class="form-control" name="memCreatedAt" id="memCreatedAt" placeholder="<?= htmlspecialchars($data['memCreatedAt']); ?>" disabled>
            </td>
          </tr>
          <tr>
            <th scope="row">마지막 로그인</th>
            <td>
              <input type="text" class="form-control" name="lastLoginAt" id="lastLoginAt" placeholder="<?= htmlspecialchars($data['lastLoginAt']); ?>" disabled>
            </td>
          </tr>
          <tr>
            <th scope="row">로그인 횟수</th>
            <td>
              <input type="text" class="form-control" name="login_count" id="login_count" placeholder="<?= htmlspecialchars($data['login_count']); ?>회" disabled>
            </td>
          </tr>
          <tr>
            <th scope="row">전화번호</th>
            <td>
              <input type="text" class="form-control" name="number" id="number" placeholder="<?= htmlspecialchars($data['number']); ?>" required maxlength="11">
            </td>
          </tr>
          <tr>
            <th scope="row">등급</th>
            <td>
              <input type="text" class="form-control" name="grade" id="grade" placeholder="<?= htmlspecialchars($data['grade']); ?>" disabled>
            </td>
          </tr>
        </tbody>
        </table>
        <div class="text-end">
          <a href="users_delete.php?MemId=<?= htmlspecialchars($data['memId']); ?>" class="btn btn-danger btn-md">탈퇴하기</a>
          <a href="users_update.php?MemId=<?= htmlspecialchars($data['memId']); ?>" class="btn btn-primary btn-md">저장하기</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<script>
  // 카카오 주소 API 활용
  document.getElementById("findAddressBtn").addEventListener("click", function() {
    new daum.Postcode({
      oncomplete: function(data) {
        // 주소 검색 결과 반환
        let fullAddress = data.roadAddress; // 도로명 주소
        let extraAddress = ''; // 추가 주소 (동, 건물명 등)

        // 상세주소 추가
        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
          extraAddress += data.bname;
        }
        if (data.buildingName !== '' && data.apartment === 'Y') {
          extraAddress += (extraAddress !== '' ? ', ' + data.buildingName : data.buildingName);
        }

        fullAddress += (extraAddress !== '' ? ' (' + extraAddress + ')' : '');
        
        // 주소 입력 필드에 값 채우기
        document.getElementById("memAddr").value = fullAddress;
      }
    }).open();
  });
</script>


<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
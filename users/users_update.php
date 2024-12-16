<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// 세션에서 사용자 이메일 가져오기
if (!isset($_SESSION['MemEmail'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); location.href = '/qc/index.php';</script>";
    exit;
}

$userEmail = $_SESSION['MemEmail'];

// 사용자 데이터 가져오기
$sql = "SELECT * FROM membersKakao WHERE memEmail = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>내 정보</title>
  <!-- 캐싱 문제 방지용 CSS -->
  <link rel="stylesheet" href="/qc/css/core-style.css?v=<?= time(); ?>">
  <!-- 폰트어썸 및 jQuery UI -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/css/common.css">
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST']; ?>/qc/css/core-style.css">
  <style>
    .profile-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #ccc;
    }
  </style>
</head>
<body>
  <div class="container mt-3">
    <h3>나의 정보</h3>
    <div class="row mt-4">
      <div class="col-md-4 text-center">
        <?php $profileImage = $data['memProfilePath'] ?? '../img/icon-img/no-image.png'; ?>
        <img src="<?= htmlspecialchars($profileImage); ?>" alt="프로필 이미지" class="profile-img mb-3">
        <p>등급: <?= htmlspecialchars($data['grade']); ?></p>
      </div>
      <div class="col-md-8">
        <table class="table table-bordered" id="userInfoTable">
          <tbody>
            <tr>
              <th>이름</th>
              <td data-key="memName"><?= htmlspecialchars($data['memName']); ?></td>
            </tr>
            <tr>
              <th>이메일</th>
              <td data-key="memEmail"><?= htmlspecialchars($data['memEmail']); ?></td>
            </tr>
            <tr>
              <th>생년월일</th>
              <td data-key="birth"><?= $data['birth'] ? htmlspecialchars($data['birth']) : '정보 없음'; ?></td>
            </tr>
            <tr>
              <th>주소</th>
              <td data-key="memAddr"><?= $data['memAddr'] ? htmlspecialchars($data['memAddr']) : '정보 없음'; ?></td>
            </tr>
            <tr>
              <th>번호</th>
              <td data-key="number"><?= $data['number'] ? htmlspecialchars($data['number']) : '정보 없음'; ?></td>
            </tr>
            <tr>
              <th>등급</th>
              <td data-key="grade"><?= htmlspecialchars($data['grade']); ?></td>
            </tr>
          </tbody>
        </table>
        <div class="text-end">
          <button class="btn btn-primary" id="editButton">수정하기</button>
          <button class="btn btn-success d-none" id="saveButton">저장하기</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const editButton = document.getElementById("editButton");
      const saveButton = document.getElementById("saveButton");
      const tableCells = document.querySelectorAll("td[data-key]");

      // 수정하기 버튼 클릭 시
      editButton.addEventListener("click", function () {
        editButton.classList.add("d-none");
        saveButton.classList.remove("d-none");

        tableCells.forEach((cell) => {
          const key = cell.dataset.key;
          const value = cell.innerText.trim();
          cell.innerHTML = `<input type="text" class="form-control" name="${key}" value="${value}">`;
        });
      });

      // 저장하기 버튼 클릭 시
      saveButton.addEventListener("click", function () {
        const updatedData = {};

        // 입력된 데이터를 수집
        tableCells.forEach((cell) => {
          const input = cell.querySelector("input");
          if (input) {
            updatedData[input.name] = input.value.trim();
            cell.innerText = input.value.trim(); // 입력값을 다시 텍스트로 변환
          }
        });

        // 버튼 상태 변경
        saveButton.classList.add("d-none");
        editButton.classList.remove("d-none");

        // 서버로 데이터 전송
        fetch('/qc/admin/update_member.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(updatedData),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert("정보가 성공적으로 업데이트되었습니다.");
            } else {
              alert("업데이트 실패: " + data.message);
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            alert("서버와의 통신 중 문제가 발생했습니다.");
          });
      });
    });
  </script>
</body>
</html>
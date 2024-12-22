<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

if (!isset($_SESSION['MemId'])) {
    echo "
        <script>
            alert('회원으로 로그인해주세요');
            location.href = '../index.php';
        </script>
    ";
}

$MemId = $_SESSION['MemId']; // print_r($MemId); 

$sql = "SELECT * FROM membersKakao WHERE memId = $MemId"; 
$result = $mysqli->query($sql); // 쿼리 실행 결과
$data = $result->fetch_object();


?>

<div class="container mt-5">
  <div class="row">
    <div class="col-3 mb-5">
      <div class="member_coverImg2 mb-3">
        <img src=" <?= $data->memProfilePath ?? '../img/icon-img/no-image.png'; ?>" id="coverImg" alt="" width="80" height="80" style="object-fit: cover; border-radius: 25%; border: 2px solid #ccc;">
      </div>
      <div>
        <h5>이름 : <?= $data->memName; ?></h5>
        <h6>아이디  : <?= $data->memEmail; ?></h6>
      </div>
      <hr>
      <div class="d-flex justify-content-center align-items-center gap-5">
        <div class="text-center">
          <p>총 강의 수</p>
          <p></p>
        </div>
        <div class="text-center">
          <p>평균 진도율</p>
          <p> </p>
        </div>
        <div class="text-center">
          <p>강의 평점</p>
          <p></p>
        </div>
      </div>
      <hr>
      <nav>
        <ul>
          <li class="my-2">
            <!-- 실제 이동 링크 -->
            <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/users/users_view.php?MemId=<?php echo htmlspecialchars($MemId); ?>" 
              class="text-decoration-none">
              대시보드
            </a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none load-page" data-page="myProgress.php" id="myLectures">수강 관리</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none load-page" data-page="myInfo.php" id="myInfo">개인 정보</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none load-page" data-page="myCoupons.php" id="myCoupons">나의 쿠폰</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none load-page" data-page="myMessages.php" id="myCoupons">나의 쪽지</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none load-page" data-page="myWrites.php" id="myCoupons">나의 작성글</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none load-page" data-page="myPayments.php" id="myCoupons">결제내역</a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="col-9 mb-3" id="main_content">
      <h4>메인메뉴에는 뭐가 들어가면 좋을까???</h4>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".load-page");
    const mainContent = document.getElementById("main_content");

    links.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const page = this.getAttribute("data-page");

            if (page) {
                fetch(page)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("페이지 로드 실패");
                        }
                        return response.text();
                    })
                    .then(html => {
                        mainContent.innerHTML = html;
                    })
                    .catch(error => {
                        console.error("페이지 로드 에러:", error);
                        mainContent.innerHTML = "<p>콘텐츠를 로드할 수 없습니다.</p>";
                    });
            }
        });
    });

    // URL에 특정 해시값(#myCoupons)이 있는 경우 자동 클릭
    const hash = window.location.hash;
    if (hash === "#myCoupons") {
        const myMessagesLink = document.querySelector('a[data-page="myMessages.php"]');
        if (myMessagesLink) {
            myMessagesLink.click();
        }
    }
});
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
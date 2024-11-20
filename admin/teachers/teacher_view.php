<?php
$title = '강사 상세 페이지';
$teacher_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/teacher.css\" rel=\"stylesheet\">";
$chart_js = "<script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../index.php';
    </script>
  ";
}


$tid = $_GET['tid'];
if (!isset($tid)) {
  echo "<script>alert('관련 정보가 없습니다.'); location.href = '../teachers/teacher_list.php';</script>";
}

$sql = "SELECT * FROM teachers WHERE tid = $tid";  //여기서 tid는 숫자.
$result = $mysqli->query($sql); //쿼리 실행 결과
$data = $result->fetch_object();


$sql2 = "SELECT * FROM lecture_list WHERE t_id = '$data->id'";
// echo $sql2;
$lecture_result = $mysqli->query($sql2); //쿼리 실행 결과
// $lecture_data = $lecture_result->fetch_object()
while($lecture_data = $lecture_result->fetch_object()){
  $lecture_dataArr[] = $lecture_data;
}

$lecture_dataArr = array_slice($lecture_dataArr, 0, 6); //총 6개만 보여줌
// print_r($lecture_dataArr)

?>

<div class="container">
  <h1>gdgd</h1>
  <div class="row teacher">
    <div class="col-3 mb-5">
      <div class="teacher_coverImg2 mb-3">
        <img src="<?= $data->cover_image; ?>" id="coverImg" alt="" width="200" height="200" style="object-fit: cover; border-radius: 25%;">
      </div>
      <div>
        <h5>이름 : <?= $data->name; ?></h5>
        <h6>아이디  : <?= $data->id; ?></h6>
      </div>
      <hr>
      <div class="d-flex justify-content-center align-items-center gap-5">
        <div class="text-center">
          <p>총 수강생 수</p>
          <p><?= $data->student_number ?></p>
        </div>
        <div class="text-center">
          <p>수강평 수</p>
          <p> </p>
        </div>
        <div class="text-center">
          <p>강의 평점</p>
          <p>4.6</p>
        </div>
      </div>
      <hr>
      <nav>
        <ul>
          <?php if (isset($data)) { ?> 
          <li class="my-2">
            <a href="teacher_view.php?tid=<?= $data->tid;?>" class="text-decoration-none">홈</a>
          </li>
          <li class="my-2">
            <a href="teacher_overview_allLecture.php?tid=<?= $data->tid;?>" class="text-decoration-none">모든 강의</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none" id="sales">매출</a>
          </li>
          <li class="my-2">
            <a href="#" class="text-decoration-none">개인 정보</a>
          </li>
          <?php } ?> 
        </ul>
      </nav>
    </div>
    <div class="col-9 mb-3" id="main_content">
      <table class="table">
        <h4>강사 소개글</h4>
        <tbody>
          <tr>
            <textarea disabled><?= $data->teacher_detail; ?></textarea>
          </tr>
        </tbody>
      </table>
      <hr>
      <?php if (isset($lecture_dataArr)) { ?>
      <h4>현재 진행 중인 강의 TOP4</h4>
      <div class="d-flex flex-wrap"> <!-- Flex 컨테이너 justify-content-center -->
        <?php foreach ($lecture_dataArr as $item) { ?> 
        <div class="card m-3 shadow-lg" style="width: 18rem; height: 22rem; border-radius: 15px; overflow: hidden;"> 
          <!-- 이미지 섹션 -->
          <img class="card-img-top" src="<?= $item->cover_image ?>" alt="Card image cap" style="height: 12rem; object-fit: cover;">
          <!-- 카드 본문 -->
          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-primary fw-bold"><?= $item->title ?></h5>
            <p class="card-text text-muted"><?= $item->description ?></p>
            <a href="/qc/admin/lecture/lecture_view.php?lid=<?= $item->lid; ?>" class="btn btn-primary mt-auto" style="border-radius: 10px;">
              해당 강의 보러가기
            </a>
          </div>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <div class="d-flex justify-content-center mt-4">
        <button id="show_all_lecture" class="btn btn-primary">모든 강의 보기</button>
      </div>
      <hr>
      <div class="container mt-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="card-title text-center mb-4">강사 개인 정보</h4>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th scope="col" class="text-center">구분</th>
                  <th scope="col" class="text-center">내용</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">회원 고유 ID</th>
                  <td>
                    <input type="text" class="form-control" name="name" id="name" placeholder="<?= $data->tid; ?>" disabled>
                  </td>
                </tr>
                <tr>
                  <th scope="row">이름</th>
                  <td>
                    <input type="text" class="form-control" name="name" id="name" placeholder="<?= $data->name; ?>" disabled>
                  </td>
                </tr>
                <tr>
                  <th scope="row">아이디</th>
                  <td>
                    <input type="text" class="form-control" name="id" id="id" placeholder="<?= $data->id; ?>" disabled>
                  </td>
                </tr>
                <tr>
                  <th scope="row">생년월일</th>
                  <td>
                    <input type="text" class="form-control" name="birth" id="birth" placeholder="<?= $data->birth; ?>" disabled>
                  </td>
                </tr>
                <tr>
                  <th scope="row">이메일</th>
                  <td>
                    <input type="text" class="form-control" name="email" id="email" placeholder="<?= $data->email; ?>" disabled>
                  </td>
                </tr>
                <tr>
                  <th scope="row">전화번호</th>
                  <td>
                    <input type="text" class="form-control" name="number" id="number" placeholder="<?= $data->number; ?>" disabled>
                  </td>
                </tr>
                <tr>
                  <th scope="row">가입일</th>
                  <td>
                    <input type="text" class="form-control" name="reg_date" id="reg_date" placeholder="<?= $data->reg_date; ?>" disabled>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <Form action="" id="teacher_save" method="" enctype="multipart/form-data">
        <div class="mt-3 d-flex justify-content-end">
          <a href="teacher_update.php?tid=<?= $data->tid; ?>" class="btn btn-primary btn-md">수정하기</a>
        </div>
      </Form>
    </div>
    <div class="col-9 mb-3" id="sales_content" style="display: none;">
      <h4>강사 매출 정보</h4>
      <p>여기에 강사의 매출 데이터를 표시합니다.</p>
    </div>
    
  </div>
</div>

<script>
  // 클릭 시 active 클래스 추가
  const navLinks = document.querySelectorAll('nav ul li a');
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      // 모든 링크에서 active 클래스 제거
      navLinks.forEach((l) => l.classList.remove('active'));
      // 클릭한 링크에 active 클래스 추가
      link.classList.add('active');
    });
  });


    // "모든 강의 보기" 버튼 클릭 이벤트
    $('#show_all_lecture').click(function () {
        const tid = <?= json_encode($tid) ?>; // 현재 페이지의 tid 가져오기

        // Ajax 요청
        $.ajax({
          //async, url, data(여기선 필요없을듯), type(여기선 필요없을듯), dataType 등이 요구됌
            async:false,
            url: `/qc/admin/teachers/get_all_lectures.php?tid=${tid}`,
            method: 'GET',
            dataType: 'json',
            error: function (xhr, status, error) {
                console.error('Error fetching lectures:', error);
                alert('강의를 가져오는 중 오류가 발생했습니다.');
            },
            success: function (data) {
                if (data.error) {
                    alert(`Error: ${data.error}`);
                    return;
                }

                // 강의 데이터 렌더링
                const $lectureContainer = $('.d-flex.flex-wrap');
                $lectureContainer.empty(); // 기존 강의 삭제

                $.each(data, function (index, item) {
                    const lectureCard = `
                        <div class="card m-3 shadow-lg" style="width: 25rem; height: 24rem; border-radius: 15px; overflow: hidden;">
                            <img class="card-img-top" src="${item.cover_image}" alt="강의 이미지" style="height: 12rem; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary fw-bold">${item.title}</h5>
                                <p class="card-text text-muted">${item.description}</p>
                                <a href="/qc/admin/lecture/lecture_view.php?lid=${item.lid}" class="btn btn-primary mt-auto" style="border-radius: 10px;">
                                    해당 강의 보러가기
                                </a>
                            </div>
                        </div>`;
                    $lectureContainer.append(lectureCard);
                });
            },
            
        });
    });

    $('#sales').click(function () {
      $('#main_content').hide();// 기존 콘텐츠 숨기기
      $('#sales_content').show();// 새로운 콘텐츠 표시
    });


  // document.getElementById('show_all_lecture').addEventListener('click', function () {
  //       const tid = <?= json_encode($tid) ?>; // 현재 페이지의 tid 가져오기

  //       // Ajax 요청
  //       fetch(`/qc/admin/teachers/get_all_lectures.php?tid=${tid}`)
  //           .then(response => {
  //               if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
  //               return response.json(); // JSON 형식으로 변환
  //           })
  //           .then(data => {
  //               if (data.error) {
  //                   alert(`Error: ${data.error}`);
  //                   return;
  //               }

  //               // 강의 데이터 렌더링
  //               const lectureContainer = document.querySelector('.d-flex.flex-wrap');
  //               lectureContainer.innerHTML = ''; // 기존 강의 삭제

  //               data.forEach(item => {
  //                   const lectureCard = `
  //                       <div class="card m-3 shadow-lg" style="width: 25rem; height: 24rem; border-radius: 15px; overflow: hidden;">
  //                           <img class="card-img-top" src="${item.cover_image}" alt="강의 이미지" style="height: 12rem; object-fit: cover;">
  //                           <div class="card-body d-flex flex-column">
  //                               <h5 class="card-title text-primary fw-bold">${item.title}</h5>
  //                               <p class="card-text text-muted">${item.description}</p>
  //                               <a href="/qc/admin/lecture/lecture_view.php?lid=${item.lid}" class="btn btn-primary mt-auto" style="border-radius: 10px;">
  //                                   해당 강의 보러가기
  //                               </a>
  //                           </div>
  //                       </div>`;
  //                   lectureContainer.innerHTML += lectureCard;
  //               });
  //           })
  //           .catch(error => console.error('Error fetching lectures:', error));
  //   });


</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
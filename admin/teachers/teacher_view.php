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

// print_r($lecture_dataArr)
?>

<div class="container">
  <Form action="" id="teacher_save" method="" enctype="multipart/form-data">
    <div class="row teacher">
      <div class="col-4 mb-5">
        <div class="teacher_coverImg2 mb-3">
          <img src="<?= $data->cover_image; ?>" id="coverImg" alt="" width="400" height="300">
        </div>
        <div class="col-12 mb-3">
          <table class="table">
            <tbody>
              <tr scope="row">
                <th scope="row" class="insert_name">최고 인기 강의 </th>
                <td>
                  <input type="text" class="form-control" name="name" id="name" placeholder="아직 구현 전" disabled>
                </td>
              </tr>
              <tr scope="row">
                <th scope="row" class="insert_name">누적 회원 수 </th>
                <td >
                  <input type="text" class="form-control" name="name" id="name" placeholder="아직 구현 전"  disabled>
                </td>
              </tr>
              <tr scope="row">
                <th scope="row" class="insert_id">이번 달 매출 </th>
                <td colspan="3">
                  <input type="text" class="form-control" name="id" id="id" placeholder="아직 구현 전"  disabled>
                </td>
              </tr>
              <tr scope="row">
                <th scope="row" class="insert_birth">올해 총 매출 </th>
                <td colspan="3">
                  <input type="text" class="form-control" name="birth" id="birth" placeholder="아직 구현 전"  disabled>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>



      <div class="col-8 mb-3">
        <!--  -->
        <?php
          if (isset($lecture_dataArr)) {
        ?>
        <h3>현재 진행 중인 강의</h3>
        <div class="d-flex flex-wrap"> <!-- Flex 컨테이너 -->
          <?php
          foreach ($lecture_dataArr as $item) {
          ?> 
          <div class="card m-3" style="width: 22rem;"> <!-- 개별 카드 -->
            <img class="card-img-top" src="<?= $item->cover_image?>" alt="Card image cap" width="300" height="200">
            <div class="card-body">
              <h5 class="card-title"><?= $item->title?></h5>
              <p class="card-text"><?= $item->description?></p>
              <a href="/qc/admin/lecture/lecture_view.php?lid=<?= $item->lid; ?>" class="btn btn-primary" >해당 강의 보러가기</a>
            </div>
          </div>
          <?php
          }
          ?>
        </div>
        <?php
        }
        ?>

        
        <!--  -->
        <hr>
        <table class="table">
          <h3>강사 월별 매출 현황</h3>
          <thead class="visually-hidden">
            <tr>
              <th scope="col">11111111111111111구분</th>
              <th scope="col">111111내용111111111</th>
            </tr>
          </thead>
          <tbody>
            <tr scope="row">
              <th scope="row" class="insert_name">회원 고유 ID</th>
              <td colspan="3">
                <input type="text" class="form-control" name="name" id="name" placeholder=<?= $data->tid; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">이름</th>
              <td colspan="3">
                <input type="text" class="form-control" name="name" id="name" placeholder=<?= $data->name; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_id">아이디</th>
              <td colspan="3">
                <input type="text" class="form-control" name="id" id="id" placeholder=<?= $data->id; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_birth">생년월일</th>
              <td colspan="3">
                <input type="text" class="form-control" name="birth" id="birth" placeholder=<?= $data->birth; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_email">이메일</th>
              <td colspan="3">
                <input type="text" class="form-control" name="email" id="email" placeholder=<?= $data->email; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_number">전화번호</th>
              <td colspan="3">
                <input type="text" class="form-control" name="number" id="number" placeholder=<?= $data->number; ?>  disabled>
              </td>
            </tr>
            <tr>
              <th scope="row">가입일</th>
              <td class="twoculumn_table">
                <input type="text" class="form-control" name="reg_date" id="reg_date" placeholder=<?= $data->reg_date; ?> disabled></input>
                <span></span>
              </td>
            </tr>
            <tr>
              <th scope="row">강사 요약</th>
              <td class="twoculumn_table">
                <label for="teacher_detail" class="bold"></label>
                <textarea class="form-control"  name="teacher_detail" id="teacher_detail"  disabled><?= $data->teacher_detail; ?></textarea>
              </td>
            </tr>
          </tbody>
        </table>
        <hr>
        <table class="table">
          <thead class="visually-hidden">
            <tr>
              <th scope="col">11111111111111111구분</th>
              <th scope="col">111111내용111111111</th>
            </tr>
          </thead>
          <tbody>
            <h3>강사 개인 정보</h3>
            <tr scope="row">
              <th scope="row" class="insert_name">회원 고유 ID</th>
              <td colspan="3">
                <input type="text" class="form-control" name="name" id="name" placeholder=<?= $data->tid; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">이름</th>
              <td colspan="3">
                <input type="text" class="form-control" name="name" id="name" placeholder=<?= $data->name; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_id">아이디</th>
              <td colspan="3">
                <input type="text" class="form-control" name="id" id="id" placeholder=<?= $data->id; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_birth">생년월일</th>
              <td colspan="3">
                <input type="text" class="form-control" name="birth" id="birth" placeholder=<?= $data->birth; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_email">이메일</th>
              <td colspan="3">
                <input type="text" class="form-control" name="email" id="email" placeholder=<?= $data->email; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_number">전화번호</th>
              <td colspan="3">
                <input type="text" class="form-control" name="number" id="number" placeholder=<?= $data->number; ?>  disabled>
              </td>
            </tr>
            <tr>
              <th scope="row">가입일</th>
              <td class="twoculumn_table">
                <input type="text" class="form-control" name="reg_date" id="reg_date" placeholder=<?= $data->reg_date; ?> disabled></input>
                <span></span>
              </td>
            </tr>
            <tr>
              <th scope="row">강사 요약</th>
              <td class="twoculumn_table">
                <label for="teacher_detail" class="bold"></label>
                <textarea class="form-control"  name="teacher_detail" id="teacher_detail"  disabled><?= $data->teacher_detail; ?></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    
      
    </div>
    <div class="mt-3 d-flex justify-content-end">
      <a href="teacher_update.php?tid=<?= $data->tid; ?>" class="btn btn-primary btn-md">수정하기</a>
    </div>
  </Form>
</div>

<script>
  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
<?php
$title = '강사 상세 페이지';
$teacher_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/teacher.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

// session_start();


$tid = $_GET['tid'];
if (!isset($tid)) {
  echo "<script>alert('상품정보가 없습니다.'); location.href = '../teachers/teacher_list.php';</script>";
}


// if(!isset($_SESSION['AUID'])){
//   echo "
//     <script>
//       alert('관리자로 로그인해주세요');
//       location.href = '../login.php';
//     </script>
//   ";
// }

$sql = "SELECT * FROM teachers WHERE tid = $tid";
$result = $mysqli->query($sql); //쿼리 실행 결과
while($data = $result->fetch_object()){
  $dataArr[] = $data;
}

?>

<div class="container">
  <Form action="" id="teacher_save" method="" enctype="multipart/form-data">
    <?php
      if(isset($dataArr)){
        foreach($dataArr as $item){
    ?> 
    <div class="row teacher">
      <div class="col-4 mb-5">
        <div class="teacher_coverImg mb-3">
          <img src="" id="coverImg" alt="">
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
        <table class="table">
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
                <input type="text" class="form-control" name="name" id="name" placeholder=<?= $item->tid; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">이름</th>
              <td colspan="3">
                <input type="text" class="form-control" name="name" id="name" placeholder=<?= $item->name; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_id">아이디</th>
              <td colspan="3">
                <input type="text" class="form-control" name="id" id="id" placeholder=<?= $item->id; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_birth">생년월일</th>
              <td colspan="3">
                <input type="text" class="form-control" name="birth" id="birth" placeholder=<?= $item->birth; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_email">이메일</th>
              <td colspan="3">
                <input type="text" class="form-control" name="email" id="email" placeholder=<?= $item->email; ?>  disabled>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_number">전화번호</th>
              <td colspan="3">
                <input type="text" class="form-control" name="number" id="number" placeholder=<?= $item->number; ?>  disabled>
              </td>
            </tr>
            <tr>
              <th scope="row">가입일</th>
              <td class="twoculumn_table">
                <input type="text" class="form-control" name="reg_date" id="reg_date" placeholder=<?= $item->reg_date; ?> disabled>
                <span></span>
              </td>
            </tr>
            <tr>
              <th scope="row">강사 요약</th>
              <td class="twoculumn_table">
                <label for="teacher_detail" class="bold"></label>
                <textarea class="form-control" placeholder=<?= $item->teacher_detail; ?> name="teacher_detail" id="teacher_detail"  disabled></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php
        }
      }
    ?>
    <div class="mt-3 d-flex justify-content-end">
      <a href="teacher_update.php?tid=<?= $item->tid; ?>" class="btn btn-primary btn-md">수정하기</a>
    </div>
  </Form>
</div>

<script>
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
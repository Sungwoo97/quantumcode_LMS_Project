<?php
$title = '강사 등록';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/lecture.css\" rel=\"stylesheet\">";
$summernote_css = "<link href=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css\" rel=\"stylesheet\">";
$summernote_js = "<script src=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.php');

$sql = "SELECT MAX(lid) AS last_lid FROM lecture_list";
if ($result = $mysqli->query($sql)) {
  $data = $result->fetch_object();
}


?>
<div class="container">
  <Form action="lecture_insert_ok.php" id="lecture_submit" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="lecture_description" name="lecture_description" value="">
    <input type="hidden" name="lecture_videoId" id="lecture_videoId" value="">
    <input type="hidden" name="lid" id="lid" value="<?= $data->last_lid === null ? 1 : $data->last_lid ?>">
    <div class="row lecture">
      <div class="col-4 mb-5">
        <h6>강사 이미지 등록</h6>
        <div class="lecture_coverImg mb-3">
          <img src="" id="coverImg" alt="">
        </div>
        <div class="input-group">
          <input type="file" class="form-control" accept="image/*" name="cover_image" id="cover_image" required>
        </div>
        <div>
          <tr scope="row">
            <th scope="row">강사등급 선택</th>
            <td colspan="3">
              <div class="d-flex gap-3">
                <select class="form-select" name="platforms" required>
                  <option value="" selected>등급을 선택해주세요</option>
                  <option value="A0001">Blonze</option>
                  <option value="A0001">Silver</option>
                  <option value="A0001">Gold</option>
                  <option value="A0001">Vip</option>
                </select>
              </div>
            </td>
          </tr>
        </div>
        
      </div>
      <div class="col-8 mt-3">
        <table class="table">
          <thead class="visually-hidden">
            <tr>
              <th scope="col">11111111111111111구분</th>
              <th scope="col">111111내용111111111</th>
            </tr>
          </thead>
          <tbody>
            <tr scope="row">
              <th scope="row" class="insert_name">이름</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="이름을 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">생년월일</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="생년월일을 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">아이디</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="아이디를 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">비밀번호</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="비밀번호를 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">비밀번호 확인</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="비밀번호를 한번 더 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">이메일</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="이메일을 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">전화번호</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="전화번호를을 입력해주세요" required>
              </td>
            </tr>
            <tr>
              <th scope="row">가입일</th>
              <td class="twoculumn_table">
                <input type="date" class="form-control" name="regist_day" id="regist_day" placeholder="" required>
                <span></span>
              </td>
            </tr>
            <!-- 강의 요약 넣기 -->
          </tbody>
        </table>
      </div>
    </div>
    <div class="mt-3 d-flex justify-content-end">
      <button type="submit" class="btn btn-danger">삭제</button>
      <button type="submit" class="btn btn-primary">등록</button>
    </div>
  </Form>
</div>

<script>

  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/footer.php');
?>
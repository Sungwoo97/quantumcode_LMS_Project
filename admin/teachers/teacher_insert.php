<?php
$title = '강사 등록';
$teacher_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/teacher.css\" rel=\"stylesheet\">";
$summernote_css = "<link href=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css\" rel=\"stylesheet\">";
$summernote_js = "<script src=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.php');


?>

<div class="container">
  <Form action="teacher_insert_ok.php" id="teacher_save" method="POST" enctype="multipart/form-data">
    <!-- <input type="hidden" id="teacher_description" name="teacher_description" value="">
    <input type="hidden" name="lid" id="lid" value=""> -->
    <div class="row teacher">
      <div class="col-4 mb-5">
        <h6>강사 이미지 등록</h6>
        <div class="teacher_coverImg mb-3">
          <img src="" id="coverImg" alt="">
        </div>
        <div class="input-group">
          <input type="file" class="form-control" accept="image/*" name="cover_image" id="cover_image" required>
        </div>
        <div class="mt-3">
          <tr>
            <th scope="row">강사등급 선택</th>
            <td colspan="3">
              <div class="d-flex gap-3">
                <select class="form-select mt-3" name="grade" required>
                  <option value="" selected>등급을 선택해주세요</option>
                  <option value="1">Blonze</option>
                  <option value="2">Silver</option>
                  <option value="3">Gold</option>
                  <option value="4">Vip</option>
                </select>
              </div>
            </td>
          </tr>
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
              <th scope="row" class="insert_name">이름</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="name" id="name" placeholder="이름을 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_id">아이디</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="id" id="id" placeholder="아이디를 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_birth">생년월일</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="birth" id="birth" placeholder="생년월일을 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_password">비밀번호</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="password" id="password" placeholder="비밀번호를 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_passwordCheck">비밀번호 확인</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="passwordCheck" id="passwordCheck" placeholder="비밀번호를 한번 더 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_email">이메일</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="email" id="email" placeholder="이메일을 입력해주세요" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_number">전화번호</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="number" id="number" placeholder="전화번호를을 입력해주세요" required>
              </td>
            </tr>
            <tr>
              <th scope="row">가입일</th>
              <td class="twoculumn_table">
                <input type="date" class="form-control" name="reg_date" id="reg_date" placeholder="" required>
                <span></span>
              </td>
            </tr>
            <tr>
              <th scope="row">강사 요약</th>
              <td class="twoculumn_table">
                <label for="teacher_detail" class="bold"></label>
                <textarea class="form-control" placeholder="강사 요약" name="teacher_detail" id="teacher_detail"></textarea>
              </td>
            </tr>
            
          </tbody>
        </table>
      </div>
    </div>
    <div class="mt-3 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">등록</button>
    </div>
  </Form>
</div>

<script>

  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/footer.php');
?>
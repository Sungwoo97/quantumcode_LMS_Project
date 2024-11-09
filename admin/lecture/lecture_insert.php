<?php
$title = '강의 등록';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/lecture.css\" rel=\"stylesheet\">;";
$summernote_css = "<link href=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css\" rel=\"stylesheet\">";
$summernote_js = "<script src=\"https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.php');
?>
<h4> lecture_insert</h4>
<div class="container">
  <Form action="lecture_insert_ok" method="POST">
    <div class="row lecture">
      <div class="col-4 mb-5">
        <h6>커버 이미지 등록</h6>
        <div class="lecture_coverImg mb-3">
          <!-- <img src="../img/core-img/Large Logo.svg" alt=""> -->
        </div>
        <div class="input-group">
          <input type="file" class="form-control" accept="image/*" name="cover_image" id="cover_image" >
        </div>
      </div>
      <div class="col-8 mt-3">
        <table class="table">
          <thead class="visually-hidden">
            <tr>
              <th scope="col">구분</th>
              <th scope="col">내용</th>
            </tr>
          </thead>
          <tbody>
            <tr scope="row">
              <th scope="row" class="insert_name">강의명</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="title" id="title" placeholder="강의명을 입력해주세요">
              </td>
            </tr>
            <tr scope="row">
              <th scope="row">카테고리 선택</th>
              <td colspan="3">
                <div class="d-flex gap-3">
                    <select class="form-select" name="platforms">
                      <option selected>Platforms</option>
                      <!-- <option value="1">One</option> -->
                    </select>
                    <select class="form-select"  name="development">
                      <option selected>Development</option>
                      <!-- <option value="1">One</option> -->
                    </select>
                    <select class="form-select" name="technologies">
                      <option selected>Technologies</option>
                      <!-- <option value="1">One</option> -->
                    </select>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">수강료</th>
              <td class="twoculumn_table">
                <input type="text" class="form-control" name="tuition" id="tuition" placeholder="">
                <span></span>
              </td>
              <th scope="row" class="insert_name">할인 수강료</th>
              <td>
                <input type="text" class="form-control" name="dis_tuition" id="dis_tuition" placeholder="">
              </td>
            </tr>
            <tr>
              <th scope="row">등록일</th>
              <td class="twoculumn_table">
                <input type="date" class="form-control" name="dis_tuition" id="regist_day" placeholder="">
                <span></span>
              </td>
              <th scope="row" class="insert_name">난이도</th>
              <td>
              <select class="form-select " name="difficult">
                    <option selected>난이도</option>
                    <option value="1">입문</option>
                    <option value="2">초급</option>
                    <option value="3">중급</option>
                    <option value="4">고급</option>
                    <option value="5">전문가</option>
                  </select>
              </td>
            </tr>
            <tr scope="row" >
              <th scope="row" class="insert_name">노출옵션</th>
              <td colspan="3">
                <div class="d-flex justify-content-between">
                  <div class="d-flex align-items-center flex-grow-1 justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="ispremium" value="" id="ispremium">
                    <label class="form-check-label" for="ispremium">프리미엄</label>
                  </div>
                  <div class="d-flex align-items-center flex-grow-1 justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="ispopular" value="" id="ispopular">
                    <label class="form-check-label" for="ispopular">인기 강의</label>
                  </div>
                  <div class="d-flex align-items-center flex-grow-1 justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="isrecom" value="" id="isrecom">
                    <label class="form-check-label" for="isrecom">추천 강의</label>
                  </div>
                  <div class="d-flex align-items-center flex-grow-1 justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="isfree" value="" id="isfree">
                    <label class="form-check-label" for="isfree">무료 강의</label>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-4 ">
        <h6>홍보영상 등록</h6>
        <div class="lecture_coverImg mb-3">
          <!-- <img src="../img/core-img/Large Logo.svg" alt=""> -->
        </div>
        <input type="file" class="form-control" accept="video/*" name="pr_video" id="pr_video" >
        <div class="input-group mb-3">
          <span class="input-group-text" id="pr_videoAddon">URL</span>
          <input type="text" class="form-control" name="pr_videoUrl" id="pr_videoUrl" >
        </div>
      </div>
      <div class="col-8 ">
        <div class="d-flex flex-column gap-2">
          <label for="sub_title" class="bold">강의 요약</label>
          <textarea class="form-control" placeholder="강의 요약" name="sub_title" id="sub_title"></textarea>
        </div >
      </div>
      <div>
        <h6>강의 상세 설명</h6>
        <div id="desc"></div>
      </div>
      <div class="col-4 ">
        <h6>강의 영상 등록</h6>
        <div class="lecture_coverImg mb-3">
          <!-- <img src="../img/core-img/Large Logo.svg" alt=""> -->
        </div>
        <input type="file" class="form-control" accept="video/*" name="add_videos[]" id="add_videos" >
        <div class="input-group mb-3">
          <span class="input-group-text" id="add_videosAddon">URL</span>
          <input type="text" class="form-control" name="add_videosUrl" id="add_videosUrl" >
        </div>
      </div>
      <div class="col-8 ">
        <div class="d-flex flex-column gap-2">
          <label for="objectives" class="bold">강의 목표</label>
          <textarea class="form-control" placeholder="강의 목표" name="objectives" id="objectives"></textarea>
        </div>
        <div class="d-flex flex-column gap-2">
          <label for="tag" class="bold">강의 태그</label>
          <textarea class="form-control" placeholder="강의 태그" name="tag" id="tag"></textarea>
        </div>
      </div>
    </div>
    <div class="mt-3 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">등록</button>
    </div>
  </Form>
</div>
<script>
 $('#desc').summernote({
    placeholder: 'Hello Bootstrap 4',
    tabsize: 2,
    height: 500
  });
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/footer.php');
?>
<?php
$title = '쿠폰 수정';
// $coupon_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/coupon.css\" rel=\"stylesheet\" >";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.php');
?>

<!-- 임시로 넣은 css 링크(집에서 가져온거랑 달리 연결이 안됨) -->
<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/admin/css/coupon.css">
</head>

<div class="container">
  <form action="coupon_edit_ok.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="cid" value="<?= $cid; ?>"> 
  <div class="row coupon">
    <div class="col-4 mb-5">
      <h6>쿠폰 이미지 등록</h6>
      <div class="coupon_cpImg mb-3">
        <img src="" id="couponImg" alt="">
      </div>
      <div class="input-group">
        <input type="file" class="form-control" accept="image/*" name="coupon_image" id="coupon_image">
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
              <th scope="row" class="insert_name">쿠폰 이름</th>
              <td colspan="3">
                <input type=" text" class="form-control" name="coupon_name" id="coupon_name" value="<?= $data->coupon_name; ?>">"required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">쿠폰 설명</th>
              <td colspan="3">
              <textarea class="form-control" name="coupon_content" id="coupon_content" rows="2"></textarea>
            </tr>
            <tr>
              <th scope="row">할인구분</th>
              <td>
                <select class="form-select" name="coupon_type" id="coupon_type" aria-label="할인구분">                            
                  <option value="1" selected>정액</option>
                  <option value="2">정률</option>
                </select>
              </td>
              <td>
                <input type="text" class="form-control" name="dis_tuition" id="dis_tuition" placeholder="최소 금액">
              </td>
              <td>
                <input type="text" class="form-control" name="dis_tuition" id="dis_tuition" placeholder="최대 금액">
              </td>
            </tr>
            <tr>
              <th scope="row">사용기한</th>
              <td>
                <select class="form-select" name="coupon_type" id="coupon_type" aria-label="사용기한">                            
                  <option value="1" selected>무제한</option>
                  <option value="2">제한</option>
                </select>
              </td>
              <td>
                <input type="date" class="form-control" name="startdate" id="startdate" placeholder="" required>
              </td>
              <td>
               <input type="date" class="form-control" name="enddate" id="enddate" placeholder="" required>
              </td>
            </tr>
            <tr scope="row">
              <th scope="row" class="insert_name">활성화</th>
              <td colspan="3">
                <div class="d-flex gap-3">
                  <div class="d-flex align-items-center justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="ispremium" value="1" id="ispremium">
                    <label class="form-check-label" for="ispremium">활성화</label>
                  </div>
                  <div class="d-flex align-items-center justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="ispopular" value="1" id="ispopular">
                    <label class="form-check-label" for="ispopular">비활성화</label>
                  </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="gap-3 mt-50 d-flex justify-content-end">
      <button type="submit" class="btn btn-primary">등록</button>
      <button a href="coupon_list.php" class="btn btn-danger">취소</button>
    </div>
  </form>
</div>
  

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?> 

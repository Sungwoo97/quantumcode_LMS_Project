<?php
$title = '쿠폰 등록';
// $coupon_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/coupon.css\" rel=\"stylesheet\" >";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

// if(!isset($_SESSION['AUID'])){
//   echo "
//     <script>
//       alert('관리자로 로그인해주세요');
//       location.href = '../login.php';
//     </script>
//   ";
// }

include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');
?>

<!-- 임시로 넣은 css 링크(집에서 가져온거랑 달리 연결이 안됨) -->
<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/css/coupon.css">
</head>

<div class="coupon_regis container">
  <form action="coupon_regis_ok.php" id="coupon_submit" method="POST">
  <input type="hidden" id="coupon_description" name="coupon_description" value="">
  <input type="hidden" name="coupon_img" id="coupon_img" value="">
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
                <input type=" text" class="form-control" name="coupon_name" id="coupon_name" required>
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
          <td id="ct1">
            <div class="input-group mb-3">
              <input type="text" name="coupon_price" class="form-control" aria-label="할인가" value="0" aria-describedby="coupon_price"> 
              <span class="input-group-text" id="coupon_price">원</span>
            </div>
          </td> 
          <td id="ct2">
            <div class="input-group mb-3">
              <input type="text" name="coupon_ratio" class="form-control" aria-label="할인비율" value="0" aria-describedby="coupon_ratio">
              <span class="input-group-text" id="coupon_ratio">%</span>
            </div>
          </td>
        </tr>
        </tr> 
            <tr>
              <th scope="row">사용기한</th>
              <td>
                <select class="form-select" name="coupon_type_usage" id="coupon_type_usage" aria-label="사용기한">                            
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
                    <input class="form-check-input me-2" type="checkbox" name="coupon_activate" value="1" id="coupon_activate">
                    <label class="form-check-label" for="coupon_activate">활성화</label>
                  </div>
                  <div class="d-flex align-items-center justify-content-start">
                    <input class="form-check-input me-2" type="checkbox" name="coupon_deactivate" value="1" id="coupon_deactivate">
                    <label class="form-check-label" for="coupon_deactivate">비활성화</label>
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
      <button a href="coupon_list.php" class="btn btn-danger cancel">취소</button>
    </div>
  </form>
</div>
  
<script>
  //할인구분
  $('#ct2 input').prop('disabled', true);

  $('#coupon_type').change(function(){
    let value = $(this).val();
    $('#ct1 input, #ct2 input').prop('disabled', true);
    if(value == 1){
      $('#ct1 input').prop('disabled', false);
    } else{
      $('#ct2 input').prop('disabled', false);
    }
  });

  //사용기한
  $('#coupon_type_usage').change(function() {
    let value = $(this).val();
    if (value == 1) {
      $('#startdate, #enddate').prop('disabled', true).val('');
    } else {
      $('#startdate, #enddate').prop('disabled', false);
    }
  });

  if ($('#coupon_type_usage').val() == 1) {
    $('#startdate, #enddate').prop('disabled', true);
  }

// 활성화 체크박스 
  document.addEventListener('DOMContentLoaded', ()=>{
  const activateCheckbox = document.getElementById('coupon_activate');
  const deactivateCheckbox = document.getElementById('coupon_deactivate');

  activateCheckbox.addEventListener('change', ()=>{
    if (activateCheckbox.checked) {
      deactivateCheckbox.checked = false; 
    }
  });

  deactivateCheckbox.addEventListener('change', ()=>{
    if (deactivateCheckbox.checked) {
      activateCheckbox.checked = false;
    }
  });
});

  $('.cancel').click(function(e) {
      e.preventDefault();
      if (confirm('정말 취소할까요?')) {
          window.location.href = $(this).attr('href');
      }
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?> 

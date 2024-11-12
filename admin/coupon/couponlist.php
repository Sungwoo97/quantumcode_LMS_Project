<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');


if(!$_SESSION['AUID']){
  echo "<script>alert('권한이 없습니다.');history.back();</script>";
  exit;
}

$sql = "SELECT * FROM coupons ORDER BY cid DESC";
$result = $mysqli->query($sql);
$dataArr = [];
while ($data = $result->fetch_object()) {
  $dataArr[] = $data;
}
print_r($dataArr);

?>


<form action="search_result.php" class="coupon_serch d-flex align-items-center">
  <div class="couponlist_view d-flex">
    <img src="../img/icon-img/Rows.svg" alt="박스형 리스트">
    <img src="../img/icon-img/Layout.svg" alt="목차형 리스트">
  </div>
  <select class="form-select" name="search_cat" aria-label="할인 구분 선택">
    <option selected>할인 구분</option>
    <option value="1">정액</option>
    <option value="2">정률</option>
  </select>
  <select class="form-select" name="search_cat" aria-label="카테고리 선택">
    <option selected>활성화</option>
    <option value="1">활성화</option>
    <option value="2">비활성화</option>
  </select>
  <div class="d-flex align-items-center w-50 justify-content-end gap-3">
    <input type="text" name="keywords" class="form-control w-75">
    <button class="btn btn-primary">검색</button>
  </div>      
  </form>


  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">checkbox</th>
      <th scope="col">No</th>
      <th scope="col">쿠폰 이름</th>
      <th scope="col">할인율</th>
      <th scope="col">발급기간</th>
      <th scope="col">활성화</th>
      <th scope="col">상세보기</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(isset($dataArr)){
      foreach ($dataArr as $item){
        
    ?>
    <tr>
      <td scope="row">
      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
      </td>
      <th scope="row"><?= $item->cid ?></th>
      <td><?= $item->coupon_name ?></td>
      <!-- <td>홍길동</td>
      <td>2024.00.00</td>
      <td>
        <a href="#"><img src="../img/icon-img/ToggleLeft.svg" alt="" style="width: 24px;"></a>
      </td>
      <td>
        <a href="#"><img src="../img/icon-img/Edit.svg" alt="" style="width: 24px;"></a>
        <a href="#"><img src="../img/icon-img/Trash.svg" alt="" style="width: 24px;"></a>
      </td> -->
      <?php
      }
    }
      ?>
  </tbody>
</table>







<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?> 

<?php


include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');
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
    <tr>
      <td scope="row">
      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
      </td>
      <th scope="row">1</th>
      <td>제목1</td>
      <td>홍길동</td>
      <td>2024.00.00</td>
      <td>
        <a href="#"><img src="../img/icon-img/ToggleLeft.svg" alt="" style="width: 24px;"></a>
      </td>
      <td>
        <a href="#"><img src="../img/icon-img/Edit.svg" alt="" style="width: 24px;"></a>
        <a href="#"><img src="../img/icon-img/Trash.svg" alt="" style="width: 24px;"></a>
      </td>
    </tr>
  </tbody>
</table>

<nav aria-label="Page navigation example">
  <ul class="pagination d-flex justify-content-center">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>

<div class=" d-flex justify-content-end">
  <a class="btn btn-primary" href="#" role="button">글등록</a>
</div>






<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?> 

<?php
$title = '쿠폰 목록';
$coupon_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/admin/css/coupon.css\" rel=\"stylesheet\" >";
include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/inc/header.php');


?>

<form action="search_result.php" class="coupon_serch d-flex align-items-center justify-content-between">
  <div class="couponlist_view d-flex">
    <img src="../img/icon-img/Rows.svg" alt="박스형 리스트">
    <img src="../img/icon-img/Layout.svg" alt="목차형 리스트">
  </div>
 <div class="couponlist_search d-flex gap-3">
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
      <input type="text" name="keywords" class="form-control">
      <button type="submit" class="btn btn-primary">검색</button>
    </div>   
 </div>   
  </form>

<table class="mt-3 table table-hover text-center couponlist">
  <thead>
    <tr>
      <th scope="col"></th>
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
    $sql = "SELECT * FROM coupons ORDER BY cid DESC";
    $result = $mysqli->query($sql);
    while($data = $result->fetch_object()){
      $coupon_name = $data->coupon_name;    
    ?>
    <tr>
      <td scope="row">
      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
      </td>
      <th scope="row">
        <input type="hidden" name="cid[]" value="<?= $data->cid; ?>">
        <?= $data->cid; ?>
      </th>
      <td><?= $data->coupon_name ?></td>
      <td><?= $data->coupon_price ? number_format($data->coupon_price).'원' : ($data->coupon_ratio ? $data->coupon_ratio."%" : "할인 없음") ?></td>
      <td><?= $data->	startdate.'~'.$data->	enddate; ?> </td>
      <td>
      <div class="form-check form-switch d-flex justify-content-center">
        <input class="form-check-input" type="checkbox" role="switch" id="coupon_switchToggle" data-id="<?= $data->cid ?>" <?= $data->status ? 'checked' : '' ?>>
        <label class="form-check-label" for="coupon_switchToggle"></label>
      </div>
      </td>
      <td class="icon_hover d-flex gap-1 justify-content-center">
        <a href="coupon_view.php?pid=<?= $data->cid; ?>"><img src="../img/icon-img/Edit.svg" alt="" style="width: 20px;"></a>
        <a href="coupon_del.php?pid=<?= $data->cid; ?>"><img src="../img/icon-img/Trash.svg" alt="" style="width: 20px;"></a>
      </td>
      <?php
      }
      ?>
  </tbody>
</table>

    <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <li class="page-item disabled">
          <span class="page-link">Previous</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active" aria-current="page">
          <span class="page-link">2</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
  
  <div class="d-flex gap-3 justify-content-end">
    <button a href="product_up.php" class="btn btn-secondary">복사</button>
    <button a href="coupon_regis.php" class="btn btn-primary">생성</button>
    <button a href="coupon_del.php" class="btn btn-danger">삭제</button>
  </div>

  <script>
  $('.delete').click(function(e) {
      e.preventDefault();
      if (confirm('정말 삭제할까요?')) {
          window.location.href = $(this).attr('href');
      }
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?> 

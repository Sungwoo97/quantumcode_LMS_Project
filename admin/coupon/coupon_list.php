<?php
$title = '쿠폰 목록';
// $coupon_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/coupon.css\" rel=\"stylesheet\" >";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;

$search_where = '';

$search_keyword = $_GET['search_keyword'] ?? '';

if($search_keyword){ 
  $search_where .= " and (coupon_name LIKE '%$search_keyword%')";
}

// 전체 데이터 개수 조회
$page_sql = "SELECT COUNT(*) AS count FROM coupons";
$page_result = $mysqli->query($page_sql);
$page_data = $page_result->fetch_assoc();
$row_num = $page_data['count'];

//페이지네이션
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 목록 개수와 시작 번호 설정
$list = 10;
$start_num = $page*$list;
$block_ct = 5;
$block_num = ceil($page/$block_ct);

$block_start = (($block_num-1)*$block_ct) + 1;
$block_end = $block_start + $block_ct - 1;

$total_page = ceil($row_num/$list);
$total_block = ceil($total_page/$block_ct);

if($block_end > $total_page ) $block_end = $total_page;

?>


<!-- 임시로 넣은 css 링크(집에서 가져온거랑 달리 연결이 안됨) -->
<head>
  <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/qc/admin/css/coupon.css">
</head>

<form action="" class="coupon_serch d-flex align-items-center justify-content-between" id="search_form">
  <div class="couponlist_view d-flex">
    <button class="Rows"><img src="../img/icon-img/Rows.svg" alt="박스형 리스트"></button>
    <button class="Layout"><img src="../img/icon-img/Layout.svg" alt="목차형 리스트"></button>
  </div>
 <div class="couponlist_search d-flex gap-3">
    <select class="form-select" name="search_cat" aria-label="할인 구분 선택">
      <option selected>할인 구분</option>
      <option value="1">정액</option>
      <option value="2">정률</option>
    </select>
    <select class="form-select" name="search_cat" aria-label="카테고리 선택">
      <option selected>활성화 구분</option>
      <option value="1" >활성화</option>
      <option value="2">비활성화</option>
    </select>
    <div class="d-flex align-items-center w-50 justify-content-end gap-3">
      <input type="text" class="form-control" name="search_keyword" id="search">
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
    $sql = "SELECT * FROM coupons ORDER BY cid DESC LIMIT $start_num, $list";
    $result = $mysqli->query($sql);
    while($data = $result->fetch_object()){ 
    ?>
    <tr>
      <td scope="row">
      <input class="form-check-input listcheck" type="checkbox" value="" id="cid<?= $data->cid; ?>">
      </td>
      <th scope="row">
        <input type="hidden" name="cid[]" value="<?= $data->cid; ?>">
        <?= $data->cid; ?>
      </th>
      <td>
        <a href="coupon_view.php?pid=<?= $data->cid; ?>"><?= $data->coupon_name ?></a>
      </td>
      <td><?= $data->coupon_price ? number_format($data->coupon_price).'원' : ($data->coupon_ratio ? $data->coupon_ratio."%" : "할인 없음") ?></td>
      <td><?= $data->	startdate.'~'.$data->	enddate; ?> </td>
      <td>
      <div class="form-check form-switch d-flex justify-content-center">
        <input class="form-check-input" type="checkbox" role="switch" id="coupon_switchToggle" data-id="<?= $data->cid ?>" <?= $data->status ? 'checked' : '' ?>>
        <label class="form-check-label" for="coupon_switchToggle"></label>
      </div>
      </td>
      <td class="icon_hover d-flex gap-1 justify-content-center">
        <a href="coupon_.php?pid=<?= $data->cid; ?>"><img src="../img/icon-img/Edit.svg" alt="" style="width: 20px;"></a>
        <a href="coupon_del.php?pid=<?= $data->cid; ?>"><img src="../img/icon-img/Trash.svg" alt="" style="width: 20px;"></a>
      </td>
      <?php
      }
      ?>
  </tbody>
</table>

<nav aria-label="Page navigation">
    <ul class="pagination d-flex justify-content-center">
    <?php
      if($block_num > 1){
        $prev = $block_start - $block_ct;
        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"coupon_list.php?search_keyword={$search_keyword}&page={$prev}\">Previous</a></li>";
      }
    ?>
    
    <?php
      for($i=$block_start; $i<=$block_end; $i++){                
        // if($page == $i) {$active = 'active';} else {$active = '';}
        $page == $i ? $active = 'active': $active = '';
    ?>
    <li class="page-item <?= $active; ?>"><a class="page-link" href="coupon_list.php?search_keyword=<?= $search_keyword;?>&page=<?= $i;?>"><?= $i;?></a></li>
    <?php
      }
      $next = $block_end + 1;
      if($total_block >  $block_num){
    ?>
    <li class="page-item"><a class="page-link" href="coupon_list.php?search_keyword=<?= $search_keyword;?>&page=<?= $next;?>">Next</a></li>
    <?php
    }         
    ?>
  </ul>
</nav>

  <div class="d-flex gap-3 justify-content-end">
    <button class="btn btn-secondary"><a href="coupon_copy.php">복사</a></button>
    <button class="btn btn-primary"><a href="coupon_regis.php">생성</a></button>
    <button class="btn btn-danger"><a href="coupon_del.php">삭제</a></button>
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
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?> 

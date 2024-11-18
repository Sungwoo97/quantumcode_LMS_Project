<?php
$title = "강사 목록";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');


// if(!isset($_SESSION['AUID'])){
//   echo "
//     <script>
//       alert('관리자로 로그인해주세요');
//       location.href = '../login.php';
//     </script>
//   ";
// }

//검색
$search_where = ''; //초기화
$search_keyword = $_GET['search_keyword'] ?? '';

if($search_keyword){ 
  // $search_where .= " and (name LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%')";
  $search_where .= " and (name LIKE '%$search_keyword%')";
}

//데이터의 개수 조회
$page_sql = "SELECT COUNT(*) AS cnt FROM teachers WHERE 1=1 $search_where";
$page_result = $mysqli->query($page_sql);
$page_data = $page_result->fetch_assoc();
$row_num = $page_data['cnt'];


//페이지네이션 
if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
}

$list = 10;
$start_num=($page-1)*$list;
$block_ct = 5;
$block_num = ceil($page/$block_ct); //$page1/5 0.2 = 1

$block_start = (($block_num-1)*$block_ct) + 1;
$block_end = $block_start + $block_ct - 1;

$total_page = ceil($row_num/$list); //총75개 10개씩, 8
$total_block = ceil($total_page/$block_ct);

if($block_end > $total_page ) $block_end = $total_page;

//목적에 맞게 목록 가져오기
$sql = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY tid ASC LIMIT $start_num, $list"; //teachers 테이블에서 모든 데이터를 조회
$sql_lowPriceToHigh = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY sales DESC"; //테이블에서 모든 데이터를 조회
$sql_highPriceToLow = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY sales ASC"; //테이블에서 모든 데이터를 조회
$sql_lowLectureToHigh = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY sales DESC"; //테이블에서 모든 데이터를 조회
$sql_highLectureToLow = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY sales ASC"; //테이블에서 모든 데이터를 조회

$result = $mysqli->query($sql); //쿼리 실행 결과
while($data = $result->fetch_object()){
  $dataArr[] = $data;
}

?>

<div class="container">
  <form action="">
    <h3>현재 강사 수 : <?= $row_num; ?> 명</h3>
    <div class="d-flex gap-3 w-30 mt-3 align-items-center">
    <tr>
        <td colspan="3">
          <div class="d-flex gap-3">
            <select class="form-select mt-3" name="sort_order" >
              <option value="" selected>정렬 기준을 선택해 주세요</option>
              <option value="highPriceToLow">등록 순</option>
              <option value="highPriceToLow">매출 많은 순</option>
              <option value="lowPriceToHigh">매출 적은 순</option>
              <option value="highLectureToLow">강의 많은 순</option>
              <option value="lowLectureToHigh">강의 적은 순</option>
            </select>
          </div>
        </td>
      </tr>
      <input type="text" class="form-control w-25 ms-auto" name="search_keyword" id="search">
      <button class="btn btn-primary btn-sm w-20">검색</button>
    </div>     
    


    <hr> 
    <!-- <form action="plist_update.php" method="GET"> -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No. </th>
          <th scope="col">이름</th>
          <th scope="col">아이디</th>
          <th scope="col">이메일</th>
          <th scope="col">가입날짜</th>
          <th scope="col">강의 갯수</th>
          <th scope="col">올해 매출</th>
          <th scope="col">강사 등급</th>
          <th scope="col">상세보기, 수정 삭제</th>
        </tr>
      </thead>
      <tbody>
          <?php
            if(isset($dataArr)){
              foreach($dataArr as $item){
          ?> 
          <tr>
            <th scope="row"><?= $item->tid; ?></th>
              <td><?= $item->name; ?></td>
              <td><?= $item->id; ?></td>
              <td><?= $item->email; ?></td>
              <td><?= $item->reg_date; ?></td>
              <td><?= $item->lecture_num; ?></td>
              <td><?= $item->sales; ?></td>
              <td><?= $item->grade; ?></td>
              <td><a href="teacher_view.php?tid=<?= $item->tid;?>" class="btn btn-primary btn-sm">상세보기</a></td>
          </tr>

          <?php
              }
            }
          ?> 
      </tbody>
    </table>
  </form>
  <nav aria-label="Page navigation">
      <ul class="pagination d-flex justify-content-center">
        <?php
          if($block_num > 1){
            $prev = $block_start - $block_ct;
            echo "<li class=\"page-item\"><a class=\"page-link\" href=\"teacher_list.php?&search_keyword={$search_keyword}&page={$prev}\">Previous</a></li>";
          }
        ?>
        
        <?php
          for($i=$block_start; $i<=$block_end; $i++){                
            $page == $i ? $active = 'active': $active = '';
        ?>
        <li class="page-item <?= $active; ?>"><a class="page-link" href="teacher_list.php?&search_keyword=<?= $search_keyword;?>&page=<?= $i;?>"><?= $i;?></a></li>
        <?php
          }
          $next = $block_end + 1;
          if($total_block >  $block_num){
        ?>
        <li class="page-item"><a class="page-link" href="teacher_list.php?&search_keyword=<?= $search_keyword;?>&page=<?= $next;?>">Next</a></li>
        <?php
        }         
        ?>
      </ul>
    </nav>
</div>

<script>
  

  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
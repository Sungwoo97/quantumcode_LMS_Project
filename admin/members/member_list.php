<?php
$title = "회원 목록";
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
$page_sql = "SELECT COUNT(*) AS cnt FROM members WHERE 1=1 $search_where";
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
$sql = "SELECT * FROM members WHERE 1=1 $search_where ORDER BY mid ASC LIMIT $start_num, $list"; //teachers 테이블에서 모든 데이터를 조회

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
              <option value="">등록일 빠른 순</option>
              <option value="">등록일 늦은 순</option>
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
          <th scope="col">회원 등급</th>
          <th scope="col">상세보기</th>
          <th scope="col">수정하기</th>
          <th scope="col">쪽지보내기</th>

        </tr>
      </thead>
      <tbody>
          <?php
            if(isset($dataArr)){
              foreach($dataArr as $item){
          ?> 
          <tr>
            <th scope="row"><?= $item->mid; ?></th>
              <td><?= $item->name; ?></td>
              <td><?= $item->id; ?></td>
              <td><?= $item->email; ?></td>
              <td><?= $item->reg_date; ?></td>
              <td><?= $item->grade; ?></td>
              <td><a href="member_view.php?mid=<?= $item->mid;?>" class="btn btn-primary btn-sm">상세보기</a></td>
              <td><a href="member_view.php?mid=<?= $item->mid;?>" class="btn btn-secondary btn-sm">수정하기</a></td>
              <td>
                <button class="btn btn-light btn-sm" id="send-message-btn" data-mid="<?= $item->mid; ?>">쪽지보내기</button>
              </td>
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
          echo "<li class=\"page-item\"><a class=\"page-link\" href=\"member_list.php?&search_keyword={$search_keyword}&page={$prev}\">Previous</a></li>";
        }
      ?>
      
      <?php
        for($i=$block_start; $i<=$block_end; $i++){                
          $page == $i ? $active = 'active': $active = '';
      ?>
      <li class="page-item <?= $active; ?>"><a class="page-link" href="member_list.php?&search_keyword=<?= $search_keyword;?>&page=<?= $i;?>"><?= $i;?></a></li>
      <?php
        }
        $next = $block_end + 1;
        if($total_block >  $block_num){
      ?>
      <li class="page-item"><a class="page-link" href="member_list.php?&search_keyword=<?= $search_keyword;?>&page=<?= $next;?>">Next</a></li>
      <?php
      }         
      ?>
    </ul>
  </nav>
</div>
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">쪽지 보내기</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="messageForm">
          <input type="hidden" id="sender_idx" value="4"> <!-- 관리자 idx -->
          <input type="hidden" id="receiver_mid">
          <div class="mb-3">
            <label for="message" class="form-label">메시지 내용</label>
            <textarea id="message" class="form-control" placeholder="쪽지 내용을 입력하세요" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">보내기</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
  // 쪽지보내기 버튼 클릭 이벤트
  document.querySelectorAll("#send-message-btn").forEach(button => {
    button.addEventListener("click", function () {
      const receiverMid = this.getAttribute("data-mid"); // 버튼의 data-mid 값을 가져옴
      document.getElementById("receiver_mid").value = receiverMid; // 모달 hidden input에 설정

      // Bootstrap 모달 초기화 및 표시
      const messageModal = new bootstrap.Modal(document.getElementById("messageModal"));
      messageModal.show();
    });
  });
});

  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
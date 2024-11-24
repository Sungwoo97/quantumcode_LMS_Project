<?php
$title = "쪽지 관리";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/teachers/inc/header.php');

//검색
$search_where = ''; //초기화
$search_keyword = $_GET['search_keyword'] ?? '';

if($search_keyword){ 
  $search_where .= " and (name LIKE '%$search_keyword%')";
}

//데이터의 개수 조회
$page_sql = "SELECT COUNT(*) AS cnt FROM toteachermessages WHERE 1=1 $search_where";
$page_result = $mysqli->query($page_sql);
$page_data = $page_result->fetch_assoc();

//print_r($page_data); Array ( [cnt] => 22 )

$row_num = $page_data['cnt'];  //echo $row_num; 22


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





$message_sql = "SELECT * FROM toteachermessages";
$message_result = $mysqli->query($message_sql);
$dataArr = []; // 배열 초기화
while($m_data = $message_result->fetch_object()){
  $dataArr[] = $m_data;
}


// print_r($message_data); //stdClass Object ( [id] => 3 [sender_id] => 4 [receiver_id] => 2 [message_content] => to 우진쌤 [sent_at] => 2024-11-24 04:30:01 [is_read] => 0 )


?>

<div class="container">
  <form action="">
    <h5>현재 쪽지 수 : <?= $row_num; ?> 개</h5>
    <!-- <div class="d-flex gap-3 w-30 mt-3 align-items-center">
      <tr>
        <td colspan="3">
          <div class="d-flex gap-3">
            <select class="form-select mt-3" id="sort_order" >
              <option value="base" selected>정렬 기준을 선택해 주세요</option>
              <option value="desc">매출 많은 순</option>
              <option value="asc">매출 적은 순</option>
              <option value="highLectureToLow">강의 많은 순</option>
              <option value="lowLectureToHigh">강의 적은 순</option>
            </select>
          </div>
        </td>
      </tr>
      <input type="text" class="form-control w-25 ms-auto" name="search_keyword" id="search">
      <button class="btn btn-primary btn-sm w-20">검색</button>
    </div>      -->
    <hr> 
    
    <!-- <form action="plist_update.php" method="GET"> -->
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">작성자 아이디</th>
          <th scope="col">작성자 이름</th>
          <th scope="col">쪽지 내용</th>
          <th scope="col">보낸 시각</th>
          <th scope="col">읽음 여부</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($dataArr)): ?>
          <?php foreach ($dataArr as $item): ?>
            <tr>
              <th scope="row"><?= $item->id; ?></th>
              <td><?= $item->sender_id; ?></td>
              <td><?= $item->sender_name; ?></td>
              <td>
                <a href="#" 
                   class="text-primary message-link" 
                   data-bs-toggle="modal" 
                   data-bs-target="#messageModal" 
                   data-message="<?= htmlspecialchars($item->message_content, ENT_QUOTES, 'UTF-8'); ?>"
                   data-id="<?= $item->id; ?>">
                  <?= mb_strimwidth($item->message_content, 0, 20, "...", "UTF-8"); ?>
                </a>
              </td>
              <td><?= $item->sent_at; ?></td>
              <td>
                <?= $item->is_read ? "읽음" : "읽지 않음"; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center">표시할 메시지가 없습니다.</td>
          </tr>
        <?php endif; ?>
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

<!-- 모달 창 -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">쪽지 내용</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- 메시지가 동적으로 삽입됩니다 -->
        <p id="modalMessageContent"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // 모든 메시지 링크에 이벤트 리스너 추가
    const messageLinks = document.querySelectorAll('[data-bs-target="#messageModal"]');
    const modalMessageContent = document.getElementById('modalMessageContent');

    messageLinks.forEach(link => {
        link.addEventListener('click', function () {
            // data-message 속성에서 메시지 내용 가져오기
            const messageContent = this.getAttribute('data-message');
            // 모달의 콘텐츠 영역에 메시지 표시
            modalMessageContent.textContent = messageContent;
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const messageLinks = document.querySelectorAll('.message-link');
    const modalMessageContent = document.getElementById('modalMessageContent');

    messageLinks.forEach(link => {
        link.addEventListener('click', function () {
            const messageContent = this.getAttribute('data-message');
            const messageId = this.getAttribute('data-id');

            // 메시지 내용을 모달에 표시
            modalMessageContent.textContent = messageContent;

            // AJAX 요청으로 is_read를 업데이트
            fetch('update_is_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: messageId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('is_read 업데이트 성공:', data);
                } else {
                    console.error('is_read 업데이트 실패:', data.message);
                }
            })
            .catch(error => console.error('에러 발생:', error));
        });
    });
});
</script>



<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/teachers/inc/footer.php');
?>


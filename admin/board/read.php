<?php
$title ='글 상세보기';
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');

//관리자가 아닐시 로그인창으로 보내기
// if(!isset($_SESSION['AUID'])){
//   echo "
//     <script>
//       alert('관리자로 로그인해주세요');
//       location.href = '../login.php';
//     </script>
//   ";
// }


$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$pid = isset($_GET['pid']) ? $_GET['pid'] : null; 


// 추천 쿼리
if(!isset($_SESSION['hits'])){
  $_SESSION['hits'] =[];
}

if(!isset($_SESSION['hits'][$pid])){
  $hit_sql = "UPDATE board SET hit = hit+1 WHERE pid=$pid";
  $hit_result = $mysqli->query($hit_sql);

  $_SESSION['hits'][$pid] = true;
};





 
if ($category === 'all') {
  $sql = "SELECT title, likes, hit, content, user_id, category, img, is_img, date, start_date, end_date FROM board WHERE pid = $pid";
} else {
  // 카테고리가 'all'이 아닌 경우, 카테고리 조건을 추가하여 쿼리 실행
  $sql = "SELECT title, likes, hit, content, user_id, category, img, is_img, date, start_date, end_date FROM board WHERE pid = $pid AND category = '$category'";
}
$result = $mysqli->query($sql);
$data = $result->fetch_object();

//이벤트 카테고리 날짜 값 변경문
$post_date = date("Y-m-d", strtotime($data->date));
$start_date = date("Y-m-d", strtotime($data->start_date));
$end_date = date("Y-m-d", strtotime($data->end_date));

switch ($category) {
  case 'all':
      $redirect_url = '/qc/admin/board/board_list.php?category=all'; 
      break;
  case 'qna':
      $redirect_url = '/qc/admin/board/board_list.php?category=qna'; 
      break;
  case 'notice':
      $redirect_url = '/qc/admin/board/board_list.php?category=notice'; 
      break;
  case 'event':
      $redirect_url = '/qc/admin/board/board_list.php?category=event'; 
      break;
  case 'free':
      $redirect_url = '/qc/admin/board/board_list.php?category=free'; 
      break;
  default:
      die("유효하지 않은 카테고리입니다.");
}



?>





<div class="d-flex justify-content-between">
  <h2>제목:<?=$data->title?></h2>
  <span> <?= $data->category === 'event' ? '시작일: ' . ($data->start_date ? $start_date : '').'~' . ' 종료일: ' . ($data->end_date ? $end_date : '') : '' ?> 글쓴이:<?=$data->user_id?> <span id="like-count">추천수:<?=$data->likes ? $data->likes : 0?></span> 조회수:<?=$data->hit ? $data->hit : 0?> 등록일자:<?=$post_date?></span>
</div>


<div class="mb-3">
내용:<?=$data->content?>
</div>
<div>
  <?php
  // 이미지가 있을시 출력
    if($data->is_img == 1){
      echo "<img src=\"{$data->img}\" width=\"300\" class=\"mb-3\">";
    }
  ?>
</div>
<div class="d-flex justify-content-end">
  <p class="d-flex gap-3">
    <a href="<?=$redirect_url?>" class="btn btn-secondary">목록</a>
    <a href="like_up.php?pid=<?=$pid?>&category=<?=$category?>" class="btn btn-info">추천</a>
    <a href="board_modify.php?pid=<?=$pid?>&category=<?=$category?>" class="btn btn-primary">수정</a>
    <a href="delete.php?pid=<?=$pid?>&category=<?=$category?>" class="btn btn-danger">삭제</a>
  </p>
</div>

<hr style="color:#0D6EFD;">
<!-- 댓글 -->
<form action="board_reply_ok.php" method="POST">
  <input type="hidden" name="pid" value="<?=$pid?>">
  <input type="hidden" name="category" value="<?=$data->category?>">
  <div class="d-flex gap-3 mb-3 align-items-center">
    <p>댓글 입력:</p> 
    <textarea name="content" class="form-control w-25" placeholder="댓글내용을 입력 해주세요."></textarea>
    <button class="btn btn-primary btn-sm ">등록</button>
  </div>
</form>

<div class="" style="width: 18rem;">
  <ul class="list-group list-group-flush">
    <?php
    // 댓글 쿼리
      $sql = "SELECT * FROM board_reply WHERE b_pid = $pid ORDER BY date DESC";
      $reply_result = $mysqli->query($sql);

      while($data = $reply_result -> fetch_object()){
        ?>
        <!-- 댓글 출력 부분 -->
      <li class="list-group-item mb-3" style="border: 1px solid blue; border-radius:15px">
        <div class="contents">
          <div class="d-flex justify-content-between">
            <small><?=$data->user_id?></small> 
            <small><?=$data->date?></small>
          </div>
          <hr>
          <div class="content">
          <?=$data->content?>
          </div>
          <div class="controls d-flex justify-content-end gap-1">
            <button class="btn btn-primary sm" data-bs-toggle="modal" data-bs-target="#reply_edit<?=$data->pid?>">수정</button>
            <a href="reply_delete.php?pid=<?=$data->pid?>&b_pid=<?=$data->b_pid?>&category=<?=$category?>" class="btn btn-danger sm">삭제</a>
          </div>
        </div>
        <!-- //댓글 출력 부분 -->
        <!-- modal -->
        <div class="modal fade" id="reply_edit<?=$data->pid?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form action="board_reply_modify_ok.php" method="POST" class="modal-content">
              <input type="hidden" name="pid" value="<?=$data->pid?>">
              <input type="hidden" name="b_pid" value="<?=$pid?>">
              <input type="hidden" name="category" value="<?=$category?>">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">댓글 수정</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <?=$data->user_id?>
                <hr>
                <textarea name="content" class="form-control mt-3"> <?=$data->content?></textarea>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">확인</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">취소</button>
              </div>
            </form>
          </div>
        </div>
      </li>
      <?php
      }
    ?>

  </ul>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?>
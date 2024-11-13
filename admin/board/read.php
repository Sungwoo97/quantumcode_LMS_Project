<?php
$title ='글 상세보기';
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');

$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$pid = $_GET['pid']; 
 
if ($category === 'all') {
  $sql = "SELECT title, name, likes, hit, content, date FROM board WHERE pid = $pid";
} else {
  // 카테고리가 'all'이 아닌 경우, 카테고리 조건을 추가하여 쿼리 실행
  $sql = "SELECT title, name, likes, hit, content, date FROM board WHERE pid = $pid AND category = '$category'";
}
$result = $mysqli->query($sql);
$data = $result->fetch_object();

switch ($category) {
  case 'all':
      $redirect_url = '/admin/board/board_list.php?category=all'; 
      break;
  case 'qna':
      $redirect_url = '/admin/board/board_list.php?category=qna'; 
      break;
  case 'notice':
      $redirect_url = '/admin/board/board_list.php?category=notice'; 
      break;
  case 'event':
      $redirect_url = '/admin/board/board_list.php?category=event'; 
      break;
  case 'free':
      $redirect_url = '/admin/board/board_list.php?category=free'; 
      break;
  default:
      die("유효하지 않은 카테고리입니다.");
}



?>





<div class="d-flex justify-content-between">
  <h2>제목:<?=$data->title?></h2>
  <span>글쓴이:<?=$data->name?> <span id="like-count">추천수:<?=$data->likes ? $data->likes : 0?></span> 조회수:<?=$data->hit ? $data->hit : 0?> 등록일자:<?=$data->date?></span>
</div>


<div>
내용:<?=$data->content?>
</div>

<div class="d-flex justify-content-end">
  <p>
    <a href="<?=$redirect_url?>" class="btn btn-secondary">목록</a>
    <button id="likeCount" class="btn btn-info">추천</button>
    <a href="board_modify.php?pid=<?=$pid?>&category=<?=$category?>" class="btn btn-primary">수정</a>
    <a href="delete.php?pid=<?=$pid?>&category=<?=$category?>" class="btn btn-danger">삭제</a>
  </p>
</div>


<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');

$category = $_GET['category'];
$idx = $_GET['idx']; 

// 카테고리에 맞는 테이블과 컬럼 설정
$table = '';
$pid_column = '';  // 각 카테고리에 맞는 ID 컬럼명 추가
$title_column = ''; // 제목 컬럼
$user_id_column = '';  // 글쓴이 컬럼
$like_column = '';  // 추천수 컬럼
$hit_column = '';  // 조회수 컬럼
$date_column = '';  // 등록일자 컬럼
$content_column = '';  // 컨텐츠 컬럼
switch ($category) {
    case 'qna':
        $table = 'board_qna';
        $pid_column = 'qb_pid';
        $title_column = 'qb_title';
        $user_id_column = 'qb_user_id';
        $like_column = 'qb_like';
        $hit_column = 'qb_hit'; 
        $date_column = 'qb_date'; 
        $content_column = 'qb_content';
        $redirect_url = '/admin/board/qna_list.php'; 
        break;
    case 'notice':
        $table = 'board_notice';
        $pid_column = 'nb_pid';
        $title_column = 'nb_title'; 
        $user_id_column = 'nb_user_id'; 
        $like_column = 'nb_like'; 
        $hit_column = 'nb_hit'; 
        $date_column = 'nb_date'; 
        $content_column = 'nb_content';
        $redirect_url = '/admin/board/notice_list.php';
        break;
    case 'event':
        $table = 'board_event';
        $pid_column = 'eb_pid';
        $title_column = 'eb_title'; 
        $user_id_column = 'eb_user_id';  
        $like_column = 'eb_like'; 
        $hit_column = 'eb_hit'; 
        $date_column = 'eb_date';  
        $content_column = 'eb_content';
        $redirect_url = '/admin/board/event_list.php';
        break;
    case 'free':
        $table = 'board_free';
        $pid_column = 'fb_pid';
        $title_column = 'fb_title'; 
        $user_id_column = 'fb_user_id'; 
        $like_column = 'fb_like';  
        $hit_column = 'fb_hit'; 
        $date_column = 'fb_date';  
        $content_column = 'fb_content';
        $redirect_url = '/admin/board/free_list.php';
        break;
    default:
        die("유효하지 않은 카테고리입니다.");
}

$sql = "SELECT $title_column,$user_id_column,$like_column,$hit_column,$date_column,$content_column FROM $table WHERE $pid_column = $idx";
$result = $mysqli->query($sql);
$data = $result->fetch_object();

$title = $data->{$title_column};
$user_id = $data->{$user_id_column};
$like = $data->{$like_column};
$hit = $data->{$hit_column}+1;
$content = $data->{$content_column};
$date = $data->{$date_column};

$hitSql = "UPDATE $table SET $hit_column=$hit WHERE $pid_column = $idx";
$mysqli->query($hitSql);
?>

<h1>게시물 상세보기</h1>
<div class="d-flex justify-content-between">
  <h2>제목:<?=$title?></h2>
  <span>글쓴이:<?=$user_id?> 추천수:<?=$like?> 조회수:<?=$hit?> 등록일자:<?=$date?></span>
</div>


<div>
내용:<?=$content?>
</div>

<div class="d-flex justify-content-end">
  <p>
    <a href="<?=$redirect_url?>" class="btn btn-secondary">목록</a>
    <a href="free_list.php" class="btn btn-info">추천</a>
    <a href="board_modify.php?idx=<?=$idx?>&category=<?=$category?>" class="btn btn-primary">수정</a>
    <a href="delete.php?idx=<?=$idx?>&category=<?=$category?>" class="btn btn-danger">삭제</a>
  </p>
</div>
<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
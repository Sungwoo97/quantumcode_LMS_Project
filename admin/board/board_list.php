<?php
$title = '전체 게시판';
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/header.php');

$category = isset($_GET['category']) ? $_GET['category'] : 'all';


if($category == 'all') {
  $sql = "SELECT * FROM board ORDER BY pid DESC LIMIT 10";
} else {
  $sql = "SELECT * FROM board WHERE category = '$category' ORDER BY pid DESC LIMIT 10";
}

$result = $mysqli->query($sql);




?>
<div class="container">
    <select id="categorySelect" name="category">
      <option value="all">전체 게시판</option>
      <option value="notice" <?= $category == 'notice' ? 'selected' : '' ?>>공지사항</option>
      <option value="free" <?= $category == 'free' ? 'selected' : '' ?>>자유게시판</option>
      <option value="event" <?= $category == 'event' ? 'selected' : '' ?>>이벤트</option>
      <option value="qna" <?= $category == 'qna' ? 'selected' : '' ?>>질문과답변</option>
    </select>

  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">제목</th>
        <th scope="col">글쓴이</th>
        <th scope="col">내용</th>
        <th scope="col">등록일</th>
        <th scope="col">추천수</th>
        <th scope="col">조회수</th>
        <th scope="col">Edit</th>
      </tr>
    </thead>
    <tbody id="board_list">
      <?php
      // 게시글 출력
      while($data = $result->fetch_object()){
        $title1 = $data->title;
        // 제목이 길 경우 10글자로 자르기
        if(iconv_strlen($title1) > 10){
          $title1 = iconv_substr($title, 0, 10) . '...';
        }
        ?>
      <tr>
        <th scope="row"><?= $data->pid ?></th>
        <td><a href="read.php?pid=<?=$data->pid?>&category=<?=$category?>"><?=$title1 ?></a></td>
        <td><?=$data->user_id ?></td>
        <td><?=$data->content ?></td>
        <td><?=$data->date ?></td>
        <td><?=$data->likes ? $data->likes : 0 ?></td>
        <td><?=$data->hit ? $data->hit : 0 ?></td>
        <td><a href=""><i class="fa-regular fa-pen-to-square"></i></a></td>
      </tr>
      <?php
      }
      ?>
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
    <a class="btn btn-primary" href="board_write.php" role="button">글등록</a>
    <a class="btn btn-danger" href="#" role="button">글삭제</a>
  </div>
</div>

<!-- <script>
  // 카테고리 선택 시
  const cate = document.querySelector('#categorySelect');
  cate.addEventListener('change', function(e) {
    e.preventDefault();
    const category = this.value;

    // AJAX 요청으로 데이터만 갱신
    $.ajax({
      url: 'board_list.php',  // 요청할 PHP 파일
      type: 'GET',
      data: { category: category },  // 보낼 데이터 (카테고리 값)
      success: function(data) {
        $('#board_list').html($(data).find('#board_list').html());
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
      }
    });
  });
</script> -->

<script>
  // 카테고리 선택 시
  const cate = document.querySelector('#categorySelect');
  cate.addEventListener('change', function() {
    const category = this.value;
  location.href=`?category=${category}`;
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/qc/admin/inc/footer.php');
?>
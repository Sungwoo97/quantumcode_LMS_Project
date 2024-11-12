<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');
?>

<div class="container">
  <h2>전체 게시판</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">제목</th>
        <th scope="col">내용</th>
        <th scope="col">작성일</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // 데이터베이스에서 게시글 목록 조회
      $sql = "SELECT * FROM board ORDER BY pid DESC";
      $result = mysqli_query($sql);

      // 게시글 출력
      while($data = $result->fetch_object()){
        $title = $data->title;
        
        // 제목이 길 경우 10글자로 자르기
        if(iconv_strlen($title) > 10){
          $title = iconv_substr($title, 0, 10) . '...';
        }
      ?>
      <tr>
        <th scope="row"><?=$data->pid ?></th>
        <td><?=$title ?></td>
        <td><?=$data->content ?></td>
        <td><?=$data->date ?></td>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
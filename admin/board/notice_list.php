<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');
?>

<h1>공지사항</h1>
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
  <tbody>
    <?php
    $sql = "SELECT * FROM board_notice ORDER BY nb_pid DESC LIMIT 10";

    $result = $mysqli->query($sql);
    
    $list = '';
    while($data = $result -> fetch_object()){
      $nb_title = $data->nb_title;

      if(iconv_strlen($nb_title)>10){
        $nb_title = iconv_substr($nb_title, 0, 10) . '...';
      }
   ?>
      <tr>
        <th scope="row"><?=$data->nb_pid ?></th>
        <td><a href="read.php?idx=<?=$data->nb_pid?>&category=notice"><?=$nb_title ?></td>
        <td><?=$data->nb_user_id ?></td>
        <td><?=$data->nb_content ?></td>
        <td><?=$data->nb_date ?></td>
        <td><?=$data->nb_like ?></td>
        <td><?=$data->nb_hit ?></td>
        <td><a href="board_modify.php?idx=<?=$data->nb_pid?>&category=notice"><i class="fa-regular fa-pen-to-square"></i></a></td>
      </tr>
   <?php
    }
    ?>
    <?=$list?>
    <!--
    <tr>
      <th scope="row">1</th>
      <td>제목1</td>
      <td>홍길동</td>
      <td>2024.00.00</td>
      <td>1</td>
      <td>2</td>
      <td><a href="#"><i class="fa-regular fa-pen-to-square"></i></a></td>
    </tr>
-->
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



<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
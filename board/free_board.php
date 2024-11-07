<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');
?>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">제목</th>
      <th scope="col">글쓴이</th>
      <th scope="col">등록일</th>
      <th scope="col">추천수</th>
      <th scope="col">조회수</th>
      <th scope="col">Edit</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>제목1</td>
      <td>홍길동</td>
      <td>2024.00.00</td>
      <td>1</td>
      <td>2</td>
      <td><a href="#"><i class="fa-regular fa-pen-to-square"></i></a></td>
    </tr>
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
  <a class="btn btn-primary" href="#" role="button">글등록</a>
</div>



<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
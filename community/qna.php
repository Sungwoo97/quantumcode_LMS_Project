<?php 
$title = "QnA";
$community_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/community.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

?>
<!-- 스타일 -->
<style>
  #inquiryButton {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  #inquiryButton:hover {
    background-color: #0056b3;
  }

  .modal-content {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .modal-header {
    background-color: #007bff;
    color: #fff;
    border-bottom: none;
    border-radius: 10px 10px 0 0;
  }

  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
  }
</style>

<div class="search_box">
  <div class="container">
    <h2><?= $title ?></h2>
    <form action="" class="d-flex">
      <input type="text" class="form-control" id="search_box" placeholder="검색어를 입력하세요.">
      <button type="submit" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>  
</div>

<div class="community container">
  <div class="row">
    <aside class="col-2 d-flex flex-column">
      <h6>커뮤니티</h6>
      <hr>
      <ul>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/community/notice.php"><li>공지사항<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/community/faq.php"><li>FAQ<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/community/qna.php" class="active"><li>QnA<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/community/board.php"><li>자유게시판<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/qc/community/study.php"><li>스터디 모집<i class="fa-solid fa-chevron-right"></i></li></a>
      </ul>
    </aside>
  
    <div class="qna content col-10">
      <div class="d-flex justify-content-between align-items-center">
        <h6>퀀텀코드에게 문의하세요.</h6>
        <!-- 문의하기 버튼 -->
        <button class="btn btn-primary" id="inquiryButton">문의하기</button>
      </div>
      <hr>
      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th scope="col" class="num" style="width: 5%;">No</th>
            <th scope="col" style="width: 50%;">제목</th>
            <th scope="col" style="width: 10%;">조회</th>
            <th scope="col" style="width: 10%;">답변</th>
            <th scope="col" style="width: 25%;">게시일</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td class="post"><a href="#">문의 제목 예시</a></td>
            <td>123</td>
            <td>1</td>
            <td>2024-12-18</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td class="post"><a href="#">문의 제목 예시 2</a></td>
            <td>234</td>
            <td>0</td>
            <td>2024-12-17</td>
          </tr>
        </tbody>
      </table>
      
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#"><img src="../img/icon-img/CaretLeft.svg" alt=""></a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#"><img src="../img/icon-img/CaretRight.svg" alt=""></a></li>
        </ul>
      </nav>
    </div>
  </div>
</div>

<!-- 문의 모달 -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inquiryModalLabel">문의하기</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="inquiryForm">
          <div class="mb-3">
            <label for="inquiryTitle" class="form-label">문의 제목</label>
            <input type="text" class="form-control" id="inquiryTitle" placeholder="제목을 입력하세요" required>
          </div>
          <div class="mb-3">
            <label for="inquiryContent" class="form-label">문의 내용</label>
            <textarea class="form-control" id="inquiryContent" rows="5" placeholder="내용을 입력하세요" required></textarea>
          </div>
          <div class="mb-3 text-end">
            <button type="submit" class="btn btn-primary">제출하기</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


</div>
<!-- 스크립트 -->
<script>
  document.getElementById("inquiryButton").addEventListener("click", function () {
    const inquiryModal = new bootstrap.Modal(document.getElementById("inquiryModal"));
    inquiryModal.show();
  });

  document.getElementById("inquiryForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const title = document.getElementById("inquiryTitle").value;
    const content = document.getElementById("inquiryContent").value;

    alert("문의가 제출되었습니다.\n\n제목: " + title + "\n내용: " + content);
    const inquiryModal = bootstrap.Modal.getInstance(document.getElementById("inquiryModal"));
    inquiryModal.hide();
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
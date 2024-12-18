<?php
$title = "공지사항";
$community_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/community.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php'); // DB 연결

// 페이지네이션 설정
$items_per_page = 10; // 한 페이지에 표시할 항목 수
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 현재 페이지

if ($current_page < 1) $current_page = 1; // 페이지 범위 제한

// 총 게시물 수 계산
$total_items_sql = "SELECT COUNT(*) AS total FROM board WHERE category = 'notice'";
$total_items_result = $mysqli->query($total_items_sql);
$total_items_row = $total_items_result->fetch_assoc();
$total_items = $total_items_row['total'];

// 총 페이지 수 계산
$total_pages = ceil($total_items / $items_per_page);
if ($current_page > $total_pages) $current_page = $total_pages;

// 데이터 가져오기
$start_index = ($current_page - 1) * $items_per_page;
$sql = "SELECT pid, title, content, user_id, date FROM board WHERE category = 'notice' ORDER BY date DESC LIMIT ?, ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $start_index, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();
$notices = $result->fetch_all(MYSQLI_ASSOC);
?>

<!-- 스타일 -->
<style>
  /* 모달 전체 높이 조정 */
  .modal-content-custom {
    height: 190vh; /* 모달 창의 높이를 화면의 90%로 설정 */
  }

  /* 모달 본문 높이 조정 */
  .modal-body-custom {
    text-align: left;
    padding: 20px;
    overflow-y: auto; /* 내용이 많을 경우 스크롤 추가 */
    height: auto; /* 헤더와 푸터를 제외한 공간 차지 */
  }

  #modalTitle {
    margin-bottom: 20px; /* 제목과 내용 간격 */
    font-size: 1.5rem; /* 제목 폰트 크기 */
    font-weight: bold;
  }

  #modalContent {
    margin: 0;
    font-size: 1.1rem; /* 내용의 폰트 크기 */
    line-height: 1.8; /* 줄 간격 */
    white-space: pre-wrap; /* 줄바꿈 유지 */
  }
</style>
<div class="title_box">
  <div class="container">
    <h2><?= $title ?></h2>  
  </div>  
</div>

<div class="community container">
  <div class="row">
    <aside class="col-2 d-flex flex-column">
      <h6>커뮤니티</h6>
      <hr>
      <ul>
        <a href="notice.php" class="active"><li>공지사항<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="faq.php"><li>FAQ<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="qna.php"><li>QnA<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="board.php"><li>자유게시판<i class="fa-solid fa-chevron-right"></i></li></a>
        <a href="study.php"><li>스터디 모집<i class="fa-solid fa-chevron-right"></i></li></a>
      </ul>
    </aside>
  
    <div class="notice content col-10">
      <h6>퀀텀코드의 공지사항입니다.</h6>
      <hr>
      <table class="table table-hover text-center">
        <thead>
          <tr>
            <th scope="col" class="num">No</th>
            <th scope="col">제목</th>
            <th scope="col">작성자</th>
            <th scope="col" class="date">게시일</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($notices as $index => $notice): ?>
            <tr>
              <th scope="row"><?= $total_items - $start_index - $index ?></th>
              <td class="post"><a href="#" class="view-content" data-title="<?= htmlspecialchars($notice['title']) ?>" data-content="<?= htmlspecialchars($notice['content']) ?>"><?= htmlspecialchars($notice['title']) ?></a></td>
              <td><?= htmlspecialchars($notice['user_id']) ?></td>
              <td><?= htmlspecialchars($notice['date']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- 페이지네이션 -->
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
          <!-- 이전 버튼 -->
          <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $current_page - 1 ?>">&lt;</a>
          </li>
          <!-- 페이지 번호 -->
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($current_page == $i) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
          <!-- 다음 버튼 -->
          <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $current_page + 1 ?>">&gt;</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>

<!-- 모달 -->
<div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- 넓이를 크게 하기 위해 modal-lg 클래스 추가 -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contentModalLabel">게시물 내용</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-custom">
        <h5 id="modalTitle"></h5>
        <p id="modalContent"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // 제목 클릭 시 모달 표시
    const links = document.querySelectorAll(".view-content");
    links.forEach(link => {
      link.addEventListener("click", function (e) {
        e.preventDefault();
        const title = this.getAttribute("data-title");
        const content = this.getAttribute("data-content");

        // 모달에 데이터 삽입
        document.getElementById("modalTitle").textContent = title;
        document.getElementById("modalContent").textContent = content;

        // 모달 표시
        const contentModal = new bootstrap.Modal(document.getElementById("contentModal"));
        contentModal.show();
      });
    });
  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
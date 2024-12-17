<?php 
$title = "공지사항";
$community_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/community.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

// 공지사항 데이터 배열 (23개)
$notices = [
    ["시스템 점검 안내 (12월 15일)", "관리자", "2024.12.01"],
    ["[이벤트] 퀴즈 풀고 경품 받으세요!", "이벤트팀", "2024.11.29"],
    ["연말 결산 보고 및 업데이트 소식", "관리자", "2024.11.25"],
    ["보안 강화 및 비밀번호 변경 권장", "보안팀", "2024.11.20"],
    ["공지사항 게시판 이용 안내", "관리자", "2024.11.18"],
    ["신규 기능 업데이트 예정", "개발팀", "2024.11.10"],
    ["서비스 약관 개정 안내", "법무팀", "2024.10.30"],
    ["고객센터 운영 시간 변경", "고객지원팀", "2024.10.20"],
    ["추석 연휴 배송 지연 안내", "물류팀", "2024.09.15"],
    ["1:1 문의 게시판 개설 안내", "관리자", "2024.08.01"],
    ["서비스 점검 완료 안내", "관리자", "2024.07.25"],
    ["신규 강의 오픈 안내", "개발팀", "2024.07.10"],
    ["사이트 리뉴얼 예정 안내", "관리자", "2024.06.25"],
    ["보안 시스템 강화 공지", "보안팀", "2024.06.15"],
    ["결제 시스템 업데이트 안내", "관리자", "2024.06.01"],
    ["여름 휴가 기간 배송 안내", "물류팀", "2024.05.25"],
    ["신규 이벤트 참여 방법 안내", "이벤트팀", "2024.05.10"],
    ["데이터 백업 및 점검 안내", "시스템팀", "2024.04.30"],
    ["고객센터 확장 운영 공지", "고객지원팀", "2024.04.20"],
    ["회원 가입 이벤트 소식", "이벤트팀", "2024.04.10"],
    ["이용약관 변경 안내", "법무팀", "2024.04.05"],
    ["긴급 서버 점검 안내", "시스템팀", "2024.03.25"],
    ["자주 묻는 질문 업데이트", "관리자", "2024.03.15"]
];

// 페이지네이션 설정
$items_per_page = 10;
$total_items = count($notices);
$total_pages = ceil($total_items / $items_per_page);
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 페이지 범위 설정
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages) $current_page = $total_pages;

$start_index = ($current_page - 1) * $items_per_page;
$paginated_notices = array_slice($notices, $start_index, $items_per_page);
?>

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
            <th scope="col" class="writer">글쓴이</th>
            <th scope="col" class="date">게시일</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($paginated_notices as $index => $notice): ?>
            <tr>
              <th scope="row"><?= $total_items - $start_index - $index ?></th>
              <td class="post"><a href="#"><?= $notice[0] ?></a></td>
              <td><?= $notice[1] ?></td>
              <td><?= $notice[2] ?></td>
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

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
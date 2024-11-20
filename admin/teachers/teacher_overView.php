<?php
$title = "강사 목록";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../index.php';
    </script>
  ";
}


//검색
$search_where = ''; //초기화
$search_keyword = $_GET['search_keyword'] ?? '';

if($search_keyword){ 
  // $search_where .= " and (name LIKE '%$search_keyword%' OR content LIKE '%$search_keyword%')";
  $search_where .= " and (name LIKE '%$search_keyword%')";
}

//데이터의 개수 조회
$page_sql = "SELECT COUNT(*) AS cnt FROM teachers WHERE 1=1 $search_where";
$page_result = $mysqli->query($page_sql);
$page_data = $page_result->fetch_assoc();
$row_num = $page_data['cnt'];


//페이지네이션 
if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
}

$list = 10;
$start_num=($page-1)*$list;
$block_ct = 5;
$block_num = ceil($page/$block_ct); //$page1/5 0.2 = 1

$block_start = (($block_num-1)*$block_ct) + 1;
$block_end = $block_start + $block_ct - 1;

$total_page = ceil($row_num/$list); //총75개 10개씩, 8
$total_block = ceil($total_page/$block_ct);

if($block_end > $total_page ) $block_end = $total_page;

//목적에 맞게 목록 가져오기
$sql = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY tid ASC LIMIT $start_num, $list"; //teachers 테이블에서 모든 데이터를 조회
$sql_lowPriceToHigh = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY year_sales DESC"; //테이블에서 모든 데이터를 조회
$sql_highPriceToLow = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY year_sales ASC"; //테이블에서 모든 데이터를 조회
$sql_lowLectureToHigh = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY year_sales DESC"; //테이블에서 모든 데이터를 조회
$sql_highLectureToLow = "SELECT * FROM teachers WHERE 1=1 $search_where ORDER BY year_sales ASC"; //테이블에서 모든 데이터를 조회

$result = $mysqli->query($sql); //쿼리 실행 결과
while($data = $result->fetch_object()){
  $dataArr[] = $data;
}

?>


<div class="container">
  <div class="">
    <h1>인기강사.<매출많은 순서대로 나타낼것></h1>
    <div class="d-flex flex-wrap"> <!-- Flex 컨테이너 -->
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="">
    <h1>보통강사<무작위로 나타낼것></h1>
    <div class="d-flex flex-wrap"> <!-- Flex 컨테이너 -->
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="">
    <h1>신규강사<가입순 최신대로 나타낼것></h1>
    <div class="d-flex flex-wrap"> <!-- Flex 컨테이너 -->
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
      <div class="card m-2" style="width: 18rem;"> <!-- 개별 카드 -->
        <img class="card-img-top" src="" alt="Card image cap" width="300" height="200">
        <div class="card-body">
          <h5 class="card-title">123</h5>
          <p class="card-text">123</p>
          <a href="/qc/admin/lecture/lecture_view.php?lid=" class="btn btn-primary">해당 강의 보러가기</a>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center my-4">
    <a href="/qc/admin/teachers/teacher_list.php" class="btn btn-primary btn-lg">모든 강사 보러 가기</a>
  </div>
</div>

<script>
  

  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
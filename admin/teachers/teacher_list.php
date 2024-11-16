<?php
session_start();
$title = "상품목록";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');


if(!isset($_SESSION['AUID'])){
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}

$sql = "SELECT * FROM teachers ORDER BY sales DESC";
$result = $mysqli->query($sql);
while($data = $result -> fetch_object()){
  $dataArr[] = $data;
}

// print_r($dataArr);

?>



<div class="container">
  <h3>총 강사 수 : M 명
  <hr>
  <!-- <form action="plist_update.php" method="GET"> -->
  <table class="table">
    <thead>
      <tr>
        <th scope="col">No. </th>
        <th scope="col">이름</th>
        <th scope="col">아이디</th>
        <th scope="col">이메일</th>
        <th scope="col">가입날짜</th>
        <th scope="col">강의 갯수</th>
        <th scope="col">올해 매출</th>
        <th scope="col">강사 등급</th>
        <th scope="col">수정 및 삭제</th>
      </tr>
    </thead>
    <tbody>
        <?php
          if(isset($dataArr)){
            foreach($dataArr as $item){
        ?> 
        <tr>
          <th scope="row"><?= $item->tid; ?></th>
            <td><?= $item->name; ?></td>
            <td><?= $item->id; ?></td>
            <td><?= $item->email; ?></td>
            <td><?= $item->reg_date; ?></td>
            <td><?= $item->notyet; ?></td>
            <td><?= $item->sales; ?></td>
            <td><?= $item->grade; ?></td>
            <td>상세보기 바로가기</td>
        </tr>

        <?php
            }
          }
        ?> 
    </tbody>
  </table>
</div>

<script>
  

  
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
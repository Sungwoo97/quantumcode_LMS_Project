<?php
// DB 연결 설정 (dbcon.php를 포함하고 있으면 연결이 되어 있을 것입니다)
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

// POST 데이터 받기
$name = $_POST['name'] ?? ''; //id, email, number
$value = $_POST['value'] ?? ''; //입력한 값

// 반환할 결과 초기화
//$return_data = array("result" => 0);  중복이 없으면 result = 0

if ($name && $value) {
    // SQL 쿼리 작성
    if ($name === 'id') {
        // 아이디 중복 체크
        $sql = "SELECT COUNT(*) AS cnt FROM teachers WHERE id = $value";
    } elseif ($name === 'email') {
        // 이메일 중복 체크
        $sql = "SELECT COUNT(*) AS cnt FROM teachers WHERE email = $value";
    } elseif ($name === 'number') {
        // 전화번호 중복 체크
        $sql = "SELECT COUNT(*) AS cnt FROM teachers WHERE number = $value";
    }

    if (isset($sql)) {
      $result = $mysqli->query($sql);
      $row = $result->fetch_assoc();
      $row_num = $row['cnt'];

      if($row_num > 0){
        $return_data = array('result'=>$row_num);
        echo json_encode($return_data);
      }else if($row_num == 0){
        $return_data = array('result'=>0);
        echo json_encode($return_data);
      }
    }
}

$mysqli->close();
?>


<!-- //중복 id 개수 조회
$id_sql = "SELECT COUNT(*) AS cnt FROM admins WHERE userid='$userid '";
$id_result = $mysqli->query($id_sql);
$id_data = $id_result->fetch_assoc();
$row_num = $id_data['cnt'];  //중복 1, 중복x 0

if($row_num >= 1){
  $return_data = array('result'=>'error');
  echo json_encode($return_data);
}else if($row_num == 0){ 
  $return_data = array('result'=>'ok');
  echo json_encode($return_data);
}

$mysqli->close(); -->

<!-- 
$id_result = $mysqli->query($id_sql);
$row = $id_result -> fetch_object(); // $row->cnt
$row_num = $row->cnt;


$return_data = array('result'=>$row_num);
echo json_encode($return_data);
$mysqli->close();

-->



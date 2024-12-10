<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/dbcon.php');

$status = $_POST['status'] ?? '';
$tag = $_POST['tag'] ?? '';
$plat = $_POST['plat'] ?? '';
$dev = $_POST['dev'] ?? '';
$tech = $_POST['tech'] ?? '';
$option = $_POST['option'] ?? '';

$filter = '';



if ($status) {
  $filter .= "  AND l.lecture_status = $status";
}
if($tag){
  $filter .= " AND l.lecture_tag = '$tag'";
}
if($plat){
  $plat_sql = "SELECT code FROM lecture_category WHERE ppcode = '$plat' ";
  $plat_result = $mysqli->query($plat_sql);
  $platArr = [];
  while ($data = $plat_result->fetch_object()) {
    $code_sql = "SELECT lcid FROM lecture_category WHERE code = '$data->code' ";
    $code_result = $mysqli->query($code_sql);
    $platArr[] = $code_result->fetch_object()->lcid;
  }
  $plats = implode(',', [...$platArr]);
  $filter .= " AND c.lcid IN ($plats)";
}
if($dev){
  $dev_sql = "SELECT code FROM lecture_category WHERE pcode = '$dev' ";
  $dev_result = $mysqli->query($dev_sql);
  $devArr = [];
  while ($data = $dev_result->fetch_object()) {
    $code_sql = "SELECT lcid FROM lecture_category WHERE code = '$data->code' ";
    $code_result = $mysqli->query($code_sql);
    $devArr[] = $code_result->fetch_object()->lcid;
  }
  $devs = implode(',', [...$devArr]);
  $filter .= " AND c.lcid IN ($devs)";
}
if($tech){
  $filter .= " AND c.lcid = $tech";
}
if($option){
  $filter .= " AND l.{$option} = 1";
}

$sql = "SELECT l.*, c.*
FROM lecture_list l 
JOIN lecture_category c 
ON l.lcid = c.lcid
WHERE 1=1 $filter";


$result = $mysqli->query($sql);


if($result){

  while ($item = $result->fetch_object()) {
    
    $tuition = '';
    if ($item->dis_tuition > 0) {
      $tui_val = number_format($item->tuition);
      $distui_val = number_format($item->dis_tuition);
      $tuition .= "<p class=\"text-decoration-line-through tui \"> $tui_val 원 </p><p class=\"active-font \"> $distui_val 원 </p>";
    } else {
      $tui_val = number_format($item->tuition);
      $tuition .=  "<p class=\"active-font \"> $tui_val 원 </p>";
    }
    echo "
    <section class=\"col-md-3 mb-3 list d-flex flex-column justify-content-between\">
      <div>
        <div class=\"cover mb-2\">
          <img src=\"{$item->cover_image}\" alt=\"\">
        </div>
        <div class=\"title mb-2\">
          <h5 class=\"small-font mb-0\"><a href=\"lecture_view.php?lid={$item->lid}\">{$item->title}</a></h5>
          <p class=\"name text-decoration-underline\">{$item->t_id}</p>
        </div>
        <div class=\"d-flex flex-column-reverse justify-content-start tuition\">
          {$tuition}
        </div>
      </div>
      <ul>
        <li class=\"d-flex align-items-center gap-2\"> <img src=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/img/icon-img/review.svg\" alt=\"\"> 5점 </li>
        <li class=\"like d-flex align-items-center\"><img src=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/img/icon-img/Heart.svg\" width=\"10\" height=\"10\" alt=\"\">500+</li>
        <li class=\"tag\"> <span> {$item->lecture_tag}</span>  </li>
      </ul>
    </section>";
  }
}else{
  echo "검색 결과가 없습니다.";
}
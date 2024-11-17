<?php
$title = '상품 목록';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');


$html = '';
$list = array();

$sql = "SELECT * FROM lecture_list ORDER BY regdate LIMIT 10";
$result = $mysqli->query($sql);
while($data = $result->fetch_object()){
  $list[]= $data;
}

if(count($list)>0){
  $i = 1;
  foreach($list as $list){
    $html .= "<tr class=\"border-bottom border-secondary-subtitle\">
    <th >{$i}</th>
    <td><img src=\"{$list->cover_image}\" width=\"50\"></td>
    <td>{$list->title}</td>
    <td>{$list->tid}</td>
    <td>{$list->dis_tuition}</td>
    <td>{$list->difficult}</td>
    <td>{$list->category}</td>
    <td>{$list->regist_day}</td>
    <td><img src=\"../img/icon-img/Edit.svg\" width=\"20\"></td>
  </tr>";
  $i++;
  }
}




?>

<div class="container">
<table class="table table-hover text-center">
    <thead>
      <tr class="border-bottom border-secondary-subtitle thline">
        <th scope="col">No</th>
        <th scope="col">Platforms</th>
        <th scope="col">Development</th>
        <th scope="col">Technologies</th>
        <th scope="col">Edit</th>
        <th scope="col">Edit</th>
        <th scope="col">Edit</th>
        <th scope="col">Edit</th>
      </tr>
    </thead>
    <tbody>
      <?= $html; ?>
    </tbody>
  </table>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
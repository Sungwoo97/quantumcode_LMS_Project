<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/header.php');
?>

<?php

// 전체 게시판 조회
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($sql);

$list = '';
while($data = $result -> fetch_object()){
  $title = $data->title;
  

  if(iconv_strlen($title)>10){
    $title = iconv_substr($title, 0, 10) . '...';
  }
?>
  <tr>
    <th scope="row"><?=$data->pid ?></th>
    <td><?=$title ?></td>
    <td><?=$data->content ?></td>
    <td><?=$data->created_at ?></td>
  </tr>
<?php
}
?>
<?=$list?>
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/admin/inc/footer.php');
?>
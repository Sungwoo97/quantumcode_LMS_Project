<?php
$title = '수강평';
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/admin/css/lecture.css\" rel=\"stylesheet\">";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$id = isset($_SESSION['AUID']) ? $_SESSION['AUID']  : $_SESSION['TUID'];
if (!isset($id)) {
  echo "
    <script>
      alert('관리자로 로그인해주세요');
      location.href = '../login.php';
    </script>
  ";
}



$reply = '';



$review = '';
$review_sql = "SELECT * FROM lecture_review";
$review_result = $mysqli->query($review_sql);
while ($review_data = $review_result->fetch_object()) {
  $reply_sql = "SELECT * FROM lecture_reply WHERE lrid = $review_data->lrid";
  $reply_result = $mysqli->query($reply_sql);
  while ($reply_data = $reply_result->fetch_object()) {
    $reply .=
      "<div class=\"rereply d-flex gap-3 align-items-center mb-3 ml-3\">
        <div>
          <img src=\"../img/core-img/어드민_이미지.png\" alt=\"\">
        </div>
        <div>
          <h3>{$reply_data->t_id}</h3>
        </div>
        <form class=\"d-flex w-100\">
          <div class=\"w-100\">
            <p>{$reply_data->comment}</p>
          </div>
            <div class=\"d-flex gap-3 mx-3\">
              <button type=\"button\" class=\"btn btn-primary reply_edit\" data-id=\"{$reply_data->lpid}\">수정</button>
              <button type=\"button\" class=\"btn btn-danger reply_del\" data-id=\"{$reply_data->lpid}\">삭제</button>
            </div>
          </form>
        </div>";
  }
  $review .= "<div class=\"review d-flex gap-3 align-items-center mb-3\">
    <div>
      <img src=\"{$review_data->profile_image}\" width=\"50\" alt=\"\">
    </div>
    <div>
      <h5>{$review_data->username}</h5>
      <h6>{$review_data->regist_day}</h6>
      <img src=\"../img/icon-img/review.svg\" alt=\"\">
    </div>
    <div>
      <p>{$review_data->comment}</p>
    </div>
    <div class=\"mx-3\">
      <button class=\" btn btn-primary\" data-id=\"{$review_data->lrid}\">답글</button>
    </div>
  </div>
  $reply 
  <div class=\"reply hidden d-flex gap-3 align-items-center mb-3 ml-3\">
  </div>
  ";
}
?>

<?= $review ?>
<!-- <div class="reply d-flex gap-3 align-items-center mb-3 ml-3">
  <div>
    <img src="../img/core-img/어드민_이미지.png" alt="">
  </div>
  <div>
    <h3>admin</h3>
  </div>
  <form class="d-flex w-100">
    <div class="w-100">
      <textarea type="text" class="form-control " name="reply" id="reply"></textarea>
    </div>
    <div class=" mx-3">
      <button class=" btn btn-primary">작성</button>
    </div>
  </form>
</div> -->

<script>
  $('.content').on('click', '.review .btn', function() {
    let lrid = $(this).attr('data-id');
    let reply = `<div><img src="../img/core-img/어드민_이미지.png" alt=""></div><div><h3>admin</h3></div><form class="d-flex w-100" data-id="${lrid}"><div class="w-100"><textarea  class="form-control " name="reply" id="reply"></textarea></div><div class=" mx-3"><button class=" btn btn-primary">작성</button></div></form>`;
    if ($('.reply').hasClass('hidden')) {
      $('.reply').removeClass('hidden');
      $('.reply').append(reply);
    } else {
      $('.reply').addClass('hidden');
      $('.reply').empty();
    }
  });
  $('.content').on('submit', '.reply form', function(e) {
    e.preventDefault();
    let lrid = $(this).attr('data-id');
    let comment = $('#reply').val();

    let data = {
      lrid: lrid,
      comment: comment
    }
    console.log(data);

    $.ajax({
      url: 'lecture_reply.php',
      method: 'POST',
      data: data,
      dataType: 'json',
      success: function(response) {
        if (response.result === 1) {
          alert('답글이 작성되었습니다.');
          location.reload(); // 페이지 새로고침
        } else {
          alert('작성 실패: ' + response.error);
        }
      },
      error: function(error) {
        console.error(error);
        alert('작성 중 오류가 발생했습니다.');
      }
    })

  });
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
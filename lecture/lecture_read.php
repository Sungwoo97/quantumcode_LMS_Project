<?php
$title = "학습하기";
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";
$video_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/video.css\" rel=\"stylesheet\">";
$libVideo_css = "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/video.js/8.21.1/video-js.min.css\" integrity=\"sha512-eAxdlYVdHHB5//MPUJMimVOM0OoKa3I1RWCnrqvzwri3u5+RBdB6d0fdBsEOj78PyomrHR3+E3vy0ovoVU9hMQ==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" />";
$libVideo_js = "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/video.js/8.21.1/video.min.js\" integrity=\"sha512-4ojVomDWDnx2FZyOK/eVZCTut+02zggocT1Cj8S7Y/E31ozUWlU0vZ5+rzVyy+hKZCG6Gt9RJ9elOMS70LBRtQ==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

$lid = $_GET['lid'];
$vidArr = [];
$sql = "SELECT * FROM lecture_video WHERE lid = $lid ORDER BY lvid";
$result = $mysqli->query($sql);
if (isset($result)) {
  while ($data = $result->fetch_object()) {
    $vidArr[] = $data->video_lecture;
  }
} else {
  echo
  "<script>
  alert('영상이 제공되지 않는 강의 입니다');
  location.href = './lecture_view.php?lid=<?= $lid ?>';
  </script> ";
}

$lecture_sql = "SELECT sub_title, learning_obj FROM lecture_list WHERE lid=$lid";
$lecture_result = $mysqli->query($lecture_sql);
if ($lecture_result) {
  $lecture_data = $lecture_result->fetch_object();
}
$vidArrJson = json_encode($vidArr);

?>

<div class="hidden_hover"></div>
<div class="video">
  <div class="video_wrapper d-flex">
    <video id="lecture-video" class="video-js" width="100%" height="100%" controls>
      <source src="<?= $vidArr[0] ?>" type="video/mp4">
    </video>
    <ul class="video_index">
      <?php 
      if (!empty($vidArr)) {
        $i = 1;
        foreach ($vidArr as $vid) {
      ?> 
      <li data-id="<?= $i - 1 ?>">
        <h5><a href="#"><?= $i ?>강 </a></h5>
      </li>
      <?php
      $i++;
        }
      }
      ?>
    </ul>
    <ul class="video_desc">
      <li>
        <p><?= $lecture_data->sub_title ?></p>
        <p><?= $lecture_data->learning_obj ?></p>
      </li>
    </ul>
  </div>
  <!-- 기존의 controls 섹션 유지 -->
  <div class="controls">
    <button id="prev-btn"><i class="fa-solid fa-backward"></i><span>이전 수업</span></button>
    <button id="next-btn"><span>다음 수업</span> <i class="fa-solid fa-forward"></i></button>
  </div>
  <aside>
    <div class="index" data-target="index">
      <img src="../img/icon-img/st_book.svg" width="40" alt="">
      <h5>강의 목차</h5>
    </div>
    <div class="desc" data-target="desc">
      <img src="../img/icon-img/ChatText.svg" width="40" alt="">
      <h5>강의 설명</h5>
    </div>
  </aside>
</div>

<!-- 모달 창 -->
<div id="endModal" class="modal">
  <div class="modal-content">
    <p style="font-size: 24px">수강이 완료되었습니다.</p>
    <p>수강완료 혹은 다음강의로 이동을 클릭하셔야 수업을 들은 걸로 인정됩니다.</p>
    <button id="complete-btn">수강 완료</button>
    <button id="nextLesson">다음 강의로 이동</button>
  </div>
</div>

<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }
  .modal-content {
    position: absolute;
    background-color: #fff;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 300px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
  }
  .modal-content button {
    margin: 10px;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
  }
</style>

<script>
  const vidArr = <?= $vidArrJson; ?>;
  let currentIndex = 0;

  const video = document.getElementById('lecture-video');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');
  const modal = document.getElementById('endModal');
  const completeBtn = document.getElementById('complete-btn');
  const nextLessonBtn = document.getElementById('nextLesson');

  const loadVideo = (index) => {
    if (index >= 0 && index < vidArr.length) {
      video.src = vidArr[index];
      video.play();
      currentIndex = index;
    } else {
      alert('강의가 더 이상 없습니다.');
    }
  };

  prevBtn.addEventListener('click', () => {
    loadVideo(currentIndex - 1);
  });

  nextBtn.addEventListener('click', () => {
    loadVideo(currentIndex + 1);
  });

  video.addEventListener('ended', () => {
    modal.style.display = 'block';
  });

  completeBtn.addEventListener('click', () => {
    alert('수강 완료가 기록되었습니다!');
    modal.style.display = 'none';
  });

  nextLessonBtn.addEventListener('click', () => {
    loadVideo(currentIndex + 1);
    modal.style.display = 'none';
  });

  if (vidArr.length > 0) {
    loadVideo(0);
  } else {
    alert('영상이 제공되지 않는 강의입니다.');
  }
</script>
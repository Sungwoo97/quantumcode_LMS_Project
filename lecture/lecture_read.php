<?php
$title = "학습하기";
$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";
$video_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/video.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

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
  history.back();
  </script> ";
}
$vidArrJson = json_encode($vidArr);
?>


<div class="video">
  <video id="lecture-video" controls>
    <source src="" type="video/mp4">
    Your browser does not support the video tag.
  </video>
  <div class="controls">
    <button id="prev-btn">이전 수업</button>
    <button id="next-btn">다음 수업</button>
  </div>
  <aside>
    <div>강의 목차</div>
    <div>강의 설명</div>
  </aside>
</div>


<script>
  // 강의 영상 배열 (PHP에서 전달)
  const vidArr = <?= $vidArrJson; ?>;
  let currentIndex = 0; // 현재 영상 인덱스

  // 영상 요소 참조
  const videoElement = document.getElementById('lecture-video');
  const prevBtn = document.getElementById('prev-btn');
  const nextBtn = document.getElementById('next-btn');

  // 영상 재생 함수
  const loadVideo = (index) => {
    if (index >= 0 && index < vidArr.length) {
      videoElement.src = vidArr[index]; // 비디오 URL 설정
      videoElement.play(); // 자동 재생
      currentIndex = index; // 현재 인덱스 업데이트
    } else {
      alert('강의가 더 이상 없습니다.');
    }
  };

  // 버튼 이벤트 핸들러
  prevBtn.addEventListener('click', () => {
    loadVideo(currentIndex - 1); // 이전 영상 로드
  });

  nextBtn.addEventListener('click', () => {
    loadVideo(currentIndex + 1); // 다음 영상 로드
  });

  // 페이지 로드 시 첫 번째 영상 자동 재생
  if (vidArr.length > 0) {
    loadVideo(0);
  } else {
    alert('영상이 제공되지 않는 강의입니다.');
  }
</script>
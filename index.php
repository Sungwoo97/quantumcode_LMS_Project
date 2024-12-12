<?php

$main_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/main.css\" rel=\"stylesheet\">";
$slick_css = "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css\" integrity=\"sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" />";
$slick_js = "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js\" integrity=\"sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

//인기 강의
$sql = "SELECT * FROM lecture_list WHERE ispopular = 1";
$result = $mysqli->query($sql);
$dataArr = [];
while ($data = $result->fetch_object()) {
  $dataArr[] = $data;
}

//프리미엄 강의
$sql2 = "SELECT * FROM lecture_list WHERE ispremium = 1";
$result2 = $mysqli->query($sql2);
$dataArr2 = [];
while ($data2 = $result2->fetch_object()) {
  $dataArr2[] = $data2;
}



?>

<!-- Placeholder for Main Content -->
<main>
  <section class="banner">
    <div class="main_slides">
      <div class="slide">
        <img src="img/core-img/001.png" alt="배너 이미지">
      </div>
      <div class="slide">
        <img src="img/core-img/002.png" alt="배너 이미지">
      </div>
      <div class="slide">
        <img src="img/core-img/003.png" alt="배너 이미지">
      </div>
      <div class="slide">
        <img src="img/core-img/004.png" alt="배너 이미지">
      </div>
    </div>

    <div class="custom container">
      <div class="banner_controls">
        <button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>
        <span>1/4</span>
        <button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>
      </div>
      <div class="custom-pagination "></div>
    </div>



    <div class="main_notice container d-flex">
      <h2 class="w-100"><i class="fa-solid fa-triangle-exclamation"></i> 공지</h2>
      <div class="notice_slides ">
        <div class="notice_text d-flex justify-content-between">
          <span>[업데이트] 12월 1주차 - 서비스 기능 업데이트</span>
          <span>2024.12.02</span>
        </div>
        <div class="notice_text d-flex justify-content-between">
          <span>[업데이트] 12월 1주차 - 서비스 기능 업데이트</span>
          <span>2024.12.02</span>
        </div>
        <div class="notice_text d-flex justify-content-between">
          <span>[업데이트] 12월 1주차 - 서비스 기능 업데이트</span>
          <span>2024.12.02</span>
        </div>
        <div class="notice_text d-flex justify-content-between">
          <span>[업데이트] 12월 1주차 - 서비스 기능 업데이트</span>
          <span>2024.12.02</span>
        </div>
      </div>
      <div class="notice_controls">
        <button class="slick-prev"><i class="fa-solid fa-angle-up"></i></button>
        <button class="slick-next"><i class="fa-solid fa-angle-down"></i></button>
      </div>
    </div>
  </section>
  <section class="skill_tag container d-flex my-5">
    <figure>
      <div><img src="./img/icon-img/html_icon.svg" alt=""></div>
      <figcaption>Html</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/css_icon.svg" alt=""></div>
      <figcaption>Css</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/javascript_icon.svg" alt=""></div>
      <figcaption>JavaScript</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/react_icon.svg" alt=""></div>
      <figcaption>React</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/java_icon.svg" alt=""></div>
      <figcaption>Java</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/jquery_icon.svg" alt=""></div>
      <figcaption>Jqeury</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/python_icon.svg" alt=""></div>
      <figcaption>Python</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/php_icon.svg" alt=""></div>
      <figcaption>PHP</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/node_js_icon.svg" alt=""></div>
      <figcaption>Node.js</figcaption>
    </figure>
    <figure>
      <div><img src="./img/icon-img/vue_icon.svg" alt=""></div>
      <figcaption>Vue.js</figcaption>
    </figure>

  </section>

  <div class="main_popular container mb-3"> <!-- Flex 컨테이너 -->
    <p>BEST</p>
    <h3>인기 강의</h3>
    <p>수강생 PICK! 지금 가장 뜨거운 강의, 당신의 성공을 위한 필수 선택! </p>
    <div class="popular">
      <?php
      foreach ($dataArr as $item) {
        $tuition = '';
        if ($item->dis_tuition > 0) {
          $tui_val = number_format($item->tuition);
          $distui_val = number_format($item->dis_tuition);
          $tuition .= "<p class=\"text-decoration-line-through \"> $tui_val 원 </p><p class=\"active-font\"> $distui_val 원 </p>";
        } else {
          $tui_val = number_format($item->tuition);
          $tuition .=  "<p class=\"active-font\"> $tui_val 원 </p>";
        }
      ?>
        <section class="slide">
          <div>
            <div class="cover mb-2">
              <img src="<?= $item->cover_image ?>" alt="">
            </div>
            <div class="title mb-2">
              <h5 class="small-font mb-0"><a href="lecture_view.php?lid=<?= $item->lid ?>"><?= $item->title ?></a></h5>
              <p class="name text-decoration-underline"><?= $item->t_id ?></p>
            </div>
            <div>
              <?= $tuition ?>
            </div>
          </div>
          <ul>
            <!-- <li class="d-flex align-items-center gap-2"> <img src="../img/icon-img/review.svg" alt=""> 5점 </li>
            <li class="like d-flex align-items-center"><img src="../img/icon-img/Heart.svg" width="10" height="10" alt="">500+</li> -->
            <li class="tag"><?= !empty($item->lecture_tag) ? "<span> {$item->lecture_tag}</span>" : '' ?> </li>
          </ul>
        </section>
      <?php
      }
      ?>
    </div>
    <div class="porpular_controls">
      <button type="button" class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>
      <button type="button" class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
  <section class="container main_premium">
    <div class="premium_slider">
      <?php
      foreach ($dataArr2 as $item) {
        $tuition = '';
        if ($item->dis_tuition > 0) {
          $tui_val = number_format($item->tuition);
          $distui_val = number_format($item->dis_tuition);
          $tuition .= "<p class=\"text-decoration-line-through \"> $tui_val 원 </p><p class=\"active-font\"> $distui_val 원 </p>";
        } else {
          $tui_val = number_format($item->tuition);
          $tuition .=  "<p class=\"active-font\"> $tui_val 원 </p>";
        }
      ?>
        <section class="slide">
          <div>
            <div class="cover mb-2">
              <img src="<?= $item->cover_image ?>" alt="">
            </div>
            <div class="title mb-2">
              <h5 class="small-font mb-0"><a href="lecture_view.php?lid=<?= $item->lid ?>"><?= $item->title ?></a></h5>
              <p class="name text-decoration-underline"><?= $item->t_id ?></p>
            </div>
            <div>
              <?= $tuition ?>
            </div>
          </div>
          <ul>
            <li class="tag"><?= !empty($item->lecture_tag) ? "<span> {$item->lecture_tag}</span>" : '' ?> </li>
          </ul>
        </section>
      <?php
      }
      ?>
    </div>

  </section>
  <section class="main_info text-center">
    <h3>퀀텀코드: 코드로 미래를 뛰어넘다</h3>
    <h4>최신 기술을 실무 중심으로 배우며, 스스로의 가능성을 퀀텀 점프 시킬 수 있는 최고의 코드 강의 플랫폼
      "오늘의 배움이 내일의 기술이 됩니다. 퀀텀코드와 함께 도전하세요."</h4>
    <dl class="d-flex">
      <dt>강의 만족도 99%</dt>
      <dd>하루 20분의 기적 수강생 만족도</dd>
      <img src="" alt="">
      <dt>320만 회원돌파</dt>
      <dd>코딩 공부를 위해 퀀텀코드를 선택한 회원</dd>
      <img src="" alt="">
      <dt>24년의 코딩노하우</dt>
      <dd>퀀텀코드만의 코딩교육 노하우</dd>
      <img src="" alt="">
      <dt>10명 중 9명 완강 실적</dt>
      <dd>수강생이 선택한 학습효과</dd>
      <img src="" alt="">
    </dl>
    <a href="">퀀텀코드 자세히 알기</a>
  </section>

  <section class="container review">
    <h3>수강생 후기</h3>

  </section>

  <section class="main_recom container">

  </section>

  <section class="main_free container">

  </section>

  <section class="main_category">

  </section>
</main>


<script>
  const $pagination = $(".custom-pagination");

  $(".main_slides").on("init reInit afterChange", function(event, slick, currentSlide) {
    const totalSlides = slick.slideCount;
    const current = (currentSlide || 0) + 1;

    // 페이지네이션 텍스트 갱신
    $(".controls span").text(`${current}/${totalSlides}`);

    // 페이지네이션 상태 갱신
    $pagination.find(".custom-dot").removeClass("active");
    $pagination.find(`.custom-dot:nth-child(${current})`).addClass("active");
  });

  $('.main_slides').slick({
    speed: 300,
    prevArrow: $('.banner .slick-prev'),
    nextArrow: $('.banner .slick-next'),
    dots: false, // 기본 dots 비활성화
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
  });

  $('.notice_slides').slick({
    speed: 300,
    vertical: true,
    prevArrow: $('.main_notice .slick-prev'),
    nextArrow: $('.main_notice .slick-next'),
  });

  $('.popular').slick({

    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    prevArrow: $('.main_popular .slick-prev'),
    nextArrow: $('.main_popular .slick-next'),
    responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]
  });
  $('.premium_slider').slick({
    rows: 2, // 슬라이드의 행 수
    slidesPerRow: 3, // 각 행에 표시할 슬라이드 개수
    infinite: true, // 무한 반복
    arrows: true, // 화살표 표시
    dots: true // 페이지 네비게이션
  });

  // 커스텀 페이지네이션 생성
  const slideCount = $(".main_slides").slick("getSlick").slideCount;
  for (let i = 0; i < slideCount; i++) {
    $pagination.append(`<div class="custom-dot"></div>`);
  }

  // 첫 번째 dot 활성화
  $pagination.find(".custom-dot:first-child").addClass("active");
</script>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');

?>
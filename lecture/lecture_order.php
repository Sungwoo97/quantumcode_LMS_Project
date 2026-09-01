<?php
$title = "강의 목록";

$lecture_css = "<link href=\"//{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');

if ($email === '') {
  echo "<script>
  alert('로그인 이후 이용 가능한 기능입니다');
  history.back();
  </script>";
}

// $userid = 5;
$total = 0;
$dataArr = [];
$lidArr = [];
// 현재 로그인한 userid 와 같은 것과 비교해서 목록을 출력 (임의로 홍길동)
$sql = "SELECT lc.*, ll.cover_image, ll.t_id, ll.title, ll.lid 
FROM lecture_cart lc
JOIN lecture_list ll
ON lc.lid = ll.lid
WHERE mid = '$email'";
$result = $mysqli->query($sql);
while ($row = $result->fetch_object()) {
  $dataArr[] = $row;
  $total += $row->price;
  $lidArr[] = $row->lid;
}
$lid = implode(',', $lidArr);




?>
<div class="container cart">
  <h2>수강바구니</h2>
  <div class="row">
    <div class="col-9">
      <div class="d-flex justify-content-between align-items-center order-head mb-3">
        <span class="">
          <input type="checkbox" class="cart_check" name="select_all" id="select_all">
          <label for="select_all" class="cart_label"></label>
          <strong class="w-100 cart_tr">전체선택</strong>
        </span>
        <button class="btn btn-secondary sel_delete">선택 삭제</button>
      </div>
      <hr>
      <table class="table ">
        <thead>
          <tr class="visually-hidden">
            <th scope="col"><input type="checkbox" name="" id=""></th>
            <th scope="col">커버이미지</th>
            <th scope="col">강의 정보</th>
            <th scope="col">강의 가격</th>
          </tr>
        </thead>

        <tbody>
          <?php
          if (!empty($dataArr)) {
            foreach ($dataArr as $data) {
          ?>
              <tr>
                <th>
                  <input type="checkbox" class="cart_check" name="l_check" id="l_check<?= $data->lid ?>" data-id="<?= $data->lid ?>" data-price="<?= $data->price ?>">
                  <label for="l_check<?= $data->lid ?>" class="cart_label"></label>
                </th>
                <td><img src="<?= $data->cover_image ?>" width="150" alt=""></td>
                <td><?= $data->title ?></td>
                <td id="total_price"><?= number_format($data->price) ?> 원</td>
              </tr>
          <?php
            }
          }
          ?>
        </tbody>
      </table>
    </div>
    <div class="col-3 payment">
      <div class="d-flex justify-content-between">
        <span class="font">선택 금액</span><span class="normal-font total_payment"> 0 원</span>
      </div>
      <div class="control m-3">
        <button type="button" class="payment_btn btn btn-primary w-100">구매하기</button>
      </div>
    </div>
  </div>
</div>
<script>
  const paymentBtn = document.querySelector('.payment_btn');
  let total_payment = document.querySelector('.total_payment').innerText;
  let numericValue = total_payment.replace(/[^0-9]/g, '');
  const lec_check = document.querySelectorAll('.table input[type="checkbox"]');
  const sel_delete = document.querySelector('.sel_delete');
  const cart_tr = document.querySelector('.cart_tr');
  const sel_all = document.getElementById('select_all');

  let checkArr = [];
  let priceArr = [];
  var sum_price = 0;
  let lid;

  // 선택한 강의만 들고 결제 페이지로 넘어간다
  paymentBtn.addEventListener('click', () => {
    if (!lid) {
      alert('구매할 강의를 선택해주세요.');
      return;
    }
    location.href = 'lecture_checkout.php?lid=' + encodeURIComponent(lid);
  })

  sel_delete.addEventListener('click', () => {
    if (lid) {
      console.log(lid);
      const data = new URLSearchParams({
        lid: lid
      });
      fetch('lecture_order_del.php', {
          method: 'post',
          body: data,
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(result => {

          if (result.status === 'success') {
            alert('데이터가 성공적으로 삭제되었습니다!');
            location.reload(); // 페이지 새로고침
          } else {
            alert('데이터 삭제에 실패했습니다: ' + result.message);
          }
        })
        .catch(error => {
          console.error('Error:', error); // 네트워크나 JSON 변환 에러 처리
        });
    }
  })

  // 천자리 마다 , 해주는 함수
  function numberFormat(number, thousandSeparator = ',') {
    const integerPart = Math.floor(number).toString(); // 정수 부분만 처리
    return integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);
  }
  // 체크박스 클릭 시 데이터 저장
  lec_check.forEach(check => {
    check.addEventListener('change', (e) => {
      let check_id = e.target.getAttribute('data-id');
      let check_price = Number(e.target.getAttribute('data-price'));
      if (check.checked == 1) {
        sum_price += check_price;
        checkArr.push(check_id);
        console.log(sum_price, check_id);

      } else {
        checkArr = checkArr.filter(item => item !== check_id);
        sum_price -= check_price;
        console.log(sum_price);
      }
      lid = checkArr.join(',');
      console.log(lid);
      document.querySelector('.total_payment').innerText = numberFormat(sum_price) + '원';
      // console.log(sum);
    })
  })

  cart_tr.addEventListener('click', function() {
    sel_all.addEventListener('trig')
  })

  sel_all.addEventListener('click', function() {
    const isChecked = this.checked;
    document.querySelectorAll('.cart_check').forEach(checkbox => {
      checkbox.checked = isChecked; // 체크박스 상태 변경
      checkbox.dispatchEvent(new Event('change')); // 이벤트 트리거
    });
  });
</script>



<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>
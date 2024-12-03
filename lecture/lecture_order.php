<?php
$title = "강의 목록";

$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/header.php');

$userid = 5;
$total = 0;
$dataArr = [];
$lidArr = [];
// 현재 로그인한 userid 와 같은 것과 비교해서 목록을 출력 (임의로 홍길동)
$sql = "SELECT lc.*, ll.cover_image, ll.t_id, ll.title 
FROM lecture_cart lc
JOIN lecture_list ll
ON lc.lid = ll.lid
WHERE mid = $userid";
$result = $mysqli->query($sql);
while ($row = $result->fetch_object()) {
  $dataArr[] = $row;
  $total += $row->price;
  $lidArr[] = $row->lid;
}
$lid = implode(',', $lidArr);




$couponArr = [];
$coupon_sql = "SELECT cu.*, c.*  
FROM coupons_usercp cu
JOIN coupons c
ON c.cid = cu.couponid
WHERE cu.status = 1
AND c.status = 1
AND cu.userid = $userid
AND cu.use_max_date >=now() ";
$coupon_result = $mysqli->query($coupon_sql);
while ($coupon_row = $coupon_result->fetch_object()) {
  $couponArr[] = $coupon_row;
}


$user_sql = "SELECT * FROM members WHERE mid = $userid";
$user_result = $mysqli->query($user_sql);
$user_data = $user_result->fetch_object();
$callnum = "0" . substr($user_data->number, 0, 2) . "-" . substr($user_data->number, 2, 4) . "-" . substr($user_data->number, 6);



?>
<div class="row">
  <div class="col-9">
    <div class="d-flex justify-content-between align-items-center order-head mb-3">
      <span class=""><img src="../img/icon-img/Check_Y.svg" alt="" class="mx-3"><strong class="w-100">전체선택</strong></span> <button class="btn btn-secondary">선택 삭제</button>
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
              <th><input type="checkbox" name="" id=""></th>
              <td><img src="<?= $data->cover_image ?>" width="150" alt=""></td>
              <td><?= $data->title ?></td>
              <td><?= number_format($data->price) ?> 원</td>

            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="col-3 payment">
    <dl>
      <dt>신청자</dt>
      <dd><?= $user_data->name ?></dd>
      <dt>이메일</dt>
      <dd><?= $user_data->email ?></dd>
      <dt>전화번호</dt>
      <dd><?= $callnum ?></dd>

      <dt>쿠폰</dt>
      <dd>
        <select class="form-select" name="coupon" id="coupon">
          <option value="" selected>쿠폰 선택</option>
          <?php
          if (!empty($couponArr)) {
            foreach ($couponArr as $coupon) {
              $price = 0;
              if ($coupon->coupon_type === 'fixed') {
                $price = $coupon->coupon_price;
              } else {
                $price = $coupon->coupon_ratio;
              }
          ?>
              <option value="<?= $coupon->ucid ?>" data-price="<?= $price ?>"><?= $coupon->coupon_name ?> </option>
          <?php
            }
          }
          ?>
        </select>
      </dd>
    </dl>
    <div class="d-flex justify-content-between">
      <span class="font">결제 금액</span><span class="normal-font total_payment"><?= number_format($total) ?>원</span>
    </div>
    <div class="control m-3">
      <button type="button" class="payment_btn btn btn-primary w-100">결제하기</button>
    </div>
  </div>
</div>
<script>
  const paymentBtn = document.querySelector('.payment_btn');
  const coupon = document.querySelector('#coupon');
  const total_payment = document.querySelector('.total_payment').innerText;
  let numericValue = total_payment.replace(/[^0-9]/g, '');

  paymentBtn.addEventListener('click', () => {
    const mid = "<?= $userid ?>";
    const lid = "<?= $lid ?>";
    const total = numericValue;
    console.log(mid, lid, total);
    const data = new URLSearchParams({
      lid: lid,
      mid: mid,
      total_price: total,
    });
    fetch('lecture_payment.php', {
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
        console.log('Success:', result);
      })
      .catch(error => {
        console.error('Error:', error); // 네트워크나 JSON 변환 에러 처리
      });
  })
  coupon.addEventListener('change', (e) => {
    let ucid = e.target.value;
    let ucprice = e.target.options[e.target.selectedIndex].getAttribute('data-price');
    console.log(ucid, ucprice);
    numericValue -= Number(ucprice);
    

    document.querySelector('.total_payment').innerText = numberFormat(numericValue) + '원';
  })

  function numberFormat(number, thousandSeparator = ',') {
    const integerPart = Math.floor(number).toString(); // 정수 부분만 처리
    return integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);
  }
</script>



<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/admin/inc/footer.php');
?>
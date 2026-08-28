<?php
$title = "결제";

$lecture_css = "<link href=\"http://{$_SERVER['HTTP_HOST']}/qc/css/lecture.css\" rel=\"stylesheet\">";

include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/toss_config.php');

if ($email === '') {
  echo "<script>
  alert('로그인 이후 이용 가능한 기능입니다');
  history.back();
  </script>";
}

// 결제할 강의 번호. 주소로 넘어온 값이라 숫자만 남기고 걸러낸다
$lidArr = [];
foreach (explode(',', $_GET['lid'] ?? '') as $one_lid) {
  $one_lid = trim($one_lid);
  if (ctype_digit($one_lid)) {
    $lidArr[] = $one_lid;
  }
}

// 강의 가격은 주소로 받지 않고 여기서 다시 조회한다
$orderArr = [];
$total = 0;
if (!empty($lidArr)) {
  $lids = implode(',', $lidArr);
  $order_sql = "SELECT lid, title, cover_image, tuition, dis_tuition FROM lecture_list WHERE lid IN ($lids)";
  $order_result = $mysqli->query($order_sql);
  while ($order_row = $order_result->fetch_object()) {
    $order_row->price = $order_row->dis_tuition > 0 ? $order_row->dis_tuition : $order_row->tuition;
    $orderArr[] = $order_row;
    $total += $order_row->price;
  }
}

$couponArr = [];
$coupon_sql = "SELECT cu.*, c.*
FROM coupons_usercp cu
JOIN coupons c
ON c.cid = cu.couponid
WHERE cu.status = 1
AND c.status = 1
AND cu.userid = '$email'
";
$coupon_result = $mysqli->query($coupon_sql);
while ($coupon_row = $coupon_result->fetch_object()) {
  $couponArr[] = $coupon_row;
}

$user_sql = "SELECT * FROM memberskakao WHERE memEmail = '$email'";
$user_result = $mysqli->query($user_sql);
$user_data = $user_result->fetch_object();
$membernum = $user_data ? $user_data->number : '';
?>
<div class="container cart">
  <h2>결제하기</h2>

  <?php if (empty($orderArr)) { ?>
    <div class="payment p-4 text-center my-5">
      <p class="normal-font">결제할 강의가 없습니다.</p>
      <div class="control m-3">
        <a href="lecture_order.php" class="btn btn-primary" role="button">수강바구니로 이동</a>
      </div>
    </div>
  <?php } else { ?>
    <div class="row">
      <div class="col-9">
        <h5 class="font mt-3">주문 강의</h5>
        <hr>
        <table class="table">
          <thead>
            <tr class="visually-hidden">
              <th scope="col">커버이미지</th>
              <th scope="col">강의 정보</th>
              <th scope="col">강의 가격</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orderArr as $order) { ?>
              <tr>
                <td><img src="<?= $order->cover_image ?>" width="150" alt=""></td>
                <td><?= $order->title ?></td>
                <td><?= number_format($order->price) ?> 원</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <h5 class="font mt-4">주문자 정보</h5>
        <hr>
        <dl class="row">
          <dt class="col-3">이름</dt>
          <dd class="col-9"><?= $user_data->memName ?></dd>
          <dt class="col-3">이메일</dt>
          <dd class="col-9"><?= $user_data->memEmail ?></dd>
          <dt class="col-3">연락처</dt>
          <dd class="col-9">
            <input type="text" class="form-control" id="order_phone" value="<?= $membernum ?>" placeholder="숫자만 입력해주세요 (예: 01012345678)" maxlength="16">
            <small class="normal-font">결제를 진행하면 입력한 연락처가 회원정보에도 반영됩니다.</small>
          </dd>
        </dl>
      </div>

      <div class="col-3 payment">
        <dl>
          <dt>쿠폰</dt>
          <dd>
            <select class="form-select" name="coupon" id="coupon">
              <option value="0" selected>쿠폰 선택</option>
              <?php
              foreach ($couponArr as $coupon) {
                $price = 0;
                if ($coupon->coupon_type === 'fixed') {
                  $price = $coupon->coupon_price;
                } else {
                  $price = $coupon->coupon_ratio;
                }
              ?>
                <option value="<?= $coupon->ucid ?>" data-type="<?= $coupon->coupon_type ?>" data-price="<?= $price ?>"><?= $coupon->coupon_name ?> </option>
              <?php } ?>
            </select>
          </dd>
        </dl>
        <div class="d-flex justify-content-between">
          <span class="font">결제 금액</span><span class="normal-font total_payment"><?= number_format($total) ?> 원</span>
        </div>
        <div class="control m-3">
          <button type="button" class="payment_btn btn btn-primary w-100">결제하기</button>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<script src="https://js.tosspayments.com/v2/standard"></script>
<script>
  const tossClientKey = '<?= $toss_client_key ?>';
  const tossCustomerKey = 'qc_mem_<?= $memId ?>';
  const tossSuccessUrl = '<?= $toss_success_url ?>';
  const tossFailUrl = '<?= $toss_fail_url ?>';

  const orderLid = '<?= implode(',', $lidArr) ?>';
  const orderTotal = <?= (int) $total ?>;

  const paymentBtn = document.querySelector('.payment_btn');
  const coupon = document.querySelector('#coupon');
  const orderPhone = document.querySelector('#order_phone');

  // 천자리 마다 , 해주는 함수
  function numberFormat(number, thousandSeparator = ',') {
    const integerPart = Math.floor(number).toString(); // 정수 부분만 처리
    return integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);
  }

  // 쿠폰을 고르면 결제금액 표시를 바꾼다. 실제 금액은 서버에서 다시 계산한다
  if (coupon) {
    coupon.addEventListener('change', (e) => {
      const option = e.target.options[e.target.selectedIndex];
      const type = option.getAttribute('data-type');
      const value = Number(option.getAttribute('data-price'));
      let pay_price = orderTotal;
      if (e.target.value > 0) {
        if (type === 'fixed') {
          pay_price = orderTotal - value;
        } else {
          pay_price = orderTotal - Math.floor(orderTotal * value / 100);
        }
      }
      if (pay_price < 0) {
        pay_price = 0;
      }
      document.querySelector('.total_payment').innerText = numberFormat(pay_price) + ' 원';
    })
  }

  // 결제 준비를 요청하고, 주문이 만들어지면 토스 결제창을 띄운다
  if (paymentBtn) {
    paymentBtn.addEventListener('click', () => {
      const phone = orderPhone.value.replace(/[^0-9]/g, '');
      if (phone.length < 10) {
        alert('연락처를 정확히 입력해주세요.');
        orderPhone.focus();
        return;
      }

      const data = new URLSearchParams({
        lid: orderLid,
        ucid: coupon.value,
        phone: phone,
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
          if (result.status !== 'success') {
            alert(result.message);
            return;
          }
          const tossPayments = TossPayments(tossClientKey);
          const payment = tossPayments.payment({
            customerKey: tossCustomerKey,
          });
          payment.requestPayment({
            method: 'CARD',
            amount: {
              currency: 'KRW',
              value: Number(result.amount),
            },
            orderId: result.orderId,
            orderName: result.orderName,
            successUrl: tossSuccessUrl,
            failUrl: tossFailUrl,
            customerEmail: result.customerEmail,
            customerName: result.customerName,
            card: {
              useEscrow: false,
              flowMode: 'DEFAULT',
              useCardPoint: false,
              useAppCardOnly: false,
            },
          });
        })
        .catch(error => {
          console.error('Error:', error); // 네트워크나 JSON 변환 에러 처리
        });
    })
  }
</script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/qc/inc/footer.php');
?>

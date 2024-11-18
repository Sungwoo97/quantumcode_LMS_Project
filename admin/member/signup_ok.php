
<?php
include $_SERVER["DOCUMENT_ROOT"]."/inc/dbcon.php";




$userid=$_POST["userid"];
$username=$_POST["username"];
$email=$_POST["email"];
$passwd=$_POST["passwd"];
$passwd=hash('sha512',$passwd);




$sql="INSERT INTO members
        (userid, email, username, passwd)
        VALUES('".$userid."', '".$email."', '".$username."', '".$passwd."')";
$result=$mysqli->query($sql) or die($mysqli->error);




if($result){
    $query="select * from coupons where cid=1";//회원가입축하쿠폰
    $result2 = $mysqli->query($query) or die("query error => ".$mysqli->error);
    $rs = $result2->fetch_object();




    $last_date = date("Y-m-d 23:59:59", strtotime("+30 days")); //30일이 지나면 못쓴다. //strtotime 함수로 텍스트 시간을 unix타임스탬프로 변환
    $sql="INSERT INTO user_coupons
    (couponid, userid, status, use_max_date, regdate, reason)
    VALUES(".$rs->cid.", '".$userid."', 1, '".$last_date."', now(), '회원가입')";
    $ins=$mysqli->query($sql) or die($mysqli->error);




    echo "<script>alert('가입을 환영합니다. 10% 할인 쿠폰을 발행해 드렸습니다.');location.href='/pinkping/index.php';</script>";
    exit;
}else{
    echo "<script>alert('회원가입에 실패했습니다.');history.back();</script>";
    exit;
}


?>


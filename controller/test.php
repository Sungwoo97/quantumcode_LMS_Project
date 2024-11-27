<?php
session_start(); // 세션 시작

echo print_r($_SESSION);
// 세션의 모든 값을 출력
echo "<hr/>";

echo var_dump($_SESSION);

echo "<hr/>";

echo print_r($_SESSION['properties']);

echo "<hr/>";

echo print_r($_SESSION['kakao_account']);


echo "<hr/>";

// 배열내 특정 값 뽑아내는 방법
echo $_SESSION['kakao_account']->email;
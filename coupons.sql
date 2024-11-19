-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-19 02:12
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `quantumcode`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `coupons`
--

CREATE TABLE `coupons` (
  `cid` int(11) NOT NULL,
  `coupon_name` varchar(100) NOT NULL COMMENT '쿠폰명',
  `coupon_image` varchar(100) NOT NULL COMMENT '쿠폰이미지',
  `coupon_content` text NOT NULL COMMENT '쿠폰 설명',
  `coupon_type` varchar(100) NOT NULL COMMENT '쿠폰타입(fixed,percentage)',
  `coupon_price` double DEFAULT NULL COMMENT '할인금액',
  `coupon_ratio` double DEFAULT NULL COMMENT '할인비율',
  `status` tinyint(4) DEFAULT 0 COMMENT '활성화 상태',
  `startdate` datetime DEFAULT current_timestamp() COMMENT '등록일',
  `enddate` date NOT NULL COMMENT '만료일',
  `userid` varchar(100) DEFAULT NULL COMMENT '등록한유저'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `coupons`
--

INSERT INTO `coupons` (`cid`, `coupon_name`, `coupon_image`, `coupon_content`, `coupon_type`, `coupon_price`, `coupon_ratio`, `status`, `startdate`, `enddate`, `userid`) VALUES
(1, '프론트엔드 강의 10% 할인', '쿠폰_10%.jpg', '프론트엔드 강의 구매 시 10% 할인 적용', 'percentage', NULL, 10, 0, '2024-05-15 01:02:16', '2024-12-31', 'admin'),
(2, '첫 강의 무료 쿠폰', '쿠폰_무료.jpg', '신규 회원 첫 강의 무료 제공', 'fixed', 0, NULL, 1, '2024-11-03 01:02:16', '2025-01-01', 'user123'),
(3, '5만원 이상 구매 시 5천원 할인', '쿠폰_5천원.jpg', '5만원 이상 강의 구매 시 5천원 할인', 'fixed', 5000, NULL, 1, '2024-09-10 01:02:16', '2024-12-31', 'admin'),
(4, '백엔드 강의 패키지 15% 할인', '쿠폰_15%.jpg', '백엔드 강의 패키지에 대해 15% 할인', 'percentage', NULL, 15, 0, '2024-08-23 01:02:16', '2024-12-31', 'user456'),
(5, '데이터 사이언스 강의 할인', '쿠폰_1만원.jpg', '데이터 사이언스 강의에 대해 10,000원 할인', 'fixed', 10000, NULL, 1, '2024-06-27 01:02:16', '2025-02-28', 'user789'),
(6, '무료 체험 강의 제공', '쿠폰_무료.jpg', '특정 강의를 무료로 체험할 수 있는 쿠폰', 'fixed', 0, NULL, 1, '2024-09-25 01:02:16', '2025-01-31', 'guest'),
(7, '알고리즘 강의 20% 할인', '쿠폰_20%.jpg', '알고리즘 강의 수강료 20% 할인', 'percentage', NULL, 20, 1, '2024-09-22 01:02:16', '2024-12-15', 'admin'),
(8, 'AI 강의 패키지 할인', '쿠폰_30%.jpg', 'AI 강의 패키지 최대 30% 할인', 'percentage', NULL, 30, 1, '2024-04-18 01:02:16', '2025-03-31', 'user999'),
(9, '여름 시즌 강의 할인', '쿠폰_5%.jpg', '여름 동안 모든 강의 5% 할인', 'percentage', NULL, 5, 1, '2024-05-08 01:02:16', '2025-02-15', 'user123'),
(10, '초보자 전용 할인 쿠폰', '쿠폰_7천원.jpg', '초보자를 위한 기본 강의 7,000원 할인', 'fixed', 7000, NULL, 0, '2024-04-19 01:02:16', '2025-04-01', 'user001'),
(11, '풀스택 개발자 과정 10% 할인', '쿠폰_10%.jpg', '풀스택 개발자 과정을 10% 할인된 가격으로 제공', 'percentage', NULL, 10, 1, '2024-07-13 01:02:16', '2024-12-31', 'user002'),
(12, '강의 3개 이상 구매 시 20% 할인', '쿠폰_20%.jpg', '3개 이상의 강의를 구매 시 20% 할인', 'percentage', NULL, 20, 1, '2024-09-20 01:02:16', '2025-01-15', 'admin'),
(13, '리뷰 작성자 전용 쿠폰', '쿠폰_5천원.jpg', '강의 리뷰를 작성한 사용자에게 제공되는 5,000원 할인 쿠폰', 'fixed', 5000, NULL, 0, '2024-11-13 01:02:16', '2025-02-28', 'user003'),
(14, 'VIP 고객 감사 할인', '쿠폰_25%.jpg', 'VIP 고객 대상 25% 할인 쿠폰', 'percentage', NULL, 25, 1, '2024-01-10 01:02:16', '2025-03-31', 'user004'),
(15, '이벤트 참가자 쿠폰', '쿠폰_무료.jpg', '특별 이벤트 참가자에게 제공되는 강의 1개 무료 쿠폰', 'fixed', 0, NULL, 1, '2024-08-26 01:02:16', '2025-04-01', 'user005');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`cid`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `coupons`
--
ALTER TABLE `coupons`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

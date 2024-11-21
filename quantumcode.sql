-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-21 04:08
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
-- 테이블 구조 `admins`
--

CREATE TABLE `admins` (
  `idx` int(11) NOT NULL,
  `userid` varchar(145) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `username` varchar(145) DEFAULT NULL,
  `passwd` varchar(200) DEFAULT NULL,
  `regdate` datetime DEFAULT current_timestamp(),
  `level` tinyint(4) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `end_login_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `admins`
--

INSERT INTO `admins` (`idx`, `userid`, `email`, `username`, `passwd`, `regdate`, `level`, `last_login`, `end_login_date`) VALUES
(4, 'admin', 'admin@shop.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2023-01-01 17:12:32', 100, '2024-11-21 09:30:57', NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `board`
--

CREATE TABLE `board` (
  `pid` int(10) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(200) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `pw` int(50) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NULL DEFAULT NULL,
  `hit` int(11) DEFAULT 0,
  `likes` int(11) DEFAULT 0,
  `category` enum('notice','free','event','qna') NOT NULL,
  `img` varchar(255) NOT NULL,
  `is_img` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board`
--

INSERT INTO `board` (`pid`, `user_id`, `title`, `content`, `name`, `pw`, `date`, `updated_date`, `hit`, `likes`, `category`, `img`, `is_img`, `start_date`, `end_date`) VALUES
(1, NULL, '123123', '123123123', NULL, NULL, '2024-11-11 08:18:06', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(2, NULL, '', '', NULL, NULL, '2024-11-11 08:18:07', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(3, NULL, '', '', NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(4, NULL, '', '', NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(5, NULL, '', '', NULL, NULL, '2024-11-11 08:18:09', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(6, NULL, '', '', NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(7, NULL, '', '', NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(8, NULL, '', '', NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(9, NULL, '', '', NULL, NULL, '2024-11-11 08:18:28', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(10, NULL, '1111', '1111', NULL, NULL, '2024-11-11 08:18:42', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(11, NULL, '12312412', '1241231231', NULL, NULL, '2024-11-11 08:19:40', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(12, NULL, 'free', 'free', NULL, NULL, '2024-11-11 08:22:02', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(25, '', '하하', '아룡함니꺼', NULL, NULL, '2024-11-12 07:26:09', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(31, '', '공지1', '공지1', NULL, NULL, '2024-11-13 07:56:25', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(32, '', '자유1', '자유1', NULL, NULL, '2024-11-13 07:56:36', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(34, '', '질문1', '질문1', NULL, NULL, '2024-11-13 07:56:57', NULL, NULL, NULL, 'qna', '', NULL, NULL, NULL),
(35, '', '조회1', '조회1', NULL, NULL, '2024-11-13 08:18:18', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(39, '', '공지 추천1', '공지 추천1', NULL, NULL, '2024-11-13 08:53:47', NULL, 1, 5, 'notice', '', NULL, NULL, NULL),
(40, '', '질문 추천', '질문 추천', NULL, NULL, '2024-11-13 08:56:08', NULL, 1, 7, 'qna', '', NULL, NULL, NULL),
(41, '', '추천2', '추천2', NULL, NULL, '2024-11-13 08:58:07', NULL, 2, 3, 'notice', '', NULL, NULL, NULL),
(42, '', '99', '99', NULL, NULL, '2024-11-13 08:58:43', NULL, 1, 0, 'qna', '', NULL, NULL, NULL),
(43, '', '자유 추천', '자유 추천', NULL, NULL, '2024-11-13 09:00:12', NULL, 2, 3, 'free', '', NULL, NULL, NULL),
(44, '', '88', '88', NULL, NULL, '2024-11-13 09:02:03', NULL, 1, 5, 'free', '', NULL, NULL, NULL),
(45, '', '77', '77', NULL, NULL, '2024-11-13 09:03:06', NULL, 3, 5, 'notice', '', NULL, NULL, NULL),
(46, '', '66', '66', NULL, NULL, '2024-11-13 09:05:18', NULL, 2, 5, 'notice', '', NULL, NULL, NULL),
(47, '', '55', '55', NULL, NULL, '2024-11-13 09:07:32', NULL, 2, 3, 'notice', '', NULL, NULL, NULL),
(48, '', '11', '11', NULL, NULL, '2024-11-13 09:09:02', NULL, 3, 20, 'notice', '', NULL, NULL, NULL),
(49, '', '44', '44', NULL, NULL, '2024-11-13 09:10:51', NULL, 1, 2, 'qna', '', NULL, NULL, NULL),
(50, '', '11', '11', NULL, NULL, '2024-11-14 07:34:15', NULL, 0, 0, 'notice', '', NULL, NULL, NULL),
(51, '', '99', '99', NULL, NULL, '2024-11-14 07:34:44', NULL, 2, 0, 'notice', '', NULL, NULL, NULL),
(52, '', '11', '11', NULL, NULL, '2024-11-14 08:05:49', NULL, 1, 0, 'notice', '', NULL, NULL, NULL),
(53, '', '11', '11', NULL, NULL, '2024-11-14 08:15:00', NULL, 2, 0, 'free', '', NULL, NULL, NULL),
(54, '', '33', '33', NULL, NULL, '2024-11-14 08:16:01', NULL, 0, 0, 'qna', '', NULL, NULL, NULL),
(55, '', '222', '222', NULL, NULL, '2024-11-14 08:35:37', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(56, '', '666', '666', NULL, NULL, '2024-11-14 08:38:29', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(60, '', '1251515', '31461436143', NULL, NULL, '2024-11-14 09:08:33', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(61, NULL, '24', '15', NULL, NULL, '2024-11-17 12:42:14', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(62, NULL, '24', '15', NULL, NULL, '2024-11-17 12:44:06', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(90, NULL, '이미지', '이미지', NULL, NULL, '2024-11-18 04:19:54', NULL, 1, 0, 'free', './upload/logo2.png', 1, NULL, NULL),
(91, NULL, '1123', '23232', NULL, NULL, '2024-11-18 05:52:09', NULL, 1, 0, 'notice', './upload/', 0, NULL, NULL),
(92, NULL, '1', '1', NULL, NULL, '2024-11-18 05:59:29', NULL, 1, 0, 'notice', './upload/qqq.jpg', 1, NULL, NULL),
(93, NULL, '22', '22', NULL, NULL, '2024-11-18 06:05:18', NULL, 2, 0, 'free', './upload/', 0, NULL, NULL),
(94, NULL, 'ㅅㅁㄼ11243', 'ㅈㅂㄷㅂ11253', NULL, NULL, '2024-11-18 06:12:20', NULL, 2, 0, 'qna', './upload/qqq2.png', 1, NULL, NULL),
(95, NULL, '123456789123456789', 'ㅁㄹㄴㅁㄻㄹㄴㅁ', NULL, NULL, '2024-11-18 07:21:18', NULL, 1, 0, 'free', './upload/', 0, NULL, NULL),
(96, NULL, '123456789ㅂㅈㄷㅂ', 'ㅂㅈㅈㅂ', NULL, NULL, '2024-11-18 07:22:23', NULL, 3, 0, 'notice', './upload/', 0, NULL, NULL),
(101, NULL, '11', '11', NULL, NULL, '2024-11-19 01:08:32', NULL, 2, 1, 'notice', './upload/qqq3.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 'kwak', '강사 이미지123456', '강사 이미지123456', NULL, NULL, '2024-11-20 04:01:16', NULL, 6, 3, 'notice', '/qc/admin/board/upload/1732080377_qqq.jpg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'admin', '관리자 뚱마루', '관리자 뚱마루', NULL, NULL, '2024-11-20 04:02:28', NULL, 4, 2, 'notice', '/qc/admin/board/upload/1732075348_qqq4.jpg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'admin', '이벤트2', '이벤트2', NULL, NULL, '2024-11-20 04:06:24', NULL, 4, 0, 'event', '/qc/admin/board/upload/1732075584_qqq2.png', 1, '2024-11-20 00:00:00', '2024-11-23 00:00:00'),
(106, 'admin', '이벤트3', '이벤트3', NULL, NULL, '2024-11-20 04:06:44', NULL, 4, 0, 'event', '/qc/admin/board/upload/1732075604_qqq3.png', 1, '2024-11-20 00:00:00', '2024-11-30 00:00:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `board_like`
--

CREATE TABLE `board_like` (
  `pid` int(11) NOT NULL,
  `l_pid` int(11) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_like`
--

INSERT INTO `board_like` (`pid`, `l_pid`, `user_id`) VALUES
(1, 102, 'admin');

-- --------------------------------------------------------

--
-- 테이블 구조 `board_reply`
--

CREATE TABLE `board_reply` (
  `pid` int(11) NOT NULL,
  `b_pid` int(11) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `pw` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_reply`
--

INSERT INTO `board_reply` (`pid`, `b_pid`, `user_id`, `pw`, `content`, `date`) VALUES
(1, 59, '', '', '     1234411', '2024-11-16 22:54:46'),
(2, 59, '', '', ' 1231231111', '2024-11-16 22:54:50'),
(3, 59, '', '', ' 1231231111', '2024-11-16 22:56:24'),
(4, 59, '', '', ' 1231231111', '2024-11-16 22:56:24'),
(5, 59, '', '', ' 1231231111', '2024-11-16 22:56:25'),
(6, 59, '', '', ' 1231231111', '2024-11-16 22:56:25'),
(7, 59, '', '', ' 1231231111', '2024-11-16 22:56:29'),
(8, 59, '', '', ' 1231231111', '2024-11-16 22:57:41'),
(9, 59, '', '', ' 1231231111', '2024-11-16 22:57:42'),
(11, 59, '', '', ' 1231231111', '2024-11-16 23:22:13'),
(12, 37, '', '', ' 1231231111', '2024-11-16 23:28:50'),
(13, 59, '', '', ' 1231231111', '2024-11-17 00:10:07'),
(14, 59, '', '', ' 1231231111', '2024-11-17 00:10:33'),
(15, 59, '', '', ' 1231231111', '2024-11-17 00:10:57'),
(16, 38, '', '', '이벤트 추천11', '2024-11-17 00:33:31'),
(18, 58, '', '', ' 11111', '2024-11-17 00:41:40'),
(19, 59, '', '', ' 1122', '2024-11-17 00:46:41'),
(20, 58, '', '', '1111', '2024-11-18 12:43:06'),
(21, 102, 'kwak', '', '강사 댓글', '2024-11-20 13:01:28'),
(23, 103, 'admin', '', '관리자 댓글', '2024-11-20 13:02:37'),
(24, 103, 'kwak', '', '강사 댓글', '2024-11-20 13:03:21'),
(25, 102, 'admin', '', ' ㅎㅇㅎㅇ11', '2024-11-20 17:15:33'),
(26, 102, 'admin', '', 'ㅎㅇㅎㅇ', '2024-11-20 17:42:10'),
(27, 102, 'admin', '', '11', '2024-11-20 17:42:29'),
(28, 102, 'admin', '', 'ㅎㅇ', '2024-11-20 17:48:56');

-- --------------------------------------------------------

--
-- 테이블 구조 `board_re_reply`
--

CREATE TABLE `board_re_reply` (
  `pid` int(11) NOT NULL,
  `r_pid` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_re_reply`
--

INSERT INTO `board_re_reply` (`pid`, `r_pid`, `user_id`, `content`, `date`) VALUES
(26, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:12'),
(27, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:13'),
(28, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:13'),
(29, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:13'),
(30, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:14'),
(31, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:14'),
(32, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:14'),
(33, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:14'),
(34, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:18'),
(35, 22, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:56:37'),
(36, 102, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:58:29'),
(37, 102, 'admin', 'ㅎㅇㅎㅇ', '2024-11-20 07:59:38'),
(38, 102, 'admin', 'ㅎㅇ3', '2024-11-20 09:14:38'),
(39, 102, 'admin', 'ㅎㅇ3', '2024-11-20 09:14:48'),
(40, 102, 'admin', 'ㅁㄴㅇㄴㅁㅇ', '2024-11-21 01:03:39'),
(41, 102, 'admin', 'ㅎㅇㅎㅇ', '2024-11-21 01:05:40'),
(42, 29, 'admin', 'ㅎㅇㅎㅇ', '2024-11-21 01:16:17'),
(44, 28, 'admin', 'ㅎㅇㅎ2', '2024-11-21 01:18:23'),
(47, 30, 'admin', 'ㅎㅇ3', '2024-11-21 02:01:08'),
(48, 29, 'admin', '헬로우', '2024-11-21 02:07:14');

-- --------------------------------------------------------

--
-- 테이블 구조 `coupons`
--

CREATE TABLE `coupons` (
  `cid` int(11) NOT NULL,
  `coupon_name` varchar(100) NOT NULL COMMENT '쿠폰명',
  `coupon_image` varchar(100) NOT NULL COMMENT '쿠폰이미지',
  `coupon_content` text NOT NULL COMMENT '쿠폰 설명',
  `coupon_type` varchar(100) NOT NULL COMMENT '쿠폰타입(정액,정률)',
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
(1, '프론트엔드 강의 10% 할인', '/qc/admin/upload/20241120084829512142.png', '프론트엔드 강의 구매 시 10% 할인 적용', 'percentage', 0, 10, 1, '2024-09-11 00:00:00', '2025-02-06', 'admin'),
(2, '첫 강의 무료 쿠폰', '/qc/admin/upload/20241120084958134303.png', '신규 회원 첫 강의 무료 제공', 'percentage', 0, 100, 1, '2023-01-20 00:00:00', '2095-12-31', 'admin'),
(3, '5만원 이상 구매 시 5천원 할인', '/qc/admin/upload/20241120085051148019.png', '5만원 이상 구매 시 5천원 할인', 'fixed', 5000, 0, 1, '2023-01-20 00:00:00', '2024-12-07', 'admin'),
(4, '백엔드 강의 패키지 15% 할인', '/qc/admin/upload/20241120085116476668.png', '백엔드 강의 패키지에 대해 15% 할인', 'percentage', 0, 15, 1, '2024-11-13 00:00:00', '2024-11-27', 'admin'),
(5, '데이터 사이언스 강의 할인', '/qc/admin/upload/20241120085143832055.png', '데이터 사이언스 강의에 대해 10,000원 할인', 'fixed', 10000, 0, 0, '2024-07-29 00:00:00', '2024-10-31', 'admin'),
(6, '무료 체험 강의 제공', '/qc/admin/upload/20241120085218187242.png', '특정 강의를 무료로 체험할 수 있는 쿠폰', 'percentage', 0, 100, 1, '2024-11-01 00:00:00', '2024-11-30', 'admin'),
(7, '알고리즘 강의 20% 할인', '/qc/admin/upload/20241120085251119634.png', '알고리즘 강의 수강료 20% 할인', 'percentage', 0, 20, 0, '2024-11-09 00:00:00', '2025-01-21', 'admin'),
(8, 'AI 강의 패키지 할인', '/qc/admin/upload/20241120085326172682.png', 'AI 강의 패키지 최대 30% 할인', 'percentage', 0, 30, 1, '2024-09-05 00:00:00', '2024-12-24', 'admin'),
(9, '여름 시즌 강의 할인', '/qc/admin/upload/20241120085404158672.png', '여름 동안 모든 강의 5% 할인', 'percentage', 0, 5, 0, '2024-07-01 00:00:00', '2024-09-30', 'admin'),
(10, '초보자 전용 할인 쿠폰', '/qc/admin/upload/20241120085440136439.png', '초보자를 위한 기본 강의 7,000원 할인', 'fixed', 7000, 0, 0, '2024-10-31 00:00:00', '2024-12-03', 'admin');

-- --------------------------------------------------------

--
-- 테이블 구조 `coupons_usercp`
--

CREATE TABLE `coupons_usercp` (
  `ucid` int(11) NOT NULL,
  `couponid` int(11) NOT NULL COMMENT '쿠폰아이디',
  `userid` varchar(100) NOT NULL COMMENT '유저아이디',
  `status` int(11) DEFAULT 1 COMMENT '상태',
  `use_max_date` datetime DEFAULT NULL COMMENT '만료일',
  `regdate` datetime DEFAULT current_timestamp() COMMENT '발급일',
  `usedate` date DEFAULT NULL COMMENT '사용일',
  `reason` varchar(100) NOT NULL COMMENT '쿠폰사용강의'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `coupons_usercp`
--

INSERT INTO `coupons_usercp` (`ucid`, `couponid`, `userid`, `status`, `use_max_date`, `regdate`, `usedate`, `reason`) VALUES
(1, 1, 'user1', 1, '2025-12-31 23:59:59', '2024-11-18 15:31:50', NULL, 'Python 기초 강의'),
(2, 2, 'user2', 0, '2024-11-30 23:59:59', '2024-11-18 15:31:50', '2024-11-15', 'JavaScript 심화 과정'),
(3, 3, 'user3', 1, '2025-06-30 23:59:59', '2024-11-18 15:31:50', NULL, 'HTML/CSS 기초'),
(4, 4, 'user4', 1, '2024-12-25 23:59:59', '2024-11-18 15:31:50', NULL, 'React 기본 강의'),
(5, 5, 'user5', 0, '2025-01-15 23:59:59', '2024-11-18 15:31:50', '2025-01-10', 'Node.js 프로그래밍'),
(6, 6, 'user6', 1, '2025-03-31 23:59:59', '2024-11-18 15:31:50', NULL, 'Spring Boot 실습'),
(7, 7, 'user7', 0, '2024-12-31 23:59:59', '2024-11-18 15:31:50', '2024-12-20', 'Vue.js 입문'),
(8, 8, 'user8', 1, '2025-02-14 23:59:59', '2024-11-18 15:31:50', NULL, 'SQL 데이터베이스 기초'),
(9, 9, 'user9', 0, '2025-07-31 23:59:59', '2024-11-18 15:31:50', '2025-07-15', 'Docker 활용'),
(10, 10, 'user10', 1, '2025-05-01 23:59:59', '2024-11-18 15:31:50', NULL, 'Java 고급 프로그래밍'),
(11, 11, 'user11', 1, '2025-08-31 23:59:59', '2024-11-18 15:31:50', NULL, 'C++ 알고리즘'),
(12, 12, 'user12', 0, '2024-12-01 23:59:59', '2024-11-18 15:31:50', '2024-11-28', 'Git/GitHub 실습'),
(13, 13, 'user13', 1, '2025-02-28 23:59:59', '2024-11-18 15:31:50', NULL, 'Python 데이터 분석'),
(14, 14, 'user14', 1, '2024-11-27 23:59:59', '2024-11-18 15:31:50', NULL, 'Kotlin 개발'),
(15, 15, 'user15', 0, '2025-10-31 23:59:59', '2024-11-18 15:31:50', '2025-10-15', 'Android 앱 개발'),
(16, 16, 'user16', 1, '2024-12-31 23:59:59', '2024-11-18 15:31:50', NULL, 'AWS 클라우드 기초'),
(17, 17, 'user17', 0, '2025-03-15 23:59:59', '2024-11-18 15:31:50', '2025-03-05', 'TypeScript 입문'),
(18, 18, 'user18', 1, '2024-12-20 23:59:59', '2024-11-18 15:31:50', NULL, 'Data Science 강의'),
(19, 19, 'user19', 1, '2025-09-30 23:59:59', '2024-11-18 15:31:50', NULL, 'Machine Learning 기본'),
(20, 20, 'user20', 0, '2025-04-30 23:59:59', '2024-11-18 15:31:50', '2025-04-20', 'GraphQL 실습'),
(21, 21, 'user21', 1, '2025-05-31 23:59:59', '2024-11-18 15:31:50', NULL, 'React Native 개발'),
(22, 22, 'user22', 1, '2025-07-15 23:59:59', '2024-11-18 15:31:50', NULL, 'Go 언어 기초'),
(23, 23, 'user23', 1, '2025-11-30 23:59:59', '2024-11-18 15:31:50', NULL, 'Swift 프로그래밍'),
(24, 24, 'user24', 0, '2025-12-31 23:59:59', '2024-11-18 15:31:50', '2025-12-20', 'Flutter 앱 개발'),
(25, 25, 'user25', 1, '2024-10-31 23:59:59', '2024-11-18 15:31:50', NULL, 'Unity 게임 개발');

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_category`
--

CREATE TABLE `lecture_category` (
  `lcid` int(11) NOT NULL COMMENT '카테고리 고유번호',
  `code` varchar(20) NOT NULL COMMENT '카테고리코드',
  `pcode` varchar(20) DEFAULT NULL COMMENT '카테고리 부모코드',
  `ppcode` varchar(20) DEFAULT NULL COMMENT '카테고리 최상위 코드',
  `name` varchar(100) NOT NULL COMMENT '카테고리 이름',
  `step` tinyint(4) NOT NULL COMMENT '카테고리 분류 단계'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 카테고리';

--
-- 테이블의 덤프 데이터 `lecture_category`
--

INSERT INTO `lecture_category` (`lcid`, `code`, `pcode`, `ppcode`, `name`, `step`) VALUES
(23, 'A0001', '', '', 'Web', 1),
(24, 'A0002', '', '', 'App', 1),
(25, 'B0001', 'A0001', '', 'Front', 2),
(26, 'B0002', 'A0001', '', 'Back', 2),
(27, 'B0001', 'A0002', '', 'dev', 2),
(36, 'C0001', 'B0001', 'A0001', 'html', 3),
(37, 'C0002', 'B0001', 'A0001', 'CSS', 3),
(38, 'C0003', 'B0001', 'A0002', 'java', 3),
(39, 'C0001', 'B0002', 'A0001', 'react', 3),
(40, 'C0004', 'B0001', 'A0001', 'javascript', 3),
(41, 'A0003', '', '', 'test', 1),
(42, 'B0001', 'A0003', '', 'test', 2),
(44, 'A0004', '', '', 'test', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_data`
--

CREATE TABLE `lecture_data` (
  `lid` int(11) NOT NULL,
  `lecture_completion` int(10) NOT NULL,
  `lecture_name` varchar(50) NOT NULL,
  `lecture_time` time NOT NULL,
  `lecture_number` int(20) NOT NULL,
  `lecture_date` int(20) NOT NULL,
  `lecture_avgwatch` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `lecture_data`
--

INSERT INTO `lecture_data` (`lid`, `lecture_completion`, `lecture_name`, `lecture_time`, `lecture_number`, `lecture_date`, `lecture_avgwatch`) VALUES
(4, 80, '웹 프론트엔드를 위한 자바스크립트', '02:40:00', 12, 2, '02:40:00'),
(5, 60, '만들면서 배우는 리액트', '06:25:00', 41, 7, '05:40:00'),
(6, 50, '코어 자바스크립트', '04:32:00', 24, 4, '02:40:00'),
(7, 75, '웹의 탄생, HTML의 탄생과 기초', '01:06:00', 6, 1, '00:40:00'),
(8, 66, 'React 공식문서 공부하기', '02:11:00', 10, 2, '01:59:00'),
(9, 78, 'Vue.js 시작하기', '03:55:00', 20, 5, '03:40:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_list`
--

CREATE TABLE `lecture_list` (
  `lid` int(11) NOT NULL COMMENT '강의 고유번호',
  `category` varchar(100) NOT NULL COMMENT '강의 카테고리',
  `lcid` int(11) DEFAULT NULL COMMENT '카테고리 고유 아이디',
  `title` varchar(500) NOT NULL COMMENT '강의 제목',
  `cover_image` varchar(100) DEFAULT NULL COMMENT '강의 커버 이미지',
  `t_id` varchar(100) NOT NULL COMMENT '강사이름',
  `isfree` tinyint(4) NOT NULL COMMENT '무료강의',
  `ispremium` tinyint(4) NOT NULL COMMENT '프리미엄강의',
  `ispopular` tinyint(4) NOT NULL COMMENT '인기강의',
  `isrecom` tinyint(4) NOT NULL COMMENT '추천강의',
  `tuition` int(50) NOT NULL COMMENT '수강료',
  `dis_tuition` int(50) DEFAULT NULL COMMENT '할인 수강료',
  `regist_day` date NOT NULL COMMENT '수강시작일',
  `expiration_day` date DEFAULT NULL COMMENT '수강마감일',
  `sub_title` varchar(250) DEFAULT NULL COMMENT '강의 요약',
  `description` text NOT NULL COMMENT '강의 설명',
  `learning_obj` text DEFAULT NULL COMMENT '강의 목표',
  `difficult` varchar(11) NOT NULL COMMENT '난이도',
  `lecture_tag` varchar(250) DEFAULT NULL COMMENT '강의관련 스킬',
  `pr_video` varchar(100) DEFAULT NULL COMMENT '홍보 영상',
  `regdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '작성시간',
  `status` tinyint(4) NOT NULL COMMENT '상태',
  `student_count` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 목록 테이블';

--
-- 테이블의 덤프 데이터 `lecture_list`
--

INSERT INTO `lecture_list` (`lid`, `category`, `lcid`, `title`, `cover_image`, `t_id`, `isfree`, `ispremium`, `ispopular`, `isrecom`, `tuition`, `dis_tuition`, `regist_day`, `expiration_day`, `sub_title`, `description`, `learning_obj`, `difficult`, `lecture_tag`, `pr_video`, `regdate`, `status`, `student_count`) VALUES
(30, 'A0001B0001C0001', 36, '관리자가 등록한 강의', '/qc/admin/upload/20241119042317924625.png', 'admin', 0, 0, 0, 1, 1000, 1000, '2024-11-11', '2025-02-11', 'test', '<p>test</p>', '', '1', '', 'Array', '2024-11-19 12:23:17', 0, 80),
(31, 'A0001B0001C0001', 36, '곽튜브와 함께 하는 css강좌', '/qc/admin/upload/20241119085758118186.png', 'kwak', 0, 0, 0, 1, 100000, 10000, '2024-11-01', '2025-02-01', '여행가듯 가르치는 강사', '<p>초보자를 위한 css html 강의!</p>', '', '1', '', 'Array', '2024-11-19 16:57:58', 0, 48),
(32, 'A0001B0001C0004', 40, '곽튜브와 함께하는 react 여행', '/qc/admin/upload/20241119085915834304.png', 'kwak', 0, 1, 0, 0, 150000, 15000, '2024-11-02', '2025-02-02', '곽튜브와 함께하는 신나는 리액트 여행', '<p>곽튜브와 함께하는 신나는 리액트 여행</p>', '', '2', '', 'Array', '2024-11-19 16:59:15', 0, 55),
(33, 'A0001B0001C0004', 40, '곽샘과 함께하는 신나는 자바스크립트 여행', '/qc/admin/upload/20241119090036113948.png', 'kwak', 0, 0, 0, 1, 1000000, 10000, '2024-10-18', '2025-01-18', '평생 무료로 1:1 멘토링까지 해주는 강의', '<p>평생 무료로 1:1 멘토링까지 해주는 강의</p>', '', '1', '', 'Array', '2024-11-19 17:00:36', 0, 65),
(34, 'A0001B0002C0001', 39, '곽샘과 함께하는 mysql', '/qc/admin/upload/20241119095514163495.jpg', 'kwak', 0, 0, 0, 1, 100000, 100000, '2024-11-04', '2025-02-04', '즐거운 mysql 여행', '<p>즐거운 mysql 코딩여행</p>', '', '3', '', 'Array', '2024-11-19 17:55:14', 0, 15),
(35, 'A0001B0001C0001', 36, '승제샘과 함께하는 자바스크립트', '/qc/admin/upload/20241120045238464976.png', 'jungsungjae', 0, 0, 0, 1, 150000, 10000, '2024-11-03', '2025-02-03', '승제샘과 함께하는 자바스크립트', '<p>승제샘과 함께하는 자바스크립트</p>', '', '1', '', 'Array', '2024-11-20 12:52:38', 0, 24),
(36, 'A0001B0001C0004', 40, '우진샘과 함께하는 자바스크립트', '/qc/admin/upload/20241120045400399893.png', 'hyunwonjun', 0, 0, 1, 0, 100000, 10000, '2024-09-10', '2024-12-10', '우진샘과 함께하는 자바스크립트', '<p>우진샘과 함께하는 자바스크립트</p>', '', '2', '', 'Array', '2024-11-20 12:54:00', 0, 29),
(37, 'A0001B0001C0004', 40, '해원샘과 함께하는 타입스크립트', '/qc/admin/upload/20241120045459689237.jpg', 'ohhaewon', 0, 0, 1, 0, 100000, 10000, '2024-08-21', '2024-11-21', '해원샘과 함께하는 타입스크립트', '<p>해원샘과 함께하는 타입스크립트</p>', '', '2', '', 'Array', '2024-11-20 12:54:59', 0, 33),
(38, 'A0001B0002C0001', 39, '희진샘과 함께하는 신나는 리액트', '/qc/admin/upload/20241120045611111539.png', 'minheejin', 0, 0, 0, 1, 100000, 10000, '2024-09-11', '2024-12-11', '희진샘과 함께하는 신나는 리액트', '<p>희진샘과 함께하는 신나는 리액트</p>', '', '1', '', 'Array', '2024-11-20 12:56:11', 0, 39),
(39, 'A0002B0001C0003', 38, '설민석의 nodejs', '/qc/admin/upload/20241120045754906860.png', 'sulminsuk', 0, 0, 0, 1, 123123, 10000, '2024-07-17', '2024-10-17', '설민석의 nodejs', '<p>설민석의 nodejs</p>', '', '1', '', 'Array', '2024-11-20 12:57:54', 0, 44),
(40, 'A0001B0002C0001', 39, '설민석의 mysql', '/qc/admin/upload/20241120045823750741.jpg', 'sulminsuk', 0, 0, 1, 0, 100000, 10000, '2023-06-20', '2023-09-20', '설민석의 nodejs', '<p>설민석의 nodejs</p>', '', '1', '', 'Array', '2024-11-20 12:58:23', 0, 23),
(41, 'A0001B0002C0001', 39, '자바스크립트', '/qc/admin/upload/20241120050013976917.png', 'kangdongwon', 0, 0, 0, 1, 100000, 10000, '2024-11-19', '2025-02-19', '자바스크립트', '<p>자바스크립트</p>', '', '2', '', 'Array', '2024-11-20 13:00:13', 0, 67),
(42, 'A0002B0001C0003', 38, 'go언어 고수 되는 방법', '/qc/admin/upload/20241120050112128854.png', 'kwondohyung', 0, 0, 0, 1, 150000, 10000, '2024-10-22', '2025-01-22', 'go언어 고수 되는 방법', '<p>go언어 고수 되는 방법</p>', '', '1', '', 'Array', '2024-11-20 13:01:12', 0, 51),
(43, 'A0001B0001C0002', 37, '빠니와 함께하는 css여행', '/qc/admin/upload/20241120050222832118.png', 'panibottle', 0, 0, 1, 0, 200000, 10000, '2024-09-18', '2024-12-18', '빠니와 함께하는 css여행', '<p>빠니와 함께하는 css여행</p>', '', '1', '', 'Array', '2024-11-20 13:02:22', 0, 31),
(44, 'A0001B0001C0001', 36, '지현샘과 함께하는 c++', '/qc/admin/upload/20241120050628168178.png', 'admin', 0, 0, 0, 1, 250000, 10000, '2024-07-16', '2024-10-16', '지현샘과 함께하는 c++', '<p>지현샘과 함께하는 c++</p>', '', '2', '', 'Array', '2024-11-20 13:06:28', 0, 10),
(45, 'A0001B0001C0001', 36, '손석구와 파이썬', '/qc/admin/upload/20241120050715385295.jpg', 'sonsuk9', 0, 0, 1, 0, 100000, 10000, '2024-09-17', '2024-12-17', '손석구와 파이썬', '<p>손석구와 파이썬</p>', '', '1', '', 'Array', '2024-11-20 13:07:15', 0, 11),
(46, 'A0001B0001C0002', 37, 'css정석', '/qc/admin/upload/20241120050804419880.png', 'sinsungbum', 0, 0, 1, 0, 200000, 15000, '2024-09-17', '2024-12-17', 'css정석', '<p>css정석</p>', '', '2', '', 'Array', '2024-11-20 13:08:04', 0, 41),
(47, 'A0001B0002C0001', 39, '맛있는 자바', '/qc/admin/upload/20241120050836844794.png', 'mrahn', 0, 0, 1, 0, 100000, 10000, '2024-10-30', '2025-01-30', '맛있는 자바', '<p>맛있는 자바</p>', '', '2', '', 'Array', '2024-11-20 13:08:36', 0, 18),
(48, 'A0001B0002C0001', 39, '차갑게 배우는 리액트', '/qc/admin/upload/20241120050923524575.png', 'lucas', 0, 0, 1, 0, 100000, 10000, '2024-11-19', '2025-02-19', '차갑게 배우는 리액트', '<p>차갑게 배우는 리액트</p>', '', '3', '', 'Array', '2024-11-20 13:09:23', 0, 41),
(49, 'A0001B0001C0001', 36, '미미미누와 같이 파이썬 공부하기', '/qc/admin/upload/20241120051030144009.jpg', 'mimiminu', 0, 0, 1, 0, 25000, 1000, '2024-10-24', '2025-01-24', '미미미누와 같이 파이썬 공부하기', '<p>미미미누와 같이 파이썬 공부하기</p>', '', '1', '', 'Array', '2024-11-20 13:10:30', 0, 63),
(50, 'A0001B0001C0001', 36, '세아샘과 함께하는 자바스크립트', '/qc/admin/upload/20241120051201391962.png', 'yoonsaeah', 0, 0, 0, 1, 100000, 10000, '2024-08-28', '2024-11-28', '세아샘과 함께하는 자바스크립트', '<p>세아샘과 함께하는 자바스크립트</p>', '', '1', '', 'Array', '2024-11-20 13:12:01', 0, 48),
(51, 'A0001B0002C0001', 39, '기상과 함께하는 노드js', '/qc/admin/upload/20241120051301127737.png', 'wakeup', 0, 0, 0, 1, 145000, 15000, '2024-08-21', '2024-11-21', '기상과 함께하는 노드js', '<p>기상과 함께하는 노드js</p>', '', '1', '', 'Array', '2024-11-20 13:13:01', 0, 49),
(52, 'A0001B0001C0001', 36, '기상샘과 함께하는 파이썬 여행', '/qc/admin/upload/20241120051342146639.jpg', 'wakeup', 0, 0, 0, 0, 254600, 10000, '2024-11-20', '2025-02-20', '기상샘과 함께하는 파이썬 여행', '<p>기상샘과 함께하는 파이썬 여행</p>', '', '1', '', 'Array', '2024-11-20 13:13:42', 0, 76),
(53, 'A0001B0001C0001', 36, '동진샘과 함께하는 mysql', '/qc/admin/upload/20241120051431211298.jpg', 'dongjin', 0, 0, 0, 0, 325000, 25000, '2024-05-22', '2024-08-22', '동진샘과 함께하는 mysql', '<p>동진샘과 함께하는 mysql</p>', '', '1', '', 'Array', '2024-11-20 13:14:31', 0, 112),
(54, 'A0001B0001C0001', 36, '지영샘과 함께하는 리액트 마스터', '/qc/admin/upload/20241120051508184740.png', 'easyyoung', 0, 0, 0, 1, 200000, 10000, '2024-05-14', '2024-08-14', '지영샘과 함께하는 리액트 마스터', '<p>지영샘과 함께하는 리액트 마스터</p>', '', '1', '', 'Array', '2024-11-20 13:15:08', 0, 89),
(55, 'A0001B0002C0001', 39, '지영샘과 함께하는 go 마스터', '/qc/admin/upload/20241120051530137373.png', 'easyyoung', 0, 0, 0, 1, 100000, 10000, '2024-07-09', '2024-10-09', '지영샘과 함께하는 go 마스터', '<p>지영샘과 함께하는 go 마스터</p>', '', '1', '', 'Array', '2024-11-20 13:15:30', 0, NULL),
(56, 'A0001B0002C0001', 39, '장윤정의 java마스터', '/qc/admin/upload/20241120051614750313.png', 'yoonjunng', 0, 0, 0, 1, 100000, 10000, '2024-08-21', '2024-11-21', '장윤정의 java마스터', '<p>장윤정의 java마스터</p>', '', '2', '', 'Array', '2024-11-20 13:16:14', 0, NULL),
(58, 'A0001B0001C0001', 36, '풀스택을 노려보아요 - 수정', '/qc/admin/upload/20241120204752200453.png', 'admin', 0, 1, 0, 0, 10000, 0, '2024-11-20', '2025-02-20', '요요', '<p>설설</p>', '', '5', '', 'Array', '2024-11-21 04:47:52', 0, NULL),
(59, 'A0002B0001C0003', 38, '강의강의', '/qc/admin/upload/20241120210203184454.png', 'admin', 0, 1, 0, 0, 1000, 0, '2024-11-21', '2025-02-21', '요약', '<p>설명</p>', 'ㅇㅇ', '3', 'ㅇㅇ', '/qc/admin/upload/20241120210203101228.mp4', '2024-11-21 05:02:03', 0, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_video`
--

CREATE TABLE `lecture_video` (
  `lvid` int(11) NOT NULL COMMENT '강의영상 고유번호',
  `lid` int(11) NOT NULL COMMENT '연결된 강의 고유번호',
  `t_id` varchar(20) NOT NULL,
  `video_lecture` varchar(100) NOT NULL COMMENT '강의 영상 파일경로',
  `video_desc` text DEFAULT NULL COMMENT '강의 설명',
  `regdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '등록 시간'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 영상 테이블';

--
-- 테이블의 덤프 데이터 `lecture_video`
--

INSERT INTO `lecture_video` (`lvid`, `lid`, `t_id`, `video_lecture`, `video_desc`, `regdate`) VALUES
(4, 0, 'admin', '/qc/admin/upload/20241120043618208750.mp4', NULL, '2024-11-20 12:36:18'),
(5, 0, 'admin', '/qc/admin/upload/20241120043618151080.mp4', NULL, '2024-11-20 12:36:18'),
(6, 0, 'admin', '/qc/admin/upload/20241120044508959883.mp4', NULL, '2024-11-20 12:45:08'),
(7, 0, 'admin', '/qc/admin/upload/20241120044508183600.mp4', NULL, '2024-11-20 12:45:08'),
(8, 8, 'admin', '/qc/admin/upload/20241120050607919383.mp4', NULL, '2024-11-20 13:06:07'),
(9, 8, 'admin', '/qc/admin/upload/20241120050607107252.mp4', NULL, '2024-11-20 13:06:07'),
(10, 9, 'admin', '/qc/admin/upload/20241120065159208654.mp4', NULL, '2024-11-20 14:51:59'),
(11, 9, 'admin', '/qc/admin/upload/20241120065159195847.mp4', NULL, '2024-11-20 14:51:59'),
(12, 59, 'admin', '/qc/admin/upload/20241120210201194896.mp4', NULL, '2024-11-21 05:02:01'),
(13, 59, 'admin', '/qc/admin/upload/20241120210201958783.mp4', NULL, '2024-11-21 05:02:01');

-- --------------------------------------------------------

--
-- 테이블 구조 `members`
--

CREATE TABLE `members` (
  `mid` int(15) NOT NULL,
  `name` varchar(111) NOT NULL,
  `id` varchar(45) NOT NULL,
  `birth` date NOT NULL,
  `password` varchar(222) NOT NULL,
  `email` varchar(45) NOT NULL,
  `number` int(25) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `member_detail` text DEFAULT NULL,
  `cover_image` varchar(111) DEFAULT NULL,
  `grade` int(11) NOT NULL,
  `progress` double DEFAULT NULL,
  `last_login` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `sales_course`
--

CREATE TABLE `sales_course` (
  `scid` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `month` varchar(20) NOT NULL,
  `sales` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `sales_course`
--

INSERT INTO `sales_course` (`scid`, `course_name`, `month`, `sales`) VALUES
(1, 'React', '1월', 220000),
(2, 'React', '2월', 130000),
(3, 'React', '3월', 120000),
(4, 'React', '4월', 160000),
(5, 'React', '5월', 140000),
(6, 'React', '6월', 180000),
(7, 'React', '7월', 220000),
(8, 'React', '8월', 190000),
(9, 'React', '9월', 250000),
(10, 'React', '10월', 240000),
(11, 'React', '11월', 220000),
(12, 'React', '12월', 300000),
(13, 'JavaScript', '1월', 80000),
(14, 'JavaScript', '2월', 110000),
(15, 'JavaScript', '3월', 100000),
(16, 'JavaScript', '4월', 90000),
(17, 'JavaScript', '5월', 120000),
(18, 'JavaScript', '6월', 140000),
(19, 'JavaScript', '7월', 150000),
(20, 'JavaScript', '8월', 180000),
(21, 'JavaScript', '9월', 170000),
(22, 'JavaScript', '10월', 90000),
(23, 'JavaScript', '11월', 210000),
(24, 'JavaScript', '12월', 110000),
(25, 'PHP', '1월', 260000),
(26, 'PHP', '2월', 170000),
(27, 'PHP', '3월', 85000),
(28, 'PHP', '4월', 100000),
(29, 'PHP', '5월', 95000),
(30, 'PHP', '6월', 210000),
(31, 'PHP', '7월', 110000),
(32, 'PHP', '8월', 140000),
(33, 'PHP', '9월', 130000),
(34, 'PHP', '10월', 160000),
(35, 'PHP', '11월', 170000),
(36, 'PHP', '12월', 190000),
(37, 'Vue', '1월', 190000),
(38, 'Vue', '2월', 95000),
(39, 'Vue', '3월', 110000),
(40, 'Vue', '4월', 125000),
(41, 'Vue', '5월', 230000),
(42, 'Vue', '6월', 115000),
(43, 'Vue', '7월', 140000),
(44, 'Vue', '8월', 150000),
(45, 'Vue', '9월', 170000),
(46, 'Vue', '10월', 160000),
(47, 'Vue', '11월', 180000),
(48, 'Vue', '12월', 100000);

-- --------------------------------------------------------

--
-- 테이블 구조 `sales_management`
--

CREATE TABLE `sales_management` (
  `sid` int(11) NOT NULL COMMENT '테이블 고유번호',
  `total_lecture` int(50) NOT NULL COMMENT '총 강의 수',
  `total_student` int(50) NOT NULL COMMENT '총 수강생',
  `total_grade` int(50) NOT NULL COMMENT '평점',
  `total_sales` int(100) NOT NULL COMMENT '총 매출'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `sales_management`
--

INSERT INTO `sales_management` (`sid`, `total_lecture`, `total_student`, `total_grade`, `total_sales`) VALUES
(1, 23, 2323, 5, 12020000);

-- --------------------------------------------------------

--
-- 테이블 구조 `sales_monthly`
--

CREATE TABLE `sales_monthly` (
  `msid` int(11) NOT NULL,
  `month` varchar(50) NOT NULL,
  `sales` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `sales_monthly`
--

INSERT INTO `sales_monthly` (`msid`, `month`, `sales`) VALUES
(1, '1월', 1500000),
(2, '2월', 1200000),
(5, '3월', 1000000),
(6, '4월', 1300000),
(7, '5월', 1600000),
(8, '6월', 1200000),
(9, '7월', 1800000),
(10, '8월', 1500000),
(11, '9월', 1300000),
(12, '10월', 1000000),
(13, '11월', 1200000),
(14, '12월', 1900000);

-- --------------------------------------------------------

--
-- 테이블 구조 `teachers`
--

CREATE TABLE `teachers` (
  `tid` int(15) NOT NULL,
  `name` varchar(15) NOT NULL,
  `id` varchar(45) NOT NULL,
  `birth` date NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(45) NOT NULL,
  `number` int(45) NOT NULL,
  `reg_date` date NOT NULL DEFAULT current_timestamp(),
  `cover_image` varchar(200) DEFAULT NULL,
  `teacher_detail` text DEFAULT NULL,
  `grade` varchar(15) NOT NULL,
  `last_login` datetime DEFAULT current_timestamp(),
  `notyet` varchar(155) DEFAULT NULL,
  `main` varchar(15) NOT NULL,
  `year_sales` bigint(155) DEFAULT NULL,
  `student_number` int(11) DEFAULT NULL,
  `level` int(15) NOT NULL DEFAULT 10,
  `lecture_num` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `teachers`
--

INSERT INTO `teachers` (`tid`, `name`, `id`, `birth`, `password`, `email`, `number`, `reg_date`, `cover_image`, `teacher_detail`, `grade`, `last_login`, `notyet`, `main`, `year_sales`, `student_number`, `level`, `lecture_num`) VALUES
(1, '정승제', 'jungsungjae', '1978-12-14', '123123', 'jungsungjae@naver.com', 1099451212, '2024-11-08', '/qc/admin/upload/20241119085443204349.jpg', '코딩 포기자를 위한 자바 1타 강사', 'Gold', '2024-11-20 12:51:51', NULL, '', 1500000, 34, 10, NULL),
(2, '현우진', 'hyunwonjun', '1987-12-09', '123123', 'hyunwojin@naver.com', 1032221234, '2024-11-07', '/qc/admin/upload/20241119085548949558.png', '정석대로 가르치는 자바스크립트 1타 강사', 'Silver', '2024-11-20 12:53:24', NULL, '', 1300000, NULL, 10, NULL),
(3, '곽튜브', 'kwak', '1977-12-09', '123123', 'kwak@naver.com', 1052221234, '2024-11-07', '/qc/admin/upload/20241119085632209070.jpg', '7년차 서버개발자입니다\r\n\r\n다양한 강의를 올려보고 싶습니다!\r\n\r\n파이썬, 웹개발, 알고리즘, 개발자 취업 등등..\r\n\r\n여행 유튜브를 운영하고 있습니다\r\n\r\nhttps://www.youtube.com/@JBKWAK \r\n\r\n구경오세요 심심하시면!', 'Vip', '2024-11-19 17:54:27', NULL, '', 2100000, 68, 10, NULL),
(4, '오해원', 'ohhaewon', '1998-12-12', '123123', 'ohhaewon@naver.com', 1022221299, '2023-07-17', '/qc/admin/upload/20241120030641125682.jpg', '신나게 가르칩니다.', 'Silver', '2024-11-20 12:54:26', NULL, '', 2300000, 72, 10, NULL),
(5, '민희진', 'minheejin', '1992-12-12', '123123', 'minheejin@naver.com', 1044221299, '2023-07-19', '/qc/admin/upload/20241120030753809411.jpg', '랩 하듯이 가르칩니다.', 'Silver', '2024-11-20 12:55:11', NULL, '', 1930000, 23, 10, NULL),
(6, '설민석', 'sulminsuk', '1992-12-12', '123123', 'sulminsuk@naver.com', 1044441299, '2023-07-16', '/qc/admin/upload/20241120030830210517.jpg', '연극 하듯이 가르칩니다.', 'Gold', '2024-11-20 12:56:24', NULL, '', 800000, 44, 10, NULL),
(7, '강동원', 'kangdongwon', '1982-12-12', '123123', 'kangdongwon@naver.com', 1022241299, '2023-07-01', '/qc/admin/upload/20241120030940207252.png', '연극 하듯이 가르칩니다.', 'Gold', '2024-11-20 12:59:01', NULL, '', 1200000, 65, 10, NULL),
(8, '권도형', 'kwondohyung', '1982-12-12', '123123', 'kwondohyung@naver.com', 1012224299, '2024-03-11', '/qc/admin/upload/20241120031027201008.png', '코인 1타 강사', 'Vip', '2024-11-20 13:00:32', NULL, '', 54000000, 44, 10, NULL),
(9, '빠니보틀', 'panibottle', '1982-01-02', '123123', 'panibottle@naver.com', 1099991234, '2024-11-19', '/qc/admin/upload/20241120033644134389.jpg', '빠니샘과 같이하는 코딩 여행', 'Blonze', '2024-11-20 13:01:26', NULL, '', 126500, 56, 10, NULL),
(10, '박지헌', 'parkgihyun', '1982-01-02', '123123', 'parkgihyun@naver.com', 1044991234, '2024-11-18', '/qc/admin/upload/20241120033725149648.png', '걸그룹 출신 코딩 강사', 'Gold', '2024-11-20 13:02:33', NULL, '', 2560000, 53, 10, NULL),
(11, '손석구', 'sonsuk9', '1989-12-12', '123123', 'sonsuk9@naver.com', 2147483647, '2024-11-07', '/qc/admin/upload/20241120033953598994.jpg', '열심히 안하면 납치', 'Silver', '2024-11-20 13:06:46', NULL, '', 1765000, 51, 10, NULL),
(12, '신승범', 'sinsungbum', '1989-12-12', '123123', 'sinsungbum@naver.com', 2147483647, '2024-10-24', '/qc/admin/upload/20241120034031211441.png', '수학강사에서 코딩강사로', 'Gold', '2024-11-20 13:07:28', NULL, '', 8906000, 75, 10, NULL),
(13, '안성재', 'mrahn', '1989-12-12', '123123', 'mrahn@naver.com', 2147483647, '2024-10-24', '/qc/admin/upload/20241120034058941646.jpg', '요리사에서 코딩강사로', 'Vip', '2024-11-20 13:08:14', NULL, '', 2450000, 22, 10, NULL),
(14, '윤루카스', 'lucas', '1989-12-12', '123123', 'lucas@naver.com', 2147483647, '2024-10-11', '/qc/admin/upload/20241120034130130733.jpg', '차가운 코딩강사', 'Silver', '2024-11-20 13:08:46', NULL, '', 1456700, 11, 10, NULL),
(15, '미미미누', 'mimiminu', '1982-01-02', '123123', 'mimiminu@naver.com', 1022221234, '2023-04-27', '/qc/admin/upload/20241120043443178786.jpg', '고대 출신의 코딩괴물', 'Silver', '2024-11-20 13:09:56', NULL, '', 5400000, 34, 10, NULL),
(16, '윤세아', 'yoonsaeah', '1982-01-02', '123123', 'yoonsaeah@naver.com', 1022221265, '2023-07-07', '/qc/admin/upload/20241120044334125301.jpg', '고대 출신의 코딩괴물', 'Silver', '2024-11-20 13:10:50', NULL, '', 15400000, 25, 10, NULL),
(17, '이기상', 'wakeup', '1982-01-02', '123123', 'wakeup@naver.com', 1022221261, '2023-07-27', '/qc/admin/upload/20241120044413641480.jpg', '한국지리에서 코딩강사로', 'Silver', '2024-11-20 13:13:19', NULL, '', 23400000, 77, 10, NULL),
(18, '이동진', 'dongjin', '1982-01-02', '123123', 'dongjin@naver.com', 1022221244, '2023-07-31', '/qc/admin/upload/20241120044447527474.jpg', '영화평론가 겸 코딩강사', 'Silver', '2024-11-20 13:13:55', NULL, '', 15430000, 66, 10, NULL),
(19, '이지영', 'easyyoung', '1982-01-02', '123123', 'easyyoung@naver.com', 1022221288, '2023-08-10', '/qc/admin/upload/20241120044519121958.jpg', '윤리강사 겸 코딩강사', 'Silver', '2024-11-20 13:14:42', NULL, '', 15600000, 76, 10, NULL),
(20, '장윤정', 'yoonjunng', '1982-01-02', '123123', 'yoonjunng@gmail.com', 1022221209, '2024-12-07', '/qc/admin/upload/20241120044610663632.jpg', '트로트 가수 겸 코딩강사', 'Gold', '2024-11-20 13:15:44', NULL, '', 16780000, 65, 10, NULL),
(21, '현우진', 'hyunwonjun', '1987-12-09', '123123', 'hyunwojin@naver.com', 1032221234, '2024-11-07', '/qc/admin/upload/20241119085548949558.png', '정석대로 가르치는 자바스크립트 1타 강사', 'Silver', '2024-11-20 12:53:24', NULL, '', 1300000, 27, 10, NULL),
(22, '황재성', 'king', '1982-01-02', '123123', 'haemil123123@gmail.com', 1044421234, '2024-11-22', '/qc/admin/upload/20241120084425169587.jpg', '개그맨에서 코딩 강사로 전향한 만큼 재밌고\r\n위트넘치게 가르치겠습니다. ', 'Blonze', '2024-11-20 16:44:25', NULL, '', NULL, NULL, 10, NULL);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idx`);

--
-- 테이블의 인덱스 `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `board_like`
--
ALTER TABLE `board_like`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `l_pid` (`l_pid`,`user_id`);

--
-- 테이블의 인덱스 `board_reply`
--
ALTER TABLE `board_reply`
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `board_re_reply`
--
ALTER TABLE `board_re_reply`
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`cid`);

--
-- 테이블의 인덱스 `coupons_usercp`
--
ALTER TABLE `coupons_usercp`
  ADD PRIMARY KEY (`ucid`);

--
-- 테이블의 인덱스 `lecture_category`
--
ALTER TABLE `lecture_category`
  ADD PRIMARY KEY (`lcid`);

--
-- 테이블의 인덱스 `lecture_data`
--
ALTER TABLE `lecture_data`
  ADD PRIMARY KEY (`lid`);

--
-- 테이블의 인덱스 `lecture_list`
--
ALTER TABLE `lecture_list`
  ADD PRIMARY KEY (`lid`);

--
-- 테이블의 인덱스 `lecture_video`
--
ALTER TABLE `lecture_video`
  ADD PRIMARY KEY (`lvid`);

--
-- 테이블의 인덱스 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`mid`);

--
-- 테이블의 인덱스 `sales_course`
--
ALTER TABLE `sales_course`
  ADD PRIMARY KEY (`scid`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `board_like`
--
ALTER TABLE `board_like`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

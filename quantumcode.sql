-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-25 23:33
-- 서버 버전: 10.4.32-MariaDB
-- PHP 버전: 8.0.30

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
(4, 'admin', 'admin@shop.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2023-01-01 17:12:32', 100, '2024-11-26 03:18:51', NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `board`
--

CREATE TABLE `board` (
  `pid` int(10) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(200) NOT NULL,
  `status` int(11) DEFAULT 0,
  `name` varchar(20) DEFAULT NULL,
  `pw` int(50) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
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

INSERT INTO `board` (`pid`, `user_id`, `title`, `content`, `status`, `name`, `pw`, `date`, `updated_date`, `hit`, `likes`, `category`, `img`, `is_img`, `start_date`, `end_date`) VALUES
(1, NULL, '123123', '123123123', 0, NULL, NULL, '2024-11-11 08:18:06', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(2, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:07', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(3, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(4, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(5, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:09', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(6, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(7, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(8, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(9, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:28', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(10, NULL, '1111', '1111', 0, NULL, NULL, '2024-11-11 08:18:42', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(11, NULL, '12312412', '1241231231', 0, NULL, NULL, '2024-11-11 08:19:40', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(12, NULL, 'free', 'free', 0, NULL, NULL, '2024-11-11 08:22:02', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(25, '', '하하', '아룡함니꺼', 0, NULL, NULL, '2024-11-12 07:26:09', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(31, '', '공지1', '공지1', 0, NULL, NULL, '2024-11-13 07:56:25', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(32, '', '자유1', '자유1', 0, NULL, NULL, '2024-11-13 07:56:36', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(34, '', '질문1', '질문1', 0, NULL, NULL, '2024-11-13 07:56:57', NULL, NULL, NULL, 'qna', '', NULL, NULL, NULL),
(35, '', '조회1', '조회1', 0, NULL, NULL, '2024-11-13 08:18:18', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(39, '', '공지 추천1', '공지 추천1', 0, NULL, NULL, '2024-11-13 08:53:47', NULL, 1, 5, 'notice', '', NULL, NULL, NULL),
(40, '', '질문 추천', '질문 추천', 0, NULL, NULL, '2024-11-13 08:56:08', NULL, 1, 7, 'qna', '', NULL, NULL, NULL),
(41, '', '추천2', '추천2', 0, NULL, NULL, '2024-11-13 08:58:07', NULL, 2, 3, 'notice', '', NULL, NULL, NULL),
(42, '', '99', '99', 0, NULL, NULL, '2024-11-13 08:58:43', NULL, 1, 0, 'qna', '', NULL, NULL, NULL),
(43, '', '자유 추천', '자유 추천', 0, NULL, NULL, '2024-11-13 09:00:12', NULL, 2, 3, 'free', '', NULL, NULL, NULL),
(44, '', '88', '88', 0, NULL, NULL, '2024-11-13 09:02:03', NULL, 1, 5, 'free', '', NULL, NULL, NULL),
(45, '', '77', '77', 0, NULL, NULL, '2024-11-13 09:03:06', NULL, 3, 5, 'notice', '', NULL, NULL, NULL),
(46, '', '66', '66', 0, NULL, NULL, '2024-11-13 09:05:18', NULL, 2, 5, 'notice', '', NULL, NULL, NULL),
(47, '', '55', '55', 0, NULL, NULL, '2024-11-13 09:07:32', NULL, 2, 3, 'notice', '', NULL, NULL, NULL),
(48, '', '11', '11', 0, NULL, NULL, '2024-11-13 09:09:02', NULL, 3, 20, 'notice', '', NULL, NULL, NULL),
(49, '', '44', '44', 0, NULL, NULL, '2024-11-13 09:10:51', NULL, 1, 2, 'qna', '', NULL, NULL, NULL),
(50, '', '11', '11', 0, NULL, NULL, '2024-11-14 07:34:15', NULL, 0, 0, 'notice', '', NULL, NULL, NULL),
(51, '', '99', '99', 0, NULL, NULL, '2024-11-14 07:34:44', NULL, 2, 0, 'notice', '', NULL, NULL, NULL),
(52, '', '11', '11', 0, NULL, NULL, '2024-11-14 08:05:49', NULL, 1, 0, 'notice', '', NULL, NULL, NULL),
(53, '', '11', '11', 0, NULL, NULL, '2024-11-14 08:15:00', NULL, 2, 0, 'free', '', NULL, NULL, NULL),
(54, '', '33', '33', 0, NULL, NULL, '2024-11-14 08:16:01', NULL, 0, 0, 'qna', '', NULL, NULL, NULL),
(55, '', '222', '222', 0, NULL, NULL, '2024-11-14 08:35:37', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(56, '', '666', '666', 0, NULL, NULL, '2024-11-14 08:38:29', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(60, '', '1251515', '31461436143', 0, NULL, NULL, '2024-11-14 09:08:33', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(61, NULL, '24', '15', 0, NULL, NULL, '2024-11-17 12:42:14', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(62, NULL, '24', '15', 0, NULL, NULL, '2024-11-17 12:44:06', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(90, NULL, '이미지', '이미지', 0, NULL, NULL, '2024-11-18 04:19:54', NULL, 1, 0, 'free', './upload/logo2.png', 1, NULL, NULL),
(91, NULL, '1123', '23232', 0, NULL, NULL, '2024-11-18 05:52:09', NULL, 1, 0, 'notice', './upload/', 0, NULL, NULL),
(92, NULL, '1', '1', 0, NULL, NULL, '2024-11-18 05:59:29', NULL, 1, 0, 'notice', './upload/qqq.jpg', 1, NULL, NULL),
(93, NULL, '22', '22', 0, NULL, NULL, '2024-11-18 06:05:18', NULL, 2, 0, 'free', './upload/', 0, NULL, NULL),
(94, NULL, 'ㅅㅁㄼ11243', 'ㅈㅂㄷㅂ11253', 0, NULL, NULL, '2024-11-18 06:12:20', NULL, 3, 0, 'qna', './upload/qqq2.png', 1, NULL, NULL),
(95, NULL, '123456789123456789', 'ㅁㄹㄴㅁㄻㄹㄴㅁ', 0, NULL, NULL, '2024-11-18 07:21:18', NULL, 1, 0, 'free', './upload/', 0, NULL, NULL),
(96, NULL, '123456789ㅂㅈㄷㅂ', 'ㅂㅈㅈㅂ', 0, NULL, NULL, '2024-11-18 07:22:23', NULL, 3, 0, 'notice', './upload/', 0, NULL, NULL),
(101, NULL, '11', '11', 0, NULL, NULL, '2024-11-19 01:08:32', NULL, 2, 1, 'notice', './upload/qqq3.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'admin', '관리자 뚱마루', '관리자 뚱마루', 0, NULL, NULL, '2024-11-20 04:02:28', NULL, 5, 2, 'notice', '/qc/admin/board/upload/1732075348_qqq4.jpg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'admin', '이벤트3', '이벤트3', 0, NULL, NULL, '2024-11-20 04:06:44', NULL, 4, 0, 'event', '/qc/admin/board/upload/1732075604_qqq3.png', 1, '2024-11-20 00:00:00', '2024-11-30 00:00:00'),
(107, 'admin', '123123', '123123', 0, NULL, NULL, '2024-11-24 19:39:21', NULL, 0, 0, 'free', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'admin', 'test', 'test', 0, NULL, NULL, '2024-11-24 19:40:01', NULL, 1, 0, 'free', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'kwak', '1111', '1111', 0, NULL, NULL, '2024-11-24 19:43:58', NULL, 0, 0, 'notice', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'kwak', '1111', '1111', 0, NULL, NULL, '2024-11-24 19:44:26', NULL, 0, 0, 'notice', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'kwak', '1111test', '1111etste', 0, NULL, NULL, '2024-11-24 19:45:01', NULL, 0, 0, 'notice', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(1, 102, 'admin'),
(2, 116, 'admin');

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
(30, 111, 'kwak', '', '  ㅎㅇㅎㅇdznn', '2024-11-21 15:42:26'),
(31, 110, 'kwak', '', 'ㅎㅇ2', '2024-11-21 15:43:17'),
(32, 109, 'kwak', '', 'ㅎㅇ', '2024-11-21 15:43:26'),
(33, 111, 'admin', '', 'ㅎㅇㅎㅇ', '2024-11-21 15:44:08'),
(34, 110, 'admin', '', 'ㅎㅇ2', '2024-11-21 15:44:35'),
(35, 111, 'admin', '', ' ㅎㅇㅇㅎ11', '2024-11-21 15:46:14'),
(36, 112, 'admin', '', '그건 이렇게 하면 돼요', '2024-11-21 15:47:23'),
(37, 116, 'admin', '', '할렐루야', '2024-11-21 17:04:05'),
(38, 111, 'admin', '', '헬롱', '2024-11-22 10:55:29'),
(39, 125, 'kwak', '', 'gddg', '2024-11-22 17:21:44'),
(40, 111, 'kwak', '', 'gdgd', '2024-11-22 17:21:57');

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
(60, 31, 'kwak', 'ㅎㅇ2', '2024-11-21 06:43:21'),
(61, 32, 'kwak', 'ㅎㅇ', '2024-11-21 06:43:31'),
(62, 30, 'admin', '      ㅎㅇㅎㅇ112', '2024-11-21 06:44:15'),
(63, 31, 'admin', 'ㅎㅇ2', '2024-11-21 06:44:40'),
(65, 37, 'admin', '아멘', '2024-11-21 08:41:39'),
(66, 35, 'admin', 'gdgd2', '2024-11-22 00:51:30'),
(67, 33, 'admin', 'gdgddgd', '2024-11-22 01:54:51'),
(68, 39, 'kwak', '  gdgd112', '2024-11-22 08:21:48');

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
(51, 'A0001', '', '', 'Web', 1),
(52, 'A0002', '', '', 'App', 1),
(53, 'B0001', 'A0001', '', 'Front', 2),
(54, 'B0002', 'A0001', '', 'Back', 2),
(55, 'B0003', 'A0002', '', 'Mobile', 2),
(56, 'C0001', 'B0001', 'A0001', 'HTML', 3),
(57, 'C0002', 'B0001', 'A0001', 'CSS', 3),
(58, 'C0003', 'B0001', 'A0002', 'Java', 3),
(59, 'C0004', 'B0002', 'A0001', 'React', 3),
(60, 'C0005', 'B0001', 'A0001', 'JavaScript', 3),
(61, 'C0006', 'B0002', 'A0001', 'Node.js', 3),
(62, 'C0007', 'B0002', 'A0001', 'Vue', 3),
(63, 'C0008', 'B0003', 'A0002', 'Swift', 3),
(64, 'C0009', 'B0003', 'A0002', 'Kotlin', 3),
(65, 'C0010', 'B0001', 'A0001', 'TypeScript', 3),
(66, 'C0011', 'B0002', 'A0001', 'Angular', 3),
(67, 'C0012', 'B0001', 'A0001', 'SASS', 3),
(68, 'C0013', 'B0002', 'A0001', 'Django', 3),
(69, 'C0014', 'B0002', 'A0001', 'Flask', 3),
(70, 'C0015', 'B0003', 'A0002', 'Flutter', 3),
(71, 'C0016', 'B0003', 'A0002', 'React Native', 3),
(72, 'C0017', 'B0001', 'A0001', 'Bootstrap', 3),
(73, 'C0018', 'B0001', 'A0001', 'Tailwind CSS', 3),
(74, 'C0019', 'B0002', 'A0001', 'Express.js', 3),
(75, 'C0020', 'B0002', 'A0001', 'GraphQL', 3),
(76, 'C0021', 'B0003', 'A0002', 'Ionic', 3),
(78, 'C0023', 'B0001', 'A0001', 'Parcel', 3),
(79, 'C0024', 'B0002', 'A0001', 'Spring', 3),
(80, 'C0025', 'B0002', 'A0001', 'Hibernate', 3),
(81, 'C0026', 'B0001', 'A0001', 'jQuery', 3),
(82, 'C0027', 'B0001', 'A0001', 'Backbone.js', 3),
(83, 'C0028', 'B0001', 'A0001', 'Ember.js', 3),
(84, 'C0029', 'B0002', 'A0001', 'Laravel', 3),
(85, 'C0030', 'B0002', 'A0001', 'Symfony', 3),
(86, 'C0031', 'B0002', 'A0001', 'Ruby on Rails', 3),
(87, 'C0032', 'B0002', 'A0001', 'ASP.NET', 3),
(88, 'C0033', 'B0001', 'A0001', 'Gulp', 3),
(89, 'C0034', 'B0001', 'A0001', 'Grunt', 3),
(90, 'C0035', 'B0003', 'A0002', 'Objective-C', 3),
(91, 'C0036', 'B0003', 'A0002', 'C#', 3),
(92, 'C0037', 'B0003', 'A0002', 'Python', 3),
(93, 'C0038', 'B0002', 'A0001', 'PHP', 3),
(94, 'C0039', 'B0001', 'A0001', 'Less', 3),
(95, 'C0040', 'B0001', 'A0001', 'Stylus', 3),
(96, 'C0041', 'B0002', 'A0001', 'Perl', 3),
(97, 'C0042', 'B0002', 'A0001', 'Go', 3),
(98, 'C0043', 'B0003', 'A0002', 'Rust', 3),
(99, 'C0044', 'B0003', 'A0002', 'Dart', 3),
(100, 'C0045', 'B0003', 'A0002', 'Scala', 3);

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
(62, 'A0001B0001C0001', 56, '관리자가 등록한 강의', '/qc/admin/upload/20241119042317924625.png', 'admin', 0, 0, 0, 1, 1000, 1000, '2024-11-11', '2025-02-11', 'test', '<p>test</p>', '', '1', '', 'Array', '2024-11-19 12:23:17', 0, 80),
(63, 'A0001B0001C0001', 57, '곽튜브와 함께 하는 css강좌', '/qc/admin/upload/20241122071638378822.png', 'kwak', 0, 0, 0, 1, 100000, 10000, '2024-11-01', '2025-02-01', '여행가듯 가르치는 강사', '<p>초보자를 위한 css html 강의!</p>', '', '1', '', 'Array', '2024-11-19 16:57:58', 0, 48),
(64, 'A0001B0001C0004', 58, '곽튜브와 함께하는 react 여행', '/qc/admin/upload/20241119085915834304.png', 'kwak', 0, 1, 0, 0, 150000, 15000, '2024-11-02', '2025-02-02', '곽튜브와 함께하는 신나는 리액트 여행', '<p>곽튜브와 함께하는 신나는 리액트 여행</p>', '', '2', '', 'Array', '2024-11-19 16:59:15', 0, 55),
(65, 'A0001B0001C0001', 59, '곽샘과 함께하는 신나는 자바스크립트 여행', '/qc/admin/upload/20241119090036113948.png', 'kwak', 0, 1, 0, 1, 1000000, 10000, '2024-10-18', '2025-01-18', '평생 무료로 1:1 멘토링까지 해주는 강의', '<p>평생 무료로 1:1 멘토링까지 해주는 강의</p>', '', '1', '', 'Array', '2024-11-19 17:00:36', 0, 65),
(66, 'A0001B0002C0004', 60, '곽샘과 함께하는 mysql', '/qc/admin/upload/20241122071647461853.jpg', 'kwak', 0, 0, 0, 1, 100000, 100000, '2024-11-04', '2025-02-04', '즐거운 mysql 여행', '<p>즐거운 mysql 코딩여행</p>', '', '3', '', 'Array', '2024-11-19 17:55:14', 0, 15),
(67, 'A0001B0001C0001', 61, '승제샘과 함께하는 자바스크립트', '/qc/admin/upload/20241122071657315140.png', 'jungsungjae', 0, 0, 0, 1, 150000, 10000, '2024-11-03', '2025-02-03', '승제샘과 함께하는 자바스크립트', '<p>승제샘과 함께하는 자바스크립트</p>', '', '1', '', 'Array', '2024-11-20 12:52:38', 0, 24),
(68, 'A0001B0001C0001', 62, '우진샘과 함께하는 자바스크립트', '/qc/admin/upload/20241122071732111117.jpg', 'hyunwonjun', 0, 0, 1, 0, 100000, 10000, '2024-09-10', '2024-12-10', '우진샘과 함께하는 자바스크립트', '<p>우진샘과 함께하는 자바스크립트</p>', '', '2', '', 'Array', '2024-11-20 12:54:00', 0, 29),
(69, 'A0001B0001C0004', 63, '해원샘과 함께하는 타입스크립트', '/qc/admin/upload/20241120045459689237.jpg', 'ohhaewon', 0, 0, 1, 0, 100000, 10000, '2024-08-21', '2024-11-21', '해원샘과 함께하는 타입스크립트', '<p>해원샘과 함께하는 타입스크립트</p>', '', '2', '', 'Array', '2024-11-20 12:54:59', 0, 33),
(70, 'A0001B0002C0001', 64, '희진샘과 함께하는 신나는 리액트', '/qc/admin/upload/20241120045611111539.png', 'minheejin', 0, 0, 0, 1, 100000, 10000, '2024-09-11', '2024-12-11', '희진샘과 함께하는 신나는 리액트', '<p>희진샘과 함께하는 신나는 리액트</p>', '', '1', '', 'Array', '2024-11-20 12:56:11', 0, 39),
(71, 'A0002B0001C0003', 65, '설민석의 nodejs', '/qc/admin/upload/20241120045754906860.png', 'sulminsuk', 0, 0, 0, 1, 123123, 10000, '2024-07-17', '2024-10-17', '설민석의 nodejs', '<p>설민석의 nodejs</p>', '', '1', '', 'Array', '2024-11-20 12:57:54', 0, 44),
(72, 'A0001B0002C0001', 66, '설민석의 mysql', '/qc/admin/upload/20241120045823750741.jpg', 'sulminsuk', 0, 0, 1, 0, 100000, 10000, '2023-06-20', '2023-09-20', '설민석의 nodejs', '<p>설민석의 nodejs</p>', '', '1', '', 'Array', '2024-11-20 12:58:23', 0, 23),
(73, 'A0001B0002C0001', 67, '자바스크립트', '/qc/admin/upload/20241120050013976917.png', 'kangdongwon', 0, 0, 0, 1, 100000, 10000, '2024-11-19', '2025-02-19', '자바스크립트', '<p>자바스크립트</p>', '', '2', '', 'Array', '2024-11-20 13:00:13', 0, 67),
(74, 'A0002B0003C0008', 68, 'go언어 고수 되는 방법', '/qc/admin/upload/20241125190105135266.jpg', 'kwondohyung', 1, 0, 0, 1, 150000, 10000, '2024-10-22', '2025-01-22', 'go언어 고수 되는 방법', '<p>go언어 고수 되는 방법</p>', '', '1', '', 'Array', '2024-11-20 13:01:12', 0, 51),
(75, 'A0001B0001C0002', 69, '빠니와 함께하는 css여행', '/qc/admin/upload/20241125185937443101.png', 'panibottle', 0, 0, 1, 0, 200000, 10000, '2024-09-18', '2024-12-18', '빠니와 함께하는 css여행', '<p>빠니와 함께하는 css여행</p>', '', '1', '', 'Array', '2024-11-20 13:02:22', 0, 31),
(76, 'A0001B0001C0001', 70, '지현샘과 함께하는 c++', '/qc/admin/upload/20241120050628168178.png', 'admin', 0, 0, 0, 1, 250000, 10000, '2024-07-16', '2024-10-16', '지현샘과 함께하는 c++', '<p>지현샘과 함께하는 c++</p>', '', '2', '', 'Array', '2024-11-20 13:06:28', 0, 10),
(77, 'A0001B0001C0001', 71, '손석구와 파이썬', '/qc/admin/upload/20241120050715385295.jpg', 'sonsuk9', 0, 0, 1, 0, 100000, 10000, '2024-09-17', '2024-12-17', '손석구와 파이썬', '<p>손석구와 파이썬</p>', '', '1', '', 'Array', '2024-11-20 13:07:15', 0, 11),
(78, 'A0001B0001C0002', 72, 'css정석', '/qc/admin/upload/20241125190002113062.png', 'sinsungbum', 0, 0, 1, 0, 200000, 15000, '2024-09-17', '2024-12-17', 'css정석', '<p>css정석</p>', '', '2', '', 'Array', '2024-11-20 13:08:04', 0, 41),
(79, 'A0001B0002C0001', 73, '맛있는 자바', '/qc/admin/upload/20241120050836844794.png', 'mrahn', 0, 0, 1, 0, 100000, 10000, '2024-10-30', '2025-01-30', '맛있는 자바', '<p>맛있는 자바</p>', '', '2', '', 'Array', '2024-11-20 13:08:36', 0, 18),
(80, 'A0001B0002C0001', 74, '차갑게 배우는 리액트', '/qc/admin/upload/20241120050923524575.png', 'lucas', 0, 0, 1, 0, 100000, 10000, '2024-11-19', '2025-02-19', '차갑게 배우는 리액트', '<p>차갑게 배우는 리액트</p>', '', '3', '', 'Array', '2024-11-20 13:09:23', 0, 41),
(81, 'A0001B0001C0001', 75, '미미미누와 같이 파이썬 공부하기', '/qc/admin/upload/20241120051030144009.jpg', 'mimiminu', 0, 0, 1, 0, 25000, 1000, '2024-10-24', '2025-01-24', '미미미누와 같이 파이썬 공부하기', '<p>미미미누와 같이 파이썬 공부하기</p>', '', '1', '', 'Array', '2024-11-20 13:10:30', 0, 63),
(82, 'A0001B0001C0001', 76, '세아샘과 함께하는 자바스크립트', '/qc/admin/upload/20241120051201391962.png', 'yoonsaeah', 0, 1, 0, 1, 100000, 10000, '2024-08-28', '2024-11-28', '세아샘과 함께하는 자바스크립트', '<p>세아샘과 함께하는 자바스크립트</p>', '', '1', '', 'Array', '2024-11-20 13:12:01', 0, 48),
(83, 'A0001B0002C0001', 76, '기상과 함께하는 노드js', '/qc/admin/upload/20241120051301127737.png', 'wakeup', 0, 0, 0, 1, 145000, 15000, '2024-08-21', '2024-11-21', '기상과 함께하는 노드js', '<p>기상과 함께하는 노드js</p>', '', '1', '', 'Array', '2024-11-20 13:13:01', 0, 49),
(84, 'A0001B0001C0001', 78, '기상샘과 함께하는 파이썬 여행', '/qc/admin/upload/20241120051342146639.jpg', 'wakeup', 0, 0, 0, 0, 254600, 10000, '2024-11-20', '2025-02-20', '기상샘과 함께하는 파이썬 여행', '<p>기상샘과 함께하는 파이썬 여행</p>', '', '1', '', 'Array', '2024-11-20 13:13:42', 0, 76),
(85, 'A0001B0001C0001', 79, '동진샘과 함께하는 mysql', '/qc/admin/upload/20241120051431211298.jpg', 'dongjin', 0, 0, 0, 0, 325000, 25000, '2024-05-22', '2024-08-22', '동진샘과 함께하는 mysql', '<p>동진샘과 함께하는 mysql</p>', '', '1', '', 'Array', '2024-11-20 13:14:31', 0, 112),
(86, 'A0001B0001C0001', 80, '지영샘과 함께하는 리액트 마스터', '/qc/admin/upload/20241120051508184740.png', 'easyyoung', 0, 0, 0, 1, 200000, 10000, '2024-05-14', '2024-08-14', '지영샘과 함께하는 리액트 마스터', '<p>지영샘과 함께하는 리액트 마스터</p>', '', '1', '', 'Array', '2024-11-20 13:15:08', 0, 89),
(87, 'A0001B0002C0001', 81, '지영샘과 함께하는 go 마스터', '/qc/admin/upload/20241120051530137373.png', 'easyyoung', 0, 0, 0, 1, 100000, 10000, '2024-07-09', '2024-10-09', '지영샘과 함께하는 go 마스터', '<p>지영샘과 함께하는 go 마스터</p>', '', '1', '', 'Array', '2024-11-20 13:15:30', 0, NULL),
(88, 'A0001B0002C0001', 82, '장윤정의 java마스터', '/qc/admin/upload/20241120051614750313.png', 'yoonjunng', 0, 0, 0, 1, 100000, 10000, '2024-08-21', '2024-11-21', '장윤정의 java마스터', '<p>장윤정의 java마스터</p>', '', '2', '', 'Array', '2024-11-20 13:16:14', 0, NULL),
(89, 'A0001B0001C0001', 56, '관리자가 등록한 강의', '/qc/admin/upload/20241119042317924625.png', 'admin', 0, 0, 0, 1, 1000, 1000, '2024-11-11', '2025-02-11', 'test', '<p>test</p>', '', '1', '', 'Array', '2024-11-19 12:23:17', 0, 80),
(90, 'A0001B0001C0001', 57, '곽튜브와 함께 하는 자바2', '/qc/admin/upload/20241122071752662987.png', 'kwak', 0, 0, 0, 1, 100000, 10000, '2024-11-01', '2025-02-01', '여행가듯 가르치는 강사', '<p>초보자를 위한 css html 강의!</p>', '', '1', '', 'Array', '2024-11-19 16:57:58', 0, 48),
(91, 'A0001B0001C0004', 58, '곽튜브와 함께하는 react 여행', '/qc/admin/upload/20241119085915834304.png', 'kwak', 0, 1, 0, 0, 150000, 15000, '2024-11-02', '2025-02-02', '곽튜브와 함께하는 신나는 리액트 여행', '<p>곽튜브와 함께하는 신나는 리액트 여행</p>', '', '2', '', 'Array', '2024-11-19 16:59:15', 0, 55),
(92, 'A0001B0001C0004', 59, '곽샘과 함께하는 신나는 자바스크립트 여행', '/qc/admin/upload/20241119090036113948.png', 'kwak', 0, 0, 0, 1, 1000000, 10000, '2024-10-18', '2025-01-18', '평생 무료로 1:1 멘토링까지 해주는 강의', '<p>평생 무료로 1:1 멘토링까지 해주는 강의</p>', '', '1', '', 'Array', '2024-11-19 17:00:36', 0, 65),
(93, 'A0001B0002C0004', 60, '곽샘과 함께하는 mysql', '/qc/admin/upload/20241122071809777892.jpg', 'kwak', 0, 0, 0, 1, 100000, 100000, '2024-11-04', '2025-02-04', '즐거운 mysql 여행', '<p>즐거운 mysql 코딩여행</p>', '', '3', '', 'Array', '2024-11-19 17:55:14', 0, 15),
(94, 'A0001B0001C0001', 61, '승제샘과 함께하는 자바스크립트', '/qc/admin/upload/20241125190143156529.png', 'jungsungjae', 0, 0, 0, 1, 150000, 10000, '2024-11-03', '2025-02-03', '승제샘과 함께하는 자바스크립트', '<p>승제샘과 함께하는 자바스크립트</p>', '', '1', '', 'Array', '2024-11-20 12:52:38', 0, 24),
(95, 'A0001B0001C0001', 62, '우진샘과 함께하는 자바스크립트', '/qc/admin/upload/20241125190020136371.png', 'hyunwonjun', 0, 0, 1, 0, 100000, 10000, '2024-09-10', '2024-12-10', '우진샘과 함께하는 자바스크립트', '<p>우진샘과 함께하는 자바스크립트</p>', '', '2', '', 'Array', '2024-11-20 12:54:00', 0, 29),
(96, 'A0001B0001C0004', 63, '해원샘과 함께하는 타입스크립트', '/qc/admin/upload/20241120045459689237.jpg', 'ohhaewon', 0, 0, 1, 0, 100000, 10000, '2024-08-21', '2024-11-21', '해원샘과 함께하는 타입스크립트', '<p>해원샘과 함께하는 타입스크립트</p>', '', '2', '', 'Array', '2024-11-20 12:54:59', 0, 33),
(97, 'A0001B0002C0001', 64, '희진샘과 함께하는 신나는 리액트', '/qc/admin/upload/20241120045611111539.png', 'minheejin', 0, 0, 0, 1, 100000, 10000, '2024-09-11', '2024-12-11', '희진샘과 함께하는 신나는 리액트', '<p>희진샘과 함께하는 신나는 리액트</p>', '', '1', '', 'Array', '2024-11-20 12:56:11', 0, 39),
(98, 'A0002B0001C0003', 65, '설민석의 nodejs', '/qc/admin/upload/20241120045754906860.png', 'sulminsuk', 0, 0, 0, 1, 123123, 10000, '2024-07-17', '2024-10-17', '설민석의 nodejs', '<p>설민석의 nodejs</p>', '', '1', '', 'Array', '2024-11-20 12:57:54', 0, 44),
(99, 'A0001B0002C0001', 66, '설민석의 mysql', '/qc/admin/upload/20241120045823750741.jpg', 'sulminsuk', 0, 0, 1, 0, 100000, 10000, '2023-06-20', '2023-09-20', '설민석의 nodejs', '<p>설민석의 nodejs</p>', '', '1', '', 'Array', '2024-11-20 12:58:23', 0, 23),
(100, 'A0001B0002C0001', 67, '자바스크립트', '/qc/admin/upload/20241120050013976917.png', 'kangdongwon', 0, 0, 0, 1, 100000, 10000, '2024-11-19', '2025-02-19', '자바스크립트', '<p>자바스크립트</p>', '', '2', '', 'Array', '2024-11-20 13:00:13', 0, 67),
(101, 'A0002B0003C0008', 68, 'go언어 고수 되는 방법', '/qc/admin/upload/20241125190205580087.png', 'kwondohyung', 1, 0, 0, 1, 150000, 10000, '2024-10-22', '2025-01-22', 'go언어 고수 되는 방법', '<p>go언어 고수 되는 방법</p>', '', '1', '', 'Array', '2024-11-20 13:01:12', 0, 51),
(102, 'A0001B0001C0002', 69, '빠니와 함께하는 css여행', '/qc/admin/upload/20241125190034791405.jpg', 'panibottle', 1, 0, 1, 0, 200000, 10000, '2024-09-18', '2024-12-18', '빠니와 함께하는 css여행', '<p>빠니와 함께하는 css여행</p>', '', '1', '', 'Array', '2024-11-20 13:02:22', 0, 31),
(103, 'A0001B0001C0001', 70, '지현샘과 함께하는 c++', '/qc/admin/upload/20241120050628168178.png', 'admin', 0, 0, 0, 1, 250000, 10000, '2024-07-16', '2024-10-16', '지현샘과 함께하는 c++', '<p>지현샘과 함께하는 c++</p>', '', '2', '', 'Array', '2024-11-20 13:06:28', 0, 10),
(104, 'A0001B0001C0001', 71, '손석구와 파이썬', '/qc/admin/upload/20241120050715385295.jpg', 'sonsuk9', 0, 0, 1, 0, 100000, 10000, '2024-09-17', '2024-12-17', '손석구와 파이썬', '<p>손석구와 파이썬</p>', '', '1', '', 'Array', '2024-11-20 13:07:15', 0, 11),
(105, 'A0001B0001C0002', 72, 'css정석', '/qc/admin/upload/20241125190048488319.png', 'sinsungbum', 1, 0, 1, 0, 200000, 15000, '2024-09-17', '2024-12-17', 'css정석', '<p>css정석</p>', '', '2', '', 'Array', '2024-11-20 13:08:04', 0, 41),
(106, 'A0001B0002C0001', 73, '맛있는 자바', '/qc/admin/upload/20241120050836844794.png', 'mrahn', 0, 0, 1, 0, 100000, 10000, '2024-10-30', '2025-01-30', '맛있는 자바', '<p>맛있는 자바</p>', '', '2', '', 'Array', '2024-11-20 13:08:36', 0, 18),
(107, 'A0001B0002C0001', 74, '차갑게 배우는 리액트', '/qc/admin/upload/20241120050923524575.png', 'lucas', 0, 0, 1, 0, 100000, 10000, '2024-11-19', '2025-02-19', '차갑게 배우는 리액트', '<p>차갑게 배우는 리액트</p>', '', '3', '', 'Array', '2024-11-20 13:09:23', 0, 41),
(108, 'A0001B0001C0001', 75, '미미미누와 같이 파이썬 공부하기', '/qc/admin/upload/20241120051030144009.jpg', 'mimiminu', 0, 0, 1, 0, 25000, 1000, '2024-10-24', '2025-01-24', '미미미누와 같이 파이썬 공부하기', '<p>미미미누와 같이 파이썬 공부하기</p>', '', '1', '', 'Array', '2024-11-20 13:10:30', 0, 63),
(109, 'A0001B0001C0001', 76, '세아샘과 함께하는 자바스크립트', '/qc/admin/upload/20241120051201391962.png', 'yoonsaeah', 0, 0, 0, 1, 100000, 10000, '2024-08-28', '2024-11-28', '세아샘과 함께하는 자바스크립트', '<p>세아샘과 함께하는 자바스크립트</p>', '', '1', '', 'Array', '2024-11-20 13:12:01', 0, 48),
(110, 'A0001B0002C0004', 76, '기상과 함께하는 노드js -수정', '/qc/admin/upload/20241120051301127737.png', 'wakeup', 0, 0, 0, 1, 145000, 0, '2024-08-21', '2024-11-21', '기상과 함께하는 노드js', '<p>기상과 함께하는 노드js</p>', '', '1', '', 'Array', '2024-11-20 13:13:01', 0, 49),
(111, 'A0001B0001C0001', 78, '기상샘과 함께하는 파이썬 여행', '/qc/admin/upload/20241120051342146639.jpg', 'wakeup', 0, 0, 0, 0, 254600, 10000, '2024-11-20', '2025-02-20', '기상샘과 함께하는 파이썬 여행', '<p>기상샘과 함께하는 파이썬 여행</p>', '', '1', '', 'Array', '2024-11-20 13:13:42', 0, 76),
(112, 'A0001B0001C0001', 79, '동진샘과 함께하는 mysql', '/qc/admin/upload/20241120051431211298.jpg', 'dongjin', 0, 0, 0, 0, 325000, 25000, '2024-05-22', '2024-08-22', '동진샘과 함께하는 mysql', '<p>동진샘과 함께하는 mysql</p>', '', '1', '', 'Array', '2024-11-20 13:14:31', 0, 112),
(113, 'A0001B0001C0001', 80, '지영샘과 함께하는 리액트 마스터', '/qc/admin/upload/20241120051508184740.png', 'easyyoung', 0, 0, 0, 1, 200000, 10000, '2024-05-14', '2024-08-14', '지영샘과 함께하는 리액트 마스터', '<p>지영샘과 함께하는 리액트 마스터</p>', '', '1', '', 'Array', '2024-11-20 13:15:08', 0, 89),
(114, 'A0001B0002C0001', 81, '지영샘과 함께하는 go 마스터', '/qc/admin/upload/20241120051530137373.png', 'easyyoung', 0, 0, 0, 1, 100000, 10000, '2024-07-09', '2024-10-09', '지영샘과 함께하는 go 마스터', '<p>지영샘과 함께하는 go 마스터</p>', '', '1', '', 'Array', '2024-11-20 13:15:30', 0, NULL),
(115, 'A0001B0002C0001', 82, '장윤정의 java마스터', '/qc/admin/upload/20241120051614750313.png', 'yoonjunng', 0, 0, 0, 1, 100000, 10000, '2024-08-21', '2024-11-21', '장윤정의 java마스터', '<p>장윤정의 java마스터</p>', '', '2', '', 'Array', '2024-11-20 13:16:14', 0, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_reply`
--

CREATE TABLE `lecture_reply` (
  `lpid` int(11) NOT NULL COMMENT '답글 고유번호',
  `lrid` int(10) NOT NULL,
  `profile_image` varchar(100) DEFAULT NULL COMMENT '강사 프로필 이미지',
  `t_id` varchar(20) NOT NULL COMMENT '강사 이름',
  `regist_day` date NOT NULL DEFAULT current_timestamp() COMMENT '작성일',
  `comment` text NOT NULL COMMENT '답글'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `lecture_reply`
--

INSERT INTO `lecture_reply` (`lpid`, `lrid`, `profile_image`, `t_id`, `regist_day`, `comment`) VALUES
(1, 1, NULL, 'admin', '2024-11-21', '안녕하세요'),
(2, 1, NULL, 'admin', '2024-11-21', '반가워요'),
(3, 1, NULL, 'admin', '2024-11-21', '저는 어드민');

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_review`
--

CREATE TABLE `lecture_review` (
  `lrid` int(11) NOT NULL COMMENT '수강평 고유번호',
  `profile_image` varchar(100) NOT NULL COMMENT '회원 프로필 이미지',
  `username` varchar(20) NOT NULL COMMENT '회원이름',
  `regist_day` date NOT NULL DEFAULT current_timestamp() COMMENT '작성일',
  `review` int(10) NOT NULL COMMENT '평점',
  `comment` text NOT NULL COMMENT '후기'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `lecture_review`
--

INSERT INTO `lecture_review` (`lrid`, `profile_image`, `username`, `regist_day`, `review`, `comment`) VALUES
(1, '../img/icon-img/no-image.png', '윤서우', '2024-11-21', 5, '이런 설명력과 이런 내용들을 담고 있는데 이 가격은 말이 안 됩니다 두배로 받으셨어도 될 것 같은데 정말 사장님이 미쳤어요 같은 강의.. \r\n아직 다 소화를 했다고 하긴 어렵지만 반복 학습하면서 마스터해보겠습니다 \r\n좋은 강의 만들어주셔서 감사합니다 !!'),
(2, '../img/icon-img/no-image.png', '강민정', '2024-11-26', 5, '혼자 공부하면서 잘 이해되지 않던 내용들이 강의 들으면서 쏙쏙 이해되고 있어요. 특히 어려울 수 있는 자바스크립트의 용어와 개념을 예시 코드와 함께 쉽게 설명해주셔서 너무 좋아요. react, vue.js 등을 배우기 전 필수로 들어야 한다 생각! 자바스크립트 심화 과정도 강의 있으면 좋겠어요');

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
  `reg_date` date NOT NULL DEFAULT current_timestamp(),
  `member_detail` text DEFAULT NULL,
  `cover_image` varchar(111) DEFAULT NULL,
  `grade` varchar(11) NOT NULL,
  `progress` double DEFAULT NULL,
  `last_login` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `members`
--

INSERT INTO `members` (`mid`, `name`, `id`, `birth`, `password`, `email`, `number`, `reg_date`, `member_detail`, `cover_image`, `grade`, `progress`, `last_login`) VALUES
(1, '김철수', 'kimcs', '1985-05-14', '123123', 'kimcs@example.com', 1023456789, '2023-01-12', '개발을 좋아합니다.', NULL, 'silver', 45.6, '2023-12-31 12:34:56'),
(2, '박영희', 'parkye', '1992-03-23', '123123', 'parkye@example.com', 1098765432, '2023-02-15', '취미는 독서입니다.', NULL, 'gold', 56.3, '2023-11-20 08:12:10'),
(3, '이민수', 'leems', '1989-07-07', '123123', 'leems@example.com', 1012345678, '2023-03-20', '등산을 좋아합니다.', NULL, 'bronze', 63.2, '2023-11-15 10:50:40'),
(4, '최수정', 'choisj', '1995-11-11', '123123', 'choisj@example.com', 1034567890, '2023-04-05', '요리를 즐깁니다.', NULL, 'vip', 78.1, '2023-11-29 14:22:30'),
(5, '홍길동', 'honggd', '1990-02-20', '123123', 'honggd@example.com', 1045678901, '2023-05-01', '영화를 좋아합니다.', NULL, 'gold', 45, '2023-12-01 09:14:30'),
(6, '강수진', 'kangsj', '1993-08-17', '123123', 'kangsj@example.com', 1056789012, '2023-06-10', '테니스를 즐깁니다.', NULL, 'silver', 61.2, '2023-11-05 11:30:22'),
(7, '윤상현', 'yoonsh', '1994-12-30', '123123', 'yoonsh@example.com', 1067890123, '2023-07-08', '독서를 즐깁니다.', NULL, 'bronze', 89.5, '2023-11-19 18:50:15'),
(8, '서준영', 'seojy', '1987-01-10', '123123', 'seojy@example.com', 1078901234, '2023-08-15', '게임을 좋아합니다.', NULL, 'vip', 47.8, '2023-10-10 08:40:30'),
(9, '장민희', 'jangmh', '1991-09-25', '123123', 'jangmh@example.com', 1089012345, '2023-09-25', '사진 찍기를 좋아합니다.', NULL, 'gold', 69.3, '2023-11-12 15:10:25'),
(10, '전혜진', 'jeonhj', '1986-04-14', '123123', 'jeonhj@example.com', 1090123456, '2023-10-10', '춤을 좋아합니다.', NULL, 'bronze', 88, '2023-11-01 12:45:15'),
(11, '나현우', 'nahw', '1994-06-06', '123123', 'nahw@example.com', 1101234567, '2023-10-30', '음악 감상을 즐깁니다.', NULL, 'silver', 55.3, '2023-12-10 11:15:35'),
(12, '신예진', 'shinyj', '1989-03-02', '123123', 'shinyj@example.com', 1112345678, '2023-11-20', '요가를 좋아합니다.', NULL, 'vip', 66.7, '2023-11-21 12:00:25'),
(13, '고은지', 'goej', '1996-12-24', '123123', 'goej@example.com', 1123456789, '2023-12-10', '자전거를 좋아합니다.', NULL, 'gold', 74.5, '2023-11-30 14:15:10'),
(14, '하준호', 'hajh', '1988-07-17', '123123', 'hajh@example.com', 1134567890, '2023-12-15', '해변을 좋아합니다.', NULL, 'silver', 82.4, '2023-12-20 17:10:40'),
(15, '김다은', 'kimde', '1991-05-15', '123123', 'kimde@example.com', 1145678901, '2023-01-05', '책 읽기를 좋아합니다.', NULL, 'bronze', 54.2, '2023-01-10 13:30:50'),
(16, '박재민', 'parkjm', '1990-08-30', '123123', 'parkjm@example.com', 1156789012, '2023-02-12', '여행을 좋아합니다.', NULL, 'vip', 68.4, '2023-02-15 12:20:30'),
(17, '이하윤', 'leehy', '1993-11-20', '123123', 'leehy@example.com', 1167890123, '2023-03-18', '커피를 좋아합니다.', NULL, 'gold', 63.1, '2023-03-22 18:45:15'),
(18, '최은성', 'choies', '1987-02-12', '123123', 'choies@example.com', 1178901234, '2023-04-22', '조깅을 좋아합니다.', NULL, 'silver', 91, '2023-04-28 11:25:00'),
(19, '홍서현', 'hongsh', '1989-06-25', '123123', 'hongsh@example.com', 1189012345, '2023-05-15', '요리 강습을 좋아합니다.', NULL, 'bronze', 48.7, '2023-05-25 13:30:45'),
(20, '서수민', 'seosm', '1995-04-16', '123123', 'seosm@example.com', 1190123456, '2023-12-29', '패션을 좋아합니다.', NULL, 'vip', 64.8, '2024-01-15 13:15:20'),
(21, '나하영', 'nahy', '1990-11-18', '123123', 'nahy@example.com', 1201234567, '2024-02-05', '운동을 좋아합니다.', NULL, 'gold', 72.5, '2024-02-20 17:45:40'),
(22, '전현우', 'jeonhw', '1992-09-24', '123123', 'jeonhw@example.com', 1212345678, '2024-03-12', '예술을 좋아합니다.', NULL, 'silver', 80.1, '2024-03-20 15:50:00'),
(23, '고은찬', 'goec', '1989-12-11', '123123', 'goec@example.com', 1223456789, '2024-04-01', '기술에 관심이 많습니다.', NULL, 'bronze', 68.9, '2024-04-18 11:45:25'),
(24, '강민정', 'kangmj', '1994-05-20', '123123', 'kangmj@example.com', 1234567890, '2024-05-01', '창업을 준비 중입니다.', NULL, 'vip', 74, '2024-05-10 14:00:00'),
(25, '윤서우', 'yoonso', '1996-01-25', '123123', 'yoonso@example.com', 1245678901, '2024-06-15', '요리를 좋아합니다.', NULL, 'gold', 82.1, '2024-06-30 16:00:00'),
(26, '한도영', 'handy', '1993-02-14', '123123', 'handy@example.com', 1256789012, '2024-07-05', '자전거 타기를 좋아합니다.', NULL, 'silver', 77.5, '2024-07-20 15:45:10'),
(27, '정하늘', 'junghn', '1992-09-09', '123123', 'junghn@example.com', 1267890123, '2024-08-01', '영화를 좋아합니다.', NULL, 'bronze', 55, '2024-08-15 14:20:00'),
(28, '이수진', 'leesj', '1990-06-15', '123123', 'leesj@example.com', 1278901234, '2024-09-10', '책 읽기를 좋아합니다.', NULL, 'vip', 61.7, '2024-09-20 11:30:00'),
(29, '김지훈', 'kimjh', '1988-07-30', '123123', 'kimjh@example.com', 1289012345, '2024-10-01', '등산을 좋아합니다.', NULL, 'gold', 88.5, '2024-10-10 12:00:00'),
(30, '김유진', 'kimyj', '1994-12-12', '123123', 'kimyj@example.com', 1290123456, '2024-01-15', '음악 감상을 좋아합니다.', NULL, 'silver', 65.3, '2024-01-20 14:30:00'),
(31, '박세영', 'parkse', '1993-03-20', '123123', 'parkse@example.com', 1301234567, '2024-02-10', '사진 촬영을 좋아합니다.', NULL, 'bronze', 73.5, '2024-02-15 16:45:00'),
(32, '최지민', 'choijm', '1991-08-15', '123123', 'choijm@example.com', 1312345678, '2024-03-22', '독서를 즐깁니다.', NULL, 'vip', 84, '2024-03-30 12:15:00'),
(33, '이하나', 'leeha', '1995-05-01', '123123', 'leeha@example.com', 1323456789, '2024-04-05', '여행을 좋아합니다.', NULL, 'gold', 76.2, '2024-04-10 18:25:00'),
(34, '정윤아', 'jungya', '1992-02-25', '123123', 'jungya@example.com', 1334567890, '2024-05-20', '요리를 좋아합니다.', NULL, 'silver', 58.7, '2024-05-25 15:00:00'),
(35, '한지훈', 'hanjh', '1996-06-15', '123123', 'hanjh@example.com', 1345678901, '2024-06-12', '영화를 즐깁니다.', NULL, 'bronze', 70.8, '2024-06-20 16:00:00'),
(36, '고민정', 'gominj', '1993-09-18', '123123', 'gominj@example.com', 1356789012, '2024-07-01', '패션을 좋아합니다.', NULL, 'vip', 79, '2024-07-15 13:45:00'),
(37, '윤성우', 'yoonso', '1991-04-07', '123123', 'yoonso@example.com', 1367890123, '2024-08-10', '등산을 즐깁니다.', NULL, 'gold', 61.5, '2024-08-18 15:15:00'),
(38, '김재영', 'kimjy', '1990-11-09', '123123', 'kimjy@example.com', 1378901234, '2024-09-05', '책 읽기를 좋아합니다.', NULL, 'silver', 85.4, '2024-09-15 14:50:00'),
(39, '박현서', 'parkhs', '1995-07-17', '123123', 'parkhs@example.com', 1389012345, '2024-10-20', '운동을 좋아합니다.', NULL, 'bronze', 73.8, '2024-10-30 12:40:00'),
(40, '최은빈', 'choieb', '1992-01-12', '123123', 'choieb@example.com', 1390123456, '2024-01-05', '음악을 즐깁니다.', NULL, 'vip', 54.3, '2024-01-10 10:00:00'),
(41, '이하준', 'leehj', '1994-06-23', '123123', 'leehj@example.com', 1401234567, '2024-02-15', '자전거를 좋아합니다.', NULL, 'gold', 72.5, '2024-02-20 11:30:00'),
(42, '한지우', 'hanjw', '1996-12-05', '123123', 'hanjw@example.com', 1412345678, '2024-03-01', '기술을 좋아합니다.', NULL, 'silver', 66.7, '2024-03-10 14:25:00'),
(43, '고유진', 'goyj', '1993-10-10', '123123', 'goyj@example.com', 1423456789, '2024-04-25', '창업을 준비 중입니다.', NULL, 'bronze', 77.3, '2024-05-01 13:00:00'),
(44, '윤지현', 'yoonjh', '1992-08-30', '123123', 'yoonjh@example.com', 1434567890, '2024-05-10', '요가를 좋아합니다.', NULL, 'vip', 62.4, '2024-05-15 16:20:00'),
(45, '서지민', 'seoji', '1995-03-03', '123123', 'seoji@example.com', 1445678901, '2024-06-18', '독서를 즐깁니다.', NULL, 'gold', 74.5, '2024-06-25 15:40:00'),
(46, '정민우', 'jungmw', '1990-09-15', '123123', 'jungmw@example.com', 1456789012, '2024-07-22', '게임을 좋아합니다.', NULL, 'silver', 68.9, '2024-07-30 12:30:00'),
(47, '한수현', 'hansh', '1996-02-11', '123123', 'hansh@example.com', 1467890123, '2024-08-05', '사진을 좋아합니다.', NULL, 'bronze', 80.3, '2024-08-15 13:10:00'),
(48, '김지훈', 'kimjh', '1992-06-06', '123123', 'kimjh@example.com', 1478901234, '2024-09-12', '영화를 좋아합니다.', NULL, 'vip', 72.1, '2024-09-20 14:30:00'),
(49, '박수현', 'parksu', '1991-03-29', '123123', 'parksu@example.com', 1489012345, '2024-10-25', '해변을 좋아합니다.', NULL, 'gold', 83.5, '2024-10-30 16:40:00'),
(50, '최민아', 'choima', '1994-11-01', '123123', 'choima@example.com', 1490123456, '2024-11-10', '패션을 좋아합니다.', NULL, 'silver', 75.7, '2024-11-15 10:00:00');

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
(1, '정승제', 'jungsungjae', '1978-12-14', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'jungsungjae@naver.com', 1099451212, '2024-11-08', '/qc/admin/upload/20241119085443204349.jpg', '코딩 포기자를 위한 자바 1타 강사', 'Gold', '2024-11-20 12:51:51', NULL, '', 1500000, 34, 10, NULL),
(2, '현우진', 'hyunwonjun', '1987-12-09', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'hyunwojin@naver.com', 1032221234, '2024-11-07', '/qc/admin/upload/20241119085548949558.png', '정석대로 가르치는 자바스크립트 1타 강사', 'Silver', '2024-11-20 12:53:24', NULL, '', 1300000, NULL, 10, NULL),
(3, '곽튜브', 'kwak', '1977-12-09', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'kwak@naver.com', 1052221234, '2024-11-07', '/qc/admin/upload/20241119085632209070.jpg', '7년차 서버개발자입니다\r\n\r\n다양한 강의를 올려보고 싶습니다!\r\n\r\n파이썬, 웹개발, 알고리즘, 개발자 취업 등등..\r\n\r\n여행 유튜브를 운영하고 있습니다\r\n\r\nhttps://www.youtube.com/@JBKWAK \r\n\r\n구경오세요 심심하시면!', 'Vip', '2024-11-26 03:18:29', NULL, '', 2100000, 68, 10, NULL),
(4, '오해원', 'ohhaewon', '1998-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'ohhaewon@naver.com', 1022221299, '2023-07-17', '/qc/admin/upload/20241120030641125682.jpg', '신나게 가르칩니다.', 'Silver', '2024-11-20 12:54:26', NULL, '', 2300000, 72, 10, NULL),
(5, '민희진', 'minheejin', '1992-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'minheejin@naver.com', 1044221299, '2023-07-19', '/qc/admin/upload/20241120030753809411.jpg', '랩 하듯이 가르칩니다.', 'Silver', '2024-11-20 12:55:11', NULL, '', 1930000, 23, 10, NULL),
(6, '설민석', 'sulminsuk', '1992-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'sulminsuk@naver.com', 1044441299, '2023-07-16', '/qc/admin/upload/20241120030830210517.jpg', '연극 하듯이 가르칩니다.', 'Gold', '2024-11-20 12:56:24', NULL, '', 800000, 44, 10, NULL),
(7, '강동원', 'kangdongwon', '1982-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'kangdongwon@naver.com', 1022241299, '2023-07-01', '/qc/admin/upload/20241120030940207252.png', '연극 하듯이 가르칩니다.', 'Gold', '2024-11-20 12:59:01', NULL, '', 1200000, 65, 10, NULL),
(8, '권도형', 'kwondohyung', '1982-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'kwondohyung@naver.com', 1012224299, '2024-03-11', '/qc/admin/upload/20241120031027201008.png', '코인 1타 강사', 'Vip', '2024-11-20 13:00:32', NULL, '', 54000000, 44, 10, NULL),
(9, '빠니보틀', 'panibottle', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'panibottle@naver.com', 1099991234, '2024-11-19', '/qc/admin/upload/20241120033644134389.jpg', '빠니샘과 같이하는 코딩 여행', 'Blonze', '2024-11-20 13:01:26', NULL, '', 126500, 56, 10, NULL),
(10, '박지헌', 'parkgihyun', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'parkgihyun@naver.com', 1044991234, '2024-11-18', '/qc/admin/upload/20241120033725149648.png', '걸그룹 출신 코딩 강사', 'Gold', '2024-11-20 13:02:33', NULL, '', 2560000, 53, 10, NULL),
(11, '손석구', 'sonsuk9', '1989-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'sonsuk9@naver.com', 2147483647, '2024-11-07', '/qc/admin/upload/20241120033953598994.jpg', '열심히 안하면 납치', 'Silver', '2024-11-20 13:06:46', NULL, '', 1765000, 51, 10, NULL),
(12, '신승범', 'sinsungbum', '1989-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'sinsungbum@naver.com', 2147483647, '2024-10-24', '/qc/admin/upload/20241120034031211441.png', '수학강사에서 코딩강사로', 'Gold', '2024-11-20 13:07:28', NULL, '', 8906000, 75, 10, NULL),
(13, '안성재', 'mrahn', '1989-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'mrahn@naver.com', 2147483647, '2024-10-24', '/qc/admin/upload/20241120034058941646.jpg', '요리사에서 코딩강사로', 'Vip', '2024-11-20 13:08:14', NULL, '', 2450000, 22, 10, NULL),
(14, '윤루카스', 'lucas', '1989-12-12', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'lucas@naver.com', 2147483647, '2024-10-11', '/qc/admin/upload/20241120034130130733.jpg', '차가운 코딩강사', 'Silver', '2024-11-20 13:08:46', NULL, '', 1456700, 11, 10, NULL),
(15, '미미미누', 'mimiminu', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'mimiminu@naver.com', 1022221234, '2023-04-27', '/qc/admin/upload/20241120043443178786.jpg', '고대 출신의 코딩괴물', 'Silver', '2024-11-20 13:09:56', NULL, '', 5400000, 34, 10, NULL),
(16, '윤세아', 'yoonsaeah', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'yoonsaeah@naver.com', 1022221265, '2023-07-07', '/qc/admin/upload/20241120044334125301.jpg', '고대 출신의 코딩괴물', 'Silver', '2024-11-20 13:10:50', NULL, '', 15400000, 25, 10, NULL),
(17, '이기상', 'wakeup', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'wakeup@naver.com', 1022221261, '2023-07-27', '/qc/admin/upload/20241120044413641480.jpg', '한국지리에서 코딩강사로', 'Silver', '2024-11-20 13:13:19', NULL, '', 23400000, 77, 10, NULL),
(18, '이동진', 'dongjin', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'dongjin@naver.com', 1022221244, '2023-07-31', '/qc/admin/upload/20241120044447527474.jpg', '영화평론가 겸 코딩강사', 'Silver', '2024-11-20 13:13:55', NULL, '', 15430000, 66, 10, NULL),
(19, '이지영', 'easyyoung', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'easyyoung@naver.com', 1022221288, '2023-08-10', '/qc/admin/upload/20241120044519121958.jpg', '윤리강사 겸 코딩강사', 'Silver', '2024-11-20 13:14:42', NULL, '', 15600000, 76, 10, NULL),
(20, '장윤정', 'yoonjunng', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'yoonjunng@gmail.com', 1022221209, '2024-12-07', '/qc/admin/upload/20241120044610663632.jpg', '트로트 가수 겸 코딩강사', 'Gold', '2024-11-20 13:15:44', NULL, '', 16780000, 65, 10, NULL),
(21, '현우진', 'hyunwonjun', '1987-12-09', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'hyunwojin@naver.com', 1032221234, '2024-11-07', '/qc/admin/upload/20241119085548949558.png', '정석대로 가르치는 자바스크립트 1타 강사', 'Silver', '2024-11-20 12:53:24', NULL, '', 1300000, 27, 10, NULL),
(22, '황재성', 'king', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50b3f207fa89b6e242c9aa778e7a8baeffef85b6ca6d2e7dc16ff0a760d59c13c238f6bcdc32f8ce9cc62', 'haemil123123@gmail.com', 1044421234, '2024-11-22', '/qc/admin/upload/20241120084425169587.jpg', '개그맨에서 코딩 강사로 전향한 만큼 재밌고\r\n위트넘치게 가르치겠습니다. ', 'Blonze', '2024-11-20 16:44:25', NULL, '', NULL, NULL, 10, NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `toadminmessages`
--

CREATE TABLE `toadminmessages` (
  `id` int(15) NOT NULL,
  `sender_id` int(15) NOT NULL,
  `receiver_id` varchar(15) NOT NULL,
  `message_content` text NOT NULL,
  `sender_name` varchar(15) NOT NULL,
  `receiver_name` varchar(25) NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_read` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `toadminmessages`
--

INSERT INTO `toadminmessages` (`id`, `sender_id`, `receiver_id`, `message_content`, `sender_name`, `receiver_name`, `sent_at`, `is_read`) VALUES
(5, 3, '4', '제발 ', '곽튜브', '관리자', '2024-11-25 04:14:04', 0),
(6, 3, '4', '제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발제발', '곽튜브', '관리자', '2024-11-25 04:16:20', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `tomembermessages`
--

CREATE TABLE `tomembermessages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `sender_name` varchar(15) NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `tomembermessages`
--

INSERT INTO `tomembermessages` (`id`, `sender_id`, `receiver_id`, `message_content`, `sender_name`, `sent_at`, `is_read`) VALUES
(1, 4, 1, 'test', '', '2024-11-22 15:09:05', 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `toteachermessages`
--

CREATE TABLE `toteachermessages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message_content` text NOT NULL,
  `sender_name` varchar(15) NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `toteachermessages`
--

INSERT INTO `toteachermessages` (`id`, `sender_id`, `receiver_id`, `message_content`, `sender_name`, `sent_at`, `is_read`) VALUES
(9, 4, 3, '관리자가 곽튜브에게 ', '관리자', '2024-11-24 22:10:43', 1),
(10, 4, 3, '읽음 안읽음 되나 안되나 테스트', '관리자', '2024-11-24 23:08:31', 1),
(11, 4, 3, '읽음 안읽음 되나 안되나 테스트22', '관리자', '2024-11-24 23:08:38', 1),
(12, 4, 3, '읽음 안읽음 되나 안되나 테스트22333', '관리자', '2024-11-24 23:08:41', 1);

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
-- 테이블의 인덱스 `lecture_reply`
--
ALTER TABLE `lecture_reply`
  ADD PRIMARY KEY (`lpid`);

--
-- 테이블의 인덱스 `lecture_review`
--
ALTER TABLE `lecture_review`
  ADD PRIMARY KEY (`lrid`);

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
-- 테이블의 인덱스 `sales_management`
--
ALTER TABLE `sales_management`
  ADD PRIMARY KEY (`sid`);

--
-- 테이블의 인덱스 `sales_monthly`
--
ALTER TABLE `sales_monthly`
  ADD PRIMARY KEY (`msid`);

--
-- 테이블의 인덱스 `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`tid`);

--
-- 테이블의 인덱스 `toadminmessages`
--
ALTER TABLE `toadminmessages`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `tomembermessages`
--
ALTER TABLE `tomembermessages`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `toteachermessages`
--
ALTER TABLE `toteachermessages`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `board`
--
ALTER TABLE `board`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- 테이블의 AUTO_INCREMENT `board_like`
--
ALTER TABLE `board_like`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `board_reply`
--
ALTER TABLE `board_reply`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 테이블의 AUTO_INCREMENT `board_re_reply`
--
ALTER TABLE `board_re_reply`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- 테이블의 AUTO_INCREMENT `coupons`
--
ALTER TABLE `coupons`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 테이블의 AUTO_INCREMENT `coupons_usercp`
--
ALTER TABLE `coupons_usercp`
  MODIFY `ucid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 테이블의 AUTO_INCREMENT `lecture_category`
--
ALTER TABLE `lecture_category`
  MODIFY `lcid` int(11) NOT NULL AUTO_INCREMENT COMMENT '카테고리 고유번호', AUTO_INCREMENT=101;

--
-- 테이블의 AUTO_INCREMENT `lecture_data`
--
ALTER TABLE `lecture_data`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 테이블의 AUTO_INCREMENT `lecture_list`
--
ALTER TABLE `lecture_list`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT COMMENT '강의 고유번호', AUTO_INCREMENT=116;

--
-- 테이블의 AUTO_INCREMENT `lecture_reply`
--
ALTER TABLE `lecture_reply`
  MODIFY `lpid` int(11) NOT NULL AUTO_INCREMENT COMMENT '답글 고유번호', AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `lecture_review`
--
ALTER TABLE `lecture_review`
  MODIFY `lrid` int(11) NOT NULL AUTO_INCREMENT COMMENT '수강평 고유번호', AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `lecture_video`
--
ALTER TABLE `lecture_video`
  MODIFY `lvid` int(11) NOT NULL AUTO_INCREMENT COMMENT '강의영상 고유번호', AUTO_INCREMENT=14;

--
-- 테이블의 AUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `mid` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- 테이블의 AUTO_INCREMENT `sales_course`
--
ALTER TABLE `sales_course`
  MODIFY `scid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- 테이블의 AUTO_INCREMENT `sales_management`
--
ALTER TABLE `sales_management`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT '테이블 고유번호', AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `sales_monthly`
--
ALTER TABLE `sales_monthly`
  MODIFY `msid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 테이블의 AUTO_INCREMENT `teachers`
--
ALTER TABLE `teachers`
  MODIFY `tid` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- 테이블의 AUTO_INCREMENT `toadminmessages`
--
ALTER TABLE `toadminmessages`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 테이블의 AUTO_INCREMENT `tomembermessages`
--
ALTER TABLE `tomembermessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `toteachermessages`
--
ALTER TABLE `toteachermessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

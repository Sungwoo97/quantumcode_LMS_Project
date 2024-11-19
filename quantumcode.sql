-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-19 02:14
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
(4, 'admin', 'admin@shop.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2023-01-01 17:12:32', 100, '2024-11-19 10:02:30', NULL);

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
(25, '', '하하', '아룡함니꺼', NULL, NULL, '2024-11-12 07:26:09', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(31, '', '공지1', '공지1', NULL, NULL, '2024-11-13 07:56:25', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(32, '', '자유1', '자유1', NULL, NULL, '2024-11-13 07:56:36', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(33, '', '이벤트1', '이벤트1', NULL, NULL, '2024-11-13 07:56:45', NULL, NULL, NULL, 'event', '', NULL, NULL, NULL),
(34, '', '질문1', '질문1', NULL, NULL, '2024-11-13 07:56:57', NULL, NULL, NULL, 'qna', '', NULL, NULL, NULL),
(35, '', '조회1', '조회1', NULL, NULL, '2024-11-13 08:18:18', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(37, '', '123124214124', '12412351351513513', NULL, NULL, '2024-11-13 08:31:28', NULL, 3, NULL, 'event', '', NULL, NULL, NULL),
(38, '', '이벤트 추천1122', '이벤트 추천1122', NULL, NULL, '2024-11-13 08:43:51', NULL, 4, 15, 'event', '', NULL, NULL, NULL),
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
(58, '', '123213', '12312312', NULL, NULL, '2024-11-14 09:06:28', NULL, 2, 0, 'event', 'C:/xampp1/htdocs/qc/admin/board/upload/', NULL, NULL, NULL),
(59, '', '12421411', '12312311', NULL, NULL, '2024-11-14 09:06:41', NULL, 3, 0, 'event', 'C:/xampp1/htdocs/qc/admin/board/upload/', NULL, NULL, NULL),
(60, '', '1251515', '31461436143', NULL, NULL, '2024-11-14 09:08:33', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(61, NULL, '24', '15', NULL, NULL, '2024-11-17 12:42:14', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(62, NULL, '24', '15', NULL, NULL, '2024-11-17 12:44:06', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(89, NULL, 'gd', 'gd', NULL, NULL, '2024-11-18 03:02:57', NULL, 1, 0, 'event', './upload/qqq2.png', 1, NULL, NULL),
(90, NULL, '이미지', '이미지', NULL, NULL, '2024-11-18 04:19:54', NULL, 1, 0, 'free', './upload/logo2.png', 1, NULL, NULL),
(91, NULL, '1123', '23232', NULL, NULL, '2024-11-18 05:52:09', NULL, 1, 0, 'notice', './upload/', 0, NULL, NULL),
(92, NULL, '1', '1', NULL, NULL, '2024-11-18 05:59:29', NULL, 1, 0, 'notice', './upload/qqq.jpg', 1, NULL, NULL),
(93, NULL, '22', '22', NULL, NULL, '2024-11-18 06:05:18', NULL, 1, 0, 'free', './upload/', 0, NULL, NULL),
(94, NULL, 'ㅅㅁㄼ11243', 'ㅈㅂㄷㅂ11253', NULL, NULL, '2024-11-18 06:12:20', NULL, 1, 0, 'qna', './upload/qqq2.png', 1, NULL, NULL),
(95, NULL, '123456789123456789', 'ㅁㄹㄴㅁㄻㄹㄴㅁ', NULL, NULL, '2024-11-18 07:21:18', NULL, 1, 0, 'free', './upload/', 0, NULL, NULL),
(96, NULL, '123456789ㅂㅈㄷㅂ', 'ㅂㅈㅈㅂ', NULL, NULL, '2024-11-18 07:22:23', NULL, 2, 0, 'notice', './upload/', 0, NULL, NULL),
(98, NULL, '135', '135151351', NULL, NULL, '2024-11-18 09:01:25', NULL, 1, 0, 'event', './upload/', 0, '2024-11-18 00:00:00', '2024-11-27 00:00:00'),
(101, NULL, '11', '11', NULL, NULL, '2024-11-19 01:08:32', NULL, 1, 0, 'notice', './upload/qqq3.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `board_like`
--

CREATE TABLE `board_like` (
  `pid` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(20, 58, '', '', '1111', '2024-11-18 12:43:06');

-- --------------------------------------------------------

--
-- 테이블 구조 `coupons`
--

CREATE TABLE `coupons` (
  `cid` int(11) NOT NULL,
  `coupon_name` varchar(100) NOT NULL COMMENT '쿠폰명',
  `coupon_image` varchar(100) NOT NULL COMMENT '쿠폰이미지',
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

INSERT INTO `coupons` (`cid`, `coupon_name`, `coupon_image`, `coupon_type`, `coupon_price`, `coupon_ratio`, `status`, `startdate`, `enddate`, `userid`) VALUES
(1, '회원가입 웰컴 쿠폰', 'welcome.jpg', '정액', 5000, NULL, 1, '2024-11-18 15:25:55', '2025-12-31', 'admin'),
(2, '블랙프라이데이 할인', 'black_friday.jpg', '정률', NULL, 15, 1, '2024-11-18 15:25:55', '2024-11-30', 'admin'),
(3, '여름방학 특가', 'summer.jpg', '정액', 7000, NULL, 1, '2024-11-18 15:25:55', '2025-06-30', 'user1'),
(4, '크리스마스 선물 쿠폰', 'christmas.jpg', '정률', NULL, 20, 1, '2024-11-18 15:25:55', '2024-12-25', 'user2'),
(5, '새해 맞이 할인', 'new_year.jpg', '정액', 10000, NULL, 1, '2024-11-18 15:25:55', '2025-01-15', 'admin'),
(6, '봄맞이 이벤트', 'spring.jpg', '정률', NULL, 10, 0, '2024-11-18 15:25:55', '2025-03-31', 'user3'),
(7, '번개 할인 쿠폰', 'flash_sale.jpg', '정액', 3000, NULL, 1, '2024-11-18 15:25:55', '2024-12-31', 'user4'),
(8, '발렌타인데이 스페셜', 'valentine.jpg', '정률', NULL, 25, 1, '2024-11-18 15:25:55', '2025-02-14', 'user5'),
(9, '생일 축하 쿠폰', 'birthday.jpg', '정액', 8000, NULL, 0, '2024-11-18 15:25:55', '2025-07-31', 'user6'),
(10, '수강 기념 할인', 'anniversary.jpg', '정률', NULL, 30, 1, '2024-11-18 15:25:55', '2025-05-01', 'admin'),
(11, '프리미엄 강의 할인', 'exclusive.jpg', '정액', 1500, NULL, 1, '2024-11-18 15:25:55', '2025-08-31', 'user7'),
(12, '신학기 프로모션', 'back_to_school.jpg', '정률', NULL, 12, 0, '2024-11-18 15:25:55', '2024-12-01', 'user8'),
(13, '겨울방학 특별 할인', 'winter.jpg', '정액', 4000, NULL, 1, '2024-11-18 15:25:55', '2025-02-28', 'user9'),
(14, '사이버 먼데이 쿠폰', 'cyber_monday.jpg', '정률', NULL, 18, 1, '2024-11-18 15:25:55', '2024-11-27', 'admin'),
(15, '충성 고객 감사 쿠폰', 'loyalty.jpg', '정액', 6000, NULL, 0, '2024-11-18 15:25:55', '2025-10-31', 'user10'),
(16, '연말 프로모션', 'festival.jpg', '정률', NULL, 22, 1, '2024-11-18 15:25:55', '2024-12-31', 'user11'),
(17, '재고 정리 할인', 'clearance.jpg', '정액', 3500, NULL, 1, '2024-11-18 15:25:55', '2025-03-15', 'user12'),
(18, '휴일 특별 할인', 'holiday.jpg', '정률', NULL, 14, 0, '2024-11-18 15:25:55', '2024-12-20', 'user13'),
(19, '신규 회원 전용 쿠폰', 'new_user.jpg', '정액', 9000, NULL, 1, '2024-11-18 15:25:55', '2025-09-30', 'user14'),
(20, '강의 패키지 할인', 'shopping_spree.jpg', '정률', NULL, 17, 1, '2024-11-18 15:25:55', '2025-04-30', 'user15'),
(21, '주말 한정 할인', 'weekend.jpg', '정액', 2000, NULL, 0, '2024-11-18 15:25:55', '2025-05-31', 'user16'),
(22, '시간 한정 특별 쿠폰', 'limited_time.jpg', '정률', NULL, 28, 1, '2024-11-18 15:25:55', '2025-07-15', 'user17'),
(23, '관리자 전용 프로모션', 'promo.jpg', '정액', 12000, NULL, 1, '2024-11-18 15:25:55', '2025-11-30', 'admin'),
(24, '대박 할인 쿠폰', 'mega_discount.jpg', '정률', NULL, 35, 1, '2024-11-18 15:25:55', '2025-12-31', 'user18'),
(25, '할로윈 스페셜 쿠폰', 'halloween.jpg', '정액', 2500, NULL, 1, '2024-11-18 15:25:55', '2024-10-31', 'user19');

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

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_list`
--

CREATE TABLE `lecture_list` (
  `lid` int(11) NOT NULL COMMENT '강의 고유번호',
  `category` varchar(100) NOT NULL COMMENT '강의 카테고리',
  `title` varchar(500) NOT NULL COMMENT '강의 제목',
  `cover_image` varchar(100) DEFAULT NULL COMMENT '강의 커버 이미지',
  `tid` varchar(100) NOT NULL COMMENT '강사이름',
  `isfree` tinyint(4) NOT NULL COMMENT '무료강의',
  `ispremium` tinyint(4) NOT NULL COMMENT '프리미엄강의',
  `ispopular` tinyint(4) NOT NULL COMMENT '인기강의',
  `isrecom` tinyint(4) NOT NULL COMMENT '추천강의',
  `tuition` double NOT NULL COMMENT '수강료',
  `dis_tuition` double DEFAULT NULL COMMENT '할인 수강료',
  `regist_day` datetime NOT NULL COMMENT '수강시작일',
  `expiration_day` datetime DEFAULT NULL COMMENT '수강마감일',
  `sub_title` varchar(250) DEFAULT NULL COMMENT '강의 요약',
  `description` text NOT NULL COMMENT '강의 설명',
  `learning_obj` text DEFAULT NULL COMMENT '강의 목표',
  `difficult` varchar(11) NOT NULL COMMENT '난이도',
  `lecture_tag` varchar(250) DEFAULT NULL COMMENT '강의관련 스킬',
  `pr_video` varchar(100) DEFAULT NULL COMMENT '홍보 영상',
  `regdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '작성시간',
  `status` tinyint(4) NOT NULL COMMENT '상태'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 목록 테이블';

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_video`
--

CREATE TABLE `lecture_video` (
  `lvid` int(11) NOT NULL COMMENT '강의영상 고유번호',
  `lid` int(11) NOT NULL COMMENT '연결된 강의 고유번호',
  `tid` varchar(20) NOT NULL,
  `video_lecture` varchar(100) NOT NULL COMMENT '강의 영상 파일경로',
  `video_desc` text DEFAULT NULL COMMENT '강의 설명',
  `regdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '등록 시간'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 영상 테이블';

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
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `board_reply`
--
ALTER TABLE `board_reply`
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
-- 테이블의 인덱스 `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`tid`);

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
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- 테이블의 AUTO_INCREMENT `board_like`
--
ALTER TABLE `board_like`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `board_reply`
--
ALTER TABLE `board_reply`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 테이블의 AUTO_INCREMENT `coupons`
--
ALTER TABLE `coupons`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 테이블의 AUTO_INCREMENT `coupons_usercp`
--
ALTER TABLE `coupons_usercp`
  MODIFY `ucid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- 테이블의 AUTO_INCREMENT `lecture_category`
--
ALTER TABLE `lecture_category`
  MODIFY `lcid` int(11) NOT NULL AUTO_INCREMENT COMMENT '카테고리 고유번호';

--
-- 테이블의 AUTO_INCREMENT `lecture_list`
--
ALTER TABLE `lecture_list`
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT COMMENT '강의 고유번호';

--
-- 테이블의 AUTO_INCREMENT `lecture_video`
--
ALTER TABLE `lecture_video`
  MODIFY `lvid` int(11) NOT NULL AUTO_INCREMENT COMMENT '강의영상 고유번호';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

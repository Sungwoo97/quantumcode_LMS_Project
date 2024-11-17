-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-17 14:59
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
(4, 'admin', 'admin@shop.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2023-01-01 17:12:32', 100, '2024-11-07 17:28:44', NULL);

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
  `is_img` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board`
--

INSERT INTO `board` (`pid`, `user_id`, `title`, `content`, `name`, `pw`, `date`, `updated_date`, `hit`, `likes`, `category`, `img`, `is_img`) VALUES
(25, '', '하하', '아룡함니꺼', NULL, NULL, '2024-11-12 07:26:09', NULL, NULL, NULL, 'notice', '', NULL),
(31, '', '공지1', '공지1', NULL, NULL, '2024-11-13 07:56:25', NULL, NULL, NULL, 'notice', '', NULL),
(32, '', '자유1', '자유1', NULL, NULL, '2024-11-13 07:56:36', NULL, NULL, NULL, 'free', '', NULL),
(33, '', '이벤트1', '이벤트1', NULL, NULL, '2024-11-13 07:56:45', NULL, NULL, NULL, 'event', '', NULL),
(34, '', '질문1', '질문1', NULL, NULL, '2024-11-13 07:56:57', NULL, NULL, NULL, 'qna', '', NULL),
(35, '', '조회1', '조회1', NULL, NULL, '2024-11-13 08:18:18', NULL, NULL, NULL, 'notice', '', NULL),
(37, '', '123124214124', '12412351351513513', NULL, NULL, '2024-11-13 08:31:28', NULL, 2, NULL, 'event', '', NULL),
(38, '', '이벤트 추천1122', '이벤트 추천1122', NULL, NULL, '2024-11-13 08:43:51', NULL, 3, 15, 'event', '', NULL),
(39, '', '공지 추천1', '공지 추천1', NULL, NULL, '2024-11-13 08:53:47', NULL, 1, 5, 'notice', '', NULL),
(40, '', '질문 추천', '질문 추천', NULL, NULL, '2024-11-13 08:56:08', NULL, 1, 7, 'qna', '', NULL),
(41, '', '추천2', '추천2', NULL, NULL, '2024-11-13 08:58:07', NULL, 1, 3, 'notice', '', NULL),
(42, '', '99', '99', NULL, NULL, '2024-11-13 08:58:43', NULL, 1, 0, 'qna', '', NULL),
(43, '', '자유 추천', '자유 추천', NULL, NULL, '2024-11-13 09:00:12', NULL, 2, 3, 'free', '', NULL),
(44, '', '88', '88', NULL, NULL, '2024-11-13 09:02:03', NULL, 1, 5, 'free', '', NULL),
(45, '', '77', '77', NULL, NULL, '2024-11-13 09:03:06', NULL, 2, 5, 'notice', '', NULL),
(46, '', '66', '66', NULL, NULL, '2024-11-13 09:05:18', NULL, 1, 5, 'notice', '', NULL),
(47, '', '55', '55', NULL, NULL, '2024-11-13 09:07:32', NULL, 1, 3, 'notice', '', NULL),
(48, '', '11', '11', NULL, NULL, '2024-11-13 09:09:02', NULL, 2, 20, 'notice', '', NULL),
(49, '', '44', '44', NULL, NULL, '2024-11-13 09:10:51', NULL, 1, 2, 'qna', '', NULL),
(50, '', '11', '11', NULL, NULL, '2024-11-14 07:34:15', NULL, 0, 0, 'notice', '', NULL),
(51, '', '99', '99', NULL, NULL, '2024-11-14 07:34:44', NULL, 1, 0, 'notice', '', NULL),
(52, '', '11', '11', NULL, NULL, '2024-11-14 08:05:49', NULL, 0, 0, 'notice', '', NULL),
(53, '', '11', '11', NULL, NULL, '2024-11-14 08:15:00', NULL, 2, 0, 'free', '', NULL),
(54, '', '33', '33', NULL, NULL, '2024-11-14 08:16:01', NULL, 0, 0, 'qna', '', NULL),
(55, '', '222', '222', NULL, NULL, '2024-11-14 08:35:37', NULL, 0, 0, 'free', '', NULL),
(56, '', '666', '666', NULL, NULL, '2024-11-14 08:38:29', NULL, 1, 0, 'free', '', NULL),
(57, '', '4124', '4124', NULL, NULL, '2024-11-14 08:54:14', NULL, 1, 0, 'notice', '0', NULL),
(58, '', '123213', '12312312', NULL, NULL, '2024-11-14 09:06:28', NULL, 1, 0, 'event', 'C:/xampp1/htdocs/qc/admin/board/upload/', NULL),
(59, '', '12421411', '12312311', NULL, NULL, '2024-11-14 09:06:41', NULL, 2, 0, 'event', 'C:/xampp1/htdocs/qc/admin/board/upload/', NULL),
(60, '', '1251515', '31461436143', NULL, NULL, '2024-11-14 09:08:33', NULL, 0, 0, 'free', '', NULL),
(61, NULL, '24', '15', NULL, NULL, '2024-11-17 12:42:14', NULL, 0, 0, 'free', '', NULL),
(62, NULL, '24', '15', NULL, NULL, '2024-11-17 12:44:06', NULL, 0, 0, 'free', '', NULL),
(63, NULL, '1', '1', NULL, NULL, '2024-11-17 12:44:14', NULL, 0, 0, 'notice', '', NULL),
(64, NULL, '1', '1', NULL, NULL, '2024-11-17 12:44:40', NULL, 0, 0, 'notice', '', NULL),
(65, NULL, '2', '2', NULL, NULL, '2024-11-17 12:44:49', NULL, 0, 0, 'notice', '', NULL),
(66, NULL, '1', '1', NULL, NULL, '2024-11-17 12:45:12', NULL, 0, 0, 'notice', '', NULL),
(67, NULL, '1', '1', NULL, NULL, '2024-11-17 12:47:30', NULL, 0, 0, 'notice', '', NULL),
(68, NULL, '1', '1', NULL, NULL, '2024-11-17 12:47:39', NULL, 0, 0, 'notice', '', NULL),
(69, NULL, '1', '1', NULL, NULL, '2024-11-17 12:56:24', NULL, 0, 0, 'notice', '', NULL),
(70, NULL, '파일', '파일', NULL, NULL, '2024-11-17 12:59:12', NULL, 1, 0, 'notice', 'C:/xampp/htdocs/qc/admin/board/upload/images.jpg', NULL),
(71, NULL, '2', '2', NULL, NULL, '2024-11-17 13:03:50', NULL, 1, 0, 'notice', 'sdgs6.png', NULL),
(72, NULL, '1', '1', NULL, NULL, '2024-11-17 13:05:26', NULL, 1, 0, 'notice', 'sdgs1.png', NULL),
(73, NULL, '1', '1', NULL, NULL, '2024-11-17 13:05:51', NULL, 1, 0, 'free', 'sdgs9.png', NULL),
(74, NULL, '1', '1', NULL, NULL, '2024-11-17 13:06:29', NULL, 1, 0, 'notice', 'C:/xampp/htdocs/qc/admin/board/upload/sdgs3.png', NULL),
(75, NULL, '파일2', '파일2', NULL, NULL, '2024-11-17 13:10:15', NULL, 1, 0, 'notice', 'sdgs17.png', NULL),
(76, NULL, '파일3', '파일3', NULL, NULL, '2024-11-17 13:11:29', NULL, 1, 0, 'notice', './upload/sdgs7.png', NULL),
(77, NULL, '파일4', '파일4', NULL, NULL, '2024-11-17 13:12:13', NULL, 1, 0, 'notice', './upload/sdgs17.png', NULL),
(78, NULL, '이미지 첨부', '이미지 첨부', NULL, NULL, '2024-11-17 13:19:02', NULL, 0, 0, 'notice', './upload/sdgs1.png', 0),
(79, NULL, '첨부 2', '첨부 2', NULL, NULL, '2024-11-17 13:21:13', NULL, 0, 0, 'notice', './upload/sdgs10.png', 1),
(80, NULL, '1', '1', NULL, NULL, '2024-11-17 13:30:48', NULL, 1, 0, 'notice', './upload/board.sql', 0),
(81, NULL, '2', '2', NULL, NULL, '2024-11-17 13:31:29', NULL, 1, 0, 'notice', './upload/sdgs9.png', 1),
(82, NULL, '9', '9', NULL, NULL, '2024-11-17 13:47:24', NULL, 1, 0, 'notice', './upload/sdgs7.png', 1),
(83, NULL, '1', '1', NULL, NULL, '2024-11-17 13:50:55', NULL, 0, 0, 'notice', './upload/', 0),
(84, NULL, '1', '1', NULL, NULL, '2024-11-17 13:54:05', NULL, 0, 0, 'notice', './upload/', 0),
(85, NULL, 'test', 'test', NULL, NULL, '2024-11-17 13:54:29', NULL, 1, 0, 'notice', './upload/', 0),
(86, NULL, 'test2', 'test2', NULL, NULL, '2024-11-17 13:56:59', NULL, 1, 0, 'notice', './upload/images.jpg', 1),
(87, NULL, 'test2', 'test2', NULL, NULL, '2024-11-17 13:57:06', NULL, 1, 0, 'notice', './upload/images.jpg', 1),
(88, NULL, 'test3', 'test3', NULL, NULL, '2024-11-17 13:57:56', NULL, 1, 0, 'free', './upload/sdgs.png', 1);

-- --------------------------------------------------------

--
-- 테이블 구조 `board_event`
--

CREATE TABLE `board_event` (
  `eb_pid` int(11) NOT NULL,
  `eb_title` varchar(255) NOT NULL,
  `eb_content` text NOT NULL,
  `eb_event_date` date DEFAULT NULL,
  `eb_user_id` varchar(10) DEFAULT NULL,
  `eb_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `eb_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `eb_like` int(11) DEFAULT NULL,
  `eb_hit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `board_free`
--

CREATE TABLE `board_free` (
  `fb_pid` int(11) NOT NULL,
  `fb_title` varchar(255) NOT NULL,
  `fb_content` text NOT NULL,
  `fb_user_id` varchar(10) DEFAULT NULL,
  `fb_pw` varchar(50) NOT NULL,
  `fb_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `fb_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fb_hit` int(11) DEFAULT NULL,
  `fb_like` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_free`
--

INSERT INTO `board_free` (`fb_pid`, `fb_title`, `fb_content`, `fb_user_id`, `fb_pw`, `fb_date`, `fb_updated_date`, `fb_hit`, `fb_like`) VALUES
(1, 'test', 'test', NULL, '', '2024-11-11 07:48:18', '2024-11-11 07:48:33', 1, NULL),
(2, '1234', '1234', NULL, '', '2024-11-11 07:54:49', '2024-11-11 08:28:19', 24, 9);

-- --------------------------------------------------------

--
-- 테이블 구조 `board_images`
--

CREATE TABLE `board_images` (
  `imgid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- 테이블 구조 `board_notice`
--

CREATE TABLE `board_notice` (
  `nb_pid` int(11) NOT NULL,
  `nb_title` varchar(255) NOT NULL,
  `nb_content` text NOT NULL,
  `nb_user_id` varchar(10) DEFAULT NULL,
  `nb_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `nb_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nb_like` int(11) DEFAULT NULL,
  `nb_hit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_notice`
--

INSERT INTO `board_notice` (`nb_pid`, `nb_title`, `nb_content`, `nb_user_id`, `nb_date`, `nb_updated_date`, `nb_like`, `nb_hit`) VALUES
(1, 'test11', 'test11', NULL, '2024-11-11 07:55:07', '2024-11-11 07:56:00', 11, 13);

-- --------------------------------------------------------

--
-- 테이블 구조 `board_qna`
--

CREATE TABLE `board_qna` (
  `qb_pid` int(11) NOT NULL,
  `qb_title` varchar(255) NOT NULL,
  `qb_content` text NOT NULL,
  `qb_user_id` varchar(10) DEFAULT NULL,
  `qb_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `qb_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `qb_like` int(11) DEFAULT NULL,
  `qb_hit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_qna`
--

INSERT INTO `board_qna` (`qb_pid`, `qb_title`, `qb_content`, `qb_user_id`, `qb_date`, `qb_updated_date`, `qb_like`, `qb_hit`) VALUES
(1, 'test', 'test', NULL, '2024-11-11 07:48:54', '2024-11-11 07:54:16', NULL, 2);

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
(10, 58, '', '', '  1231231111112', '2024-11-16 23:21:51'),
(11, 59, '', '', ' 1231231111', '2024-11-16 23:22:13'),
(12, 37, '', '', ' 1231231111', '2024-11-16 23:28:50'),
(13, 59, '', '', ' 1231231111', '2024-11-17 00:10:07'),
(14, 59, '', '', ' 1231231111', '2024-11-17 00:10:33'),
(15, 59, '', '', ' 1231231111', '2024-11-17 00:10:57'),
(16, 38, '', '', '이벤트 추천11', '2024-11-17 00:33:31'),
(17, 38, '', '', '  112234', '2024-11-17 00:36:43'),
(18, 58, '', '', '11', '2024-11-17 00:41:40'),
(19, 59, '', '', ' 1122', '2024-11-17 00:46:41');

-- --------------------------------------------------------

--
-- 테이블 구조 `coupons_list`
--

CREATE TABLE `coupons_list` (
  `cid` int(11) NOT NULL,
  `coupon_name` varchar(100) NOT NULL COMMENT '쿠폰명',
  `coupon_image` varchar(100) NOT NULL COMMENT '쿠폰이미지',
  `coupon_type` varchar(100) NOT NULL COMMENT '쿠폰타입',
  `coupon_price` double DEFAULT NULL COMMENT '할인금액',
  `coupon_ratio` double DEFAULT NULL COMMENT '할인비율',
  `status` tinyint(4) DEFAULT 0 COMMENT '상태',
  `regdate` datetime DEFAULT current_timestamp() COMMENT '등록일',
  `userid` varchar(100) DEFAULT NULL COMMENT '등록한유저',
  `max_value` double DEFAULT NULL COMMENT '최대할인금액',
  `use_min_price` double DEFAULT NULL COMMENT '최소사용금액'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `reason` varchar(100) NOT NULL COMMENT '쿠폰사용강의'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 테이블 구조 `lecture_category`
--

CREATE TABLE `lecture_category` (
  `lcid` int(11) NOT NULL COMMENT '카테고리 고유번호',
  `code` varchar(20) NOT NULL COMMENT '카테고리코드',
  `pcode` varchar(20) DEFAULT NULL COMMENT '카테고리 부모코드',
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
-- 테이블의 인덱스 `board_event`
--
ALTER TABLE `board_event`
  ADD PRIMARY KEY (`eb_pid`);

--
-- 테이블의 인덱스 `board_free`
--
ALTER TABLE `board_free`
  ADD PRIMARY KEY (`fb_pid`);

--
-- 테이블의 인덱스 `board_images`
--
ALTER TABLE `board_images`
  ADD PRIMARY KEY (`imgid`);

--
-- 테이블의 인덱스 `board_like`
--
ALTER TABLE `board_like`
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `board_notice`
--
ALTER TABLE `board_notice`
  ADD PRIMARY KEY (`nb_pid`);

--
-- 테이블의 인덱스 `board_qna`
--
ALTER TABLE `board_qna`
  ADD PRIMARY KEY (`qb_pid`);

--
-- 테이블의 인덱스 `board_reply`
--
ALTER TABLE `board_reply`
  ADD PRIMARY KEY (`pid`);

--
-- 테이블의 인덱스 `coupons_list`
--
ALTER TABLE `coupons_list`
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
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- 테이블의 AUTO_INCREMENT `board_event`
--
ALTER TABLE `board_event`
  MODIFY `eb_pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `board_free`
--
ALTER TABLE `board_free`
  MODIFY `fb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `board_images`
--
ALTER TABLE `board_images`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `board_like`
--
ALTER TABLE `board_like`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `board_notice`
--
ALTER TABLE `board_notice`
  MODIFY `nb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `board_qna`
--
ALTER TABLE `board_qna`
  MODIFY `qb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `board_reply`
--
ALTER TABLE `board_reply`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 테이블의 AUTO_INCREMENT `coupons_list`
--
ALTER TABLE `coupons_list`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- 테이블의 AUTO_INCREMENT `coupons_usercp`
--
ALTER TABLE `coupons_usercp`
  MODIFY `ucid` int(11) NOT NULL AUTO_INCREMENT;

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

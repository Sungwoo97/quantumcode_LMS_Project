-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-18 03:28
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
(4, 'admin', 'admin@shop.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2023-01-01 17:12:32', 100, '2024-11-18 11:05:40', NULL);

-- --------------------------------------------------------

--
-- 테이블 구조 `board`
--

CREATE TABLE `board` (
  `pid` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(200) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `pw` int(50) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NULL DEFAULT NULL,
  `hit` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `category` enum('notice','free','event','qna') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board`
--

INSERT INTO `board` (`pid`, `title`, `content`, `name`, `pw`, `date`, `updated_date`, `hit`, `likes`, `category`) VALUES
(1, '123123', '123123123', NULL, NULL, '2024-11-11 08:18:06', NULL, NULL, NULL, 'notice'),
(2, '', '', NULL, NULL, '2024-11-11 08:18:07', NULL, NULL, NULL, ''),
(3, '', '', NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, ''),
(4, '', '', NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, ''),
(5, '', '', NULL, NULL, '2024-11-11 08:18:09', NULL, NULL, NULL, ''),
(6, '', '', NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, ''),
(7, '', '', NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, ''),
(8, '', '', NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, ''),
(9, '', '', NULL, NULL, '2024-11-11 08:18:28', NULL, NULL, NULL, ''),
(10, '1111', '1111', NULL, NULL, '2024-11-11 08:18:42', NULL, NULL, NULL, 'notice'),
(11, '12312412', '1241231231', NULL, NULL, '2024-11-11 08:19:40', NULL, NULL, NULL, 'notice'),
(12, 'free', 'free', NULL, NULL, '2024-11-11 08:22:02', NULL, NULL, NULL, 'free');

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
  `fb_pw` int(50) DEFAULT NULL,
  `fb_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `fb_updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fb_hit` int(11) DEFAULT NULL,
  `fb_like` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `board_free`
--

INSERT INTO `board_free` (`fb_pid`, `fb_title`, `fb_content`, `fb_user_id`, `fb_pw`, `fb_date`, `fb_updated_date`, `fb_hit`, `fb_like`) VALUES
(1, 'test', 'test', NULL, 0, '2024-11-11 07:48:18', '2024-11-11 07:48:33', 1, NULL),
(2, '1234', '1234', NULL, 0, '2024-11-11 07:54:49', '2024-11-11 08:28:19', 24, 9);

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
  `lecture_tag` varchar(250) DEFAULT NULL COMMENT '강의관련 스킬',
  `pr_video` varchar(100) DEFAULT NULL COMMENT '홍보 영상',
  `regdate` datetime NOT NULL DEFAULT current_timestamp() COMMENT '작성시간',
  `status` tinyint(4) DEFAULT NULL COMMENT '상태'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 목록 테이블';

--
-- 테이블의 덤프 데이터 `lecture_list`
--

INSERT INTO `lecture_list` (`lid`, `category`, `title`, `cover_image`, `tid`, `isfree`, `ispremium`, `ispopular`, `isrecom`, `tuition`, `dis_tuition`, `regist_day`, `expiration_day`, `sub_title`, `description`, `learning_obj`, `difficult`, `lecture_tag`, `pr_video`, `regdate`, `status`) VALUES
(1, 'A0001B0001C0001', '1', 'Array', 'admin', 0, 1, 0, 0, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '<p>1</p>', '1', '2', '1', '', '2024-11-14 17:40:40', NULL);

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

--
-- 테이블의 덤프 데이터 `members`
--

INSERT INTO `members` (`mid`, `name`, `id`, `birth`, `password`, `email`, `number`, `reg_date`, `member_detail`, `cover_image`, `grade`, `progress`, `last_login`) VALUES
(1, '1', '2', '0000-00-00', '4', '6', 7, '2024-11-20 00:00:00', '123', '/qc/admin/upload/20241115032056184603.png', 2, NULL, '2024-11-15 11:20:56'),
(2, '강동원', 'dongwon123', '1991-10-22', '123', '456', 123, '2024-11-18 00:00:00', '123123123123', '/qc/admin/upload/20241115041334179408.png', 1, NULL, '2024-11-15 12:13:34'),
(3, '강동원', 'dongwon123', '1991-10-22', '123', '456', 123, '2024-11-18 00:00:00', '444', '/qc/admin/upload/20241115041443153504.png', 1, NULL, '2024-11-15 12:14:43');

-- --------------------------------------------------------

--
-- 테이블 구조 `teachers`
--

CREATE TABLE `teachers` (
  `tid` int(15) NOT NULL,
  `name` varchar(15) NOT NULL,
  `id` varchar(45) NOT NULL,
  `birth` date NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `number` int(45) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `cover_image` varchar(200) DEFAULT NULL,
  `teacher_detail` text DEFAULT NULL,
  `grade` varchar(15) NOT NULL,
  `last_login` datetime DEFAULT current_timestamp(),
  `notyet` varchar(155) DEFAULT NULL,
  `main` varchar(15) NOT NULL,
  `sales` int(11) DEFAULT NULL,
  `lecture_num` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 테이블의 덤프 데이터 `teachers`
--

INSERT INTO `teachers` (`tid`, `name`, `id`, `birth`, `password`, `email`, `number`, `reg_date`, `cover_image`, `teacher_detail`, `grade`, `last_login`, `notyet`, `main`, `sales`, `lecture_num`) VALUES
(20, '강동원', 'dongwon', '1990-10-10', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50', 'dongwon@naver.com', 1011112222, '2024-11-07 00:00:00', '/qc/admin/upload/20241118025234161954.png', '자바스크립트 위주 강사', 'silver', '2024-11-18 10:52:34', NULL, '', 5000000, 4),
(21, '공유', 'gonguu', '1982-01-02', '263fec58861449aacc1c328a4aff64aff4c62df4a2d50', 'gonguu@naver.com', 1022221234, '2024-11-06 00:00:00', '/qc/admin/upload/20241118031054112220.png', '자바스트립트 인기 강사', 'Blonze', '2024-11-18 11:10:54', NULL, '', NULL, NULL);

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
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT COMMENT '강의 고유번호', AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `lecture_video`
--
ALTER TABLE `lecture_video`
  MODIFY `lvid` int(11) NOT NULL AUTO_INCREMENT COMMENT '강의영상 고유번호';

--
-- 테이블의 AUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `mid` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 테이블의 AUTO_INCREMENT `teachers`
--
ALTER TABLE `teachers`
  MODIFY `tid` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

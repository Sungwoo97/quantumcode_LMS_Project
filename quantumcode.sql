-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-10 23:09
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
(4, 'admin', 'admin@shop.com', '관리자', '33275a8aa48ea918bd53a9181aa975f15ab0d0645398f5918a006d08675c1cb27d5c645dbd084eee56e675e25ba4019f2ecea37ca9e2995b49fcb12c096a032e', '2023-01-01 17:12:32', 100, '2024-11-07 17:43:01', NULL);

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
(2, '안녕하세요12345678910', '반갑습니다2', '홍길동2', '1234', '2024-11-09 02:34:33', '2024-11-10 14:30:00', 26, 23),
(6, '123411', '123411', NULL, '', '2024-11-10 08:34:43', '2024-11-10 13:09:45', 38, 28),
(7, '수정22', '수정22', NULL, '', '2024-11-10 08:35:16', '2024-11-10 14:29:49', 36, 17),
(9, '222', '222', NULL, '', '2024-11-10 08:42:44', '2024-11-10 13:32:21', 11, NULL),
(10, '1112211', '1112211', NULL, '', '2024-11-10 11:33:36', '2024-11-10 14:29:44', 58, 40),
(11, '444', '444', NULL, '', '2024-11-10 11:44:41', '2024-11-10 13:32:39', 4, NULL);

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
(2, '수정', '수정', NULL, '2024-11-10 11:31:39', '2024-11-10 14:31:21', 5, 19);

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
(2, '1111', '1111', NULL, '2024-11-10 12:43:58', '2024-11-10 12:57:42', 2, 2);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`idx`);

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
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `admins`
--
ALTER TABLE `admins`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 테이블의 AUTO_INCREMENT `board_event`
--
ALTER TABLE `board_event`
  MODIFY `eb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 테이블의 AUTO_INCREMENT `board_free`
--
ALTER TABLE `board_free`
  MODIFY `fb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 테이블의 AUTO_INCREMENT `board_notice`
--
ALTER TABLE `board_notice`
  MODIFY `nb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 테이블의 AUTO_INCREMENT `board_qna`
--
ALTER TABLE `board_qna`
  MODIFY `qb_pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-28 09:22
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

INSERT INTO `board` (`pid`, `user_id`, `title`, `content`, `status`, `name`, `pw`, `date`, `updated_date`, `hit`, `likes`, `category`, `img`, `is_img`, `start_date`, `end_date`) VALUES
(1, NULL, '123123', '123123123', 0, NULL, NULL, '2024-11-11 08:18:06', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(2, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:07', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(3, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:08', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(5, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:09', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(6, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(7, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:27', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(9, NULL, '', '', 0, NULL, NULL, '2024-11-11 08:18:28', NULL, NULL, NULL, '', '', NULL, NULL, NULL),
(10, NULL, '1111', '1111', 0, NULL, NULL, '2024-11-11 08:18:42', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(11, NULL, '12312412', '1241231231', 0, NULL, NULL, '2024-11-11 08:19:40', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(12, NULL, 'free', 'free', 0, NULL, NULL, '2024-11-11 08:22:02', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(25, '', '하하', '아룡함니꺼', 0, NULL, NULL, '2024-11-12 07:26:09', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(31, '', '공지1', '공지1', 0, NULL, NULL, '2024-11-13 07:56:25', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(32, '', '자유1', '자유1', 0, NULL, NULL, '2024-11-13 07:56:36', NULL, NULL, NULL, 'free', '', NULL, NULL, NULL),
(35, '', '조회1', '조회1', 0, NULL, NULL, '2024-11-13 08:18:18', NULL, NULL, NULL, 'notice', '', NULL, NULL, NULL),
(39, '', '공지 추천1', '공지 추천1', 0, NULL, NULL, '2024-11-13 08:53:47', NULL, 1, 5, 'notice', '', NULL, NULL, NULL),
(41, '', '추천2', '추천2', 0, NULL, NULL, '2024-11-13 08:58:07', NULL, 2, 3, 'notice', '', NULL, NULL, NULL),
(43, '', '자유 추천', '자유 추천', 0, NULL, NULL, '2024-11-13 09:00:12', NULL, 2, 3, 'free', '', NULL, NULL, NULL),
(44, '', '88', '88', 0, NULL, NULL, '2024-11-13 09:02:03', NULL, 1, 5, 'free', '', NULL, NULL, NULL),
(45, '', '77', '77', 0, NULL, NULL, '2024-11-13 09:03:06', NULL, 3, 5, 'notice', '', NULL, NULL, NULL),
(46, '', '66', '66', 0, NULL, NULL, '2024-11-13 09:05:18', NULL, 2, 5, 'notice', '', NULL, NULL, NULL),
(47, '', '55', '55', 0, NULL, NULL, '2024-11-13 09:07:32', NULL, 2, 3, 'notice', '', NULL, NULL, NULL),
(48, '', '11', '11', 0, NULL, NULL, '2024-11-13 09:09:02', NULL, 3, 20, 'notice', '', NULL, NULL, NULL),
(50, '', '11', '11', 0, NULL, NULL, '2024-11-14 07:34:15', NULL, 0, 0, 'notice', '', NULL, NULL, NULL),
(51, '', '99', '99', 0, NULL, NULL, '2024-11-14 07:34:44', NULL, 2, 0, 'notice', '', NULL, NULL, NULL),
(52, '', '11', '11', 0, NULL, NULL, '2024-11-14 08:05:49', NULL, 1, 0, 'notice', '', NULL, NULL, NULL),
(53, '', '11', '11', 0, NULL, NULL, '2024-11-14 08:15:00', NULL, 2, 0, 'free', '', NULL, NULL, NULL),
(55, '', '222', '222', 0, NULL, NULL, '2024-11-14 08:35:37', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(56, '', '666', '666', 0, NULL, NULL, '2024-11-14 08:38:29', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(60, '', '1251515', '31461436143', 0, NULL, NULL, '2024-11-14 09:08:33', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(61, NULL, '24', '15', 0, NULL, NULL, '2024-11-17 12:42:14', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(62, NULL, '24', '15', 0, NULL, NULL, '2024-11-17 12:44:06', NULL, 1, 0, 'free', '', NULL, NULL, NULL),
(90, NULL, '이미지', '이미지', 0, NULL, NULL, '2024-11-18 04:19:54', NULL, 1, 0, 'free', './upload/logo2.png', 1, NULL, NULL),
(91, NULL, '1123', '23232', 0, NULL, NULL, '2024-11-18 05:52:09', NULL, 1, 0, 'notice', './upload/', 0, NULL, NULL),
(92, NULL, '1', '1', 0, NULL, NULL, '2024-11-18 05:59:29', NULL, 1, 0, 'notice', './upload/qqq.jpg', 1, NULL, NULL),
(93, NULL, '22', '22', 0, NULL, NULL, '2024-11-18 06:05:18', NULL, 2, 0, 'free', './upload/', 0, NULL, NULL),
(95, NULL, '123456789123456789', 'ㅁㄹㄴㅁㄻㄹㄴㅁ', 0, NULL, NULL, '2024-11-18 07:21:18', NULL, 1, 0, 'free', './upload/', 0, NULL, NULL),
(96, NULL, '123456789ㅂㅈㄷㅂ', 'ㅂㅈㅈㅂ', 0, NULL, NULL, '2024-11-18 07:22:23', NULL, 3, 0, 'notice', './upload/', 0, NULL, NULL),
(101, NULL, '11', '11', 0, NULL, NULL, '2024-11-19 01:08:32', NULL, 2, 1, 'notice', './upload/qqq3.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'admin', '관리자 뚱마루', '관리자 뚱마루', 0, NULL, NULL, '2024-11-20 04:02:28', NULL, 7, 2, 'notice', '/qc/admin/board/upload/1732075348_qqq4.jpg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'admin', '이벤트3', '이벤트3', 0, NULL, NULL, '2024-11-20 04:06:44', NULL, 6, 0, 'event', '/qc/admin/board/upload/1732075604_qqq3.png', 1, '2024-11-20 00:00:00', '2024-11-30 00:00:00'),
(107, 'admin', '123123', '123123', 0, NULL, NULL, '2024-11-24 19:39:21', NULL, 1, 0, 'free', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'admin', 'test', 'test', 0, NULL, NULL, '2024-11-24 19:40:01', NULL, 0, 0, 'free', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'kwak', '1111', '1111', 0, NULL, NULL, '2024-11-24 19:43:58', NULL, 3, 0, 'notice', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'kwak', '1111', '1111', 0, NULL, NULL, '2024-11-24 19:44:26', NULL, 1, 0, 'notice', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'kwak', '1111test', '1111etste', 0, NULL, NULL, '2024-11-24 19:45:01', NULL, 3, 0, 'notice', ' ', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'admin', '이게 뭔가요', '그러게요', 1, NULL, NULL, '2024-11-25 02:39:41', NULL, 5, 0, 'qna', '/qc/admin/board/upload/1732504358_qqq3.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 'kwak', '이거 모르겠어요', '모르겠어요', 0, NULL, NULL, '2024-11-25 02:40:56', NULL, 6, 1, 'qna', '/qc/admin/board/upload/1732780521_qqq4.jpg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 'admin', 'gdgsgsd1', 'sgassg1', 0, NULL, NULL, '2024-11-25 07:45:55', NULL, 3, 1, 'notice', '/qc/admin/board/upload/1732780305_qqq2.png', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`pid`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `board`
--
ALTER TABLE `board`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

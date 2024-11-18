-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-18 06:46
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
-- 테이블의 인덱스 `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`tid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 24-11-26 22:56
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
(101, 'A0001', '', '', 'Web', 1),
(102, 'B0001', 'A0001', '', 'Frontend', 2),
(103, 'C0001', 'B0001', 'A0001', 'HTML', 3),
(104, 'C0002', 'B0001', 'A0001', 'CSS', 3),
(105, 'C0003', 'B0001', 'A0001', 'JavaScript', 3),
(106, 'C0004', 'B0001', 'A0001', 'TypeScript', 3),
(107, 'C0005', 'B0001', 'A0001', 'WebAssembly', 3),
(108, 'B0002', 'A0001', '', 'Backend', 2),
(109, 'C0006', 'B0002', 'A0001', 'Node.js', 3),
(110, 'C0007', 'B0002', 'A0001', 'PHP', 3),
(111, 'C0008', 'B0002', 'A0001', 'Python', 3),
(112, 'C0009', 'B0002', 'A0001', 'Ruby', 3),
(113, 'C0010', 'B0002', 'A0001', 'Java', 3),
(114, 'C0011', 'B0002', 'A0001', 'Go', 3),
(115, 'B0003', 'A0001', '', 'Database', 2),
(116, 'C0013', 'B0003', 'A0001', 'MySQL', 3),
(117, 'C0014', 'B0003', 'A0001', 'PostgreSQL', 3),
(118, 'C0015', 'B0003', 'A0001', 'MongoDB', 3),
(119, 'C0016', 'B0003', 'A0001', 'Redis', 3),
(120, 'C0017', 'B0003', 'A0001', 'SQLite', 3),
(121, 'B0004', 'A0001', '', 'DevOps', 2),
(122, 'C0018', 'B0004', 'A0001', 'Docker', 3),
(123, 'C0019', 'B0004', 'A0001', 'Kubernetes', 3),
(124, 'C0020', 'B0004', 'A0001', 'Nginx/Apache', 3),
(125, 'A0002', '', '', 'App', 1),
(126, 'B0005', 'A0002', '', 'Mobile', 2),
(127, 'C0021', 'B0005', 'A0002', 'iOS', 3),
(128, 'C0022', 'B0005', 'A0002', 'Android', 3),
(129, 'B0006', 'A0002', '', 'Cross Platfrom', 2),
(130, 'C0023', 'B0006', 'A0002', 'Flutter', 3),
(131, 'C0024', 'B0006', 'A0002', 'React Native', 3),
(132, 'C0025', 'B0006', 'A0002', 'Xamarin', 3),
(133, 'C0026', 'B0006', 'A0002', 'Ionic', 3),
(134, 'B0007', 'A0002', '', 'Hybrid App', 2),
(135, 'C0027', 'B0007', 'A0002', 'Cordova', 3),
(136, 'C0028', 'B0007', 'A0002', 'PhoneGap', 3),
(137, 'B0008', 'A0002', '', 'API', 2),
(138, 'C0029', 'B0008', 'A0002', 'Firebase', 3),
(139, 'C0030', 'B0008', 'A0002', 'GraphQL', 3),
(140, 'C0031', 'B0008', 'A0002', 'REST API', 3),
(141, 'A0003', '', '', 'Game', 1),
(142, 'B0009', 'A0003', '', 'Game Engine', 2),
(143, 'C0032', 'B0009', 'A0003', 'Unity', 3),
(144, 'C0033', 'B0009', 'A0003', 'Unreal Engine', 3),
(145, 'C0034', 'B0009', 'A0003', 'Godot', 3),
(146, 'B0010', 'A0003', '', 'Game Scripting Language ', 2),
(147, 'C0035', 'B0010', 'A0003', 'Lua', 3),
(148, 'C0037', 'B0010', 'A0003', 'C#', 3),
(149, 'C0038', 'B0010', 'A0003', 'C++', 3),
(150, 'C0006', 'B0001', 'A0001', 'React', 3),
(151, 'C0007', 'B0001', 'A0001', 'Vue.js', 3);

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `lecture_category`
--
ALTER TABLE `lecture_category`
  ADD PRIMARY KEY (`lcid`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `lecture_category`
--
ALTER TABLE `lecture_category`
  MODIFY `lcid` int(11) NOT NULL AUTO_INCREMENT COMMENT '카테고리 고유번호', AUTO_INCREMENT=152;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

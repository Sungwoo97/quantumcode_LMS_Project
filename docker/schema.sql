-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: quantumcode
-- ------------------------------------------------------
-- Server version	8.0.46

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `idx` int NOT NULL AUTO_INCREMENT,
  `userid` varchar(145) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(245) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(145) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passwd` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `regdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `level` tinyint DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `end_login_date` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board`
--

DROP TABLE IF EXISTS `board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int DEFAULT '0',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pw` int DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL,
  `hit` int DEFAULT '0',
  `likes` int DEFAULT '0',
  `category` enum('notice','free','event','qna','study') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `recruit_status` tinyint NOT NULL DEFAULT '0',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_img` int DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_like`
--

DROP TABLE IF EXISTS `board_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board_like` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `l_pid` int DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `l_pid` (`l_pid`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_re_reply`
--

DROP TABLE IF EXISTS `board_re_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board_re_reply` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `r_pid` int NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `board_reply`
--

DROP TABLE IF EXISTS `board_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board_reply` (
  `pid` int NOT NULL AUTO_INCREMENT,
  `b_pid` int NOT NULL,
  `user_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pw` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_id` int NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `cid` int NOT NULL AUTO_INCREMENT,
  `coupon_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '쿠폰명',
  `coupon_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '쿠폰이미지',
  `coupon_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '쿠폰 설명',
  `coupon_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '쿠폰타입(정액,정률)',
  `coupon_price` double DEFAULT NULL COMMENT '할인금액',
  `coupon_ratio` double DEFAULT NULL COMMENT '할인비율',
  `status` tinyint DEFAULT '0' COMMENT '활성화 상태',
  `startdate` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
  `enddate` date NOT NULL COMMENT '만료일',
  `userid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '등록한유저',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coupons_usercp`
--

DROP TABLE IF EXISTS `coupons_usercp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons_usercp` (
  `ucid` int NOT NULL AUTO_INCREMENT,
  `couponid` int NOT NULL COMMENT '쿠폰아이디',
  `userid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '유저아이디',
  `status` int DEFAULT '1' COMMENT '상태',
  `use_max_date` datetime DEFAULT NULL COMMENT '만료일',
  `regdate` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '발급일',
  `usedate` date DEFAULT NULL COMMENT '사용일',
  `reason` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '쿠폰사용강의',
  PRIMARY KEY (`ucid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `courses_management`
--

DROP TABLE IF EXISTS `courses_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses_management` (
  `eid` int NOT NULL AUTO_INCREMENT COMMENT '수강 고유번호',
  `mid` int NOT NULL COMMENT '회원 ID (members.mid)',
  `lid` int NOT NULL COMMENT '강의 ID (lecture_list.lid)',
  `start_date` date NOT NULL COMMENT '수강 시작일',
  `end_date` date DEFAULT NULL COMMENT '수강 종료일',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '수강 상태 (1: 진행 중, 2: 완료, 3: 취소)',
  `progress` double DEFAULT '0' COMMENT '진도율 (%)',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록 시간',
  PRIMARY KEY (`eid`),
  KEY `mid` (`mid`),
  KEY `lid` (`lid`),
  CONSTRAINT `courses_management_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `members` (`mid`) ON DELETE CASCADE,
  CONSTRAINT `courses_management_ibfk_2` FOREIGN KEY (`lid`) REFERENCES `lecture_list` (`lid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='수강 관리 테이블';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_cart`
--

DROP TABLE IF EXISTS `lecture_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_cart` (
  `cartid` int NOT NULL AUTO_INCREMENT COMMENT '장바구니 고유번호',
  `mid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '회원 고유번호',
  `lid` int NOT NULL COMMENT '강의 고유번호',
  `price` decimal(50,0) NOT NULL COMMENT '가격',
  `regdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성시간',
  PRIMARY KEY (`cartid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_category`
--

DROP TABLE IF EXISTS `lecture_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_category` (
  `lcid` int NOT NULL AUTO_INCREMENT COMMENT '카테고리 고유번호',
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '카테고리코드',
  `pcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '카테고리 부모코드',
  `ppcode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '카테고리 최상위 코드',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '카테고리 이름',
  `step` tinyint NOT NULL COMMENT '카테고리 분류 단계',
  PRIMARY KEY (`lcid`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 카테고리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_data`
--

DROP TABLE IF EXISTS `lecture_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_data` (
  `lid` int NOT NULL AUTO_INCREMENT,
  `lecture_completion` int NOT NULL,
  `lecture_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lecture_time` time NOT NULL,
  `lecture_number` int NOT NULL,
  `lecture_date` int NOT NULL,
  `lecture_avgwatch` time NOT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_list`
--

DROP TABLE IF EXISTS `lecture_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_list` (
  `lid` int NOT NULL AUTO_INCREMENT COMMENT '강의 고유번호',
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강의 카테고리',
  `lcid` int DEFAULT NULL COMMENT '카테고리 고유 아이디',
  `title` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강의 제목',
  `cover_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '강의 커버 이미지',
  `t_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강사이름',
  `isfree` tinyint NOT NULL COMMENT '무료강의',
  `ispremium` tinyint NOT NULL COMMENT '프리미엄강의',
  `ispopular` tinyint NOT NULL COMMENT '인기강의',
  `isrecom` tinyint NOT NULL COMMENT '추천강의',
  `tuition` int NOT NULL COMMENT '수강료',
  `dis_tuition` int DEFAULT NULL COMMENT '할인 수강료',
  `regist_day` date NOT NULL COMMENT '수강시작일',
  `expiration_day` date DEFAULT NULL COMMENT '수강마감일',
  `sub_title` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '강의 요약',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강의 설명',
  `learning_obj` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '강의 목표',
  `difficult` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '난이도',
  `lecture_tag` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '강의관련 스킬',
  `pr_video` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '홍보 영상',
  `regdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성시간',
  `lecture_status` tinyint NOT NULL COMMENT '상태',
  `student_count` int DEFAULT NULL,
  PRIMARY KEY (`lid`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 목록 테이블';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_order`
--

DROP TABLE IF EXISTS `lecture_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_order` (
  `odid` int NOT NULL AUTO_INCREMENT COMMENT '주문번호',
  `mid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '회원 고유번호',
  `lid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cid` int DEFAULT NULL COMMENT '쿠폰 고유 번호',
  `order_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_key` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cancel_request` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `pay_method` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `refund_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `refund_date` datetime DEFAULT NULL,
  `total_price` decimal(10,0) NOT NULL COMMENT '최종 결제 가격',
  `status` tinyint NOT NULL COMMENT '주문 상태',
  `createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '주문 시각',
  PRIMARY KEY (`odid`),
  UNIQUE KEY `uk_order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_order_item`
--

DROP TABLE IF EXISTS `lecture_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_order_item` (
  `oiid` int NOT NULL AUTO_INCREMENT COMMENT '주문상세 고유번호',
  `odid` int NOT NULL COMMENT 'lecture_order.odid',
  `lid` int NOT NULL COMMENT 'lecture_list.lid',
  `price` decimal(10,0) NOT NULL COMMENT '구매 시점 강의 적용가',
  `paid_price` decimal(10,0) NOT NULL COMMENT '쿠폰 할인을 안분한 실제 결제액',
  `status` tinyint NOT NULL COMMENT '0 결제대기 1 결제완료 2 실패/취소 3 환불완료 4 환불요청',
  `refund_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `refund_date` datetime DEFAULT NULL,
  PRIMARY KEY (`oiid`),
  UNIQUE KEY `uk_odid_lid` (`odid`,`lid`),
  KEY `idx_lid` (`lid`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_order_item_order` FOREIGN KEY (`odid`) REFERENCES `lecture_order` (`odid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='주문에 포함된 강의 하나하나';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_progress`
--

DROP TABLE IF EXISTS `lecture_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_progress` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '수강 이력 고유번호',
  `mid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '회원 고유번호',
  `lvid` int NOT NULL COMMENT '강의영상 고유번호',
  `lid` int NOT NULL COMMENT '연결된 강의 고유번호	',
  `is_completed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '영상 완료 여부 (0: 미완료, 1: 완료)',
  `last_watched` datetime DEFAULT NULL COMMENT '마지막 시청 시간',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 시청 이력';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_reply`
--

DROP TABLE IF EXISTS `lecture_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_reply` (
  `lpid` int NOT NULL AUTO_INCREMENT COMMENT '답글 고유번호',
  `lrid` int NOT NULL,
  `profile_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '강사 프로필 이미지',
  `t_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강사 이름',
  `regist_day` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '답글',
  PRIMARY KEY (`lpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_review`
--

DROP TABLE IF EXISTS `lecture_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_review` (
  `lrid` int NOT NULL AUTO_INCREMENT COMMENT '수강평 고유번호',
  `lid` int NOT NULL COMMENT '강의 고유번호',
  `profile_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '회원 프로필 이미지',
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '회원이름',
  `regist_day` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '작성일',
  `review` int NOT NULL COMMENT '평점',
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '후기',
  PRIMARY KEY (`lrid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_video`
--

DROP TABLE IF EXISTS `lecture_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_video` (
  `lvid` int NOT NULL AUTO_INCREMENT COMMENT '강의영상 고유번호',
  `lid` int NOT NULL COMMENT '연결된 강의 고유번호',
  `t_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강사 아이디',
  `video_lecture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '강의 영상 파일경로',
  `video_title` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '강의 제목',
  `video_duration` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '영상 시간',
  `regdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록 시간',
  PRIMARY KEY (`lvid`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='강의 영상 테이블';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lecture_watch`
--

DROP TABLE IF EXISTS `lecture_watch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecture_watch` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lid` int NOT NULL,
  `lvid` int NOT NULL,
  `event_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `mid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birth` date DEFAULT NULL,
  `password` varchar(222) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `number` int NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `cover_image` varchar(111) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `grade` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'bronze',
  `last_login` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memberskakao`
--

DROP TABLE IF EXISTS `memberskakao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `memberskakao` (
  `memId` int NOT NULL AUTO_INCREMENT,
  `memName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `memPassword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `memEmail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `number` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `grade` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'bronze',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `reset_token_hash` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `account_activation_token` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `memProfilePath` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `memProfileName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `memAddr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `mem_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `memCreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memUpdatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastLoginAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `login_count` int DEFAULT '0',
  `first_coupon_issued` int NOT NULL DEFAULT '0',
  `modal_shown` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`memId`),
  UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  UNIQUE KEY `account_activation_token` (`account_activation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_course`
--

DROP TABLE IF EXISTS `sales_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_course` (
  `scid` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `month` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sales` int NOT NULL,
  PRIMARY KEY (`scid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_management`
--

DROP TABLE IF EXISTS `sales_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_management` (
  `sid` int NOT NULL AUTO_INCREMENT COMMENT '테이블 고유번호',
  `total_lecture` int NOT NULL COMMENT '총 강의 수',
  `total_student` int NOT NULL COMMENT '총 수강생',
  `total_grade` int NOT NULL COMMENT '평점',
  `total_sales` int NOT NULL COMMENT '총 매출',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales_monthly`
--

DROP TABLE IF EXISTS `sales_monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales_monthly` (
  `msid` int NOT NULL AUTO_INCREMENT,
  `month` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sales` int NOT NULL,
  PRIMARY KEY (`msid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `tid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birth` date NOT NULL,
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `number` int NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cover_image` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `teacher_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grade` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_login` datetime DEFAULT CURRENT_TIMESTAMP,
  `notyet` varchar(155) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `main` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year_sales` bigint DEFAULT NULL,
  `student_number` int DEFAULT NULL,
  `level` int NOT NULL DEFAULT '10',
  `lecture_num` int DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `toadminmessages`
--

DROP TABLE IF EXISTS `toadminmessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `toadminmessages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sender_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_read` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tomembermessages`
--

DROP TABLE IF EXISTS `tomembermessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tomembermessages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sender_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '관리자',
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `toteachermessages`
--

DROP TABLE IF EXISTS `toteachermessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `toteachermessages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sender_name` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sent_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_categories`
--

DROP TABLE IF EXISTS `user_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-25 15:50:30

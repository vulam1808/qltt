CREATE DATABASE  IF NOT EXISTS `qltt` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `qltt`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: qltt
-- ------------------------------------------------------
-- Server version	5.6.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `admin_group_id` int(11) DEFAULT NULL,
  `departments_id` int(11) DEFAULT NULL COMMENT 'thuộc fòng ban nào',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'tayson','202cb962ac59075b964b07152d234b70','tayson','0122555','Nguyá»…n Sinh ','HÃ¹ng','2015-04-13 15:07:36',0,'2015-04-13 15:07:36',0,1,1,'1995-05-10 00:00:00',1,1),(2,'admin','202cb962ac59075b964b07152d234b70','admin','01227491105','Nguyá»…n VÄƒn ','Minh','2015-05-08 08:34:40',0,'2015-05-08 08:34:40',0,1,2,'2013-07-07 00:00:00',2,1);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_group`
--

DROP TABLE IF EXISTS `admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_group`
--

LOCK TABLES `admin_group` WRITE;
/*!40000 ALTER TABLE `admin_group` DISABLE KEYS */;
INSERT INTO `admin_group` VALUES (1,'Admin','2015-04-13 15:04:09',0,'2015-04-13 15:04:09',0,1,1),(2,'Quáº£n lÃ½','2015-04-13 15:04:39',0,'2015-04-13 15:04:39',0,2,1),(3,'Äá»™i quáº£n lÃ½ thá»‹ trÆ°á»ng','2015-04-13 15:05:02',0,'2015-04-13 15:05:02',0,3,1),(4,'Doanh nghiá»‡p - Há»™ gia Ä‘Ã¬nh','2015-04-13 15:05:31',0,'2015-04-13 15:05:31',0,4,1);
/*!40000 ALTER TABLE `admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allocation_print`
--

DROP TABLE IF EXISTS `allocation_print`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allocation_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_capphat` varchar(45) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `print_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='bảng cấp phát ấn chỉ cho các đội quản lý';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allocation_print`
--

LOCK TABLES `allocation_print` WRITE;
/*!40000 ALTER TABLE `allocation_print` DISABLE KEYS */;
/*!40000 ALTER TABLE `allocation_print` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `business`
--

DROP TABLE IF EXISTS `business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `notes` varchar(45) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `ward_id` int(11) DEFAULT NULL,
  `type_business` int(11) DEFAULT NULL,
  `address_business` varchar(45) DEFAULT NULL,
  `careers` varchar(45) DEFAULT NULL,
  `SCNDKKD` varchar(45) DEFAULT NULL,
  `created_DKKD` datetime DEFAULT NULL,
  `place_Of_DKKD` varchar(45) DEFAULT NULL,
  `isBusiness` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='doanh nghiệp/hộ kinh doanh';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `business`
--

LOCK TABLES `business` WRITE;
/*!40000 ALTER TABLE `business` DISABLE KEYS */;
INSERT INTO `business` VALUES (3,'d','r','rr',3,38,39,NULL,'r',NULL,'r','0000-00-00 00:00:00','r',0,'2015-05-11 10:29:49',0,'2015-05-11 10:29:49',0,1,5),(4,'d','sd','dsdsd',3,47,17,0,'dsd',NULL,'dsd','0000-00-00 00:00:00','dsdsds',0,'2015-05-11 10:57:18',0,'2015-05-11 10:57:18',0,1,3),(5,'ss','sdsd',' etwÃªtwt',3,40,43,0,'áº»e',NULL,'rÆ°áº»wáº»','0000-00-00 00:00:00','rÃªtrte',0,'2015-05-11 14:10:01',0,'2015-05-11 14:10:01',0,1,2147483647),(6,'fsdf','fdf','fdfd',3,40,32,0,'fdfd',NULL,'fdfd','0000-00-00 00:00:00','fdfdsf',0,'2015-05-11 14:11:30',0,'2015-05-11 14:11:30',0,0,0);
/*!40000 ALTER TABLE `business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commodity`
--

DROP TABLE IF EXISTS `commodity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commodity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `type_commodity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commodity`
--

LOCK TABLES `commodity` WRITE;
/*!40000 ALTER TABLE `commodity` DISABLE KEYS */;
INSERT INTO `commodity` VALUES (1,'áº£','s','2015-04-14 15:12:35',0,'2015-04-14 15:25:49',0,123,1,1),(2,'dsd','wew','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL,NULL,NULL,1),(3,'sdd','rer fg hgf','2015-05-04 09:22:10',0,'2015-05-04 09:22:10',0,45,1,1),(4,'abc','a','2015-05-14 09:06:36',1,'2015-05-14 09:06:36',1,3,1,1),(5,'w','woso','2015-05-14 09:09:24',1,'2015-05-14 09:09:24',1,3,1,1),(6,'w','woso','2015-05-14 09:09:24',1,'2015-05-14 09:09:24',1,3,1,1);
/*!40000 ALTER TABLE `commodity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criteria`
--

DROP TABLE IF EXISTS `criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `alias` varchar(45) DEFAULT NULL COMMENT 'tên viết tắt của tiêu chí',
  `notes` text COMMENT 'Diễn giải (ghi chú)',
  `type_criteria` int(11) DEFAULT NULL COMMENT 'mã loại tiêu chí',
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `tool` varchar(45) DEFAULT NULL COMMENT 'Dụng cụ để hiển thị trường tiêu chí này',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='tiêu chí';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criteria`
--

LOCK TABLES `criteria` WRITE;
/*!40000 ALTER TABLE `criteria` DISABLE KEYS */;
INSERT INTO `criteria` VALUES (1,'Äá»‹a Ä‘iá»ƒm kinh doanh ngoÃ i trá»¥ sá»Ÿ chÃ­nh','DDKDNTS','-Ä‘iá»…n giáº£i-1\r\n-Ä‘iá»…n giáº£i 2',1,1,1,'2015-04-15 15:07:07',0,'2015-04-15 15:07:07',0,''),(2,'Giáº¥y phÃ©p kinh doanh ngoÃ i trá»¥ sá»Ÿ chÃ­nh','GPKDNTSC','- HÆ°á»›ng dáº«n sá»­ dá»¥ng 1\r\n- HÆ°á»›ng dáº«n sá»­ dá»¥ng 2\r\n- HÆ°á»›ng dáº«n sá»­ dá»¥ng 3',2,1,1,'2015-04-15 15:16:24',0,'2015-04-15 15:16:24',0,'ListBox'),(3,'HÃ ng mua láº­u','HML','- liá»‡t kÃª tÃªn hÃ ng mua láº­u\r\n- Ghi rÃµ tÃ¬nh tráº¡ng hÃ ng hÃ³a vÃ  sá»‘ lÆ°á»£ng',2,1,1,'2015-04-17 08:57:18',0,'2015-04-17 08:57:18',0,'ComBoBox'),(4,'ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC AB ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC AB ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC ABC AB ABC ABC ABC ABC ABC ABC ABC','ABC','- A\r\n- B\r\n- C\r\n- D\r\n- F',1,2,1,'2015-04-17 08:58:16',0,'2015-04-17 08:58:16',0,'TextArea'),(5,'ass','ass','- a\r\n- b\r\n- c\r\n- d',2,4,1,'2015-04-17 08:59:23',0,'2015-04-17 08:59:23',0,'ComBoBox'),(6,'a','d','f',1,4,1,'2015-04-17 09:02:38',0,'2015-04-17 09:02:38',0,'ListBox'),(7,'kiá»ƒm tra máº«u','kt ','- dÃ¹ng cho A\r\n- dÃ¹ng cho kinh doanh máº·t hÃ ng abc',2,1,1,'2015-05-06 16:24:35',0,'2015-05-06 16:24:35',0,NULL),(10,'TÃªn tiÃªu chÃ­ 1','ABCD','- DÃ¹ng cho há»™ kinh doanh\r\n- DÃ¹ng cho doanh nghiá»‡p',1,2,1,'2015-05-14 09:14:38',1,'2015-05-14 09:14:38',1,NULL);
/*!40000 ALTER TABLE `criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `leader` int(11) DEFAULT NULL COMMENT 'người đại diện',
  `type_department_id` int(11) DEFAULT NULL COMMENT 'loại fòng',
  `parent_id` int(11) DEFAULT NULL,
  `delstatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (41,'DTT003','Äá»™i thá»‹ trÆ°á»ng VÃ¢n Canh','2015-05-07 10:26:18',0,'2015-05-07 10:26:18',0,3,1,1,3,NULL,0),(42,'DTT002','Äá»™i thá»‹ trÆ°á»ng VÃ¢n Canh','2015-05-07 10:39:09',0,'2015-05-07 10:39:09',0,2,1,1,3,NULL,0),(43,'PAC001','PhÃ²ng áº¥n chá»‰ VÄ©nh Tháº¡nh','2015-05-07 10:44:38',0,'2015-05-07 10:44:38',0,2,1,1,1,NULL,0),(44,'PAC002','PhÃ²ng áº¥n chá»‰ TÃ¢y SÆ¡n','2015-05-07 10:45:22',0,'2015-05-07 10:45:22',0,5,1,1,1,NULL,0);
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `district`
--

DROP TABLE IF EXISTS `district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `delstatus` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `district`
--

LOCK TABLES `district` WRITE;
/*!40000 ALTER TABLE `district` DISABLE KEYS */;
INSERT INTO `district` VALUES (46,'VTH','VÄ©nh Háº£o',5,'2015-04-25 01:15:30',0,'2015-04-25 01:15:30',0,3,0,0),(47,'z','Sa Tháº§y',3,'2015-05-06 04:35:02',0,'2015-05-06 04:35:02',0,0,1,0),(224,'tt','ii',3,'2015-05-13 15:43:52',0,'2015-05-13 15:43:52',0,NULL,NULL,0),(225,'kk','tt',3,'2015-05-13 15:43:53',0,'2015-05-13 15:43:53',0,NULL,NULL,0),(226,'gg','gg',3,'2015-05-13 15:43:53',0,'2015-05-13 15:43:53',0,NULL,NULL,0),(251,'a','t',3,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0),(252,'b','h',3,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0),(253,'c','n',5,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0),(254,'d','m',3,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0),(255,'e','u',5,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0),(256,'g','o',3,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0),(257,'pp','uu',3,'2015-05-13 15:47:25',0,'2015-05-13 15:47:25',0,NULL,NULL,0);
/*!40000 ALTER TABLE `district` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(225) DEFAULT NULL,
  `description` varchar(225) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `status` datetime DEFAULT '0000-00-00 00:00:00',
  `content` int(11) DEFAULT NULL,
  `event` tinyint(1) DEFAULT NULL,
  `news_cat_id` varchar(225) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'zxz','xzx','2015-04-13 15:30:58',0,'0000-00-00 00:00:00',0,1,'2','2015-04-13 15:30:58','0');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_category`
--

DROP TABLE IF EXISTS `news_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_category`
--

LOCK TABLES `news_category` WRITE;
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
INSERT INTO `news_category` VALUES (1,'a','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL),(2,'b','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL),(3,'c','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print`
--

DROP TABLE IF EXISTS `print`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `coefficient` int(11) DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00' COMMENT 'ngày tạo ấn chỉ',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='bảng Ấn chỉ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print`
--

LOCK TABLES `print` WRITE;
/*!40000 ALTER TABLE `print` DISABLE KEYS */;
INSERT INTO `print` VALUES (1,'ad','dfdf',4,21,3,0,'2015-05-09 08:34:17',0,'2015-05-09 08:34:17',0),(2,'ad','dfdf',3,21,3,0,'2015-05-09 08:34:18',0,'2015-05-09 08:34:18',0),(3,'e','Thu NgÃ¢n',5,74,NULL,0,'2015-05-09 09:10:09',0,'2015-05-09 09:10:09',0),(4,'ma','dfdsgs',4,6,NULL,0,'2015-05-09 09:10:58',0,'2015-05-09 09:10:58',0);
/*!40000 ALTER TABLE `print` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `province`
--

DROP TABLE IF EXISTS `province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `delstatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `province`
--

LOCK TABLES `province` WRITE;
/*!40000 ALTER TABLE `province` DISABLE KEYS */;
INSERT INTO `province` VALUES (3,'QNA','Quáº£ng Nam','2015-04-14 14:03:50',0,'2015-05-06 08:35:05',0,3,1,0),(5,'BDI2','Binh Dinh 2','2015-04-19 15:47:03',0,'2015-05-06 08:33:09',0,15,1,0);
/*!40000 ALTER TABLE `province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scale_enterprises`
--

DROP TABLE IF EXISTS `scale_enterprises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scale_enterprises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scale_enterprises`
--

LOCK TABLES `scale_enterprises` WRITE;
/*!40000 ALTER TABLE `scale_enterprises` DISABLE KEYS */;
INSERT INTO `scale_enterprises` VALUES (1,'ad','qÆ°á»ƒ','2015-04-14 15:57:39',0,'2015-04-14 15:57:39',0,1,1,'<p>ghi ch&uacute;</p>\r\n'),(2,'dsd','add','2015-05-04 09:21:19',0,'2015-05-04 09:21:19',0,3,1,'<p>dsdsf</p>\r\n');
/*!40000 ALTER TABLE `scale_enterprises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_business`
--

DROP TABLE IF EXISTS `type_business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_business`
--

LOCK TABLES `type_business` WRITE;
/*!40000 ALTER TABLE `type_business` DISABLE KEYS */;
INSERT INTO `type_business` VALUES (1,'HANG CAM','hang cam','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL,NULL,NULL),(2,'Hang de chay','hang de chay','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL,NULL,NULL),(3,'ndc','nuoc dong chai','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL,NULL,NULL);
/*!40000 ALTER TABLE `type_business` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_commodity`
--

DROP TABLE IF EXISTS `type_commodity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_commodity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_commodity`
--

LOCK TABLES `type_commodity` WRITE;
/*!40000 ALTER TABLE `type_commodity` DISABLE KEYS */;
INSERT INTO `type_commodity` VALUES (1,'a','v12','2015-04-14 14:55:13',0,'2015-04-14 15:03:56',0,1,1);
/*!40000 ALTER TABLE `type_commodity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_criteria`
--

DROP TABLE IF EXISTS `type_criteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COMMENT='Loại tiêu chí';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_criteria`
--

LOCK TABLES `type_criteria` WRITE;
/*!40000 ALTER TABLE `type_criteria` DISABLE KEYS */;
INSERT INTO `type_criteria` VALUES (1,'Tieu chi cho doanh nghiep','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL),(2,'Tieu chi cho ho kinh doanh','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL),(3,NULL,'0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `type_criteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type_departments`
--

DROP TABLE IF EXISTS `type_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type_departments`
--

LOCK TABLES `type_departments` WRITE;
/*!40000 ALTER TABLE `type_departments` DISABLE KEYS */;
INSERT INTO `type_departments` VALUES (1,'Phong An Chi','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL),(2,'Phong Xu Phat','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL),(3,'Doi cong tac','0000-00-00 00:00:00',NULL,'0000-00-00 00:00:00',NULL);
/*!40000 ALTER TABLE `type_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `birthday` datetime DEFAULT '0000-00-00 00:00:00',
  `order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `departments_id` int(11) DEFAULT NULL,
  `chucvu` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'user','202cb962ac59075b964b07152d234b70','01222888','van a','hung','2015-04-13 15:15:14',0,'2015-04-13 15:15:14',0,NULL,1,1,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `violations`
--

DROP TABLE IF EXISTS `violations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `violations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `violations`
--

LOCK TABLES `violations` WRITE;
/*!40000 ALTER TABLE `violations` DISABLE KEYS */;
INSERT INTO `violations` VALUES (1,'cxc','sdsd','2015-04-14 16:07:59',0,'2015-04-14 16:07:59',0,1,1,'<p>adsd</p>\r\n'),(2,'qaaaÃ¢','sssssssssssss','2015-04-14 16:09:50',0,'2015-04-14 16:09:50',0,123,1,'<p>rrrrrrrrrrrrr</p>\r\n');
/*!40000 ALTER TABLE `violations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ward`
--

DROP TABLE IF EXISTS `ward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `delstatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ward`
--

LOCK TABLES `ward` WRITE;
/*!40000 ALTER TABLE `ward` DISABLE KEYS */;
INSERT INTO `ward` VALUES (7,'add',47,'2015-05-04 09:16:23',0,'2015-05-04 09:16:23',0,45,1,0),(14,'sss',47,'2015-05-06 03:13:53',0,'2015-05-06 03:13:53',0,2,0,0);
/*!40000 ALTER TABLE `ward` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'qltt'
--

--
-- Dumping routines for database 'qltt'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-14  9:32:55

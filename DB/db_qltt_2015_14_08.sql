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
-- Table structure for table `doc_items_handling`
--

DROP TABLE IF EXISTS `doc_items_handling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_items_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_items_id` int(11) DEFAULT NULL COMMENT 'Liên kết bảng danh mục hàng hóa lấy tên hàng hóa',
  `master_sanction_id` int(11) DEFAULT NULL COMMENT 'Hình thức xử lý hàng:\r\n+ Đấu thầu\r\n+ Tiêu hủy\r\n+ Khác',
  `doc_violations_handling_id` int(11) DEFAULT NULL COMMENT 'bảng xử lý vi phạm (trong xử lý vi phạm có nhiều loại hàng đc lưu)',
  `serial_handling` varchar(255) DEFAULT NULL COMMENT 'Số biên lai tịch thu hàng',
  `quantity_commodity` varchar(255) DEFAULT NULL COMMENT 'Số lượng hàng hóa tịch thu',
  `master_unit_id` int(11) DEFAULT NULL COMMENT 'Đơn vị tính số lượng tịch thu hàng hóa (cái, chiếc , lô ...)',
  `date_handling` datetime DEFAULT NULL COMMENT 'Ngày giờ tịch thu hàng hóa:\r\n+ Ngày giờ đấu thầu nếu chọn Hình thức xử lý(type_handling) là đấu thầu\r\n+ Ngày giờ tiêu hủy nếu chọn Hình thức xử lý(type_handling) là tiêu hủy',
  `amount` double DEFAULT NULL COMMENT 'Số tiền nhập vào nếu Hình thức xử lý(type_handling) là đấu thầu',
  `file_upload` varchar(255) DEFAULT NULL COMMENT 'file upload nếu có',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_commodity_id` (`master_items_id`),
  KEY `doc_violations_handling_id` (`doc_violations_handling_id`),
  KEY `master_unit_id` (`master_unit_id`),
  KEY `modified_by` (`modified_by`),
  KEY `created_by` (`created_by`),
  KEY `master_sanction` (`master_sanction_id`),
  CONSTRAINT `doc_items_handling_ibfk_2` FOREIGN KEY (`doc_violations_handling_id`) REFERENCES `doc_violations_handling` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_3` FOREIGN KEY (`master_unit_id`) REFERENCES `master_unit` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_4` FOREIGN KEY (`master_sanction_id`) REFERENCES `master_sanction` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Bảng xử lý hàng hóa khi tịch thu hàng';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `doc_print_allocation`
--

DROP TABLE IF EXISTS `doc_print_allocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_print_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_print_create_id` int(11) DEFAULT NULL,
  `master_print_id` int(11) DEFAULT NULL COMMENT 'bảng tạo ấn chỉ',
  `sys_department_id` int(11) DEFAULT NULL COMMENT 'Phòng ban',
  `sys_user_id` int(11) DEFAULT NULL COMMENT 'Nhân viên đc cấp phát',
  `request_number` varchar(255) DEFAULT NULL COMMENT 'giay de nghi cap an chi. Mã số',
  `date_allocation` datetime DEFAULT NULL COMMENT 'ngày cấp phát',
  `serial_recovery1` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_print_allocation_ibfk_2` (`sys_department_id`),
  KEY `doc_print_allocation_ibfk_1` (`master_print_id`),
  KEY `doc_print_create_id` (`doc_print_create_id`),
  KEY `sys_user_id` (`sys_user_id`),
  CONSTRAINT `doc_print_allocation_ibfk_1` FOREIGN KEY (`master_print_id`) REFERENCES `master_print` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_2` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_3` FOREIGN KEY (`doc_print_create_id`) REFERENCES `doc_print_create` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_4` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `doc_print_create`
--

DROP TABLE IF EXISTS `doc_print_create`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_print_create` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL COMMENT 'số hóa đơn mua ấn chỉ',
  `master_print_id` int(11) DEFAULT NULL COMMENT 'bảng tên ấn chỉ',
  `coefficient` int(11) DEFAULT NULL COMMENT 'Số quyển',
  `serial` varchar(255) DEFAULT NULL COMMENT 'số ấn chỉ',
  `serial_recovery` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT '0',
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_print_create_ibfk_1` (`master_print_id`),
  CONSTRAINT `doc_print_create_ibfk_1` FOREIGN KEY (`master_print_id`) REFERENCES `master_print` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `doc_print_handling`
--

DROP TABLE IF EXISTS `doc_print_handling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_print_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_print_id` int(11) DEFAULT NULL COMMENT 'ten ấn chỉ',
  `doc_print_allocation_id` int(11) DEFAULT NULL COMMENT 'ấn chỉ dc cap',
  `doc_violations_handling_id` int(11) DEFAULT NULL COMMENT 'bảng xử lý vi phạm (trong xử lý vi phạm có nhiều loại ấn chỉ đc lưu)',
  `serial_handing` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_violations_handling_id` (`doc_violations_handling_id`),
  KEY `doc_print_handling_ibfk_1` (`master_print_id`),
  KEY `doc_print_allocation_id` (`doc_print_allocation_id`),
  CONSTRAINT `doc_print_handling_ibfk_1` FOREIGN KEY (`master_print_id`) REFERENCES `master_print` (`id`),
  CONSTRAINT `doc_print_handling_ibfk_2` FOREIGN KEY (`doc_violations_handling_id`) REFERENCES `doc_violations_handling` (`id`),
  CONSTRAINT `doc_print_handling_ibfk_3` FOREIGN KEY (`doc_print_allocation_id`) REFERENCES `doc_print_allocation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='Bảng ấn chỉ vi phạm';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `doc_print_payment`
--

DROP TABLE IF EXISTS `doc_print_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_print_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sys_department_id` int(11) DEFAULT NULL COMMENT 'đơn vị',
  `sys_user_id` int(11) DEFAULT NULL COMMENT 'Nhân viên đi thanh toán',
  `doc_print_allocation_id` int(11) DEFAULT NULL COMMENT 'id đã cấp phát',
  `master_print_id` int(11) DEFAULT NULL,
  `serial_recovery` varchar(255) DEFAULT NULL COMMENT 'thu hồi ấn chỉ',
  `serial_fail` varchar(255) DEFAULT NULL COMMENT 'serial hư hỏng',
  `reasons_fail` varchar(255) DEFAULT NULL COMMENT 'Lý do hư hỏng',
  `date_payment` datetime DEFAULT NULL COMMENT 'ngày thanh toán',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_department_id` (`sys_department_id`),
  KEY `sys_user_id` (`sys_user_id`),
  KEY `doc_print_allocation_id` (`doc_print_allocation_id`),
  KEY `master_print_id` (`master_print_id`),
  CONSTRAINT `doc_print_payment_ibfk_1` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_print_payment_ibfk_2` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`),
  CONSTRAINT `doc_print_payment_ibfk_3` FOREIGN KEY (`doc_print_allocation_id`) REFERENCES `doc_print_allocation` (`id`),
  CONSTRAINT `doc_print_payment_ibfk_4` FOREIGN KEY (`master_print_id`) REFERENCES `master_print` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `doc_violations_handling`
--

DROP TABLE IF EXISTS `doc_violations_handling`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doc_violations_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_business_id` int(11) DEFAULT NULL COMMENT 'Doanh nghiệp vi phạm',
  `master_violation_id` varchar(255) DEFAULT NULL COMMENT 'bảng hành vi vi phạm',
  `master_sanctions_id` int(11) DEFAULT NULL COMMENT 'bảng hình thức xử lý',
  `sys_department_id` int(11) DEFAULT NULL COMMENT 'bảng phòng ban',
  `sys_user_id` int(11) DEFAULT NULL COMMENT 'user xử lý',
  `date_violation` datetime DEFAULT NULL COMMENT 'Ngày vi phạm',
  `info_schedule_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_violations_handling_ibfk_5` (`info_business_id`),
  KEY `doc_violations_handling_ibfk_3` (`sys_department_id`),
  KEY `doc_violations_handling_ibfk_2` (`master_sanctions_id`),
  KEY `doc_violations_handling_ibfk_1` (`master_violation_id`),
  KEY `sys_user_id` (`sys_user_id`),
  KEY `info_schedule_id` (`info_schedule_id`),
  CONSTRAINT `doc_violations_handling_ibfk_2` FOREIGN KEY (`master_sanctions_id`) REFERENCES `master_sanction` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_3` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_5` FOREIGN KEY (`info_business_id`) REFERENCES `info_business` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_6` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_7` FOREIGN KEY (`info_schedule_id`) REFERENCES `info_schedule` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='Bảng xử lý vi phạm';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_business`
--

DROP TABLE IF EXISTS `info_business`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `license_business` varchar(255) DEFAULT NULL COMMENT 'Số giấy chứng nhận đăng ký kinh doanh',
  `date_license` datetime DEFAULT NULL COMMENT 'Ngày cấp chứng nhận đăng ký kinh doanh',
  `place_license` varchar(255) DEFAULT NULL COMMENT 'nơi cấp  chứng nhận đăng ký kinh doanh',
  `address_office` varchar(255) DEFAULT NULL COMMENT 'Trụ sở chính',
  `address_branch` varchar(255) DEFAULT NULL COMMENT 'địa điểm kinh doanh ngoài trụ sở',
  `work_business` varchar(255) DEFAULT NULL COMMENT 'ngành nghề kinh doanh',
  `phone` varchar(255) DEFAULT NULL,
  `boss_business` varchar(255) DEFAULT NULL COMMENT 'tên chủ doanh nghiệp',
  `address_permanent` varchar(255) DEFAULT NULL COMMENT 'địa chỉ thường trú',
  `cellphone` varchar(255) DEFAULT NULL COMMENT 'điện thoại di động',
  `license_condition_business` varchar(255) DEFAULT NULL COMMENT 'giấy chứng nhận đủ điều kiện kinh doanh',
  `date_license_condition_business` varchar(255) DEFAULT NULL COMMENT 'ngày cấp giấy chứng nhận kinh doanh có điều kiện',
  `master_items_limit_id` varchar(255) DEFAULT NULL COMMENT 'mặt hàng hạn chế kinh doanh',
  `master_items_condition_id` varchar(255) DEFAULT NULL COMMENT 'mặt hàng kinh doanh có điều kiện',
  `master_province_id` int(11) DEFAULT NULL,
  `master_district_id` int(11) DEFAULT NULL,
  `master_ward_id` int(11) DEFAULT NULL,
  `master_business_type_id` int(11) DEFAULT NULL COMMENT 'Loại hình kinh doanh (Cty trách nhiệm hữu hạn ....)',
  `master_business_size_id` int(11) DEFAULT NULL COMMENT 'Quy mô doanh nghiệp (Vừa, nhỏ, ...)',
  `date_check` datetime DEFAULT NULL COMMENT 'ngày kiểm tra',
  `type_business` varchar(255) DEFAULT NULL COMMENT 'loại doanh nghiệp: doanh nghiệp, hộ kinh doanh, DN ngoài địa bàn',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_business_ibfk_4` (`master_business_size_id`),
  KEY `master_business_ibfk_3` (`master_business_type_id`),
  KEY `master_business_ibfk_1` (`master_district_id`),
  KEY `master_business_ibfk_2` (`master_ward_id`),
  KEY `master_province_id` (`master_province_id`),
  CONSTRAINT `info_business_ibfk_1` FOREIGN KEY (`master_district_id`) REFERENCES `master_district` (`id`),
  CONSTRAINT `info_business_ibfk_2` FOREIGN KEY (`master_ward_id`) REFERENCES `master_ward` (`id`),
  CONSTRAINT `info_business_ibfk_3` FOREIGN KEY (`master_business_type_id`) REFERENCES `master_business_type` (`id`),
  CONSTRAINT `info_business_ibfk_4` FOREIGN KEY (`master_business_size_id`) REFERENCES `master_business_size` (`id`),
  CONSTRAINT `info_business_ibfk_5` FOREIGN KEY (`master_province_id`) REFERENCES `master_province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Bảng doanh nghiệp';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_schedule`
--

DROP TABLE IF EXISTS `info_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_schedule` varchar(255) DEFAULT NULL COMMENT 'tên lịch kiểm tra',
  `date_from` datetime DEFAULT NULL COMMENT 'thời gian kiểm tra',
  `date_to` datetime DEFAULT NULL,
  `sys_department_id` int(11) DEFAULT NULL COMMENT 'phòng ban sẽ kiểm tra',
  `master_district_id` int(11) DEFAULT NULL COMMENT 'kiểm tra tại quận huyện',
  `master_ward_id` int(11) DEFAULT NULL COMMENT 'phường xã',
  `is_confirm` tinyint(4) DEFAULT '0' COMMENT 'Xác nhận sẽ đi kiểm tra',
  `confirm_sys_user_id` int(11) DEFAULT NULL COMMENT 'user xác nhận',
  `confirm_date` datetime DEFAULT NULL COMMENT 'Ngày xác nhận',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_department_id` (`sys_department_id`),
  KEY `master_district_id` (`master_district_id`),
  KEY `master_ward_id` (`master_ward_id`),
  KEY `confirm_sys_user_id` (`confirm_sys_user_id`),
  CONSTRAINT `info_schedule_ibfk_1` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `info_schedule_ibfk_2` FOREIGN KEY (`master_district_id`) REFERENCES `master_district` (`id`),
  CONSTRAINT `info_schedule_ibfk_3` FOREIGN KEY (`master_ward_id`) REFERENCES `master_ward` (`id`),
  CONSTRAINT `info_schedule_ibfk_4` FOREIGN KEY (`confirm_sys_user_id`) REFERENCES `sys_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `info_schedule_check`
--

DROP TABLE IF EXISTS `info_schedule_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info_schedule_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_schedule_id` int(11) DEFAULT NULL COMMENT 'kiểm tra theo lịch',
  `info_business_id` int(11) DEFAULT NULL COMMENT 'Doanh nghiệp đã kiểm tra',
  `sys_department_id` int(11) DEFAULT NULL,
  `doc_print_allocation_id` int(11) DEFAULT NULL COMMENT 'Ấn chỉ đc cấp đã đi kiểm tra',
  `serial_check` varchar(255) DEFAULT NULL,
  `date_check` datetime DEFAULT NULL COMMENT 'Ngày kiểm tra',
  `staff_check` int(11) DEFAULT NULL COMMENT 'Nhân viên kiểm tra',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `info_schedule_id` (`info_schedule_id`),
  KEY `info_business_id` (`info_business_id`),
  KEY `doc_print_allocation_id` (`doc_print_allocation_id`),
  KEY `sys_department_id` (`sys_department_id`),
  CONSTRAINT `info_schedule_check_ibfk_1` FOREIGN KEY (`info_schedule_id`) REFERENCES `info_schedule` (`id`),
  CONSTRAINT `info_schedule_check_ibfk_2` FOREIGN KEY (`info_business_id`) REFERENCES `info_business` (`id`),
  CONSTRAINT `info_schedule_check_ibfk_3` FOREIGN KEY (`doc_print_allocation_id`) REFERENCES `doc_print_allocation` (`id`),
  CONSTRAINT `info_schedule_check_ibfk_4` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_business_size`
--

DROP TABLE IF EXISTS `master_business_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_business_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Quy mô doanh nghiệp : vừa, nhỏ, to ....';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_business_type`
--

DROP TABLE IF EXISTS `master_business_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_business_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Loại hình kinh doanh: cty TNHH, cty TNHH 1 thành viên ...';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_district`
--

DROP TABLE IF EXISTS `master_district`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_district` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `master_province_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_province_id` (`master_province_id`),
  CONSTRAINT `master_district_ibfk_1` FOREIGN KEY (`master_province_id`) REFERENCES `master_province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='danh mục quận huyện';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_items`
--

DROP TABLE IF EXISTS `master_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type_commodity` varchar(255) DEFAULT NULL COMMENT 'Loại hàng hóa:\r\n+ Kinh Doanh Có điều kiện \r\n+ Mặt hàng hạn chế kinh doanh',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Bảng danh mục tên hàng hóa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_items_condition`
--

DROP TABLE IF EXISTS `master_items_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_items_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục mặt hàng kinh doanh có điều kiện';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_items_limit`
--

DROP TABLE IF EXISTS `master_items_limit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_items_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục mặt hàng hạn chế kinh doanh';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_print`
--

DROP TABLE IF EXISTS `master_print`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_print` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='danh mục tên ấn chỉ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_province`
--

DROP TABLE IF EXISTS `master_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='bảng tỉnh thành';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_sanction`
--

DROP TABLE IF EXISTS `master_sanction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_sanction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL COMMENT 'Phân loại thuộc hình thức xử lý thuộc loại nào (theo enum):\r\n+ Cho bảng Tịch thu hàng hóa (doc_items_handling)\r\n+ Cho Bảng xử lý vi phạm (doc_violations_handling)',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục hình thức xử lý';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_unit`
--

DROP TABLE IF EXISTS `master_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='bảng đơn vị tính';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_violation`
--

DROP TABLE IF EXISTS `master_violation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_violation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  `decree` varchar(255) DEFAULT NULL,
  `article` varchar(255) DEFAULT NULL,
  `clause` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='bảng hành vi vi phạm';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `master_ward`
--

DROP TABLE IF EXISTS `master_ward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_ward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `master_district_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_district_id` (`master_district_id`),
  CONSTRAINT `master_ward_ibfk_1` FOREIGN KEY (`master_district_id`) REFERENCES `master_district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8 COMMENT='Bảng phường xã';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `saleperorder`
--

DROP TABLE IF EXISTS `saleperorder`;
/*!50001 DROP VIEW IF EXISTS `saleperorder`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `saleperorder` (
  `master_print_id` tinyint NOT NULL,
  `coefficient` tinyint NOT NULL,
  `invoice_number` tinyint NOT NULL,
  `serial` tinyint NOT NULL,
  `id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `sys_department`
--

DROP TABLE IF EXISTS `sys_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `leader` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'phòng ban con ',
  `is_root` tinyint(4) DEFAULT '0' COMMENT 'phòng ban gốc',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `master_department_ibfk_2` (`parent_id`),
  CONSTRAINT `sys_department_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `sys_department` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='bảng phòng ban';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_privileges`
--

DROP TABLE IF EXISTS `sys_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL COMMENT 'Add, edit, view, delete ...',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng đặc quyền ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_user`
--

DROP TABLE IF EXISTS `sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cellphone` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthday` datetime DEFAULT '0000-00-00 00:00:00',
  `sys_department_id` int(11) DEFAULT NULL,
  `master_province_id` int(11) DEFAULT NULL,
  `master_district_id` int(11) DEFAULT NULL,
  `master_ward_id` int(11) DEFAULT NULL,
  `is_leader` float DEFAULT NULL,
  `sys_user_group_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_user_ibfk_1` (`sys_department_id`),
  KEY `sys_user_ibfk_2` (`sys_user_group_id`),
  KEY `master_province_id` (`master_province_id`),
  KEY `master_district_id` (`master_district_id`),
  KEY `master_ward_id` (`master_ward_id`),
  CONSTRAINT `sys_user_ibfk_1` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `sys_user_ibfk_2` FOREIGN KEY (`sys_user_group_id`) REFERENCES `sys_user_group` (`id`),
  CONSTRAINT `sys_user_ibfk_3` FOREIGN KEY (`master_province_id`) REFERENCES `master_province` (`id`),
  CONSTRAINT `sys_user_ibfk_4` FOREIGN KEY (`master_district_id`) REFERENCES `master_district` (`id`),
  CONSTRAINT `sys_user_ibfk_5` FOREIGN KEY (`master_ward_id`) REFERENCES `master_ward` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='bảng người dùng';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_user_group`
--

DROP TABLE IF EXISTS `sys_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_code` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='bảng nhóm user';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sys_user_group_detail`
--

DROP TABLE IF EXISTS `sys_user_group_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_user_group_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sys_user_group_id` int(11) DEFAULT NULL,
  `sys_privileges` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sys_user_group_detail_ibfk_2` (`sys_privileges`),
  KEY `sys_user_group_detail_ibfk_1` (`sys_user_group_id`),
  CONSTRAINT `sys_user_group_detail_ibfk_1` FOREIGN KEY (`sys_user_group_id`) REFERENCES `sys_user_group` (`id`),
  CONSTRAINT `sys_user_group_detail_ibfk_2` FOREIGN KEY (`sys_privileges`) REFERENCES `sys_privileges` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng chi tiet quyền của nhóm user';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'qltt'
--

--
-- Dumping routines for database 'qltt'
--

--
-- Final view structure for view `saleperorder`
--

/*!50001 DROP TABLE IF EXISTS `saleperorder`*/;
/*!50001 DROP VIEW IF EXISTS `saleperorder`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `saleperorder` AS select `doc_print_create`.`master_print_id` AS `master_print_id`,`doc_print_create`.`coefficient` AS `coefficient`,`doc_print_create`.`invoice_number` AS `invoice_number`,`doc_print_create`.`serial` AS `serial`,`doc_print_allocation`.`id` AS `id` from (`doc_print_allocation` join `doc_print_create` on(((`doc_print_create`.`id` = `doc_print_allocation`.`doc_print_create_id`) and (month(`doc_print_create`.`created_date`) = 6) and (year(`doc_print_create`.`created_date`) = 2015) and (`doc_print_create`.`master_print_id` = 1)))) where ((month(`doc_print_allocation`.`date_allocation`) = 6) and (year(`doc_print_allocation`.`date_allocation`) = 2015)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-14 14:14:09

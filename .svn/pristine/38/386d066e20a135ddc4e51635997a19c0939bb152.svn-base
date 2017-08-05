/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : qltt_new

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-06-04 14:59:53
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `doc_items_handling`
-- ----------------------------
DROP TABLE IF EXISTS `doc_items_handling`;
CREATE TABLE `doc_items_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_items_id` int(11) DEFAULT NULL COMMENT 'Liên kết bảng danh mục hàng hóa lấy tên hàng hóa',
  `master_sanction_id` int(11) DEFAULT NULL COMMENT 'Hình thức xử lý hàng:\r\n+ Đấu thầu\r\n+ Tiêu hủy\r\n+ Khác',
  `doc_violations_handling_id` int(11) DEFAULT NULL COMMENT 'bảng xử lý vi phạm (trong xử lý vi phạm có nhiều loại hàng đc lưu)',
  `serial_handling` int(11) DEFAULT NULL COMMENT 'Số biên lai tịch thu hàng',
  `quantity_commodity` int(11) DEFAULT NULL COMMENT 'Số lượng hàng hóa tịch thu',
  `master_unit_id` int(11) DEFAULT NULL COMMENT 'Đơn vị tính số lượng tịch thu hàng hóa (cái, chiếc , lô ...)',
  `date_handling` datetime DEFAULT NULL COMMENT 'Ngày giờ tịch thu hàng hóa:\r\n+ Ngày giờ đấu thầu nếu chọn Hình thức xử lý(type_handling) là đấu thầu\r\n+ Ngày giờ tiêu hủy nếu chọn Hình thức xử lý(type_handling) là tiêu hủy',
  `amount` int(50) DEFAULT NULL COMMENT 'Số tiền nhập vào nếu Hình thức xử lý(type_handling) là đấu thầu',
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
  CONSTRAINT `doc_items_handling_ibfk_1` FOREIGN KEY (`master_items_id`) REFERENCES `master_items` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_2` FOREIGN KEY (`doc_violations_handling_id`) REFERENCES `doc_violations_handling` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_3` FOREIGN KEY (`master_unit_id`) REFERENCES `master_unit` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_4` FOREIGN KEY (`master_sanction_id`) REFERENCES `master_sanction` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bảng xử lý hàng hóa khi tịch thu hàng';

-- ----------------------------
-- Records of doc_items_handling
-- ----------------------------

-- ----------------------------
-- Table structure for `doc_print_allocation`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_allocation`;
CREATE TABLE `doc_print_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_print_create_id` int(11) DEFAULT NULL,
  `master_print_id` int(11) DEFAULT NULL COMMENT 'bảng tạo ấn chỉ',
  `sys_department_id` int(11) DEFAULT NULL COMMENT 'Phòng ban',
  `serial_allocation` int(11) DEFAULT NULL COMMENT 'số ấn chỉ cấp phát',
  `serial_recovery` tinyint(4) DEFAULT '0' COMMENT 'số ấn chỉ thu hồi',
  `date_recovery` datetime DEFAULT NULL COMMENT 'Ngày thu hồi',
  `date_allocation` datetime DEFAULT NULL COMMENT 'ngày cấp phát',
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
  CONSTRAINT `doc_print_allocation_ibfk_1` FOREIGN KEY (`master_print_id`) REFERENCES `master_print` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_2` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_3` FOREIGN KEY (`doc_print_create_id`) REFERENCES `doc_print_create` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doc_print_allocation
-- ----------------------------
INSERT INTO `doc_print_allocation` VALUES ('1', null, '1', null, '30', '0', null, '2015-05-25 14:40:34', null, null, null, null, null, null, '0', null);
INSERT INTO `doc_print_allocation` VALUES ('5', null, '1', '1', '34', null, null, '2015-05-14 00:00:00', '2015-05-25 15:50:38', '1', '2015-05-25 15:50:38', '1', '0', '0', '0', null);
INSERT INTO `doc_print_allocation` VALUES ('6', null, '2', '2', '70', null, null, '2015-05-19 00:00:00', '2015-05-27 10:48:39', '1', '2015-05-27 10:48:39', '1', null, '0', '0', null);
INSERT INTO `doc_print_allocation` VALUES ('7', null, '2', '2', '71', null, null, '2015-05-19 00:00:00', '2015-05-27 10:48:39', '1', '2015-05-27 10:48:39', '1', null, '0', '0', null);
INSERT INTO `doc_print_allocation` VALUES ('8', null, '2', '2', '72', null, null, '2015-05-19 00:00:00', '2015-05-27 10:48:39', '1', '2015-05-27 10:48:39', '1', null, '0', '0', null);
INSERT INTO `doc_print_allocation` VALUES ('9', null, '2', '2', '73', null, null, '2015-05-19 00:00:00', '2015-05-27 10:48:39', '1', '2015-05-27 10:48:39', '1', null, '0', '0', null);
INSERT INTO `doc_print_allocation` VALUES ('10', null, '2', '2', '74', null, null, '2015-05-19 00:00:00', '2015-05-27 10:48:39', '1', '2015-05-27 10:48:39', '1', null, '0', '0', null);
INSERT INTO `doc_print_allocation` VALUES ('11', null, '2', '2', '75', null, null, '2015-05-19 00:00:00', '2015-05-27 10:48:39', '1', '2015-05-27 10:48:39', '1', null, '0', '0', null);

-- ----------------------------
-- Table structure for `doc_print_create`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_create`;
CREATE TABLE `doc_print_create` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `code_document` int(11) DEFAULT NULL COMMENT 'mã tài liệu (giống số thứ thự từ 1 trở đi)',
  `master_print_id` int(11) DEFAULT NULL COMMENT 'bảng tên ấn chỉ',
  `coefficient` int(11) DEFAULT NULL COMMENT 'hệ sổ (Số liên/1 quyển)',
  `serial` varchar(255) DEFAULT NULL COMMENT 'số ấn chỉ',
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doc_print_create
-- ----------------------------
INSERT INTO `doc_print_create` VALUES ('1', '1', '12', '1', '12', '34', null, null, null, null, null, '0', '0', null);
INSERT INTO `doc_print_create` VALUES ('2', 'QDXP', '123', '2', '2', '45-70', '2015-05-27 10:47:36', '1', '2015-05-27 10:47:36', '1', '0', '0', '0', null);

-- ----------------------------
-- Table structure for `doc_print_handling`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_handling`;
CREATE TABLE `doc_print_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_print_id` int(11) DEFAULT NULL COMMENT 'ten ấn chỉ',
  `doc_print_allocation_id` int(11) DEFAULT NULL COMMENT 'ấn chỉ dc cap',
  `doc_violations_handling_id` int(11) DEFAULT NULL COMMENT 'bảng xử lý vi phạm (trong xử lý vi phạm có nhiều loại ấn chỉ đc lưu)',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bảng ấn chỉ vi phạm';

-- ----------------------------
-- Records of doc_print_handling
-- ----------------------------

-- ----------------------------
-- Table structure for `doc_violations_handling`
-- ----------------------------
DROP TABLE IF EXISTS `doc_violations_handling`;
CREATE TABLE `doc_violations_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_business_id` int(11) DEFAULT NULL COMMENT 'Doanh nghiệp vi phạm',
  `master_violation_id` int(11) DEFAULT NULL COMMENT 'bảng hành vi vi phạm',
  `master_sanctions_id` int(11) DEFAULT NULL COMMENT 'bảng hình thức xử lý',
  `sys_deparment_id` int(11) DEFAULT NULL COMMENT 'bảng phòng ban',
  `sys_user_id` int(11) DEFAULT NULL COMMENT 'user xử lý',
  `date_violation` datetime DEFAULT NULL COMMENT 'Ngày vi phạm',
  `info_schedule_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
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
  KEY `doc_violations_handling_ibfk_3` (`sys_deparment_id`),
  KEY `doc_violations_handling_ibfk_2` (`master_sanctions_id`),
  KEY `doc_violations_handling_ibfk_1` (`master_violation_id`),
  KEY `sys_user_id` (`sys_user_id`),
  KEY `info_schedule_id` (`info_schedule_id`),
  CONSTRAINT `doc_violations_handling_ibfk_1` FOREIGN KEY (`master_violation_id`) REFERENCES `master_violation` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_2` FOREIGN KEY (`master_sanctions_id`) REFERENCES `master_sanction` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_3` FOREIGN KEY (`sys_deparment_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_5` FOREIGN KEY (`info_business_id`) REFERENCES `info_business` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_6` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_7` FOREIGN KEY (`info_schedule_id`) REFERENCES `info_schedule` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bảng xử lý vi phạm';

-- ----------------------------
-- Records of doc_violations_handling
-- ----------------------------

-- ----------------------------
-- Table structure for `info_business`
-- ----------------------------
DROP TABLE IF EXISTS `info_business`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Bảng doanh nghiệp';

-- ----------------------------
-- Records of info_business
-- ----------------------------
INSERT INTO `info_business` VALUES ('1', '123', 'DN A', '12131', '2015-05-12 15:17:31', '23', 'asds ', 'asds ', 'sad', null, 'Tran van A', null, null, null, null, null, null, null, null, null, null, null, null, 'DoanhNghiep', null, null, null, null, null, null, '0', null);
INSERT INTO `info_business` VALUES ('2', 'ads', 'HoÃ ng Nghi', '05845155', '0000-00-00 00:00:00', 'BÃ¬nh Äá»‹nh', '45 Tráº§n Quang Diá»‡u, TP quy NhÆ¡n', '', '', '', '', '', '', null, null, null, null, null, '2', '1', '1', '1', '0000-00-00 00:00:00', 'DoanhNghiep', '2015-05-29 11:14:55', '1', '2015-05-29 11:14:55', '1', null, '1', '0', null);
INSERT INTO `info_business` VALUES ('3', 'abc', 'HoÃ ng Kim', '0545454', '0000-00-00 00:00:00', 'BÃ¬nh Äá»‹nh', '64 Tráº§n Quang Diá»‡u, TP Quy NhÆ¡n', '', 'QuÃ¡n nháº­u', '0938554547', '', '', '', null, null, null, null, null, '2', '1', '1', '3', '0000-00-00 00:00:00', 'DoanhNghiep', '2015-05-30 10:51:42', '1', '2015-05-30 10:51:42', '1', null, '1', '0', null);

-- ----------------------------
-- Table structure for `info_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `info_schedule`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of info_schedule
-- ----------------------------

-- ----------------------------
-- Table structure for `info_schedule_check`
-- ----------------------------
DROP TABLE IF EXISTS `info_schedule_check`;
CREATE TABLE `info_schedule_check` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_schedule_id` int(11) DEFAULT NULL COMMENT 'kiểm tra theo lịch',
  `info_business_id` int(11) DEFAULT NULL COMMENT 'Doanh nghiệp đã kiểm tra',
  `doc_print_allocation_id` int(11) DEFAULT NULL COMMENT 'Ấn chỉ đc cấp đã đi kiểm tra',
  `date_check` datetime DEFAULT NULL COMMENT 'Ngày kiểm tra',
  `staff_check` varchar(255) DEFAULT NULL COMMENT 'Nhân viên kiểm tra',
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
  CONSTRAINT `info_schedule_check_ibfk_1` FOREIGN KEY (`info_schedule_id`) REFERENCES `info_schedule` (`id`),
  CONSTRAINT `info_schedule_check_ibfk_2` FOREIGN KEY (`info_business_id`) REFERENCES `info_business` (`id`),
  CONSTRAINT `info_schedule_check_ibfk_3` FOREIGN KEY (`doc_print_allocation_id`) REFERENCES `doc_print_allocation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of info_schedule_check
-- ----------------------------

-- ----------------------------
-- Table structure for `master_business_size`
-- ----------------------------
DROP TABLE IF EXISTS `master_business_size`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Quy mô doanh nghiệp : vừa, nhỏ, to ....';

-- ----------------------------
-- Records of master_business_size
-- ----------------------------
INSERT INTO `master_business_size` VALUES ('1', 'V', 'Vá»«a', '2015-05-29 11:01:48', '1', '2015-05-29 11:01:48', '1', '0', '0', '0', '');
INSERT INTO `master_business_size` VALUES ('2', 'Nhá»', 'Nhá»', '2015-05-29 11:02:11', '1', '2015-05-29 11:02:11', '1', '0', '0', '0', '');
INSERT INTO `master_business_size` VALUES ('3', 'Lá»›n', 'Lá»›n', '2015-05-29 11:02:29', '1', '2015-05-29 11:02:29', '1', '0', '0', '0', '');
INSERT INTO `master_business_size` VALUES ('4', 'To', 'To', '2015-05-29 11:11:13', '1', '2015-05-29 11:11:13', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_business_type`
-- ----------------------------
DROP TABLE IF EXISTS `master_business_type`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Loại hình kinh doanh: cty TNHH, cty TNHH 1 thành viên ...';

-- ----------------------------
-- Records of master_business_type
-- ----------------------------
INSERT INTO `master_business_type` VALUES ('1', 'ABC', 'TNHH 1 thÃ nh viÃªn', '2015-05-26 15:21:29', '1', '2015-05-26 15:21:29', '1', '0', '0', '0', '');
INSERT INTO `master_business_type` VALUES ('2', 'TNHH', 'TrÃ¡ch nhiá»‡m há»¯u háº¡n', '2015-05-29 10:26:49', '1', '2015-05-29 10:26:49', '1', '0', '0', '0', '');
INSERT INTO `master_business_type` VALUES ('3', 'CP', 'Cá»• pháº§n', '2015-05-29 10:27:09', '1', '2015-05-29 10:27:09', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_district`
-- ----------------------------
DROP TABLE IF EXISTS `master_district`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='danh mục quận huyện';

-- ----------------------------
-- Records of master_district
-- ----------------------------
INSERT INTO `master_district` VALUES ('1', 'sad', 'asd', '9', '2015-05-29 09:43:03', '1', '2015-05-29 09:43:03', '1', '0', '0', '0', 'sad');
INSERT INTO `master_district` VALUES ('2', 'QN', 'Quy NhÆ¡n', '8', '2015-05-26 14:11:42', '1', '2015-05-26 14:11:42', '1', '0', null, '0', '');
INSERT INTO `master_district` VALUES ('3', 'AN', 'An NhÆ¡n', '8', '2015-05-29 09:45:48', '1', '2015-05-29 09:45:48', '1', '0', null, '0', '');
INSERT INTO `master_district` VALUES ('4', 'TP', 'Tuy PhÆ°á»›c', '8', '2015-05-29 09:45:20', '1', '2015-05-29 09:45:20', '1', null, null, '0', '');

-- ----------------------------
-- Table structure for `master_items`
-- ----------------------------
DROP TABLE IF EXISTS `master_items`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bảng danh mục tên hàng hóa';

-- ----------------------------
-- Records of master_items
-- ----------------------------

-- ----------------------------
-- Table structure for `master_items_condition`
-- ----------------------------
DROP TABLE IF EXISTS `master_items_condition`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục mặt hàng kinh doanh có điều kiện';

-- ----------------------------
-- Records of master_items_condition
-- ----------------------------
INSERT INTO `master_items_condition` VALUES ('1', 'I', 'Internet', '2015-05-29 10:40:23', '1', '2015-05-29 10:40:23', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_items_limit`
-- ----------------------------
DROP TABLE IF EXISTS `master_items_limit`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục mặt hàng hạn chế kinh doanh';

-- ----------------------------
-- Records of master_items_limit
-- ----------------------------
INSERT INTO `master_items_limit` VALUES ('1', 'Bia', 'Bia', '2015-05-26 15:21:51', '1', '2015-05-26 15:21:51', '1', '0', '0', '0', '');
INSERT INTO `master_items_limit` VALUES ('2', 'R', 'RÆ°á»£u', '2015-05-29 10:38:39', '1', '2015-05-29 10:38:39', '1', '0', '0', '0', '');
INSERT INTO `master_items_limit` VALUES ('3', 'TL', 'Thuá»‘c lÃ¡', '2015-05-29 10:39:03', '1', '2015-05-29 10:39:03', '1', '0', '0', '0', '');
INSERT INTO `master_items_limit` VALUES ('4', 'Karaoke', 'Karaoke', '2015-05-29 10:39:44', '1', '2015-05-29 10:39:44', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_print`
-- ----------------------------
DROP TABLE IF EXISTS `master_print`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='danh mục tên ấn chỉ';

-- ----------------------------
-- Records of master_print
-- ----------------------------
INSERT INTO `master_print` VALUES ('1', 'QDXP', 'Xá»­ lÃ½ hÃ nh chÃ­nh', '2015-05-21 15:20:14', '1', '2015-05-21 15:20:14', '1', '1', '0', '0', '');
INSERT INTO `master_print` VALUES ('2', 'XL', 'KiÃªm tra xau dung', '2015-05-26 15:39:49', '1', '2015-05-26 15:39:49', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_province`
-- ----------------------------
DROP TABLE IF EXISTS `master_province`;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='bảng tỉnh thành';

-- ----------------------------
-- Records of master_province
-- ----------------------------
INSERT INTO `master_province` VALUES ('1', 'abcjjj', 'Quy nhÆ¡nkkk', '2015-05-22 14:33:38', '1', '2015-05-23 10:00:57', '1', '1', '0', '1', 'sad');
INSERT INTO `master_province` VALUES ('3', 'aSD', 'asD', '2015-05-22 14:43:32', '1', '2015-05-22 14:43:32', '1', '0', null, '1', 'SADSAD');
INSERT INTO `master_province` VALUES ('4', 'ZD', 'asDASD567', '2015-05-22 14:57:16', '1', '2015-05-23 15:44:18', '1', '0', '0', '1', 'SAD');
INSERT INTO `master_province` VALUES ('5', 'sad', 'asdsad', '2015-05-22 16:22:22', '1', '2015-05-22 16:22:22', '1', '0', null, '1', 'asd');
INSERT INTO `master_province` VALUES ('6', 'sdf', 'sadsa', '2015-05-23 15:45:07', '1', '2015-05-23 15:45:07', '1', '0', null, '1', 'asdasd');
INSERT INTO `master_province` VALUES ('7', 'sad', 'sad', '2015-05-23 15:51:26', '1', '2015-05-23 15:51:26', '1', '0', null, '1', 'SAdasd');
INSERT INTO `master_province` VALUES ('8', 'BÄ', 'BÃ¬nh Äá»‹nh', '2015-05-26 14:11:15', '1', '2015-05-26 14:11:15', '1', '0', null, '0', '');
INSERT INTO `master_province` VALUES ('9', 'TPHCM', 'Há»“ ChÃ­ Minh1', '2015-05-26 14:54:44', '1', '2015-05-26 14:55:00', '1', '0', null, '0', '');

-- ----------------------------
-- Table structure for `master_sanction`
-- ----------------------------
DROP TABLE IF EXISTS `master_sanction`;
CREATE TABLE `master_sanction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(11) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục hình thức xử lý';

-- ----------------------------
-- Records of master_sanction
-- ----------------------------
INSERT INTO `master_sanction` VALUES ('1', 'TT', 'Tieu huy', '_TichThuHangHoa', null, null, null, null, null, null, '0', null);
INSERT INTO `master_sanction` VALUES ('2', 'DG', 'Dau gia', '_TichThuHangHoa', null, null, null, null, null, null, '0', null);
INSERT INTO `master_sanction` VALUES ('3', 'K', 'Khac', '_TichThuHangHoa', null, null, null, null, null, null, '0', null);
INSERT INTO `master_sanction` VALUES ('4', 'PT', 'Phat tien', '_XuLyViPham', null, null, null, null, null, null, '0', null);
INSERT INTO `master_sanction` VALUES ('5', 'CB', 'Canh Bao', '_XuLyViPham', null, null, null, null, null, null, '0', null);

-- ----------------------------
-- Table structure for `master_unit`
-- ----------------------------
DROP TABLE IF EXISTS `master_unit`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='bảng đơn vị tính';

-- ----------------------------
-- Records of master_unit
-- ----------------------------
INSERT INTO `master_unit` VALUES ('1', 'c', 'CÃ¡i', '2015-05-26 15:07:38', '1', '2015-05-26 15:07:38', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_violation`
-- ----------------------------
DROP TABLE IF EXISTS `master_violation`;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='bảng hành vi vi phạm';

-- ----------------------------
-- Records of master_violation
-- ----------------------------
INSERT INTO `master_violation` VALUES ('1', 'XL', 'HÃ ng cáº¥m', '2015-05-26 15:04:59', '1', '2015-05-26 15:06:09', '1', '0', '0', '1', '');
INSERT INTO `master_violation` VALUES ('2', 'XL', 'BuÃ´n láº­u', '2015-05-26 15:06:43', '1', '2015-05-29 10:19:12', '1', '1', '0', '0', '');
INSERT INTO `master_violation` VALUES ('3', 'VCHC', 'Váº­n chuyá»ƒn hÃ ng cáº¥m', '2015-05-29 10:19:45', '1', '2015-05-29 10:19:45', '1', '0', '0', '0', '');
INSERT INTO `master_violation` VALUES ('4', 'ATVS', 'An toÃ n vá»‡ sinh', '2015-05-29 10:20:19', '1', '2015-05-29 10:20:19', '1', '0', '0', '0', '');
INSERT INTO `master_violation` VALUES ('5', 'LCVH', 'Láº¥n chiáº¿m vá»‰a hÃ¨', '2015-05-29 10:20:55', '1', '2015-05-29 10:20:55', '1', '0', '0', '0', '');
INSERT INTO `master_violation` VALUES ('6', 'DVQH', 'Váº­n chuyá»ƒn Ä‘á»™ng váº­t quÃ½ hiáº¿m', '2015-05-29 10:21:31', '1', '2015-05-29 10:21:31', '1', '0', '0', '0', '');

-- ----------------------------
-- Table structure for `master_ward`
-- ----------------------------
DROP TABLE IF EXISTS `master_ward`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Bảng phường xã';

-- ----------------------------
-- Records of master_ward
-- ----------------------------
INSERT INTO `master_ward` VALUES ('1', 'QT', 'Quang Trung', '2', '2015-05-29 09:47:46', '1', '2015-05-29 09:47:46', '1', null, null, '0', null);
INSERT INTO `master_ward` VALUES ('2', 'LTK', 'LÃ½ ThÆ°á»ng Kiá»‡t', '2', '2015-05-29 09:48:32', '1', '2015-05-29 09:48:32', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('3', 'NB', 'NhÆ¡n BÃ¬nh', '3', '2015-05-29 09:49:04', '1', '2015-05-29 09:49:04', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('4', 'NM', 'NgÃ´ MÃ¢y', '2', '2015-05-29 09:49:38', '1', '2015-05-29 09:49:38', '1', null, null, '0', '');

-- ----------------------------
-- Table structure for `sys_department`
-- ----------------------------
DROP TABLE IF EXISTS `sys_department`;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='bảng phòng ban';

-- ----------------------------
-- Records of sys_department
-- ----------------------------
INSERT INTO `sys_department` VALUES ('1', 'CC', 'Chi cá»¥c', null, null, '1', '2015-05-30 15:59:36', '1', '2015-05-30 15:59:36', '1', '0', '0', '0', '1');
INSERT INTO `sys_department` VALUES ('2', 'D1', 'Doi 1', 'Tráº§n VÄƒn A', '1', '0', '2015-05-29 09:50:29', '1', '2015-05-29 09:50:29', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('3', 'D2', 'Äá»™i 2', 'Tráº§n VÄƒn B', '1', '0', '2015-05-29 09:51:14', '1', '2015-05-29 09:51:14', '1', null, null, '0', '');
INSERT INTO `sys_department` VALUES ('4', 'D3', 'Äá»™i 3', null, '1', '0', '2015-05-29 09:51:39', '1', '2015-05-29 09:51:39', '1', null, null, '0', '');
INSERT INTO `sys_department` VALUES ('5', 'D4', 'Äá»™i 4', 'Tráº§n VÄƒn D', '1', '0', '2015-05-29 10:15:50', '1', '2015-05-29 10:15:50', '1', null, null, '0', '');
INSERT INTO `sys_department` VALUES ('6', 'KT', 'Káº¿ toÃ¡n', 'Nguyá»…n VÄƒn TÃ­', '1', '0', '2015-05-29 10:16:48', '1', '2015-05-29 10:16:48', '1', null, null, '0', '');
INSERT INTO `sys_department` VALUES ('7', 'TH', 'Tá»•ng há»£p', null, '6', '0', '2015-05-29 10:17:17', '1', '2015-05-29 10:17:17', '1', null, null, '0', '');
INSERT INTO `sys_department` VALUES ('8', 'NQ', 'NgÃ¢n Quá»¹', null, '6', '0', '2015-05-29 10:18:23', '1', '2015-05-29 10:18:23', '1', null, null, '0', '');

-- ----------------------------
-- Table structure for `sys_privileges`
-- ----------------------------
DROP TABLE IF EXISTS `sys_privileges`;
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

-- ----------------------------
-- Records of sys_privileges
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_user`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cellphone` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthday` datetime DEFAULT '0000-00-00 00:00:00',
  `master_department_id` int(11) DEFAULT NULL,
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
  KEY `sys_user_ibfk_1` (`master_department_id`),
  KEY `sys_user_ibfk_2` (`sys_user_group_id`),
  KEY `master_province_id` (`master_province_id`),
  KEY `master_district_id` (`master_district_id`),
  KEY `master_ward_id` (`master_ward_id`),
  CONSTRAINT `sys_user_ibfk_1` FOREIGN KEY (`master_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `sys_user_ibfk_2` FOREIGN KEY (`sys_user_group_id`) REFERENCES `sys_user_group` (`id`),
  CONSTRAINT `sys_user_ibfk_3` FOREIGN KEY (`master_province_id`) REFERENCES `master_province` (`id`),
  CONSTRAINT `sys_user_ibfk_4` FOREIGN KEY (`master_district_id`) REFERENCES `master_district` (`id`),
  CONSTRAINT `sys_user_ibfk_5` FOREIGN KEY (`master_ward_id`) REFERENCES `master_ward` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='bảng người dùng';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '202cb962ac59075b964b07152d234b70', 'vulam1808@yahoo.com', null, 'He', 'Lu', '0000-00-00 00:00:00', '1', null, null, null, null, '2', '2015-06-01 10:47:59', '1', '2015-06-01 10:47:59', '1', null, null, '0', null);
INSERT INTO `sys_user` VALUES ('2', 'truyenbv72499', '202cb962ac59075b964b07152d234b70', 'v.truyen@yahoo.com', null, 'Nguyá»…n Sinh Ã¡d', 'Æ°adas', '2015-05-12 00:00:00', '1', null, null, null, '0', '2', '2015-05-26 16:07:29', '1', '2015-05-26 16:07:29', '1', null, '0', '0', '');

-- ----------------------------
-- Table structure for `sys_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_group`;
CREATE TABLE `sys_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='bảng nhóm user';

-- ----------------------------
-- Records of sys_user_group
-- ----------------------------
INSERT INTO `sys_user_group` VALUES ('1', 'default', null, null, null, null, null, null, '0', null);
INSERT INTO `sys_user_group` VALUES ('2', 'admin', null, null, null, null, null, null, '0', null);
INSERT INTO `sys_user_group` VALUES ('3', 'leader', null, null, null, null, null, null, '0', null);

-- ----------------------------
-- Table structure for `sys_user_group_detail`
-- ----------------------------
DROP TABLE IF EXISTS `sys_user_group_detail`;
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

-- ----------------------------
-- Records of sys_user_group_detail
-- ----------------------------

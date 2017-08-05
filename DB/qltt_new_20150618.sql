/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : qltt_new

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-06-18 15:41:48
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
  CONSTRAINT `doc_items_handling_ibfk_1` FOREIGN KEY (`master_items_id`) REFERENCES `master_items` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_2` FOREIGN KEY (`doc_violations_handling_id`) REFERENCES `doc_violations_handling` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_3` FOREIGN KEY (`master_unit_id`) REFERENCES `master_unit` (`id`),
  CONSTRAINT `doc_items_handling_ibfk_4` FOREIGN KEY (`master_sanction_id`) REFERENCES `master_sanction` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COMMENT='Bảng xử lý hàng hóa khi tịch thu hàng';

-- ----------------------------
-- Records of doc_items_handling
-- ----------------------------
INSERT INTO `doc_items_handling` VALUES ('62', '2', '7', '45', '1234', '12', '2', '2015-06-12 00:00:00', '0', null, '2015-06-12 09:03:34', '1', '2015-06-12 09:03:34', '1', null, null, '0', null);
INSERT INTO `doc_items_handling` VALUES ('63', '3', '7', '45', '1234', '12', '2', '2015-06-12 00:00:00', '0', null, '2015-06-12 09:03:34', '1', '2015-06-12 09:03:34', '1', null, null, '0', null);
INSERT INTO `doc_items_handling` VALUES ('64', '1', '9', '47', '12', '10', '1', '2015-06-12 00:00:00', '0', null, '2015-06-12 09:19:28', '1', '2015-06-12 09:19:28', '1', null, null, '0', null);
INSERT INTO `doc_items_handling` VALUES ('65', '4', '9', '48', '12abc', '10', '2', '2015-06-12 00:00:00', '5000000', null, '2015-06-12 10:04:40', '1', '2015-06-12 10:04:40', '1', null, null, '0', null);
INSERT INTO `doc_items_handling` VALUES ('66', '5', '9', '48', '12abc', '10', '2', '2015-06-12 00:00:00', '0', null, '2015-06-12 10:04:40', '1', '2015-06-12 10:04:40', '1', null, null, '0', null);
INSERT INTO `doc_items_handling` VALUES ('67', '5', '7', '48', '12abc', '10', '2', '2015-06-12 00:00:00', '0', null, '2015-06-12 10:04:40', '1', '2015-06-12 10:04:40', '1', null, null, '0', null);
INSERT INTO `doc_items_handling` VALUES ('68', '1', '7', '50', '123', '2', '1', '2015-06-13 00:00:00', '0', null, '2015-06-13 09:28:59', '1', '2015-06-13 09:28:59', '1', null, null, '0', null);

-- ----------------------------
-- Table structure for `doc_print_allocation`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_allocation`;
CREATE TABLE `doc_print_allocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_print_create_id` int(11) DEFAULT NULL,
  `master_print_id` int(11) DEFAULT NULL COMMENT 'bảng tạo ấn chỉ',
  `sys_department_id` int(11) DEFAULT NULL COMMENT 'Phòng ban',
  `sys_user_id` int(11) DEFAULT NULL COMMENT 'Nhân viên đc cấp phát',
  `request_number` varchar(255) DEFAULT NULL COMMENT 'giay de nghi cap an chi. Mã số',
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
  KEY `sys_user_id` (`sys_user_id`),
  CONSTRAINT `doc_print_allocation_ibfk_1` FOREIGN KEY (`master_print_id`) REFERENCES `master_print` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_2` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_3` FOREIGN KEY (`doc_print_create_id`) REFERENCES `doc_print_create` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_4` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doc_print_allocation
-- ----------------------------

-- ----------------------------
-- Table structure for `doc_print_create`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_create`;
CREATE TABLE `doc_print_create` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL COMMENT 'số hóa đơn mua ấn chỉ',
  `master_print_id` int(11) DEFAULT NULL COMMENT 'bảng tên ấn chỉ',
  `coefficient` int(11) DEFAULT NULL COMMENT 'Số quyển',
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doc_print_create
-- ----------------------------

-- ----------------------------
-- Table structure for `doc_print_handling`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_handling`;
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
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='Bảng ấn chỉ vi phạm';

-- ----------------------------
-- Records of doc_print_handling
-- ----------------------------

-- ----------------------------
-- Table structure for `doc_print_payment`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_payment`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doc_print_payment
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
  CONSTRAINT `doc_violations_handling_ibfk_1` FOREIGN KEY (`master_violation_id`) REFERENCES `master_violation` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_2` FOREIGN KEY (`master_sanctions_id`) REFERENCES `master_sanction` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_3` FOREIGN KEY (`sys_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_5` FOREIGN KEY (`info_business_id`) REFERENCES `info_business` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_6` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_7` FOREIGN KEY (`info_schedule_id`) REFERENCES `info_schedule` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='Bảng xử lý vi phạm';

-- ----------------------------
-- Records of doc_violations_handling
-- ----------------------------
INSERT INTO `doc_violations_handling` VALUES ('44', '3', '4', '8', '1', '1', '2015-06-12 09:17:36', null, '0', '2015-06-12 09:01:07', '1', '2015-06-12 09:01:07', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('45', '2', '3', '9', '4', '1', '2015-06-18 09:17:40', null, '0', '2015-06-12 09:03:34', '1', '2015-06-12 09:03:34', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('46', '5', '4', '8', '4', '1', '2015-06-04 09:17:44', null, '0', '2015-06-12 09:04:16', '1', '2015-06-12 09:04:16', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('47', '2', '4', '7', '4', '1', '2015-06-12 09:19:28', null, '0', '2015-06-12 09:19:28', '1', '2015-06-12 09:19:28', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('48', '2', '5', '5', '4', '1', '2015-06-12 10:04:39', null, '3000000', '2015-06-12 10:04:39', '1', '2015-06-12 10:04:39', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('49', '3', '3', '7', '4', '1', '2015-06-12 10:04:40', null, '0', '2015-06-12 10:04:40', '1', '2015-06-12 10:04:40', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('50', '6', '3', '5', '4', '1', '2015-06-13 09:28:59', null, '0', '2015-06-13 09:28:59', '1', '2015-06-13 09:28:59', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('51', '6', '2', '5', '4', '1', '2015-06-15 11:15:24', null, '0', '2015-06-15 11:15:24', '1', '2015-06-15 11:15:24', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('52', '5', '3', '4', '4', '1', '2015-06-15 00:00:00', null, '333333', '2015-06-15 11:18:33', '1', '2015-06-15 11:18:33', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('53', '7', '3', '5', '4', '3', '2015-06-15 00:00:00', null, '0', '2015-06-15 15:04:30', '1', '2015-06-15 15:04:30', '1', null, null, '0', null);
INSERT INTO `doc_violations_handling` VALUES ('54', '2', '4', '5', '4', '1', '2015-06-16 00:00:00', null, '0', '2015-06-16 11:41:35', '1', '2015-06-16 11:41:35', '1', null, null, '0', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Bảng doanh nghiệp';

-- ----------------------------
-- Records of info_business
-- ----------------------------
INSERT INTO `info_business` VALUES ('1', 'A', 'DN A', '12131', '2015-05-12 15:17:31', '23', '124 Ngô Mây', 'asds ', 'sad', '', 'Tran van A', '', '', '', '', null, null, '8', '2', '1', null, null, '0000-00-00 00:00:00', 'DoanhNghiep', '2015-06-15 16:46:32', '1', '2015-06-15 16:46:32', '1', null, '0', '0', null);
INSERT INTO `info_business` VALUES ('2', 'HN', 'Hoàng Nghi', '05845155', '0000-00-00 00:00:00', 'Bình Định', '45 Trần Quang Diệu', '', '', '', '', '', '', '', '', '2', '1', '8', '2', '2', '1', '1', '0000-00-00 00:00:00', 'DoanhNghiep', '2015-06-15 16:49:03', '1', '2015-06-15 16:49:03', '1', null, '0', '0', null);
INSERT INTO `info_business` VALUES ('3', 'NK', 'Nguyễn Kim', '0545454', '0000-00-00 00:00:00', 'BÃ¬nh Äá»‹nh', '64 Mai Xuân Thưởng', '', 'QuÃ¡n nháº­u', '0938554547', '', '', '', '', '', '2, 3', '1', '8', '2', '1', '1', '3', '0000-00-00 00:00:00', 'DoanhNghiep', '2015-06-15 16:50:03', '1', '2015-06-15 16:50:03', '1', null, '0', '0', null);
INSERT INTO `info_business` VALUES ('4', 'scb', 'Sacombank', '23445546', '0000-00-00 00:00:00', '', '14 Mai Xuân Thưởng', '', '', '', '', '', '', '', '', '1, 2, 3, 4', '1', '8', '2', '1', '1', '2', '0000-00-00 00:00:00', 'DoanhNghiep', '2015-06-05 15:38:37', '1', '2015-06-05 15:38:37', '1', null, '1', '0', null);
INSERT INTO `info_business` VALUES ('5', 'HN', 'Hoang Nguyễn', '025315', null, '', '64 Ngô Mây', '', '', '', '', '', '', '', '', '2', '1', '8', '2', '1', '1', '1', null, 'HoKinhDoanh', '2015-06-11 17:07:35', '1', '2015-06-11 17:07:35', '1', null, '1', '0', null);
INSERT INTO `info_business` VALUES ('6', 'TN', 'Thanh nguyễn', '02150225', null, '', '', '', '', '', '', '', '', '', '', '3', '1', '8', '3', '3', '1', '1', null, 'HoKinhDoanh', '2015-06-11 17:09:32', '1', '2015-06-11 17:09:32', '1', null, '1', '0', null);
INSERT INTO `info_business` VALUES ('7', 'TT', 'Thanh Tùng', '451593612', null, '', '', '', '', '', '', '', '', '', '', '2', '1', '8', '3', '3', '1', '1', null, 'DoanhNghiepNgoaiDiaBan', '2015-06-15 15:00:49', '1', '2015-06-15 15:00:49', '1', null, '1', '0', null);
INSERT INTO `info_business` VALUES ('8', 'MN', 'Minh Nguyễn', '01582154', null, 'Bình Định', '75 Nguyễn Thái Học', '', '', '', '', '', '', '', '', '2', '1', '8', '2', '1', '1', '1', null, 'DoanhNghiep', '2015-06-15 15:59:04', '1', '2015-06-15 15:59:04', '1', null, '1', '0', null);

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
INSERT INTO `master_business_size` VALUES ('1', 'V', 'Vừa', '2015-05-29 11:01:48', '1', '2015-06-15 16:02:20', '1', '0', '0', '0', '');
INSERT INTO `master_business_size` VALUES ('2', 'Nhá»', 'Nhỏ', '2015-05-29 11:02:11', '1', '2015-06-15 16:02:05', '1', '0', '0', '0', '');
INSERT INTO `master_business_size` VALUES ('3', 'Lá»›n', 'Lớn', '2015-05-29 11:02:29', '1', '2015-06-15 16:01:25', '1', '0', '0', '0', '');
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
INSERT INTO `master_business_type` VALUES ('1', 'ABC', 'TNHH 1 thành viên', '2015-05-26 15:21:29', '1', '2015-06-15 16:53:52', '1', '0', '0', '0', '');
INSERT INTO `master_business_type` VALUES ('2', 'TNHH', 'Trách nhiệm hữu hạn', '2015-05-29 10:26:49', '1', '2015-06-15 16:55:07', '1', '0', '0', '0', '');
INSERT INTO `master_business_type` VALUES ('3', 'CP', 'Cổ phần', '2015-05-29 10:27:09', '1', '2015-06-15 16:54:42', '1', '0', '0', '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='danh mục quận huyện';

-- ----------------------------
-- Records of master_district
-- ----------------------------
INSERT INTO `master_district` VALUES ('1', 'Q1', 'Quận 1', '9', '2015-06-15 15:32:58', '1', '2015-06-15 15:32:58', '1', '0', '0', '0', '');
INSERT INTO `master_district` VALUES ('2', 'QN', 'Quy Nhơn', '8', '2015-06-15 15:33:15', '1', '2015-06-15 15:33:15', '1', '0', null, '0', '');
INSERT INTO `master_district` VALUES ('3', 'AN', 'An Nhơn', '8', '2015-06-15 15:33:31', '1', '2015-06-15 15:33:31', '1', '0', null, '0', '');
INSERT INTO `master_district` VALUES ('4', 'TP', 'Tuy Phước', '8', '2015-06-15 15:31:32', '1', '2015-06-15 15:31:32', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('5', 'TS', 'Tây Sơn', '8', '2015-06-15 15:33:46', '1', '2015-06-15 15:33:46', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('6', 'HN', 'Hoài Nhơn', '8', '2015-06-15 15:34:09', '1', '2015-06-15 15:34:09', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('7', 'HA', 'Hoài Ân', '8', '2015-06-15 15:34:32', '1', '2015-06-15 15:34:32', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('8', 'VC', 'Vân Canh', '8', '2015-06-15 15:34:56', '1', '2015-06-15 15:34:56', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('9', 'Q2', 'Quận 2', '9', '2015-06-15 15:35:38', '1', '2015-06-15 15:35:38', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('10', 'Q3', 'Quận 3', '9', '2015-06-15 15:36:43', '1', '2015-06-15 15:36:43', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('11', 'BD', 'Ba Đình', '11', '2015-06-15 15:48:32', '1', '2015-06-15 15:48:32', '1', null, null, '0', '');
INSERT INTO `master_district` VALUES ('12', 'CG', 'Cầu Giấy', '11', '2015-06-15 15:48:51', '1', '2015-06-15 15:48:51', '1', null, null, '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Bảng danh mục tên hàng hóa';

-- ----------------------------
-- Records of master_items
-- ----------------------------
INSERT INTO `master_items` VALUES ('1', 'bg', 'Bàn ghế', null, '2015-06-05 16:07:50', '1', '2015-06-15 16:09:21', '1', null, null, '0', 'sad');
INSERT INTO `master_items` VALUES ('2', 'MT', 'Máy tính', null, '2015-06-05 16:21:03', '1', '2015-06-15 16:09:31', '1', null, null, '0', '');
INSERT INTO `master_items` VALUES ('3', 'DD', 'Rượu ngoại', null, '2015-06-05 16:21:42', '1', '2015-06-15 16:09:59', '1', null, null, '0', '');
INSERT INTO `master_items` VALUES ('4', 'Heroin', 'Heroin', null, '2015-06-05 16:21:58', '1', '2015-06-05 16:21:58', '1', null, null, '0', '');
INSERT INTO `master_items` VALUES ('5', 'Heo rá»«ng', 'Heo rừng', null, '2015-06-05 16:22:09', '1', '2015-06-15 16:10:15', '1', null, null, '0', '');
INSERT INTO `master_items` VALUES ('6', 'SÃºng', 'Thuốc súng', null, '2015-06-05 16:22:21', '1', '2015-06-15 16:10:34', '1', null, null, '0', '');

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
INSERT INTO `master_items_limit` VALUES ('2', 'R', 'Rượu', '2015-05-29 10:38:39', '1', '2015-06-15 16:56:34', '1', '0', '0', '0', '');
INSERT INTO `master_items_limit` VALUES ('3', 'TL', 'Thuốc lá', '2015-05-29 10:39:03', '1', '2015-06-15 16:57:02', '1', '0', '0', '0', '');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='danh mục tên ấn chỉ';

-- ----------------------------
-- Records of master_print
-- ----------------------------
INSERT INTO `master_print` VALUES ('1', 'QDXP', 'Kiểm tra hành chính', '2015-05-21 15:20:14', '1', '2015-06-16 10:51:53', '1', '1', '0', '0', '');
INSERT INTO `master_print` VALUES ('2', 'XL', 'Kiểm tra xây dựng', '2015-05-26 15:39:49', '1', '2015-06-16 10:52:42', '1', '0', '0', '0', '');
INSERT INTO `master_print` VALUES ('3', 'KPTVT', 'Khám phương tiện vận tải', '2015-06-16 10:53:39', '1', '2015-06-16 10:53:39', '1', null, '0', '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='bảng tỉnh thành';

-- ----------------------------
-- Records of master_province
-- ----------------------------
INSERT INTO `master_province` VALUES ('1', 'abcjjj', 'Quy nhÆ¡nkkk', '2015-05-22 14:33:38', '1', '2015-05-23 10:00:57', '1', '1', '0', '1', 'sad');
INSERT INTO `master_province` VALUES ('3', 'aSD', 'asD', '2015-05-22 14:43:32', '1', '2015-05-22 14:43:32', '1', '0', null, '1', 'SADSAD');
INSERT INTO `master_province` VALUES ('4', 'ZD', 'asDASD567', '2015-05-22 14:57:16', '1', '2015-05-23 15:44:18', '1', '0', '0', '1', 'SAD');
INSERT INTO `master_province` VALUES ('5', 'sad', 'asdsad', '2015-05-22 16:22:22', '1', '2015-05-22 16:22:22', '1', '0', null, '1', 'asd');
INSERT INTO `master_province` VALUES ('6', 'sdf', 'sadsa', '2015-05-23 15:45:07', '1', '2015-05-23 15:45:07', '1', '0', null, '1', 'asdasd');
INSERT INTO `master_province` VALUES ('7', 'sad', 'sad', '2015-05-23 15:51:26', '1', '2015-05-23 15:51:26', '1', '0', null, '1', 'SAdasd');
INSERT INTO `master_province` VALUES ('8', 'BĐ', 'Bình Định', '2015-05-26 14:11:15', '1', '2015-06-15 16:30:14', '1', '0', null, '0', '');
INSERT INTO `master_province` VALUES ('9', 'TPHCM', 'Hồ Chí Minh', '2015-05-26 14:54:44', '1', '2015-06-15 15:28:43', '1', '0', null, '0', '');
INSERT INTO `master_province` VALUES ('10', 'ABC ', 'Tiền Giang', '2015-06-12 09:28:00', '1', '2015-06-15 16:25:36', '1', '0', null, '0', '');
INSERT INTO `master_province` VALUES ('11', 'HN', 'Hà Nội', '2015-06-15 15:29:11', '1', '2015-06-15 15:29:11', '1', null, null, '0', '');
INSERT INTO `master_province` VALUES ('12', 'ĐN', 'Đà Nẵng', '2015-06-15 15:29:34', '1', '2015-06-15 15:30:51', '1', '0', null, '0', '');
INSERT INTO `master_province` VALUES ('13', 'PY', 'Phú Yên', '2015-06-15 15:31:09', '1', '2015-06-15 15:31:09', '1', null, null, '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='bảng danh mục hình thức xử lý';

-- ----------------------------
-- Records of master_sanction
-- ----------------------------
INSERT INTO `master_sanction` VALUES ('1', 'TT', 'Tieu huy', 'TichThuHangHoa', null, null, null, null, null, null, '1', null);
INSERT INTO `master_sanction` VALUES ('3', 'K', 'Khac', 'TichThuHangHoa', null, null, null, null, null, null, '1', null);
INSERT INTO `master_sanction` VALUES ('4', 'PT', 'Phạt tiền', 'XuLyViPham', null, null, '2015-06-15 16:04:11', '1', null, '0', '0', '');
INSERT INTO `master_sanction` VALUES ('5', 'CB', 'Cảnh báo', 'XuLyViPham', null, null, '2015-06-15 16:04:24', '1', null, '0', '0', '');
INSERT INTO `master_sanction` VALUES ('7', 'TH', 'Tiêu hủy', 'TichThuHangHoa', '2015-06-05 16:38:12', '1', '2015-06-05 16:38:12', '1', null, '0', '0', '');
INSERT INTO `master_sanction` VALUES ('8', 'K', 'Khác', 'TichThuHangHoa', '2015-06-05 16:38:28', '1', '2015-06-05 16:38:28', '1', null, '0', '0', '');
INSERT INTO `master_sanction` VALUES ('9', 'c', 'Đấu thầu', 'TichThuHangHoa', '2015-06-05 16:47:24', '1', '2015-06-05 16:47:24', '1', null, '0', '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='bảng đơn vị tính';

-- ----------------------------
-- Records of master_unit
-- ----------------------------
INSERT INTO `master_unit` VALUES ('1', 'c', 'Cái', '2015-05-26 15:07:38', '1', '2015-06-15 16:08:19', '1', '0', '0', '0', '');
INSERT INTO `master_unit` VALUES ('2', 'Kg', 'Kg', '2015-06-05 16:24:59', '1', '2015-06-05 16:24:59', '1', '0', '0', '0', '');
INSERT INTO `master_unit` VALUES ('3', 'Chiáº¿c', 'Chiếc', '2015-06-05 16:25:10', '1', '2015-06-15 16:08:30', '1', '0', '0', '0', '');
INSERT INTO `master_unit` VALUES ('4', 'ThÃ¹ng', 'Thùng', '2015-06-05 16:25:29', '1', '2015-06-15 16:09:02', '1', '0', '0', '0', '');
INSERT INTO `master_unit` VALUES ('5', 'LÃ­t', 'Lít', '2015-06-05 16:25:48', '1', '2015-06-15 16:08:46', '1', '0', '0', '0', '');

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
INSERT INTO `master_violation` VALUES ('2', 'XL', 'Buôn lậu', '2015-05-26 15:06:43', '1', '2015-06-15 16:02:47', '1', '1', '0', '0', '');
INSERT INTO `master_violation` VALUES ('3', 'VCHC', 'Vận chuyển hàng cấm', '2015-05-29 10:19:45', '1', '2015-06-15 16:02:59', '1', '0', '0', '0', '');
INSERT INTO `master_violation` VALUES ('4', 'ATVS', 'An toàn vệ sinh', '2015-05-29 10:20:19', '1', '2015-06-15 16:03:09', '1', '0', '0', '0', '');
INSERT INTO `master_violation` VALUES ('5', 'LCVH', 'Lấn chiếm vỉa hè', '2015-05-29 10:20:55', '1', '2015-06-15 16:03:21', '1', '0', '0', '0', '');
INSERT INTO `master_violation` VALUES ('6', 'DVQH', 'Vận chuyển động vật quý hiếm', '2015-05-29 10:21:31', '1', '2015-06-15 16:03:35', '1', '0', '0', '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Bảng phường xã';

-- ----------------------------
-- Records of master_ward
-- ----------------------------
INSERT INTO `master_ward` VALUES ('1', 'QT', 'Quang Trung', '2', '2015-05-29 09:47:46', '1', '2015-05-29 09:47:46', '1', null, null, '0', null);
INSERT INTO `master_ward` VALUES ('2', 'LTK', 'Lý Thường Kiệt', '2', '2015-06-15 15:37:46', '1', '2015-06-15 15:37:46', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('3', 'BD', 'Bình Định', '3', '2015-06-15 15:39:00', '1', '2015-06-15 15:39:00', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('4', 'NM', 'Ngô Mây', '2', '2015-06-15 15:39:15', '1', '2015-06-15 15:39:15', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('5', 'NH', 'Nhơn Hưng', '3', '2015-06-15 15:39:39', '1', '2015-06-15 15:39:39', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('6', 'DD', 'Đập Đá', '3', '2015-06-15 15:40:10', '1', '2015-06-15 15:40:10', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('7', 'DT', 'Diêu Trì', '4', '2015-06-15 15:40:47', '1', '2015-06-15 15:40:47', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('8', 'TP', 'Tuy Phước', '4', '2015-06-15 15:41:08', '1', '2015-06-15 15:41:08', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('9', 'PP', 'Phú Phong', '5', '2015-06-15 15:41:41', '1', '2015-06-15 15:41:41', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('10', 'TQ', 'Tam Quan', '6', '2015-06-15 15:42:14', '1', '2015-06-15 15:42:14', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('11', 'BS', 'Bồng Sơn', '6', '2015-06-15 15:42:39', '1', '2015-06-15 15:42:39', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('12', 'TBH', 'Tăng Bạt Hổ', '7', '2015-06-15 15:43:32', '1', '2015-06-15 15:43:32', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('13', 'VC', 'Vân Canh', '8', '2015-06-15 15:44:03', '1', '2015-06-15 15:44:03', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('14', 'DK', 'Đa Kao', '1', '2015-06-15 15:45:52', '1', '2015-06-15 15:45:52', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('15', 'BN', 'Bến Nghé', '1', '2015-06-15 15:46:16', '1', '2015-06-15 15:46:16', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('16', 'BT', 'Bến Thành', '1', '2015-06-15 15:46:35', '1', '2015-06-15 15:46:35', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('17', 'AP', 'An Phú', '9', '2015-06-15 15:47:01', '1', '2015-06-15 15:47:01', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('18', 'BTD', 'Bình Trưng Đông', '9', '2015-06-15 15:47:19', '1', '2015-06-15 15:47:19', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('19', '08', '08', '10', '2015-06-15 15:47:49', '1', '2015-06-15 15:47:49', '1', null, null, '0', '');
INSERT INTO `master_ward` VALUES ('20', '07', '07', '10', '2015-06-15 15:48:05', '1', '2015-06-15 15:48:05', '1', null, null, '0', '');

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
INSERT INTO `sys_department` VALUES ('1', 'CC', 'Chi Cục', null, null, '1', '2015-06-15 15:25:07', '1', '2015-06-15 15:25:07', '1', '0', '0', '0', '1');
INSERT INTO `sys_department` VALUES ('2', 'D1', 'Đội 1', 'Trần Văn A', '1', '0', '2015-06-15 15:25:33', '1', '2015-06-15 15:25:33', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('3', 'D2', 'Đội 2', 'Trần Văn B', '1', '0', '2015-06-15 15:25:58', '1', '2015-06-15 15:25:58', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('4', 'D3', 'Đội 3', 'Trần Văn C', '1', '0', '2015-06-15 15:26:18', '1', '2015-06-15 15:26:18', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('5', 'D4', 'Đội 4', 'Trần Văn D', '1', '0', '2015-06-15 15:26:36', '1', '2015-06-15 15:26:36', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('6', 'KT', 'Kế toán', 'Trần Văn E', '1', '0', '2015-06-15 15:26:58', '1', '2015-06-15 15:26:58', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('7', 'TH', 'Tổng hợp', null, '6', '0', '2015-06-15 15:27:14', '1', '2015-06-15 15:27:14', '1', '0', null, '0', '');
INSERT INTO `sys_department` VALUES ('8', 'NQ', 'Ngân Quỹ', null, '6', '0', '2015-06-15 15:27:51', '1', '2015-06-15 15:27:51', '1', '0', null, '0', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='bảng người dùng';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', '202cb962ac59075b964b07152d234b70', 'vulam1808@yahoo.com', null, 'Trần Văn', 'Ab', '0000-00-00 00:00:00', '4', null, null, null, '1', '2', '2015-06-17 10:43:46', '1', '2015-06-17 10:43:46', '1', null, null, '0', null);
INSERT INTO `sys_user` VALUES ('2', 'truyenbv72499', '7363a0d0604902af7b70b271a0b96480', 'v.truyen@yahoo.com', null, 'Nguyễn Sinh ', 'Hùng', '0000-00-00 00:00:00', '4', null, null, null, '1', '2', '2015-06-16 11:45:50', '1', '2015-06-16 11:45:50', '1', null, '0', '0', '');
INSERT INTO `sys_user` VALUES ('3', 'user', '202cb962ac59075b964b07152d234b70', null, null, 'Trần Văn', 'ABC', '2015-06-10 00:00:00', '4', '8', '3', '3', '0', null, '2015-06-15 15:02:15', '1', '2015-06-15 15:02:15', '1', null, '0', '0', null);

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

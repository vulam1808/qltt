/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : qltt_new

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2015-05-15 10:48:55
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `doc_items_handling`
-- ----------------------------
DROP TABLE IF EXISTS `doc_items_handling`;
CREATE TABLE `doc_items_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_items_id` int(11) DEFAULT NULL COMMENT 'Liên kết bảng danh mục hàng hóa lấy tên hàng hóa',
  `master_sanction_id` int(255) DEFAULT NULL COMMENT 'Hình thức xử lý hàng:\r\n+ Đấu thầu\r\n+ Tiêu hủy\r\n+ Khác',
  `doc_violations_handling_id` int(11) DEFAULT NULL COMMENT 'bảng xử lý vi phạm (trong xử lý vi phạm có nhiều loại hàng đc lưu)',
  `serial_handling` int(11) DEFAULT NULL COMMENT 'Số biên lai tịch thu hàng',
  `quantity_commodity` int(11) DEFAULT NULL COMMENT 'Số lượng hàng hóa tịch thu',
  `master_unit_id` int(11) DEFAULT NULL COMMENT 'Đơn vị tính số lượng tịch thu hàng hóa (cái, chiếc , lô ...)',
  `date_handling` datetime DEFAULT NULL COMMENT 'Ngày giờ tịch thu hàng hóa:\r\n+ Ngày giờ đấu thầu nếu chọn Hình thức xử lý(type_handling) là đấu thầu\r\n+ Ngày giờ tiêu hủy nếu chọn Hình thức xử lý(type_handling) là tiêu hủy',
  `amount` int(11) DEFAULT NULL COMMENT 'Số tiền nhập vào nếu Hình thức xử lý(type_handling) là đấu thầu',
  `file_upload` varchar(0) DEFAULT NULL COMMENT 'file upload nếu có',
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
  `doc_print_create_id` int(255) DEFAULT NULL COMMENT 'bảng tạo ấn chỉ',
  `master_department_id` int(255) DEFAULT NULL COMMENT 'Phòng ban',
  `serial_allocation` int(255) DEFAULT NULL COMMENT 'số ấn chỉ cấp phát',
  `serial_recovery` float(11,0) DEFAULT NULL COMMENT 'số ấn chỉ thu hồi',
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
  KEY `doc_print_allocation_ibfk_1` (`doc_print_create_id`),
  KEY `doc_print_allocation_ibfk_2` (`master_department_id`),
  CONSTRAINT `doc_print_allocation_ibfk_1` FOREIGN KEY (`doc_print_create_id`) REFERENCES `doc_print_create` (`id`),
  CONSTRAINT `doc_print_allocation_ibfk_2` FOREIGN KEY (`master_department_id`) REFERENCES `sys_department` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `code_document` int(255) DEFAULT NULL COMMENT 'mã tài liệu (giống số thứ thự từ 1 trở đi)',
  `master_print_id` int(255) DEFAULT NULL COMMENT 'bảng tên ấn chỉ',
  `coefficient` int(11) DEFAULT NULL COMMENT 'hệ sổ (Số liên/1 quyển)',
  `serial` int(11) DEFAULT NULL COMMENT 'số ấn chỉ',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of doc_print_create
-- ----------------------------

-- ----------------------------
-- Table structure for `doc_print_handling`
-- ----------------------------
DROP TABLE IF EXISTS `doc_print_handling`;
CREATE TABLE `doc_print_handling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_print_allocation_id` int(11) DEFAULT NULL COMMENT 'bảng ấn chỉ được cấp',
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
  KEY `doc_print_allocation_id` (`doc_print_allocation_id`),
  KEY `doc_violations_handling_id` (`doc_violations_handling_id`),
  CONSTRAINT `doc_print_handling_ibfk_1` FOREIGN KEY (`doc_print_allocation_id`) REFERENCES `doc_print_allocation` (`id`),
  CONSTRAINT `doc_print_handling_ibfk_2` FOREIGN KEY (`doc_violations_handling_id`) REFERENCES `doc_violations_handling` (`id`)
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
  `master_business_id` int(11) DEFAULT NULL COMMENT 'Doanh nghiệp vi phạm',
  `master_violation_id` int(11) DEFAULT NULL COMMENT 'bảng hành vi vi phạm',
  `master_sanctions_id` int(11) DEFAULT NULL COMMENT 'bảng hình thức xử lý',
  `master_deparment_id` int(11) DEFAULT NULL COMMENT 'bảng phòng ban',
  `sys_user_id` int(11) DEFAULT NULL COMMENT 'user xử lý',
  `date_violation` datetime DEFAULT NULL COMMENT 'Ngày vi phạm',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doc_violations_handling_ibfk_5` (`master_business_id`),
  KEY `doc_violations_handling_ibfk_3` (`master_deparment_id`),
  KEY `doc_violations_handling_ibfk_2` (`master_sanctions_id`),
  KEY `doc_violations_handling_ibfk_1` (`master_violation_id`),
  KEY `sys_user_id` (`sys_user_id`),
  CONSTRAINT `doc_violations_handling_ibfk_1` FOREIGN KEY (`master_violation_id`) REFERENCES `master_violation` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_2` FOREIGN KEY (`master_sanctions_id`) REFERENCES `master_sanction` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_3` FOREIGN KEY (`master_deparment_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_5` FOREIGN KEY (`master_business_id`) REFERENCES `info_business` (`id`),
  CONSTRAINT `doc_violations_handling_ibfk_6` FOREIGN KEY (`sys_user_id`) REFERENCES `sys_user` (`id`)
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
  `master_items_limit_id` int(11) DEFAULT NULL COMMENT 'mặt hàng hạn chế kinh doanh',
  `master_items_condition_id` int(11) DEFAULT NULL COMMENT 'mặt hàng kinh doanh có điều kiện',
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
  CONSTRAINT `info_business_ibfk_1` FOREIGN KEY (`master_district_id`) REFERENCES `master_district` (`id`),
  CONSTRAINT `info_business_ibfk_2` FOREIGN KEY (`master_ward_id`) REFERENCES `master_ward` (`id`),
  CONSTRAINT `info_business_ibfk_3` FOREIGN KEY (`master_business_type_id`) REFERENCES `master_business_type` (`id`),
  CONSTRAINT `info_business_ibfk_4` FOREIGN KEY (`master_business_size_id`) REFERENCES `master_business_size` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bảng doanh nghiệp';

-- ----------------------------
-- Records of info_business
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Quy mô doanh nghiệp : vừa, nhỏ, to ....';

-- ----------------------------
-- Records of master_business_size
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Loại hình kinh doanh: cty TNHH, cty TNHH 1 thành viên ...';

-- ----------------------------
-- Records of master_business_type
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='danh mục quận huyện';

-- ----------------------------
-- Records of master_district
-- ----------------------------

-- ----------------------------
-- Table structure for `master_items`
-- ----------------------------
DROP TABLE IF EXISTS `master_items`;
CREATE TABLE `master_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type_commodity` varchar(11) DEFAULT NULL COMMENT 'Loại hàng hóa:\r\n+ Kinh Doanh Có điều kiện \r\n+ Mặt hàng hạn chế kinh doanh',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng danh mục mặt hàng kinh doanh có điều kiện';

-- ----------------------------
-- Records of master_items_condition
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng danh mục mặt hàng hạn chế kinh doanh';

-- ----------------------------
-- Records of master_items_limit
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='danh mục tên ấn chỉ';

-- ----------------------------
-- Records of master_print
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng tỉnh thành';

-- ----------------------------
-- Records of master_province
-- ----------------------------

-- ----------------------------
-- Table structure for `master_sanction`
-- ----------------------------
DROP TABLE IF EXISTS `master_sanction`;
CREATE TABLE `master_sanction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` int(255) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng danh mục hình thức xử lý';

-- ----------------------------
-- Records of master_sanction
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng đơn vị tính';

-- ----------------------------
-- Records of master_unit
-- ----------------------------

-- ----------------------------
-- Table structure for `master_violation`
-- ----------------------------
DROP TABLE IF EXISTS `master_violation`;
CREATE TABLE `master_violation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` int(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) DEFAULT '0',
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng hành vi vi phạm';

-- ----------------------------
-- Records of master_violation
-- ----------------------------

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Bảng phường xã';

-- ----------------------------
-- Records of master_ward
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_department`
-- ----------------------------
DROP TABLE IF EXISTS `sys_department`;
CREATE TABLE `sys_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) DEFAULT NULL,
  `name` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng phòng ban';

-- ----------------------------
-- Records of sys_department
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_privileges`
-- ----------------------------
DROP TABLE IF EXISTS `sys_privileges`;
CREATE TABLE `sys_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(11) DEFAULT NULL COMMENT 'Add, edit, view, delete ...',
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
  CONSTRAINT `sys_user_ibfk_1` FOREIGN KEY (`master_department_id`) REFERENCES `sys_department` (`id`),
  CONSTRAINT `sys_user_ibfk_2` FOREIGN KEY (`sys_user_group_id`) REFERENCES `sys_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng người dùng';

-- ----------------------------
-- Records of sys_user
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='bảng nhóm user';

-- ----------------------------
-- Records of sys_user_group
-- ----------------------------

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

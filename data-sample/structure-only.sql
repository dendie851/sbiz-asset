/*
 Navicat Premium Data Transfer

 Source Server         : Localhost - MySQL
 Source Server Type    : MySQL
 Source Server Version : 100119
 Source Host           : localhost:3306
 Source Schema         : sbiz_asset

 Target Server Type    : MySQL
 Target Server Version : 100119
 File Encoding         : 65001

 Date: 03/04/2026 15:54:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for asset
-- ----------------------------
DROP TABLE IF EXISTS `asset`;
CREATE TABLE `asset`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `code` char(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `size` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `foto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `foto_thumb` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE,
  INDEX `idx_asset_cat_del_name`(`category_id`, `is_delete`, `name`) USING BTREE,
  INDEX `idx_asset_category_delete`(`category_id`, `is_delete`, `name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 101 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for asset_depriciation
-- ----------------------------
DROP TABLE IF EXISTS `asset_depriciation`;
CREATE TABLE `asset_depriciation`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `date` datetime(0) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 101 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for asset_depriciation_history
-- ----------------------------
DROP TABLE IF EXISTS `asset_depriciation_history`;
CREATE TABLE `asset_depriciation_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_depriciation_id` int(11) NULL DEFAULT NULL,
  `asset_series_id` int(11) NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `price_buy` decimal(10, 0) NULL DEFAULT NULL,
  `price_min` decimal(10, 0) NULL DEFAULT NULL,
  `depriciation` decimal(10, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_adh_lookup`(`asset_depriciation_id`, `asset_series_id`, `depriciation`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12510 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for asset_history
-- ----------------------------
DROP TABLE IF EXISTS `asset_history`;
CREATE TABLE `asset_history`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_series_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` enum('0','1','2','3') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=pembelian, 1=perbaikan, 2=pemindahan 3=pemusnahan',
  `decription` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_ah_series_type_date`(`asset_series_id`, `type`, `date`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15193 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for asset_series
-- ----------------------------
DROP TABLE IF EXISTS `asset_series`;
CREATE TABLE `asset_series`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `fund_id` int(11) NOT NULL,
  `departement_id` int(11) NOT NULL DEFAULT 0,
  `no_serries` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_purchase` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `merk` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price_buy` decimal(15, 0) NOT NULL,
  `price` decimal(15, 0) NOT NULL,
  `price_min` decimal(15, 0) NOT NULL,
  `depriciation` decimal(10, 0) NOT NULL,
  `cond` enum('0','1','2') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=broken, 1=good, 2=half good',
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_remove` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=tidak musnah, 1=musnah',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=tidak di hapus, 1=sudah di hapus',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_ase_asset_del_rem`(`asset_id`, `is_delete`, `is_remove`) USING BTREE,
  INDEX `idx_ase_filter_group`(`is_delete`, `is_remove`, `departement_id`, `fund_id`, `location_id`, `asset_id`) USING BTREE,
  INDEX `idx_ase_lookup_serries`(`asset_id`, `location_id`, `is_delete`, `is_remove`, `no_serries`) USING BTREE,
  INDEX `idx_ase_lookup_dep`(`asset_id`, `is_delete`, `is_remove`) USING BTREE,
  INDEX `is_delete`(`is_delete`, `is_remove`) USING BTREE,
  INDEX `departement_id`(`departement_id`) USING BTREE,
  INDEX `fund_id`(`fund_id`) USING BTREE,
  INDEX `location_id`(`location_id`) USING BTREE,
  INDEX `asset_id`(`asset_id`) USING BTREE,
  INDEX `idx_lookup`(`asset_id`, `location_id`, `is_delete`, `is_remove`) USING BTREE,
  INDEX `idx_access`(`departement_id`, `fund_id`) USING BTREE,
  INDEX `idx_ase_filter`(`is_delete`, `is_remove`, `departement_id`, `fund_id`) USING BTREE,
  INDEX `idx_ase_location`(`location_id`) USING BTREE,
  INDEX `idx_ase_asset`(`asset_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12440 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 31 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for departement
-- ----------------------------
DROP TABLE IF EXISTS `departement`;
CREATE TABLE `departement`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` tinytext CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `is_fix` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0= can be delete, 1= not delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 38 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fund
-- ----------------------------
DROP TABLE IF EXISTS `fund`;
CREATE TABLE `fund`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for location
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `size` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT '0=not use, 1=use',
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE,
  INDEX `is_delete`(`is_delete`) USING BTREE,
  INDEX `parent_id_2`(`parent_id`) USING BTREE,
  INDEX `is_delete_2`(`is_delete`) USING BTREE,
  INDEX `idx_parent_name`(`parent_id`, `name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 150 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `access_departement_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `access_fund_id` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `position_id` int(11) NOT NULL,
  `is_enabled` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 23 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for position
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `privilage` char(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_delete` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0' COMMENT '0=not delete, 1=delete',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 21 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;


-- ----------------------------
-- Data untuk tabel position
-- ----------------------------
INSERT INTO `position` (`id`, `name`, `privilage`, `is_delete`) VALUES 
(1, 'Administrator', '111111111', '0'),
(2, 'Operator', '111111100', '0'),
(3, 'Supervisor', '111110000', '0'),

-- ----------------------------
-- Data untuk tabel member
-- ----------------------------
-- Asumsi: access_departement_id dan access_fund_id berisi string ID departemen yang bisa mereka kelola (misal: "1,2,3")
INSERT INTO `member` (`id`, `name`, `access_departement_id`, `access_fund_id`, `position_id`, `is_enabled`) VALUES 
(1, 'Administrator', 'all', 'all', 1, '1'),

-- ----------------------------
-- Data untuk tabel user
-- ----------------------------
-- Password menggunakan simulasi hash (biasanya md5 atau password_hash)
-- Default password: password123
INSERT INTO `user` (`id`, `username`, `password`, `member_id`) VALUES 
(1, 'admin', '24dc0291079d380962b9a7066f272a74', 1),;


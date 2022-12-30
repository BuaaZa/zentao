/*
 Navicat MySQL Data Transfer

 Source Server         : mysql8
 Source Server Type    : MySQL
 Source Server Version : 80025
 Source Host           : localhost:3307
 Source Schema         : zentao

 Target Server Type    : MySQL
 Target Server Version : 80025
 File Encoding         : 65001

 Date: 29/12/2022 18:26:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for zt_data_sample
-- ----------------------------
DROP TABLE IF EXISTS `zt_data_sample`;
CREATE TABLE `zt_data_sample`  (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `io_id` mediumint NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `sample_id` mediumint NOT NULL,
  `run_id` mediumint NOT NULL,
  `result_id` mediumint NULL DEFAULT NULL,
  `deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zt_data_sample
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;

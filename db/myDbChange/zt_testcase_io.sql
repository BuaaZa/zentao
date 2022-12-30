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

 Date: 29/12/2022 18:16:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for zt_testcase_io
-- ----------------------------
DROP TABLE IF EXISTS `zt_testcase_io`;
CREATE TABLE `zt_testcase_io`  (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `testcase_id` mediumint NOT NULL,
  `io_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `io_type` enum('input','expected_output','actual_result') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'input',
  `deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of zt_testcase_io
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;

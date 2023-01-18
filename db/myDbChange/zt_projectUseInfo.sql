# 创建zt_projectUseInfo表

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `zt_projectUseInfo`;
CREATE TABLE `zt_projectUseInfo`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `feedback` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `serverOS` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `serverCPU` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `middleware` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `database` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `terminalOS` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `terminalCPU` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `browser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;
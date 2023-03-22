SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `zt_interface`;
CREATE TABLE `zt_interface`  (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `product` mediumint NOT NULL,
  `name` CHAR(50),
  `method` ENUM('GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT') NOT NULL,
  `url` TEXT NOT NULL,
  `module` mediumint NOT NULL DEFAULT 0,
  `header` json,
  `data` json,
  `deleted` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;

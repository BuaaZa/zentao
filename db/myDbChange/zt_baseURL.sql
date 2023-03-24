SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `zt_baseurl`;
CREATE TABLE `zt_baseurl`  (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `product` mediumint NOT NULL,
  `name` CHAR(50),
  `url` TEXT NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
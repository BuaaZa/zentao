-- !!!!!!!!!!!写SQL的时候一定注意注释必须以分号结尾，重要的事情说三编!!!!!!!!!!!!!!!!;
-- !!!!!!!!!!!写SQL的时候一定注意注释必须以分号结尾，重要的事情说三编!!!!!!!!!!!!!!!!;
-- !!!!!!!!!!!写SQL的时候一定注意注释必须以分号结尾，重要的事情说三编!!!!!!!!!!!!!!!!;
-- !!!!!!!!!!!写SQL的时候一定注意注释必须以分号结尾，重要的事情说三编!!!!!!!!!!!!!!!!;

-- 表 zt_file 增加字段 ip,enternalId;
alter table `zt_action` add `commentExId` varchar(36) default '' not null after `actor`;
-- 导出的日期;
alter table `zt_action` add `exportDate` DATETIME NOT NULL after `actor`; 


-- 表 zt_file 增加字段 productVersion,usedProject,expectDate,contactWay,feedbackExId,createdAt;
alter table `zt_feedback` add `productVersion` char(255) default '' not null after `deleted`;
alter table `zt_feedback` add `usedProject` char(255) default '' not null after `deleted`;
alter table `zt_feedback` add `expectDate` DATETIME NOT NULL after `deleted`;
alter table `zt_feedback` add `contactWay` char(255) default '' not null after `deleted`;
alter table `zt_feedback` add `feedbackExId` char(36) default '' not null after `deleted`;
alter table `zt_feedback` add `createdAt` char(50) default '' not null after `deleted`;

-- 导出的日期;
alter table `zt_feedback` add `exportDate` DATETIME NOT NULL after `deleted`; 
--更新的时间;
alter table `zt_feedback` add `updateDate` DATETIME NOT NULL after `deleted`; 


-- 表 zt_file 增加字段 enternalId;
alter table `zt_file` add `enternalId` char(36) default '' not null after `deleted`;


-- 创建zt_projectUseInfo表;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `zt_projectuseinfo`;
CREATE TABLE `zt_projectuseinfo`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `feedback` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `serverOS` varchar(255) NOT NULL,
  `serverCPU` varchar(255) NOT NULL,
  `middleware` varchar(255) NOT NULL,
  `database` varchar(255) NOT NULL,
  `terminalOS` varchar(255) NOT NULL,
  `terminalCPU` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 20230306, 表 zt_product 增加字段 allowFeedback;
alter table `zt_product` add `allowFeedback` enum('0', '1') NOT NULL DEFAULT '0' after `deleted`;
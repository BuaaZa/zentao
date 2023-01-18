# 表 zt_feedback 增加字段

# 增加产品版本
DELIMITER //
CREATE PROCEDURE addProductVersion()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'productVersion' AND TABLE_NAME = 'zt_feedback';
    IF (num = 0)
    THEN
        alter table `zt_feedback` add `productVersion` char(255) default '' not null after `deleted`;
    END IF;
END//

DELIMITER ';'

CALL addProductVersion();

DROP PROCEDURE addProductVersion;



# 增加使用项目名称
DELIMITER //
CREATE PROCEDURE addUsedProject()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'usedProject' AND TABLE_NAME = 'zt_feedback';
    IF (num = 0)
    THEN
        alter table `zt_feedback` add `usedProject` char(255) default '' not null after `productVersion`;
    END IF;
END//

DELIMITER ';'

CALL addUsedProject();

DROP PROCEDURE addUsedProject;



# 增加期望交付时间
DELIMITER //
CREATE PROCEDURE addExpectDate()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'expectDate' AND TABLE_NAME = 'zt_feedback';
    IF (num = 0)
    THEN
        alter table `zt_feedback` add `expectDate` DATETIME NOT NULL after `usedProject`;
    END IF;
END//

DELIMITER ';'

CALL addExpectDate();

DROP PROCEDURE addExpectDate;



# 增加联系方式
DELIMITER //
CREATE PROCEDURE addContactWay()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'contactWay' AND TABLE_NAME = 'zt_feedback';
    IF (num = 0)
    THEN
        alter table `zt_feedback` add `contactWay` char(255) default '' not null after `expectDate`;
    END IF;
END//

DELIMITER ';'

CALL addContactWay();

DROP PROCEDURE addContactWay;



# 增加外部关联主键
DELIMITER //
CREATE PROCEDURE addFeedbackExId()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'feedbackExId' AND TABLE_NAME = 'zt_feedback';
    IF (num = 0)
    THEN
        alter table `zt_feedback` add `feedbackExId` char(36) default '' not null after `contactWay`;
    END IF;
END//

DELIMITER ';'

CALL addFeedbackExId();

DROP PROCEDURE addFeedbackExId;



# 增加创建于字段用以区分反馈记录是来自天唧还是禅道
DELIMITER //
CREATE PROCEDURE addCreatedAt()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'createdAt' AND TABLE_NAME = 'zt_feedback';
    IF (num = 0)
    THEN
        alter table `zt_feedback` add `createdAt` char(50) default '' not null after `feedbackExId`;
    END IF;
END//

DELIMITER ';'

CALL addCreatedAt();

DROP PROCEDURE addCreatedAt;


# 如果表 zt_product 不存在字段 allowFeedback ，则在 deleted 之后添加字段

DELIMITER //
CREATE PROCEDURE addEnternalIdAtProduct()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'allowFeedback' AND TABLE_NAME = 'zt_product';
    IF (num = 0)
    THEN
        alter table `zt_product` add `allowFeedback` enum('0', '1') NOT NULL DEFAULT '1' after `deleted`;
    END IF;
END//

DELIMITER ';'

CALL addEnternalIdAtProduct();

DROP PROCEDURE addEnternalIdAtProduct;


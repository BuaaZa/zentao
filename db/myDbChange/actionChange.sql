# 如果表 zt_action 不存在字段 ip ，则在 actor 之后添加字段

DELIMITER //
CREATE PROCEDURE addIpAtAction()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'ip' AND TABLE_NAME = 'zt_action';
    IF (num = 0)
    THEN
        alter table `zt_action` add `ip` char(15) default '' not null after `actor`;
    END IF;
END//

DELIMITER ';'

CALL addIpAtAction();

DROP PROCEDURE addIpAtAction;


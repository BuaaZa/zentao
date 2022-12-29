# 修改 zt_action 表

DELIMITER //
CREATE PROCEDURE addIpAtAction()

BEGIN
    IF NOT EXISTS(
            SELECT *
            FROM information_schema.COLUMNS
            WHERE COLUMN_NAME = 'ip'
              AND TABLE_NAME = 'zt_action')
    THEN
        alter table `zt_action`
            add `ip` char(15) default '' not null after `actor`;
    END IF;
END//

DELIMITER ';'
CALL addIpAtAction();
DROP PROCEDURE addIpAtAction;


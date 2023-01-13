# 如果表 zt_file 不存在字段 enternalId ，则在 deleted 之后添加字段

DELIMITER //
CREATE PROCEDURE addEnternalIdAtFile()

BEGIN
    DECLARE num INT;
    SELECT count(*) into num FROM information_schema.COLUMNS
        WHERE COLUMN_NAME = 'enternalId' AND TABLE_NAME = 'zt_file';
    IF (num = 0)
    THEN
        alter table `zt_file` add `enternalId` char(36) default '' not null after `deleted`;
    END IF;
END//

DELIMITER ';'

CALL addEnternalIdAtFile();

DROP PROCEDURE addEnternalIdAtFile;


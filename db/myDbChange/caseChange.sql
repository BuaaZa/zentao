# 如果表 zt_case 不存在字段 data_sample_new ，则添加字段。

DELIMITER //
CREATE PROCEDURE addColumnAtCase()

BEGIN
    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                  WHERE COLUMN_NAME = 'data_sample_new' AND TABLE_NAME = 'zt_case')
    THEN
        alter table `zt_case` add `data_sample_new` text NULL;
END IF;

END//

DELIMITER ';'

CALL addColumnAtCase();

DROP PROCEDURE addColumnAtCase;


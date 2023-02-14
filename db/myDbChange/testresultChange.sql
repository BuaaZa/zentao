# 如果表 zt_testresult 不存在字段 sample_data ，则添加字段。

DELIMITER //
CREATE PROCEDURE addColumnAtTestresult()

BEGIN
    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                  WHERE COLUMN_NAME = 'sample_data' AND TABLE_NAME = 'zt_testresult')
    THEN
        alter table `zt_testresult` add `sample_data` text NULL;
    END IF;

END//

DELIMITER ';'

CALL addColumnAtTestresult();

DROP PROCEDURE addColumnAtTestresult;


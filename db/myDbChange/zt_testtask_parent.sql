# 如果表 zt_testtask 不存在字段 parent 则添加字段。

DELIMITER //
CREATE PROCEDURE addColumnAtTesttask()

BEGIN
    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                  WHERE COLUMN_NAME = 'parent' AND TABLE_NAME = 'zt_testtask')
    THEN
        alter table `zt_testtask` add `parent` int not null;
    END IF;
END//

DELIMITER ';'

CALL addColumnAtTesttask();

DROP PROCEDURE addColumnAtTesttask;
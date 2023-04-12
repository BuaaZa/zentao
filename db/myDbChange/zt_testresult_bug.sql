# 如果表 zt_testresult 不存在字段 bug 则添加字段。

DELIMITER //
CREATE PROCEDURE addColumnAtTestresult()

BEGIN
    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                  WHERE COLUMN_NAME = 'bug' AND TABLE_NAME = 'zt_testresult')
    THEN
        alter table `zt_testresult` add `bug` int not null default -1;
    END IF;
END//

DELIMITER ';'

CALL addColumnAtTestresult();

DROP PROCEDURE addColumnAtTestresult;
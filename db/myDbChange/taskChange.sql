# 修改 zt_task 表

DELIMITER //
CREATE PROCEDURE addChange()

BEGIN
    IF NOT EXISTS(
            SELECT *
            FROM information_schema.COLUMNS
            WHERE COLUMN_NAME = 'workcodelines'
              AND TABLE_NAME = 'zt_task')
    THEN
        alter table zt_task
            add workcodelines int unsigned default 0 null after fromIssue;
    END IF;
END//

DELIMITER ';'
CALL addChange();
DROP PROCEDURE addChange;


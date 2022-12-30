# 修改 zt_effort 表

DELIMITER //
CREATE PROCEDURE addSyncStatusAtEffort()

BEGIN
    IF NOT EXISTS(
            SELECT *
            FROM information_schema.COLUMNS
            WHERE COLUMN_NAME = 'syncStatus'
              AND TABLE_NAME = 'zt_effort')
    THEN
        alter table `zt_effort`
            add `syncStatus` enum ('0', '1') default '0' not null after `work`;
    END IF;
END//

DELIMITER ';'
CALL addSyncStatusAtEffort();
DROP PROCEDURE addSyncStatusAtEffort;
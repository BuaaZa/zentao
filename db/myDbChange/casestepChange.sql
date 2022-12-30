# 如果表 zt_casestep 不存在字段 input、goal_action、eval_criteria ，则添加字段。

DELIMITER //
CREATE PROCEDURE addColumnAtCasestep()

BEGIN
    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                  WHERE COLUMN_NAME = 'input' AND TABLE_NAME = 'zt_casestep')
    THEN
        alter table `zt_casestep` add `input` text not null;
    END IF;

    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                      WHERE COLUMN_NAME = 'goal_action' AND TABLE_NAME = 'zt_casestep')
    THEN
        alter table `zt_casestep` add `goal_action` text not null;
    END IF;

    IF NOT EXISTS(SELECT * FROM information_schema.COLUMNS
                      WHERE COLUMN_NAME = 'eval_criteria' AND TABLE_NAME = 'zt_casestep')
    THEN
        alter table `zt_casestep` add `eval_criteria` text not null;
    END IF;
END//

DELIMITER ';'

CALL addColumnAtCasestep();

DROP PROCEDURE addColumnAtCasestep;


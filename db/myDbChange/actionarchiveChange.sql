create table if not exists zt_actionarchive
(
    id         int unsigned auto_increment
        primary key,
    objectType varchar(30)        default ''    not null,
    objectID   mediumint unsigned default '0'   not null,
    product    text                             not null,
    project    mediumint unsigned               not null,
    execution  mediumint unsigned               not null,
    actor      varchar(100)       default ''    not null,
    ip         char(15)           default ''    not null,
    action     varchar(80)        default ''    not null,
    date       datetime                         not null,
    comment    text                             not null,
    extra      text                             null,
    `read`     enum ('0', '1')    default '0'   not null,
    vision     varchar(10)        default 'rnd' not null,
    efforted   tinyint(1)         default 0     not null
)
    charset = utf8mb3;


DROP PROCEDURE IF EXISTS add_index;
DELIMITER //
CREATE PROCEDURE add_index(in target_index_name VARCHAR(100) , in target_column_name VARCHAR(100))

BEGIN
    DECLARE target_table_name VARCHAR(100);
    set target_table_name = 'zt_actionarchive';
    IF NOT EXISTS (
        SELECT *
        FROM information_schema.statistics
        WHERE table_name = target_table_name
          AND index_name = target_index_name)
        THEN
        set @statement = CONCAT('ALTER TABLE ', target_table_name, ' ADD INDEX ', target_index_name, '(', target_column_name, ')');
        PREPARE STMT FROM @statement;
        EXECUTE STMT;
    END IF;
END//

DELIMITER ;
CALL add_index('action','action');
CALL add_index('actor','actor');
CALL add_index('date','date');
CALL add_index('objectID','objectID');
CALL add_index('project','project');
DROP PROCEDURE add_index;
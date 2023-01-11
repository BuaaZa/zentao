create table zt_actionarchive
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

create index action
    on zt_actionarchive (action);

create index actor
    on zt_actionarchive (actor);

create index date
    on zt_actionarchive (date);

create index objectID
    on zt_actionarchive (objectID);

create index project
    on zt_actionarchive (project);
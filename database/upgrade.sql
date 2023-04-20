alter table zt_action
    add ip char(15) default '' not null after commentExId;

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
    extra      text               default ''    not null,
    `read`     enum ('0', '1')    default '0'   not null,
    vision     varchar(10)        default 'rnd' not null,
    efforted   tinyint(1)         default 0     not null
);

create index `action`
    on zt_actionarchive (action);

create index `actor`
    on zt_actionarchive (actor);

create index `date`
    on zt_actionarchive (date);

create index `objectID`
    on zt_actionarchive (objectID);

create index `project`
    on zt_actionarchive (project);

create table zt_baseurl
(
    id      int unsigned auto_increment
        primary key,
    product mediumint not null,
    name    char(50)  null,
    url     text      not null
);

alter table zt_bug
    modify status enum ('active', 'resolved', 'closed', 'tobedeliberated') default 'active' not null;

alter table zt_casestep
    add goal_action text not null after input;

alter table zt_casestep
    add eval_criteria text not null;

create table zt_data_sample
(
    id             int unsigned auto_increment comment '数据样本的ID'
        primary key,
    case_id        int unsigned not null comment '用例外键ID',
    casestep_id    int unsigned not null comment '测试步骤外键ID',
    casestep_level int unsigned not null comment '测试步骤编号',
    object         text         null comment '样本实体',
    version        int unsigned not null comment '数据样本版本 对应于测试用例和步骤的版本'
);

create table zt_data_sample_result
(
    id             int unsigned auto_increment comment '数据样本结果的ID'
        primary key,
    data_sample_id int unsigned                       not null comment '数据样本外键ID',
    object         text                               null comment '样本结果实体',
    create_date    datetime default CURRENT_TIMESTAMP null comment '创建时间与日期',
    version        int unsigned                       not null comment '数据样本结果版本 对应于测试用例和步骤的版本'
);

create table zt_deliberation
(
    id              int unsigned auto_increment
        primary key,
    frombugid       mediumint                                  not null,
    deliberateddate datetime                                   not null,
    description     text                                       null,
    tostatus        enum ('active', 'closed') default 'active' not null,
    launcherid      mediumint                                  not null,
    organizerid     mediumint                                  not null,
    times           int                                        not null,
    deleted         enum ('0', '1')           default '0'      not null
);

create index frombugid
    on zt_deliberation (frombugid);

alter table zt_effort
    add syncStatus enum ('0', '1') default '0' not null after work;

alter table zt_task
    add workcodelines int unsigned default '0' null after fromIssue;

alter table zt_testresult
    add bug mediumint default -1 not null after xml;

alter table zt_testtask
    add parent int not null;


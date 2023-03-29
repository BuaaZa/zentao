create table if not exists `zt_data_sample`
(
    `id`           int unsigned auto_increment primary key comment '数据样本的ID',
    `case_id`      int unsigned not null comment '用例外键ID',
    `casestep_level`  int unsigned not null comment '测试步骤编号',
    `object`       text comment '样本实体',
    `delete`       enum ('0', '1') default '0'
);

create table if not exists `zt_data_sample_result`
(
    `id`             int unsigned auto_increment primary key comment '数据样本结果的ID',
    `data_sample_id` int unsigned not null comment '数据样本外键ID',
    `object`         text comment '样本结果实体',
    `create_date`    datetime        default current_timestamp() comment '创建时间与日期',
    `delete`         enum ('0', '1') default '0'
);
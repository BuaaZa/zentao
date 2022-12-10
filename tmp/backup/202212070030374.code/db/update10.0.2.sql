REPLACE INTO `zt_report` (`code`, `name`, `module`, `sql`, `vars`, `langs`, `params`, `step`, `desc`, `addedBy`, `addedDate`) VALUES
('projectbug-type',     '{\"zh-cn\":\"\\u9879\\u76eeBug\\u7c7b\\u578b\\u7edf\\u8ba1\\u8868\",\"zh-tw\":\"\",\"en\":\"Project Bug Type\",\"de\":\"Project Bug Type\",\"fr\":\"Project Bug Type\",\"vi\":\"Project Bug Type\",\"ja\":\"Project Bug Type\"}',      ',project,test',        'select t1.id as bugID,t1.type,t2.id,t2.name as project,t3.name as execution,t3.id from TABLE_BUG as t1  \r\nleft join TABLE_PROJECT as t2 on t1.project=t2.id\r\nleft join TABLE_EXECUTION as t3 on t3.id=t1.execution\r\nwhere t1.deleted=\'0\' and t2.deleted=\'0\' and if($project=\'\',1,t2.id=$project) and if($execution=\'\',1,t3.id=$execution)',      '{\"varName\":[\"project\",\"execution\"],\"showName\":[\"\\u9879\\u76ee\\u5217\\u8868\",\"\\u6267\\u884c\\u5217\\u8868\"],\"requestType\":[\"select\",\"select\"],\"selectList\":[\"project\",\"execution\"],\"default\":[\"\",\"\"]}',        '{\"stories\":{\"zh-cn\":\"\\u9700\\u6c42\\u6570\",\"zh-tw\":\"\\u9700\\u6c42\\u6570\",\"en\":\"Stories\"},\"tasks\":{\"zh-cn\":\"\\u4efb\\u52a1\\u6570\",\"zh-tw\":\"\\u4efb\\u52a1\\u6570\",\"en\":\"Tasks\"},\"undoneStory\":{\"zh-cn\":\"\\u5269\\u4f59\\u9700\\u6c42\\u6570\",\"zh-tw\":\"\\u5269\\u4f59\\u9700\\u6c42\\u6570\",\"en\":\"Undone Story\"},\"undoneTask\":{\"zh-cn\":\"\\u5269\\u4f59\\u4efb\\u52a1\\u6570\",\"zh-tw\":\"\\u5269\\u4f59\\u4efb\\u52a1\\u6570\",\"en\":\"Undone Task\"},\"consumed\":{\"zh-cn\":\"\\u5df2\\u6d88\\u8017\\u5de5\\u65f6\",\"zh-tw\":\"\\u5df2\\u6d88\\u8017\\u5de5\\u65f6\",\"en\":\"Cost(h)\"},\"left\":{\"zh-cn\":\"\\u5269\\u4f59\\u5de5\\u65f6\",\"zh-tw\":\"\\u5269\\u4f59\\u5de5\\u65f6\",\"en\":\"Left(h)\"},\"consumedPercent\":{\"zh-cn\":\"\\u8fdb\\u5ea6\",\"zh-tw\":\"\\u8fdb\\u5ea6\",\"en\":\"Process\"},\"execution\":{\"zh-cn\":\"\\u6267\\u884c\\u540d\\u79f0\"}}',    '{\"group1\":\"project\",\"group2\":\"execution\",\"reportField\":[\"type\"],\"reportType\":[\"count\"],\"sumAppend\":[\"\"]}', 2,      '{\"zh-cn\":\"\\u6309\\u7167\\u9879\\u76ee\\u7edf\\u8ba1Bug\\u7684\\u7c7b\\u578b\\u5206\\u5e03\\u60c5\\u51b5\\u3002\",\"zh-tw\":\"\",\"en\":\"\",\"de\":\"\",\"fr\":\"\",\"vi\":\"\",\"ja\":\"\"}',     'admin',        '2015-08-04 13:54:22'),
('projectbug-assign',   '{\"zh-cn\":\"\\u9879\\u76eeBug\\u6307\\u6d3e\\u7ed9\\u5206\\u5e03\\u8868\",\"zh-tw\":\"\",\"en\":\"Project Bug Assign\",\"de\":\"Project Bug Assign\",\"fr\":\"Project Bug Assign\",\"vi\":\"Project Bug Assign\",\"ja\":\"Project Bug Assign\"}',     ',project,test',        'select t1.id as bugID,t1.assignedTo,t2.id,t2.name as project,t3.name as execution,t3.id from TABLE_BUG as t1 \r\nleft join TABLE_PROJECT as t2 on t1.project=t2.id\r\nleft join TABLE_EXECUTION as t3 on t3.id=t1.execution\r\nwhere t1.deleted=\'0\' and t2.deleted=\'0\' having bugID!=\' \' and if($project=\'\',1,t2.id=$project) and if($execution=\'\',1,t3.id=$execution)',     '{\"varName\":[\"project\",\"execution\"],\"showName\":[\"\\u9879\\u76ee\\u5217\\u8868\",\"\\u6267\\u884c\\u5217\\u8868\"],\"requestType\":[\"select\",\"select\"],\"selectList\":[\"project\",\"execution\"],\"default\":[\"\",\"\"]}',        '{\"project\":{\"zh-cn\":\"\\u9879\\u76ee\\u540d\\u79f0\"},\"execution\":{\"zh-cn\":\"\\u6267\\u884c\\u540d\\u79f0\"}}',        '{\"group1\":\"project\",\"group2\":\"execution\",\"reportField\":[\"assignedTo\"],\"isUser\":{\"reportField\":[[\"1\"]]},\"reportType\":[\"count\"],\"sumAppend\":[\"\"],\"reportTotal\":[\"1\"]}',    2,      '{\"zh-cn\":\"\\u6309\\u7167\\u9879\\u76ee\\u7edf\\u8ba1Bug\\u7684\\u6307\\u6d3e\\u7ed9\\u5206\\u5e03\\u60c5\\u51b5\\u3002\",\"zh-tw\":\"\",\"en\":\"\",\"de\":\"\",\"fr\":\"\",\"vi\":\"\",\"ja\":\"\"}',      'admin',        '2015-07-23 16:29:10'),
('projectbug-resolve',  '{\"zh-cn\":\"\\u9879\\u76eeBug\\u89e3\\u51b3\\u8005\\u5206\\u5e03\\u8868\",\"zh-tw\":\"\",\"en\":\"Project Bug Resolve\",\"de\":\"Project Bug Resolve\",\"fr\":\"Project Bug Resolve\",\"vi\":\"Project Bug Resolve\",\"ja\":\"Project Bug Resolve\"}',        ',project,test',        'select t1.id as bugID,t1.resolvedBy,t2.id,t2.name as project,t3.name as execution,t3.id from TABLE_BUG as t1 \r\nleft join TABLE_PROJECT as t2 on t1.project=t2.id\r\nleft join TABLE_EXECUTION as t3 on t3.id=t1.execution\r\nwhere t1.deleted=\'0\' and t2.deleted=\'0\' having bugID!=\' \' and if($project=\'\',1,t2.id=$project) and if($execution=\'\',1,t3.id=$execution)',     '{\"varName\":[\"project\",\"execution\"],\"showName\":[\"\\u9879\\u76ee\\u5217\\u8868\",\"\\u6267\\u884c\\u5217\\u8868\"],\"requestType\":[\"select\",\"select\"],\"selectList\":[\"project\",\"execution\"],\"default\":[\"\",\"\"]}',        '{\"project\":{\"zh-cn\":\"\\u9879\\u76ee\\u540d\\u79f0\"},\"execution\":{\"zh-cn\":\"\\u6267\\u884c\\u540d\\u79f0\"}}',        '{\"group1\":\"project\",\"group2\":\"execution\",\"reportField\":[\"resolvedBy\"],\"isUser\":{\"reportField\":[[\"1\"]]},\"reportType\":[\"count\"],\"sumAppend\":[\"\"],\"reportTotal\":[\"1\"]}',    2,      '{\"zh-cn\":\"\\u6309\\u7167\\u9879\\u76ee\\u7edf\\u8ba1Bug\\u7684\\u89e3\\u51b3\\u8005\\u5206\\u5e03\\u60c5\\u51b5\\u3002\",\"zh-tw\":\"\",\"en\":\"\",\"de\":\"\",\"fr\":\"\",\"vi\":\"\",\"ja\":\"\"}',      'admin',        '2015-07-23 16:13:16'),
('projectbug-opened',   '{\"zh-cn\":\"\\u9879\\u76eeBug\\u521b\\u5efa\\u8005\\u5206\\u5e03\\u8868\",\"zh-tw\":\"\",\"en\":\"Project Bug Opened\",\"de\":\"Project Bug Opened\",\"fr\":\"Project Bug Opened\",\"vi\":\"Project Bug Opened\",\"ja\":\"Project Bug Opened\"}',     ',project,test',        'select t1.id as bugID,t1.openedBy,t2.id,t2.name as project,t3.name as execution,t3.id from TABLE_BUG as t1\r\nleft join TABLE_PROJECT as t2 on t1.project=t2.id\r\nleft join TABLE_EXECUTION as t3 on t3.id=t1.execution\r\nwhere t1.deleted=\'0\' and t2.deleted=\'0\' having bugID!=\' \' and if($project=\'\',1,t2.id=$project) and if($execution=\'\',1,t3.id=$execution)',        '{\"varName\":[\"project\",\"execution\"],\"showName\":[\"\\u9879\\u76ee\\u5217\\u8868\",\"\\u6267\\u884c\\u5217\\u8868\"],\"requestType\":[\"select\",\"select\"],\"selectList\":[\"project\",\"execution\"],\"default\":[\"\",\"\"]}',        '{\"project\":{\"zh-cn\":\"\\u9879\\u76ee\\u540d\\u79f0\"},\"execution\":{\"zh-cn\":\"\\u6267\\u884c\\u540d\\u79f0\"}}',        '{\"group1\":\"project\",\"group2\":\"execution\",\"reportField\":[\"openedBy\"],\"isUser\":{\"reportField\":[[\"1\"]]},\"reportType\":[\"count\"],\"sumAppend\":[\"\"],\"reportTotal\":[\"1\"]}',      2,      '{\"zh-cn\":\"\\u6309\\u7167\\u9879\\u76ee\\u7edf\\u8ba1Bug\\u7684\\u521b\\u5efa\\u8005\\u5206\\u5e03\\u60c5\\u51b5\\u3002\",\"zh-tw\":\"\",\"en\":\"\",\"de\":\"\",\"fr\":\"\",\"vi\":\"\",\"ja\":\"\"}',      'admin',        '2015-07-23 16:08:10'),
('projectbug-status',   '{\"zh-cn\":\"\\u9879\\u76eeBug\\u72b6\\u6001\\u5206\\u5e03\\u8868\",\"zh-tw\":\"\",\"en\":\"Project Bug Status\",\"de\":\"Project Bug Status\",\"fr\":\"Project Bug Status\",\"vi\":\"Project Bug Status\",\"ja\":\"Project Bug Status\"}',    ',project,test',        'select t1.id as bugID,t1.status,t2.id,t2.name as project,t3.name as execution,t3.id from TABLE_BUG as t1\r\nleft join TABLE_PROJECT as t2 on t1.project=t2.id\r\nleft join TABLE_EXECUTION as t3 on t3.id=t1.execution\r\nwhere t1.deleted=\'0\' and t2.deleted=\'0\' having bugID!=\' \' and if($project=\'\',1,t2.id=$project) and if($execution=\'\',1,t3.id=$execution)',  '{\"varName\":[\"project\",\"execution\"],\"showName\":[\"\\u9879\\u76ee\\u5217\\u8868\",\"\\u6267\\u884c\\u5217\\u8868\"],\"requestType\":[\"select\",\"select\"],\"selectList\":[\"project\",\"execution\"],\"default\":[\"\",\"\"]}',        '{\"project\":{\"zh-cn\":\"\\u9879\\u76ee\\u540d\\u79f0\"},\"execution\":{\"zh-cn\":\"\\u6267\\u884c\\u540d\\u79f0\"}}',        '{\"group1\":\"project\",\"group2\":\"execution\",\"reportField\":[\"status\"],\"reportType\":[\"count\"],\"sumAppend\":[\"\"]}',       2,      '{\"zh-cn\":\"\\u6309\\u7167\\u9879\\u76ee\\u7edf\\u8ba1Bug\\u7684\\u72b6\\u6001\\u5206\\u5e03\\u60c5\\u51b5\\u3002\",\"zh-tw\":\"\",\"en\":\"\",\"de\":\"\",\"fr\":\"\",\"vi\":\"\",\"ja\":\"\"}',     'admin',        '2015-07-23 15:48:03'),
('projectbug-resolution',       '{\"zh-cn\":\"\\u9879\\u76eeBug\\u89e3\\u51b3\\u65b9\\u6848\\u5206\\u5e03\\u8868\",\"zh-tw\":\"\",\"en\":\"Project Bug Resolution\",\"de\":\"Project Bug Resolution\",\"fr\":\"Project Bug Resolution\",\"vi\":\"Project Bug Resolution\",\"ja\":\"Project Bug Resolution\"}',  ',project,test',        'select t1.id as bugID,t1.resolution,t2.id,t2.name as project,t3.id,t3.name as execution from TABLE_BUG as t1  \r\nleft join TABLE_PROJECT as t2 on t1.project = t2.id\r\nleft join TABLE_EXECUTION as t3 on t1.execution= t3.id\r\nwhere t1.deleted=\'0\' and t2.deleted=\'0\' and t1.resolution!=\'\' having  bugID!=\'\' and if($project=\'\',1,t2.id=$project) and if($execution=\'\',1,t3.id=$execution)', '{\"varName\":[\"project\",\"execution\"],\"showName\":[\"\\u9879\\u76ee\\u5217\\u8868\",\"\\u6267\\u884c\\u5217\\u8868\"],\"requestType\":[\"select\",\"select\"],\"selectList\":[\"project\",\"execution\"],\"default\":[\"\",\"\"]}',        '{\"project\":{\"zh-cn\":\"\\u9879\\u76ee\\u540d\\u79f0\"},\"execution\":{\"zh-cn\":\"\\u6267\\u884c\\u540d\\u79f0\"}}',        '{\"group1\":\"project\",\"group2\":\"execution\",\"reportField\":[\"resolution\"],\"reportType\":[\"count\"],\"sumAppend\":[\"\"],\"reportTotal\":[\"1\"]}',   2,      '{\"zh-cn\":\"\\u6309\\u7167\\u9879\\u76ee\\u7edf\\u8ba1Bug\\u7684\\u89e3\\u51b3\\u65b9\\u6848\\u5206\\u5e03\\u60c5\\u51b5\\u3002\",\"zh-tw\":\"\",\"en\":\"\",\"de\":\"\",\"fr\":\"\",\"vi\":\"\",\"ja\":\"\"}',       'admin',        '2015-07-23 16:04:46');

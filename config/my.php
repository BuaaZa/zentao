<?php
$config->installed       = true;
$config->debug           = false;
$config->requestType     = 'GET';
$config->timezone        = 'Asia/Shanghai';
$config->db->host        = '127.0.0.1';
$config->db->port        = '3306';
$config->db->name        = 'zentaopms_17_7';
$config->db->user        = 'zentaopms_17_7_man';
$config->db->encoding    = 'UTF8';
$config->db->password    = '1234';
$config->db->prefix      = 'zt_';
$config->webRoot         = getWebRoot();
$config->default->lang   = 'zh-cn';

/*  将config/config.php中引入my.php放在routes.php之后可在此添加自定义api路由
 *  格式: config->routes[${url}] = '${filename}'
 *  注意filename命名小写
 * */
$config->routes['/projects/:id/teams/batchCreate'] = 'teamBatchCreate';

# 自定义执行设置
$config->execution = new stdclass();
$config->execution->defaultWorkhours  = '7.0'; # 默认可用工时/天

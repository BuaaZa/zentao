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
$config->customSession = true;
$config->routes['/teamAccount/:id']  = 'teamaccount';

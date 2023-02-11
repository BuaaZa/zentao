在config/下创建my.php,内容如下

``` php

<?php
$config->installed       = true;
$config->debug           = true;
$config->requestType     = 'PATH_INFO';
$config->timezone        = 'Asia/Shanghai';
$config->db->host        = '192.168.8.196';
$config->db->port        = '3307';
$config->db->name        = 'zentaomydev';
$config->db->user        = 'root';
$config->db->encoding    = 'UTF8';
$config->db->password    = '123456';
$config->db->prefix      = 'zt_';
$config->webRoot         = getWebRoot();
$config->default->lang   = 'zh-cn';
```

在mysql中创建zentaomydev数据库 utf-8，导入 zentaodev.sql文件，就可以了


如果apache不支持PATH_INFO,需要开启，执行以下命令开启
sudo a2enmod rewrite
另外，也可以通过将 /etc/apache2/mods-available/rewrite.load 连接到 /etc/apache2/mods-enabled/rewrite.load 来打开 Mod_rewrite 模块。用指令操作就是：
sudo ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load
当中存储在 Ubuntu 中采用上述做法并重启了 Apache 服务后，仍然无法正常 rewrite 网址。这里，还有一点需要注意的地方：
sudo vim /etc/apache2/sites-enabled/000-default
将其中的：
AllowOverride None
修改为：
AllowOverride All
重启apache
sudo /etc/init.d/apache2 restart
sudo systemctl restart apache2

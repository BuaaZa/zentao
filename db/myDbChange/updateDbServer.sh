#!/bin/bash

# 禅道安装目录
mypath=/home/product/zentaopms
# mysql用户、密码、数据库
user=zentaopms_17_7_man
password=1234
database=zentaopms_17_7

cd ${mypath}/db/myDbChange
mysql -u $user -p${password} -D $database < allChange.sql


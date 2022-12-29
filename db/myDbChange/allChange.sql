# 添加数据库修改脚本
# Linux 环境可在 updateDbServer.sh 定义好变量后执行
# 其他环境可在db/myDbChange目录下执行 mysql -u ${user} -p${password} -D ${database} < allChange.sql
source actionChange.sql;
source zt_testcase_io.sql;
source zt_data_sample.sql;
source casestepChange.sql;
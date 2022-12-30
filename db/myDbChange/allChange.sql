# 添加数据库修改脚本
# Linux 环境可在 updateDbServer.sh 定义好变量后执行
# 其他环境需要给以下source的sql文件补充文件绝对路径, 然后登录mysql选择数据库后执行
#   source ${yourPath}/allChange.sql
source actionChange.sql;
source effortChange.sql;
source zt_testcase_io.sql;
source zt_data_sample.sql;
source casestepChange.sql;
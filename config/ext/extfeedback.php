<?php

// 所属产品接口
$config->routes['/extfeedback/products']= 'extfeedbackproducts';
// 反馈类型接口
$config->routes['/extfeedback/types']= 'extfeedbacktypes';
// 处理结果接口
$config->routes['/extfeedback/solutions']= 'extfeedbacksolutions';
// 反馈状态接口
$config->routes['/extfeedback/status']= 'extfeedbackstatus';
// 反馈评论接口
$config->routes['/extfeedback/comment/:id']= 'extfeedbackcomment';
// 文件流
$config->routes['/filestream/:id']= 'extfilestream';
// 已存在的反馈增加附件接口
$config->routes['/extfeedback/upload/:id']= 'extfeedbackupload';
// 获取用户头像
$config->routes['/extuser/avatar/:account']= 'extuseravatar';
// 删除/下载文件接口
$config->routes['/extfile/:id']= 'extfile';
// 热门产品
$config->routes['/extfeedback/hotproducts']= 'extfeedbackhotproducts';
// 更新反馈
$config->routes['/extfeedback/update/:id']= 'extfeedbackupdate';

// 天唧手机端登录
$config->routes['/tokens_tj']= 'tokensnew';
<?php
$lang->project->approval = '审批';
$lang->project->previous = '上一步';

$lang->project->approvalflow = new stdclass();
$lang->project->approvalflow->flow   = '审批流程';
$lang->project->approvalflow->object = '审批对象';

$lang->project->approvalflow->objectList[''] = '';
$lang->project->approvalflow->objectList['stage'] = '阶段';
$lang->project->approvalflow->objectList['task']  = '任务';

$lang->project->copyProjectConfirm   = '完善项目信息';
$lang->project->executionInfoConfirm = '完善迭代信息';
$lang->project->stageInfoConfirm     = '完善阶段信息';

$lang->project->executionInfoTips = '为了避免重复，请修改迭代名称和迭代代号，设置计划开始时间和计划完成时间。';

$lang->project->chosenProductStage = '请选择 “%s” 产品要复制%s阶段';
$lang->project->notCopyStage       = '不复制';
$lang->project->completeCopy       = '复制完成';

$lang->project->copyproject = new stdClass();
$lang->project->copyproject->nameTips           = '[项目名称]不可重复需要修改。';
$lang->project->copyproject->codeTips           = '[项目代号]不可重复需要修改。';
$lang->project->copyproject->endTips            = '[计划完成]不能为空。';
$lang->project->copyproject->daysTips           = '[可用工作日]应当是数字。';
$lang->project->copyproject->select             = '选择要复制的项目';
$lang->project->copyproject->confirmData        = '确认要复制的数据';
$lang->project->copyproject->improveData        = '完善新项目的数据';
$lang->project->copyproject->completeData       = '完成项目复制';
$lang->project->copyproject->selectPlz          = '请选择要复制的项目';
$lang->project->copyproject->cancel             = '取消复制';
$lang->project->copyproject->all                = '全部数据';
$lang->project->copyproject->basic              = '基础数据';
$lang->project->copyproject->allList            = array('项目自身的数据', '项目所包含的%s', '项目和%s的文档目录', '项目%s所包含的任务', 'QA质量保证计划', '过程裁剪设置', '团队成员安排与权限');
$lang->project->copyproject->toComplete         = '去完善';
$lang->project->copyproject->selectProjectPlz   = '请选择项目';
$lang->project->copyproject->confirmCopyDataTip = '请确认要复制的数据：';
$lang->project->copyproject->basicInfo          = '项目数据（所属项目集，项目名称，项目代号，所属产品）';
$lang->project->copyproject->selectProgram      = '请选择项目集';
$lang->project->copyproject->sprint             = '迭代';

<?php
$lang->project->approval = '審批';
$lang->project->previous = '上一步';

$lang->project->approvalflow = new stdclass();
$lang->project->approvalflow->flow   = '審批流程';
$lang->project->approvalflow->object = '審批對象';

$lang->project->approvalflow->objectList[''] = '';
$lang->project->approvalflow->objectList['stage'] = '階段';
$lang->project->approvalflow->objectList['task']  = '任務';

$lang->project->copyProjectConfirm   = '完善項目信息';
$lang->project->executionInfoConfirm = '完善迭代信息';
$lang->project->stageInfoConfirm     = '完善階段信息';

$lang->project->executionInfoTips = '為了避免重複，請修改迭代名稱和迭代代號，設置計劃開始時間和計劃完成時間。';

$lang->project->chosenProductStage = '請選擇 “%s” 產品要複製%s階段';
$lang->project->notCopyStage       = '不複製';
$lang->project->completeCopy       = '複製完成';

$lang->project->copyproject = new stdClass();
$lang->project->copyproject->nameTips           = '[項目名稱]不可重複需要修改。';
$lang->project->copyproject->codeTips           = '[項目代號]不可重複需要修改。';
$lang->project->copyproject->endTips            = '[計劃完成]不能為空。';
$lang->project->copyproject->daysTips           = '[可用工作日]應當是數字。';
$lang->project->copyproject->select             = '選擇要複製的項目';
$lang->project->copyproject->confirmData        = '確認要複製的數據';
$lang->project->copyproject->improveData        = '完善新項目的數據';
$lang->project->copyproject->completeData       = '完成項目複製';
$lang->project->copyproject->selectPlz          = '請選擇要複製的項目';
$lang->project->copyproject->cancel             = '取消複製';
$lang->project->copyproject->all                = '全部數據';
$lang->project->copyproject->basic              = '基礎數據';
$lang->project->copyproject->allList            = array('項目自身的數據', '項目所包含的%s', '項目和%s的文檔目錄', '項目%s所包含的任務', 'QA質量保證計劃', '過程裁剪設置', '團隊成員安排與權限');
$lang->project->copyproject->toComplete         = '去完善';
$lang->project->copyproject->selectProjectPlz   = '請選擇項目';
$lang->project->copyproject->confirmCopyDataTip = '請確認要複製的數據：';
$lang->project->copyproject->basicInfo          = '項目數據（所屬項目集，項目名稱，項目代號，所屬產品）';
$lang->project->copyproject->selectProgram      = '請選擇項目集';
$lang->project->copyproject->sprint             = '迭代';

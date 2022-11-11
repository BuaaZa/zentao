<?php
$lang->project->approval = 'Approval';
$lang->project->previous = 'Previous';

$lang->project->approvalflow = new stdclass();
$lang->project->approvalflow->flow   = 'Approval Flow';
$lang->project->approvalflow->object = 'Apporval Object';

$lang->project->approvalflow->objectList[''] = '';
$lang->project->approvalflow->objectList['stage'] = 'Stage';
$lang->project->approvalflow->objectList['task']  = 'Task';

$lang->project->copyProjectConfirm   = 'Complete Project Information';
$lang->project->executionInfoConfirm = 'Complete Execution Information';
$lang->project->stageInfoConfirm     = 'Complete Stage Information';

$lang->project->executionInfoTips = 'To avoid repetition, modify the execution name and execution code, and set the planned start time and planned finish time.';

$lang->project->chosenProductStage = 'Please select the stage of product "%s" to copy %s';
$lang->project->notCopyStage       = 'Not Copy';
$lang->project->completeCopy       = 'Complete Copy';

$lang->project->copyproject = new stdClass();
$lang->project->copyproject->nameTips           = '[Project Name] Cannot be repeated.';
$lang->project->copyproject->codeTips           = '[Project Code] Cannot be repeated.';
$lang->project->copyproject->endTips            = '[Schedule End] Cannot be empty.';
$lang->project->copyproject->daysTips           = '[Available working days] should be numerical.';
$lang->project->copyproject->select             = 'Select';
$lang->project->copyproject->confirmData        = 'Confirm';
$lang->project->copyproject->improveData        = 'Improve';
$lang->project->copyproject->completeData       = 'Complete';
$lang->project->copyproject->selectPlz          = 'Please select the project';
$lang->project->copyproject->cancel             = 'Cancel';
$lang->project->copyproject->all                = 'All data';
$lang->project->copyproject->basic              = 'Basic data';
$lang->project->copyproject->allList            = array('Project data', 'The %s', 'Project and %s documentation lib', 'The %s tasks', 'QA', 'Process', 'Team member permissions');
$lang->project->copyproject->toComplete         = 'To complete';
$lang->project->copyproject->selectProjectPlz   = 'Please select the project';
$lang->project->copyproject->confirmCopyDataTip = 'Make sure you want to copy the data:';
$lang->project->copyproject->basicInfo          = 'Project data (program, project name, project code, product)';
$lang->project->copyproject->selectProgram      = 'Please select the program';
$lang->project->copyproject->sprint             = 'Sprint';
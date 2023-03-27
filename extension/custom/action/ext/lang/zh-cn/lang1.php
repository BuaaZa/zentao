<?php
$lang->action->dynamicAction->bug['deliberationlaunched'] = '发起缺陷审议';
$lang->action->desc->deliberationlaunched = '$date, 由 <strong>$actor</strong> 发起审议。' . "\n";
$lang->action->label->deliberationlaunched = '发起审议了';
$lang->action->label->deliberationlaunchedbychild = '发起审议了';
$lang->action->search->label['deliberationlaunched'] = $lang->action->label->deliberationlaunched;
$lang->action->apiTitle->deliberationlaunched = '执行发起审议操作。';

$lang->action->dynamicAction->bug['deliberationrecorded'] = '记录缺陷审议';
$lang->action->desc->deliberationrecorded = '$date, 由 <strong>$actor</strong> 记录审议。' . "\n";
$lang->action->label->deliberationrecorded = '记录审议了';
$lang->action->label->deliberationrecordedbychild = '记录审议了';
$lang->action->search->label['deliberationrecorded'] = $lang->action->label->deliberationrecorded;
$lang->action->apiTitle->deliberationrecorded = '执行记录审议操作。';

$lang->action->dynamicAction->feedback['opened']      = '创建反馈';
$lang->action->dynamicAction->feedback['edited']      = '编辑反馈';
$lang->action->dynamicAction->feedback['reviewed']    = '审核反馈';
$lang->action->dynamicAction->feedback['asked']       = '追问反馈';
$lang->action->dynamicAction->feedback['replied']     = '回复反馈';
$lang->action->dynamicAction->feedback['commented']   = '评论反馈';
$lang->action->dynamicAction->feedback['assigned']    = '指派反馈';
$lang->action->dynamicAction->feedback['tostory']     = '反馈转' . $lang->SRCommon;
$lang->action->dynamicAction->feedback['touserstory'] = '反馈转' . $lang->URCommon;
$lang->action->dynamicAction->feedback['tobug']       = '反馈转缺陷';
$lang->action->dynamicAction->feedback['totask']      = '反馈转任务';
$lang->action->dynamicAction->feedback['totodo']      = '反馈转待办';
$lang->action->dynamicAction->feedback['closed']      = '关闭反馈';

// chenjj 230115
$lang->action->desc->processed    = '$date, 由系统更新状态为已处理。' . "\n";
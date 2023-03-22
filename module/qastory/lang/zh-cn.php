<?php
/**
 * The qastory module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     qastory
 * @version     $Id: zh-cn.php 5141 2013-07-15 05:57:15Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
global $config;
$lang->qastory->create            = "提{$lang->SRCommon}";

$lang->qastory->requirement       = zget($lang, 'URCommon', "需求");
$lang->qastory->qastory             = zget($lang, 'SRCommon', "故事");
$lang->qastory->createqastory       = '添加' . $lang->qastory->qastory;
$lang->qastory->createRequirement = '添加' . $lang->qastory->requirement;
$lang->qastory->affectedStories   = "影响的{$lang->qastory->qastory}";

$lang->qastory->batchCreate        = "批量创建";
$lang->qastory->change             = "变更";
$lang->qastory->changed            = "{$lang->SRCommon}变更";
$lang->qastory->assignTo           = '指派';
$lang->qastory->review             = '评审';
$lang->qastory->submitReview       = "提交评审";
$lang->qastory->recall             = '撤销评审';
$lang->qastory->recallChange       = '撤销变更';
$lang->qastory->recallAction       = '撤销';
$lang->qastory->needReview         = '需要评审';
$lang->qastory->batchReview        = '批量评审';
$lang->qastory->edit               = "编辑";
$lang->qastory->editDraft          = "编辑草稿";
$lang->qastory->batchEdit          = "批量编辑";
$lang->qastory->subdivide          = '功能点';
$lang->qastory->link               = '关联';
$lang->qastory->unlink             = '移除';
$lang->qastory->track              = '跟踪矩阵';
$lang->qastory->trackAB            = '矩阵';
$lang->qastory->processqastoryChange = '确认需求变动';
$lang->qastory->splitRequirent     = '拆分';
$lang->qastory->close              = '关闭';
$lang->qastory->batchClose         = '批量关闭';
$lang->qastory->activate           = '激活';
$lang->qastory->delete             = "删除";
$lang->qastory->view               = "{$lang->SRCommon}详情";
$lang->qastory->setting            = "设置";
$lang->qastory->tasks              = "相关任务";
$lang->qastory->bugs               = "相关Bug";
$lang->qastory->cases              = "相关用例";
$lang->qastory->taskCount          = '任务数';
$lang->qastory->bugCount           = 'Bug数';
$lang->qastory->caseCount          = '用例数';
$lang->qastory->taskCountAB        = 'T';
$lang->qastory->bugCountAB         = 'B';
$lang->qastory->caseCountAB        = 'C';
$lang->qastory->linkqastory          = "关联{$lang->URCommon}";
$lang->qastory->unlinkqastory        = "移除相关{$lang->SRCommon}";
$lang->qastory->linkStoriesAB      = "关联相关{$lang->SRCommon}";
$lang->qastory->linkRequirementsAB = "关联相关{$lang->URCommon}";
$lang->qastory->export             = "导出数据";
$lang->qastory->zeroCase           = "零用例{$lang->SRCommon}";
$lang->qastory->zeroTask           = "只列零任务{$lang->SRCommon}";
$lang->qastory->reportChart        = "统计报表";
$lang->qastory->copyTitle          = "同功能点名称";
$lang->qastory->batchChangePlan    = "批量修改计划";
$lang->qastory->batchChangeBranch  = "批量修改分支";
$lang->qastory->batchChangeStage   = "批量修改阶段";
$lang->qastory->batchAssignTo      = "批量指派";
$lang->qastory->batchChangeModule  = "批量修改模块";
$lang->qastory->viewAll            = '查看全部';
$lang->qastory->toTask             = '转任务';
$lang->qastory->batchToTask        = '批量转任务';
$lang->qastory->convertRelations   = '换算关系';
$lang->qastory->undetermined       = '待定';
$lang->qastory->order              = '排序';
$lang->qastory->saveDraft          = '存为草稿';
$lang->qastory->doNotSubmit        = '保存暂不提交';

$lang->qastory->editAction      = "编辑{$lang->SRCommon}";
$lang->qastory->changeAction    = "变更{$lang->SRCommon}";
$lang->qastory->assignAction    = "指派{$lang->SRCommon}";
$lang->qastory->reviewAction    = "评审{$lang->SRCommon}";
$lang->qastory->subdivideAction = "细分{$lang->SRCommon}";
$lang->qastory->closeAction     = "关闭{$lang->SRCommon}";
$lang->qastory->activateAction  = "激活{$lang->SRCommon}";
$lang->qastory->deleteAction    = "删除{$lang->SRCommon}";
$lang->qastory->exportAction    = "导出{$lang->SRCommon}";
$lang->qastory->reportAction    = "统计报表";

$lang->qastory->skipqastory        = '需求：%s 为父需求，将不会被关闭。';
$lang->qastory->closedqastory      = '需求：%s 已关闭，将不会被关闭。';
$lang->qastory->batchToTaskTips  = "已关闭的需求不会转为任务。";
$lang->qastory->successToTask    = '批量转任务成功';
$lang->qastory->qastoryRound       = '第 %s 轮估算';
$lang->qastory->float            = "『%s』应当是正数，可以是小数。";
$lang->qastory->saveDraftSuccess = '存为草稿成功';

$lang->qastory->id               = '编号';
$lang->qastory->parent           = '父需求';
$lang->qastory->product          = "所属{$lang->productCommon}";
$lang->qastory->project          = "所属项目";
$lang->qastory->branch           = "分支/平台";
$lang->qastory->module           = '所属模块';
$lang->qastory->moduleAB         = '模块';
$lang->qastory->source           = "来源";
$lang->qastory->sourceNote       = '来源备注';
$lang->qastory->fromBug          = '来源Bug';
$lang->qastory->title            = "功能点名称";
$lang->qastory->type             = "需求类型";
$lang->qastory->category         = "类别";
$lang->qastory->color            = '标题颜色';
$lang->qastory->toBug            = '转Bug';
$lang->qastory->spec             = "描述";
$lang->qastory->assign           = '指派给';
$lang->qastory->verify           = '验收标准';
$lang->qastory->pri              = '优先级';
$lang->qastory->estimate         = "预计{$lang->hourCommon}";
$lang->qastory->estimateAB       = '预计';
$lang->qastory->hour             = $lang->hourCommon;
$lang->qastory->consumed         = '耗时';
$lang->qastory->status           = '当前状态';
$lang->qastory->statusAB         = '状态';
$lang->qastory->subStatus        = '子状态';
$lang->qastory->stage            = '所处阶段';
$lang->qastory->stageAB          = '阶段';
$lang->qastory->stagedBy         = '设置阶段者';
$lang->qastory->mailto           = '抄送给';
$lang->qastory->openedBy         = '由谁创建';
$lang->qastory->openedByAB       = '创建者';
$lang->qastory->openedDate       = '创建日期';
$lang->qastory->assignedTo       = '指派给';
$lang->qastory->assignedToAB     = '指派';
$lang->qastory->assignedDate     = '指派日期';
$lang->qastory->lastEditedBy     = '最后修改';
$lang->qastory->lastEditedDate   = '最后修改日期';
$lang->qastory->closedBy         = '由谁关闭';
$lang->qastory->closedDate       = '关闭日期';
$lang->qastory->closedReason     = '关闭原因';
$lang->qastory->rejectedReason   = '拒绝原因';
$lang->qastory->changedBy        = '由谁变更';
$lang->qastory->changedDate      = '变更时间';
$lang->qastory->reviewedBy       = '评审者';
$lang->qastory->reviewer         = $lang->qastory->reviewedBy;
$lang->qastory->reviewers        = '评审人员';
$lang->qastory->reviewedDate     = '评审时间';
$lang->qastory->activatedDate    = '激活日期';
$lang->qastory->version          = '版本号';
$lang->qastory->feedbackBy       = '反馈者';
$lang->qastory->notifyEmail      = '通知邮箱';
$lang->qastory->plan             = "所属计划";
$lang->qastory->planAB           = '计划';
$lang->qastory->comment          = '备注';
$lang->qastory->children         = "子需求";
$lang->qastory->childrenAB       = "子";
$lang->qastory->linkStories      = "相关{$lang->SRCommon}";
$lang->qastory->linkRequirements = "相关{$lang->URCommon}";
$lang->qastory->childStories     = "细分{$lang->SRCommon}";
$lang->qastory->duplicateqastory   = "重复{$lang->SRCommon}";
$lang->qastory->reviewResult     = '评审意见';
$lang->qastory->reviewResultAB   = '评审结果';
$lang->qastory->preVersion       = '之前版本';
$lang->qastory->keywords         = '关键词';
$lang->qastory->newqastory         = "继续添加{$lang->SRCommon}";
$lang->qastory->colorTag         = '颜色标签';
$lang->qastory->files            = '附件';
$lang->qastory->copy             = "复制{$lang->SRCommon}";
$lang->qastory->total            = "总{$lang->SRCommon}";
$lang->qastory->draft            = '草稿';
$lang->qastory->unclosed         = '未关闭';
$lang->qastory->deleted          = '已删除';
$lang->qastory->released         = "已发布{$lang->SRCommon}数";
$lang->qastory->URChanged        = '用需变更';
$lang->qastory->design           = '相关设计';
$lang->qastory->case             = '相关用例';
$lang->qastory->bug              = '相关Bug';
$lang->qastory->repoCommit       = '相关提交';
$lang->qastory->noRequirement    = '无需求';
$lang->qastory->one              = '一个';
$lang->qastory->field            = '同步的字段';
$lang->qastory->completeRate     = '完成率';
$lang->qastory->reviewed         = '已评审';
$lang->qastory->toBeReviewed     = '待评审';
$lang->qastory->linkMR           = '相关合并请求';

$lang->qastory->ditto       = '同上';
$lang->qastory->dittoNotice = "该{$lang->SRCommon}与上一{$lang->SRCommon}不属于同一产品！";

$lang->qastory->needNotReviewList[0] = '需要评审';
$lang->qastory->needNotReviewList[1] = '不需要评审';

$lang->qastory->useList[0] = '不使用';
$lang->qastory->useList[1] = '使用';

$lang->qastory->statusList['']          = '';
$lang->qastory->statusList['draft']     = '草稿';
$lang->qastory->statusList['reviewing'] = '评审中';
$lang->qastory->statusList['active']    = '激活';
$lang->qastory->statusList['closed']    = '已关闭';
$lang->qastory->statusList['changing']  = '变更中';

$lang->qastory->stageList['']           = '';
$lang->qastory->stageList['wait']       = '未开始';
$lang->qastory->stageList['planned']    = "已计划";
$lang->qastory->stageList['projected']  = '已立项';
$lang->qastory->stageList['developing'] = '研发中';
$lang->qastory->stageList['developed']  = '研发完毕';
$lang->qastory->stageList['testing']    = '测试中';
$lang->qastory->stageList['tested']     = '测试完毕';
$lang->qastory->stageList['verified']   = '已验收';
$lang->qastory->stageList['released']   = '已发布';
$lang->qastory->stageList['closed']     = '已关闭';

$lang->qastory->reasonList['']           = '';
$lang->qastory->reasonList['done']       = '已完成';
$lang->qastory->reasonList['subdivided'] = '已细分';
$lang->qastory->reasonList['duplicate']  = '重复';
$lang->qastory->reasonList['postponed']  = '延期';
$lang->qastory->reasonList['willnotdo']  = '不做';
$lang->qastory->reasonList['cancel']     = '已取消';
$lang->qastory->reasonList['bydesign']   = '设计如此';
//$lang->qastory->reasonList['isbug']      = '是个Bug';

$lang->qastory->reviewResultList['']        = '';
$lang->qastory->reviewResultList['pass']    = '确认通过';
$lang->qastory->reviewResultList['revert']  = '撤销变更';
$lang->qastory->reviewResultList['clarify'] = '有待明确';
$lang->qastory->reviewResultList['reject']  = '拒绝';

$lang->qastory->reviewList[0] = '否';
$lang->qastory->reviewList[1] = '是';

$lang->qastory->sourceList['']           = '';
$lang->qastory->sourceList['customer']   = '客户';
$lang->qastory->sourceList['user']       = '用户';
$lang->qastory->sourceList['po']         = $lang->productCommon . '经理';
$lang->qastory->sourceList['market']     = '市场';
$lang->qastory->sourceList['service']    = '客服';
$lang->qastory->sourceList['operation']  = '运营';
$lang->qastory->sourceList['support']    = '技术支持';
$lang->qastory->sourceList['competitor'] = '竞争对手';
$lang->qastory->sourceList['partner']    = '合作伙伴';
$lang->qastory->sourceList['dev']        = '开发人员';
$lang->qastory->sourceList['tester']     = '测试人员';
$lang->qastory->sourceList['bug']        = 'Bug';
$lang->qastory->sourceList['forum']      = '论坛';
$lang->qastory->sourceList['other']      = '其他';

$lang->qastory->priList[]  = '';
$lang->qastory->priList[1] = '1';
$lang->qastory->priList[2] = '2';
$lang->qastory->priList[3] = '3';
$lang->qastory->priList[4] = '4';

$lang->qastory->changeList = array();
$lang->qastory->changeList['no']  = '不变更';
$lang->qastory->changeList['yes'] = '变更';

$lang->qastory->legendBasicInfo      = '基本信息';
$lang->qastory->legendLifeTime       = "需求的一生";
$lang->qastory->legendRelated        = '相关信息';
$lang->qastory->legendMailto         = '抄送给';
$lang->qastory->legendAttatch        = '附件';
$lang->qastory->legendProjectAndTask = $lang->executionCommon . '任务';
$lang->qastory->legendBugs           = '相关Bug';
$lang->qastory->legendFromBug        = '来源Bug';
$lang->qastory->legendCases          = '相关用例';
$lang->qastory->legendBuilds         = '相关版本';
$lang->qastory->legendReleases       = '相关发布';
$lang->qastory->legendLinkStories    = "相关{$lang->SRCommon}";
$lang->qastory->legendChildStories   = "细分{$lang->SRCommon}";
$lang->qastory->legendSpec           = "需求描述";
$lang->qastory->legendVerify         = '验收标准';
$lang->qastory->legendMisc           = '其他相关';
$lang->qastory->legendInformation    = '需求信息';

$lang->qastory->lblChange            = "变更{$lang->SRCommon}";
$lang->qastory->lblReview            = "评审{$lang->SRCommon}";
$lang->qastory->lblActivate          = "激活{$lang->SRCommon}";
$lang->qastory->lblClose             = "关闭{$lang->SRCommon}";
$lang->qastory->lblTBC               = '任务Bug用例';

$lang->qastory->checkAffection       = '影响范围';
$lang->qastory->affectedProjects     = $config->systemMode == 'new' ? "影响的{$lang->project->common}或{$lang->execution->common}" : "影响的{$lang->project->common}";
$lang->qastory->affectedBugs         = '影响的Bug';
$lang->qastory->affectedCases        = '影响的用例';

$lang->qastory->specTemplate          = "建议参考的模板：作为一名<某种类型的用户>，我希望<达成某些目的>，这样可以<开发的价值>。";
$lang->qastory->needNotReview         = '不需要评审';
$lang->qastory->successSaved          = "{$lang->SRCommon}成功添加，";
$lang->qastory->confirmDelete         = "您确认删除该{$lang->SRCommon}吗?";
$lang->qastory->confirmRecall         = "您确认撤销该{$lang->SRCommon}吗?";
$lang->qastory->errorEmptyChildqastory  = "『细分{$lang->SRCommon}』不能为空。";
$lang->qastory->errorNotSubdivide     = "状态不是激活，或者阶段不是未开始的{$lang->SRCommon}，或者是子需求，则不能细分。";
$lang->qastory->errorEmptyReviewedBy  = "『由谁评审』不能为空。";
$lang->qastory->mustChooseResult      = '必须选择评审意见';
$lang->qastory->mustChoosePreVersion  = '必须选择回溯的版本';
$lang->qastory->noqastory               = "暂时没有{$lang->SRCommon}。";
$lang->qastory->noRequirement         = "暂时没有{$lang->URCommon}。";
$lang->qastory->ignoreChangeStage     = "{$lang->SRCommon} %s 为草稿状态或已关闭状态，没有修改其阶段。";
$lang->qastory->cannotDeleteParent    = "不能删除父{$lang->SRCommon}";
$lang->qastory->moveChildrenTips      = "修改父{$lang->SRCommon}的所属产品会将其下的子{$lang->SRCommon}也移动到所选产品下。";
$lang->qastory->changeTips            = '该软件需求关联的用户需求有变更，点击“不变更”忽略此条变更，点击“变更”来进行该软件需求的变更。';
$lang->qastory->estimateMustBeNumber  = '估算值必须是数字';
$lang->qastory->estimateMustBePlus    = '估算值不能是负数';
$lang->qastory->confirmChangeBranch   = $lang->SRCommon . '%s已关联在之前所属分支的计划中，调整分支后，' . $lang->SRCommon . '将从之前所属分支的计划中移除，请确认是否继续修改上述' . $lang->SRCommon . '的分支。';
$lang->qastory->confirmChangePlan     = $lang->SRCommon . '%s已关联在之前计划的所属分支中，调整分支后，' . $lang->SRCommon . '将会从计划中移除，请确认是否继续修改计划的所属分支。';
$lang->qastory->errorDuplicateqastory   = $lang->SRCommon . '%s不存在';
$lang->qastory->confirmRecallChange   = "撤销变更后，需求内容会回退至变更前的版本，您确定要撤销吗？";
$lang->qastory->confirmRecallReview   = "您确定要撤回评审吗？";
$lang->qastory->noqastoryToTask         = "只有激活的{$lang->SRCommon}才能转为任务！";

$lang->qastory->form = new stdclass();
$lang->qastory->form->area     = "该{$lang->SRCommon}所属范围";
$lang->qastory->form->desc     = "描述及标准，什么{$lang->SRCommon}？如何验收？";
$lang->qastory->form->resource = '资源分配，有谁完成？需要多少时间？';
$lang->qastory->form->file     = "附件，如果该{$lang->SRCommon}有相关文件，请点此上传。";

$lang->qastory->action = new stdclass();
$lang->qastory->action->reviewed              = array('main' => '$date, 由 <strong>$actor</strong> 记录评审意见，评审意见为 <strong>$extra</strong>。', 'extra' => 'reviewResultList');
$lang->qastory->action->rejectreviewed        = array('main' => '$date, 由 <strong>$actor</strong> 记录评审意见，评审意见为 <strong>$extra</strong>，原因为 <strong>$reason</strong>。', 'extra' => 'reviewResultList', 'reason' => 'reasonList');
$lang->qastory->action->recalled              = array('main' => '$date, 由 <strong>$actor</strong> 撤销评审。');
$lang->qastory->action->closed                = array('main' => '$date, 由 <strong>$actor</strong> 关闭，原因为 <strong>$extra</strong> $appendLink。', 'extra' => 'reasonList');
$lang->qastory->action->reviewpassed          = array('main' => '$date, 由 <strong>系统</strong> 判定，结果为 <strong>确认通过</strong>。');
$lang->qastory->action->reviewrejected        = array('main' => '$date, 由 <strong>系统</strong> 关闭，原因为 <strong>拒绝</strong>。');
$lang->qastory->action->reviewclarified       = array('main' => '$date, 由 <strong>系统</strong> 判定，结果为 <strong>有待明确</strong>，请编辑后重新发起评审。');
$lang->qastory->action->reviewreverted        = array('main' => '$date, 由 <strong>系统</strong> 判定，结果为 <strong>撤销变更</strong>。');
$lang->qastory->action->linked2plan           = array('main' => '$date, 由 <strong>$actor</strong> 关联到计划 <strong>$extra</strong>。');
$lang->qastory->action->unlinkedfromplan      = array('main' => '$date, 由 <strong>$actor</strong> 从计划 <strong>$extra</strong> 移除。');
$lang->qastory->action->linked2execution      = array('main' => '$date, 由 <strong>$actor</strong> 关联到' . $lang->executionCommon . ' <strong>$extra</strong>。');
$lang->qastory->action->unlinkedfromexecution = array('main' => '$date, 由 <strong>$actor</strong> 从' . $lang->executionCommon . ' <strong>$extra</strong> 移除。');
$lang->qastory->action->linked2kanban         = array('main' => '$date, 由 <strong>$actor</strong> 关联到看板 <strong>$extra</strong>。');
$lang->qastory->action->linked2project        = array('main' => '$date, 由 <strong>$actor</strong> 关联到项目 <strong>$extra</strong>。');
$lang->qastory->action->unlinkedfromproject   = array('main' => '$date, 由 <strong>$actor</strong> 从项目 <strong>$extra</strong> 移除。');
$lang->qastory->action->linked2build          = array('main' => '$date, 由 <strong>$actor</strong> 关联到版本 <strong>$extra</strong>。');
$lang->qastory->action->unlinkedfrombuild     = array('main' => '$date, 由 <strong>$actor</strong> 从版本 <strong>$extra</strong> 移除。');
$lang->qastory->action->linked2release        = array('main' => '$date, 由 <strong>$actor</strong> 关联到发布 <strong>$extra</strong>。');
$lang->qastory->action->unlinkedfromrelease   = array('main' => '$date, 由 <strong>$actor</strong> 从发布 <strong>$extra</strong> 移除。');
$lang->qastory->action->linkrelatedqastory      = array('main' => "\$date, 由 <strong>\$actor</strong> 关联相关{$lang->SRCommon} <strong>\$extra</strong>。");
$lang->qastory->action->subdivideqastory        = array('main' => "\$date, 由 <strong>\$actor</strong> 细分为{$lang->SRCommon}   <strong>\$extra</strong>。");
$lang->qastory->action->unlinkrelatedqastory    = array('main' => "\$date, 由 <strong>\$actor</strong> 移除相关{$lang->SRCommon} <strong>\$extra</strong>。");
$lang->qastory->action->unlinkchildqastory      = array('main' => "\$date, 由 <strong>\$actor</strong> 移除细分{$lang->SRCommon} <strong>\$extra</strong>。");
$lang->qastory->action->recalledchange        = array('main' => "\$date, 由 <strong>\$actor</strong> 撤销变更。");
$lang->qastory->action->fromfeedback          = array('main' => "\$date, 由 <strong>\$actor</strong> 从<strong>{$lang->feedback->common}</strong>转化而来，反馈编号为 <strong>\$extra</strong>。");

/* 统计报表。*/
$lang->qastory->report = new stdclass();
$lang->qastory->report->common = '报表';
$lang->qastory->report->select = '请选择报表类型';
$lang->qastory->report->create = '生成报表';
$lang->qastory->report->value  = "需求数";

$lang->qastory->report->charts['qastorysPerProduct']        = $lang->productCommon . "{$lang->SRCommon}数量";
$lang->qastory->report->charts['qastorysPerModule']         = "模块{$lang->SRCommon}数量";
$lang->qastory->report->charts['qastorysPerSource']         = "按{$lang->SRCommon}来源统计";
$lang->qastory->report->charts['qastorysPerPlan']           = "按计划进行统计";
$lang->qastory->report->charts['qastorysPerStatus']         = '按状态进行统计';
$lang->qastory->report->charts['qastorysPerStage']          = '按所处阶段进行统计';
$lang->qastory->report->charts['qastorysPerPri']            = '按优先级进行统计';
$lang->qastory->report->charts['qastorysPerEstimate']       = "按预计{$lang->hourCommon}进行统计";
$lang->qastory->report->charts['qastorysPerOpenedBy']       = '按由谁创建来进行统计';
$lang->qastory->report->charts['qastorysPerAssignedTo']     = '按当前指派来进行统计';
$lang->qastory->report->charts['qastorysPerClosedReason']   = '按关闭原因来进行统计';
$lang->qastory->report->charts['qastorysPerChange']         = '按变更次数来进行统计';

$lang->qastory->report->options = new stdclass();
$lang->qastory->report->options->graph  = new stdclass();
$lang->qastory->report->options->type   = 'pie';
$lang->qastory->report->options->width  = 500;
$lang->qastory->report->options->height = 140;

$lang->qastory->report->qastorysPerProduct      = new stdclass();
$lang->qastory->report->qastorysPerModule       = new stdclass();
$lang->qastory->report->qastorysPerSource       = new stdclass();
$lang->qastory->report->qastorysPerPlan         = new stdclass();
$lang->qastory->report->qastorysPerStatus       = new stdclass();
$lang->qastory->report->qastorysPerStage        = new stdclass();
$lang->qastory->report->qastorysPerPri          = new stdclass();
$lang->qastory->report->qastorysPerOpenedBy     = new stdclass();
$lang->qastory->report->qastorysPerAssignedTo   = new stdclass();
$lang->qastory->report->qastorysPerClosedReason = new stdclass();
$lang->qastory->report->qastorysPerEstimate     = new stdclass();
$lang->qastory->report->qastorysPerChange       = new stdclass();

$lang->qastory->report->qastorysPerProduct->item      = $lang->productCommon;
$lang->qastory->report->qastorysPerModule->item       = '模块';
$lang->qastory->report->qastorysPerSource->item       = '来源';
$lang->qastory->report->qastorysPerPlan->item         = '计划';
$lang->qastory->report->qastorysPerStatus->item       = '状态';
$lang->qastory->report->qastorysPerStage->item        = '阶段';
$lang->qastory->report->qastorysPerPri->item          = '优先级';
$lang->qastory->report->qastorysPerOpenedBy->item     = '由谁创建';
$lang->qastory->report->qastorysPerAssignedTo->item   = '指派给';
$lang->qastory->report->qastorysPerClosedReason->item = '原因';
$lang->qastory->report->qastorysPerEstimate->item     = "预计{$lang->hourCommon}";
$lang->qastory->report->qastorysPerChange->item       = '变更次数';

$lang->qastory->report->qastorysPerProduct->graph      = new stdclass();
$lang->qastory->report->qastorysPerModule->graph       = new stdclass();
$lang->qastory->report->qastorysPerSource->graph       = new stdclass();
$lang->qastory->report->qastorysPerPlan->graph         = new stdclass();
$lang->qastory->report->qastorysPerStatus->graph       = new stdclass();
$lang->qastory->report->qastorysPerStage->graph        = new stdclass();
$lang->qastory->report->qastorysPerPri->graph          = new stdclass();
$lang->qastory->report->qastorysPerOpenedBy->graph     = new stdclass();
$lang->qastory->report->qastorysPerAssignedTo->graph   = new stdclass();
$lang->qastory->report->qastorysPerClosedReason->graph = new stdclass();
$lang->qastory->report->qastorysPerEstimate->graph     = new stdclass();
$lang->qastory->report->qastorysPerChange->graph       = new stdclass();

$lang->qastory->report->qastorysPerProduct->graph->xAxisName      = $lang->productCommon;
$lang->qastory->report->qastorysPerModule->graph->xAxisName       = '模块';
$lang->qastory->report->qastorysPerSource->graph->xAxisName       = '来源';
$lang->qastory->report->qastorysPerPlan->graph->xAxisName         = '计划';
$lang->qastory->report->qastorysPerStatus->graph->xAxisName       = '状态';
$lang->qastory->report->qastorysPerStage->graph->xAxisName        = '所处阶段';
$lang->qastory->report->qastorysPerPri->graph->xAxisName          = '优先级';
$lang->qastory->report->qastorysPerOpenedBy->graph->xAxisName     = '由谁创建';
$lang->qastory->report->qastorysPerAssignedTo->graph->xAxisName   = '当前指派';
$lang->qastory->report->qastorysPerClosedReason->graph->xAxisName = '关闭原因';
$lang->qastory->report->qastorysPerEstimate->graph->xAxisName     = '预计时间';
$lang->qastory->report->qastorysPerChange->graph->xAxisName       = '变更次数';

$lang->qastory->placeholder = new stdclass();
$lang->qastory->placeholder->estimate = $lang->qastory->hour;

$lang->qastory->chosen = new stdClass();
$lang->qastory->chosen->reviewedBy = '选择评审人...';

$lang->qastory->notice = new stdClass();
$lang->qastory->notice->closed           = "您选择的{$lang->SRCommon}已经被关闭了！";
$lang->qastory->notice->reviewerNotEmpty = '该需求需要评审，评审人员不能为空。';

$lang->qastory->convertToTask = new stdClass();
$lang->qastory->convertToTask->fieldList = array();
$lang->qastory->convertToTask->fieldList['module']     = '所属模块';
$lang->qastory->convertToTask->fieldList['spec']       = "{$lang->SRCommon}描述";
$lang->qastory->convertToTask->fieldList['pri']        = '优先级';
$lang->qastory->convertToTask->fieldList['mailto']     = '抄送给';
$lang->qastory->convertToTask->fieldList['assignedTo'] = '指派给';

$lang->qastory->categoryList['feature']     = '功能';
$lang->qastory->categoryList['interface']   = '接口';
$lang->qastory->categoryList['performance'] = '性能';
$lang->qastory->categoryList['safe']        = '安全';
$lang->qastory->categoryList['experience']  = '体验';
$lang->qastory->categoryList['improve']     = '改进';
$lang->qastory->categoryList['other']       = '其他';

$lang->qastory->changeTip = '只有激活状态的需求，才能进行变更';

$lang->qastory->reviewTip = array();
$lang->qastory->reviewTip['active']      = '该需求已是激活状态，无需评审';
$lang->qastory->reviewTip['notReviewer'] = '您不是该需求的评审人员，无法进行评审操作';
$lang->qastory->reviewTip['reviewed']    = '您已评审';

$lang->qastory->recallTip = array();
$lang->qastory->recallTip['actived'] = '该需求未发起评审流程，无需撤销操作';

$lang->qastory->subDivideTip = array();
$lang->qastory->subDivideTip['subqastory']  = '子需求无法细分';
$lang->qastory->subDivideTip['notWait']   = '该需求%s，无法进行细分操作';
$lang->qastory->subDivideTip['notActive'] = '需求不是激活状态，无法进行细分操作';

$lang->qastory->featureBar['browse']['all']       = '全部';
$lang->qastory->featureBar['browse']['unclosed']  = $lang->qastory->unclosed;
$lang->qastory->featureBar['browse']['draft']     = $lang->qastory->statusList['draft'];
$lang->qastory->featureBar['browse']['reviewing'] = $lang->qastory->statusList['reviewing'];

$lang->requirement->common             = $lang->URCommon;
$lang->requirement->create             = "提{$lang->URCommon}";
$lang->requirement->batchCreate        = "批量创建";
$lang->requirement->editAction         = "编辑{$lang->URCommon}";
$lang->requirement->changeAction       = "变更{$lang->URCommon}";
$lang->requirement->assignAction       = "指派{$lang->URCommon}";
$lang->requirement->reviewAction       = "评审{$lang->URCommon}";
$lang->requirement->subdivideAction    = "细分{$lang->URCommon}";
$lang->requirement->closeAction        = "关闭{$lang->URCommon}";
$lang->requirement->activateAction     = "激活{$lang->URCommon}";
$lang->requirement->deleteAction       = "删除{$lang->URCommon}";
$lang->requirement->exportAction       = "导出{$lang->URCommon}";
$lang->requirement->reportAction       = "统计报表";
$lang->requirement->recall             = $lang->qastory->recallAction;
$lang->requirement->batchReview        = '批量评审';
$lang->requirement->batchEdit          = "批量编辑";
$lang->requirement->batchClose         = '批量关闭';
$lang->requirement->view               = "{$lang->URCommon}详情";
$lang->requirement->linkRequirementsAB = "关联相关{$lang->URCommon}";
$lang->requirement->batchChangeBranch  = "批量修改分支";
$lang->requirement->batchAssignTo      = "批量指派";
$lang->requirement->batchChangeModule  = "批量修改模块";
$lang->requirement->submitReview       = $lang->qastory->submitReview;
$lang->requirement->linkqastory          = "关联{$lang->SRCommon}";

$lang->qastory->requirementfix = "需求";
$lang->qastory->taskPoint = "功能点";
$lang->qastory->taskPointTitle = "功能点名称";
$lang->qastory->taskPointSpec = "功能点描述";
$lang->qastory->taskPointVerify = "功能点验收标准";
$lang->qastory->taskPointTitle = "功能点名称";
$lang->qastory->decomposeTaskPoint = "分解功能点";
$lang->qastory->createTaskPoint = "提功能点";
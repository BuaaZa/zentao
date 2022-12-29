<?php
$lang->navIcons['feedback'] = "<i class='icon icon-feedback'></i>";
$lang->mainNav->feedback = $lang->navIcons['feedback'] . '反馈|feedback|admin|browseType=wait'; //rogerguo
$lang->mainNav->menuOrder[63] = 'feedback';//rogerguo


$lang->navIcons['feedback'] = "<i class='icon icon-feedback'></i>";
$lang->feedback = new stdclass();
$lang->feedback->common = '反馈';

$lang->mainNav->feedback  = "{$lang->navIcons['feedback']} {$lang->feedback->common}|feedback|admin|browseType=wait";
$lang->navGroup->ticket   = 'feedback';
$lang->navGroup->feedback = 'feedback';
$lang->navGroup->faq      = 'feedback';
$lang->navGroup->ticket   = 'feedback';

$lang->searchLang = '搜索';

$lang->feedback->menu = new stdclass();
$lang->feedback->menu->ticket   = array('link' => '工单|ticket|browse', 'alias' => 'create,edit,view,batchedit,browse,showimport,createstory,createbug');
$lang->feedback->menu->browse   = array('link' => '反馈|feedback|admin|browseType=wait', 'alias' => 'create,edit,view,adminview,batchedit,browse,showimport');
$lang->feedback->menu->faq      = array('link' => 'FAQ|faq|browse', 'alias' => 'create,edit');
$lang->feedback->menu->products = array('link' => '权限|feedback|products', 'alias' => 'manageproduct');

$lang->feedback->menuOrder[5]  = 'ticket';
$lang->feedback->menuOrder[10] = 'browse';
$lang->feedback->menuOrder[15] = 'faq';
$lang->feedback->menuOrder[20] = 'products';

$lang->ticket = new stdclass();
$lang->ticket->common = '工单';
$lang->ticket->navGroup['ticket'] = 'feedback';

$lang->faq = new stdclass();
$lang->faq->navGroup['faq'] = 'feedback';

$lang->my->menu->work['subMenu']->feedback = array('link' => "{$lang->feedback->common}|my|work|mode=feedback&type=assigntome", 'subModule' => 'feedback');
$lang->my->menu->work['subMenu']->ticket   = array('link' => "{$lang->ticket->common}|my|work|mode=ticket&type=assignedtome", 'subModule' => 'feedback');
$lang->my->menu->work['menuOrder'][80] = 'feedback';

$lang->feedbackView[0] = '研发界面';
$lang->feedbackView[1] = '非研发界面';

$lang->switchFeedbackView[1] = '切换研发界面';
$lang->switchFeedbackView[0] = '切换非研发界面';

global $config;
if($config->vision == 'lite')
{
    $lang->feedback->menu->browse = array('link' => '反馈|feedback|browse|browseType=unclosed', 'alias' => 'create,edit,view,batchedit,browse');

    unset($lang->feedback->menu->products);
    unset($lang->feedback->menuOrder[15]);
}

$lang->noMenuModule[] = 'faq';
$lang->noMenuModule[] = 'feedback';
$lang->noMenuModule[] = 'deploy';
$lang->noMenuModule[] = 'host';
$lang->noMenuModule[] = 'serverroom';
$lang->noMenuModule[] = 'service';
$lang->noMenuModule[] = 'ops';


// max
$lang->feedback->webMenu = new stdclass();
$lang->feedback->webMenu->unclosed   = array('link' => '未关闭|feedback|admin|browseType=unclosed', 'subModule' => 'tree');
$lang->feedback->webMenu->all        = array('link' => '全部|feedback|admin|browseType=all');
$lang->feedback->webMenu->public     = array('link' => '公开|feedback|admin|browseType=public');
$lang->feedback->webMenu->tostory    = array('link' => "转需求|feedback|admin|browseType=tostory");
$lang->feedback->webMenu->totask     = array('link' => '转任务|feedback|admin|browseType=totask');
$lang->feedback->webMenu->tobug      = array('link' => '转Bug|feedback|admin|browseType=tobug');
$lang->feedback->webMenu->totodo     = array('link' => '转待办|feedback|admin|browseType=totodo');
$lang->feedback->webMenu->assigntome = array('link' => '指派给我|feedback|admin|browseType=assigntome');

$lang->feedback->webMenuOrder[5]  = 'unclosed';
$lang->feedback->webMenuOrder[10] = 'all';
$lang->feedback->webMenuOrder[15] = 'public';
$lang->feedback->webMenuOrder[20] = 'tostory';
$lang->feedback->webMenuOrder[25] = 'totask';
$lang->feedback->webMenuOrder[30] = 'tobug';
$lang->feedback->webMenuOrder[35] = 'totodo';
$lang->feedback->webMenuOrder[40] = 'assigntome';
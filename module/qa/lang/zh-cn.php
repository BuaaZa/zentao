<?php
/**
 * The qa module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     company
 * @version     $Id: zh-cn.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
$lang->qa->index       = '测试主页';
$lang->qa->indexAction = '测试仪表盘';
$lang->qa->storyAction = '功能点';

$lang->qa->moreList = array();
$lang->qa->moreList[0]['module'] = 'qastory';
$lang->qa->moreList[0]['method'] = 'story';
$lang->qa->moreList[0]['icon'] = '<i class=\'icon icon-usecase\'></i>';
$lang->qa->moreList[0]['title'] = '功能点';

$lang->qa->moreList[1]['module'] = 'testtask';
$lang->qa->moreList[1]['method'] = 'browse';
$lang->qa->moreList[1]['icon'] = '<i class=\'icon icon-list\'></i>';
$lang->qa->moreList[1]['title'] = '测试单';

$lang->qa->moreList[2]['module'] = 'bug';
$lang->qa->moreList[2]['method'] = 'browse';
$lang->qa->moreList[2]['icon'] = '<i class=\'icon icon-bug\'></i>';
$lang->qa->moreList[2]['title'] = '缺陷';

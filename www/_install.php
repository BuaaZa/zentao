<?php
/**
 * The installation router file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2013 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: install.php 4677 2013-04-26 06:23:58Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
error_reporting(E_ALL);
const IN_INSTALL = true;

/* Load the framework. */
include '../framework/router.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
include '../framework/helper.class.php';

/* Instance the app. */
$app = router::createApp('pms', dirname(__FILE__, 2), 'router');

/* Check installed or not. */
if(!isset($_SESSION['installing']) and isset($config->installed) and $config->installed)
    die(header('location: index.php'));

/* Reset the config params to make sure the installation program will be launched. */
$config->set('requestType', 'GET');
$config->set('default.module', 'install');
$app->setDebug();

/* During the installation, if the database params is setted, auto connect the db. */
if(isset($config->installed) and $config->installed) $app->connectDB();

$app->parseRequest();
$app->loadModule();

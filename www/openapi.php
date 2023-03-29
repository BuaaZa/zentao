<?php
/**
 * 进行预登录行为，需要__account__和__key__
 */
error_reporting(E_ALL);
const RUN_MODE = 'api';

ob_start();

include '../framework/api/router.class.php';
include '../framework/api/entry.class.php';
include '../framework/api/helper.class.php';
include '../framework/control.class.php';
include '../framework/model.class.php';
require '../module/common/ChromePhp.php';

$startTime = getTime();

$app = new api('pms', dirname(__FILE__, 2));

/* Run the app. */
$common = $app->loadCommon();

/* Check entry. */
$common->checkPasswordFreeAPIEntry();
$common->loadConfigFromDB();

/* Set default params. */
global $config;
if(!$app->version)
    $config->requestType = 'GET';
$config->default->view = 'json';

$app->parseRequest();

/* Old version need check priv here, new version check priv in entry. */
//if(!$app->version)
//    $common->checkPriv();

$app->loadModule();

$output = ob_get_clean();

/* Flush the buffer. */
echo $app->formatData(apiHelper::removeUTF8Bom($output));

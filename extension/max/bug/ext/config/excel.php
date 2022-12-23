<?php
$config->bug->listFields     = "module,project,execution,story,severity,pri,type,os,browser,openedBuild";
$config->bug->sysListFields  = "module,execution,story";
$config->bug->templateFields = "product,branch,module,project,execution,story,title,keywords,severity,pri,type,os,browser,steps,deadline,openedBuild,feedbackBy,notifyEmail";
if($config->systemMode == 'classic')
{
    $templateFields = explode(',', $config->bug->templateFields);
    $key = array_search('project', $templateFields);
    unset($templateFields[$key]);
    $config->bug->templateFields = implode(',', $templateFields);
}

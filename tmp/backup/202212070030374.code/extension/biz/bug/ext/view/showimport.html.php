<?php js::set('bugLang',        $lang->bug);?>
<?php js::set('noticeLang',     $lang->bug->noRequire);?>
<?php js::set('requiredFields', $config->bug->create->requiredFields);?>
<?php include $app->getModuleRoot() . 'port/view/showimport.html.php';?>

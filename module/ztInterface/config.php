<?php
$config->ztinterface = new stdclass();
$config->testcase = new stdclass();
$config->testcase->defaultSteps = 3;
$config->testcase->batchCreate  = 10;
$config->testcase->needReview   = 0;

$config->testcase->create = new stdclass();
$config->testcase->edit   = new stdclass();
$config->testcase->create->requiredFields = 'title,type';
$config->testcase->edit->requiredFields   = 'title,type';

$config->testcase->editor = new stdclass();
$config->testcase->editor->edit   = array('id' => 'comment', 'tools' => 'simpleTools');
$config->testcase->editor->view   = array('id' => 'comment,lastComment', 'tools' => 'simpleTools');
$config->testcase->editor->review = array('id' => 'comment', 'tools' => 'simpleTools');

$config->testcase->export   = new stdclass();
$config->testcase->export->listFields   = array('type', 'stage', 'pri', 'status');

$config->testcase->exportFields = '
    id, product, branch, module, story,
    title, precondition, stepDesc, stepExpect, real, keywords,
    pri, type, stage, status, bugsAB, resultsAB, stepNumberAB, lastRunner, lastRunDate, lastRunResult, openedBy, openedDate,
    lastEditedBy, lastEditedDate, version, linkCase, files';

$config->testcase->customCreateFields      = 'story,stage,pri,keywords';
$config->testcase->customBatchCreateFields = 'module,stage,story,pri,precondition,keywords,review';
$config->testcase->customBatchEditFields   = 'module,story,stage,precondition,status,pri,keywords';

$config->testcase->custom = new stdclass();
$config->testcase->custom->createFields      = $config->testcase->customCreateFields;
$config->testcase->custom->batchCreateFields = 'module,story,%s';
$config->testcase->custom->batchEditFields   = 'branch,module,stage,status,pri,story';

$config->testcase->excludeCheckFileds = ',pri,type,stage,needReview,story,';

global $lang;
$config->testcase->search['module']                   = 'testcase';
$config->testcase->search['fields']['title']          = $lang->testcase->title;
$config->testcase->search['fields']['id']             = $lang->testcase->id;
$config->testcase->search['fields']['keywords']       = $lang->testcase->keywords;
$config->testcase->search['fields']['lastEditedBy']   = $lang->testcase->lastEditedByAB;
$config->testcase->search['fields']['type']           = $lang->testcase->type;

$config->testcase->search['fields']['openedBy']       = $lang->testcase->openedBy;
$config->testcase->search['fields']['status']         = $lang->testcase->status;
$config->testcase->search['fields']['product']        = $lang->testcase->product;
$config->testcase->search['fields']['branch']         = '';
$config->testcase->search['fields']['stage']          = $lang->testcase->stage;
$config->testcase->search['fields']['module']         = $lang->testcase->module;
$config->testcase->search['fields']['pri']            = $lang->testcase->pri;
$config->testcase->search['fields']['lib']            = $lang->testcase->lib;

$config->testcase->search['fields']['lastRunner']     = $lang->testcase->lastRunner;
$config->testcase->search['fields']['lastRunResult']  = $lang->testcase->lastRunResult;
$config->testcase->search['fields']['lastRunDate']    = $lang->testcase->lastRunDate;
$config->testcase->search['fields']['openedDate']     = $lang->testcase->openedDate;
$config->testcase->search['fields']['lastEditedDate'] = $lang->testcase->lastEditedDateAB;

$config->testcase->search['params']['title']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->testcase->search['params']['module']       = array('operator' => 'belong',  'control' => 'select', 'values' => 'modules');
$config->testcase->search['params']['keywords']     = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->testcase->search['params']['lastEditedBy'] = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->testcase->search['params']['type']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->testcase->typeList);

$config->testcase->search['params']['pri']          = array('operator' => '=',       'control' => 'select', 'values' => $lang->testcase->priList);
$config->testcase->search['params']['openedBy']     = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->testcase->search['params']['status']       = array('operator' => '=',       'control' => 'select', 'values' => $lang->testcase->statusList);
$config->testcase->search['params']['product']      = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->testcase->search['params']['branch']       = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->testcase->search['params']['stage']        = array('operator' => 'include', 'control' => 'select', 'values' => $lang->testcase->stageList);
$config->testcase->search['params']['lib']          = array('operator' => '=',       'control' => 'select', 'values' => '');

$config->testcase->search['params']['lastRunner']     = array('operator' => '=', 'control' => 'select', 'values' => 'users');
$config->testcase->search['params']['lastRunResult']  = array('operator' => '=', 'control' => 'select', 'values' => array_diff($lang->testcase->resultList, array('n/a' => $lang->testcase->resultList['n/a'])) + array('null' => $lang->testcase->unexecuted));
$config->testcase->search['params']['lastRunDate']    = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');
$config->testcase->search['params']['openedDate']     = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');
$config->testcase->search['params']['lastEditedDate'] = array('operator' => '=', 'control' => 'input', 'values' => '', 'class' => 'date');

global $app;
$config->ztinterface->datatable = new stdclass();
$config->ztinterface->datatable->defaultField = array('id', 'method','name', 'url','actions');

$config->ztinterface->datatable->fieldList['id']['title']    = 'idAB';
$config->ztinterface->datatable->fieldList['id']['fixed']    = 'left';
$config->ztinterface->datatable->fieldList['id']['width']    = '100';
$config->ztinterface->datatable->fieldList['id']['required'] = 'yes';

$config->ztinterface->datatable->fieldList['method']['title']    = 'method';
$config->ztinterface->datatable->fieldList['method']['fixed']    = 'no';
$config->ztinterface->datatable->fieldList['method']['width']    = '130';
$config->ztinterface->datatable->fieldList['method']['required'] = 'yes';

$config->ztinterface->datatable->fieldList['name']['title']    = 'name';
$config->ztinterface->datatable->fieldList['name']['fixed']    = 'left';
$config->ztinterface->datatable->fieldList['name']['width']    = '150';
$config->ztinterface->datatable->fieldList['name']['required'] = 'yes';

$config->ztinterface->datatable->fieldList['url']['title']    = 'url';
$config->ztinterface->datatable->fieldList['url']['fixed']    = 'left';
$config->ztinterface->datatable->fieldList['url']['width']    = 'auto';
$config->ztinterface->datatable->fieldList['url']['required'] = 'yes';

$config->ztinterface->datatable->fieldList['actions']['title']    = 'actions';
$config->ztinterface->datatable->fieldList['actions']['fixed']    = 'right';
$config->ztinterface->datatable->fieldList['actions']['width']    = '120';
$config->ztinterface->datatable->fieldList['actions']['required'] = 'yes';

<?php
$config->ticket->editor = new stdclass();
$config->ticket->editor->create    = array('id' => 'desc', 'tools' => 'simpleTools');
$config->ticket->editor->edit      = array('id' => 'desc,resolution', 'tools' => 'simpleTools');
$config->ticket->editor->view      = array('id' => 'comment', 'tools' => 'simpleTools');
$config->ticket->editor->start     = array('id' => 'comment', 'tools' => 'simpleTools');
$config->ticket->editor->assignto  = array('id' => 'comment', 'tools' => 'simpleTools');
$config->ticket->editor->close     = array('id' => 'resolution,comment', 'tools' => 'simpleTools');
$config->ticket->editor->finish    = array('id' => 'resolution,comment', 'tools' => 'simpleTools');
$config->ticket->editor->activate  = array('id' => 'comment', 'tools' => 'simpleTools');

$config->ticket->start  = new stdclass();
$config->ticket->start->requiredFields = 'assignedTo';
$config->ticket->finish = new stdclass();
$config->ticket->finish->requiredFields = 'resolvedDate,resolution';
$config->ticket->create = new stdclass();
$config->ticket->create->requiredFields = 'product,title,module';
$config->ticket->edit   = new stdclass();
$config->ticket->edit->requiredFields   = 'product,title,module';

$config->ticket->datatable = new stdclass();
$config->ticket->datatable->fieldList['module']['dataSource']      = array('module' => 'ticket', 'method' => 'getTickctModuleList', 'params' => "true&no");
$config->ticket->datatable->fieldList['product']['dataSource']     = array('module' => 'feedback', 'method' => 'getGrantProducts', 'params' => 'true&true');
$config->ticket->datatable->fieldList['deadline']['control']       = 'date';
$config->ticket->datatable->fieldList['openedBuild']['dataSource'] = array('module' => 'build', 'method' =>'getBuildPairs');
$config->ticket->datatable->fieldList['assignedTo']['dataSource']  = array('module' => 'user', 'method' => 'getPairs', 'params' => 'noclosed|nodeleted|noletter');
$config->ticket->datatable->fieldList['mailto']['dataSource']      = array('module' => 'user', 'method' => 'getPairs', 'params' => 'noclosed|nodeleted|noletter');

global $lang;
$config->ticket->search['module'] = 'ticket';
$config->ticket->search['fields']['title']          = $lang->ticket->title;
$config->ticket->search['fields']['status']         = $lang->ticket->status;
$config->ticket->search['fields']['type']           = $lang->ticket->type;
$config->ticket->search['fields']['product']        = $lang->ticket->product;
$config->ticket->search['fields']['pri']            = $lang->ticket->pri;
$config->ticket->search['fields']['module']         = $lang->ticket->module;
$config->ticket->search['fields']['id']             = $lang->ticket->idAB;
$config->ticket->search['fields']['desc']           = $lang->ticket->desc;
$config->ticket->search['fields']['openedBuild']    = $lang->ticket->openedBuild;
$config->ticket->search['fields']['customer']       = $lang->ticket->customer;
$config->ticket->search['fields']['contact']        = $lang->ticket->contact;
$config->ticket->search['fields']['notifyEmail']    = $lang->ticket->notifyEmail;
$config->ticket->search['fields']['deadline']       = $lang->ticket->deadline;
$config->ticket->search['fields']['assignedTo']     = $lang->ticket->assignedTo;
$config->ticket->search['fields']['mailto']         = $lang->ticket->mailto;
$config->ticket->search['fields']['keywords']       = $lang->ticket->keywords;
$config->ticket->search['fields']['openedBy']       = $lang->ticket->createdBy;
$config->ticket->search['fields']['openedDate']     = $lang->ticket->createdDate;
$config->ticket->search['fields']['source']         = $lang->ticket->source;
$config->ticket->search['fields']['startedBy']      = $lang->ticket->startedBy;
$config->ticket->search['fields']['startedDate']    = $lang->ticket->startedDate;
$config->ticket->search['fields']['activatedBy']    = $lang->ticket->activatedBy;
$config->ticket->search['fields']['activatedDate']  = $lang->ticket->activatedDate;
$config->ticket->search['fields']['activatedCount'] = $lang->ticket->activatedCount;
$config->ticket->search['fields']['resolvedBy']     = $lang->ticket->resolvedBy;
$config->ticket->search['fields']['resolution']     = $lang->ticket->resolution;
$config->ticket->search['fields']['resolvedDate']   = $lang->ticket->resolvedDate;
$config->ticket->search['fields']['closedBy']       = $lang->ticket->closedBy;
$config->ticket->search['fields']['closedDate']     = $lang->ticket->closedDate;
$config->ticket->search['fields']['closedReason']   = $lang->ticket->closedReason;
$config->ticket->search['fields']['lastEditedBy']   = $lang->ticket->lastEditedBy;
$config->ticket->search['fields']['lastEditedDate'] = $lang->ticket->lastEditedDate;

$config->ticket->search['params']['title']          = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['product']        = array('operator' => '=', 'control' => 'select',  'values' => '');
$config->ticket->search['params']['status']         = array('operator' => '=', 'control' => 'select',  'values' => $lang->ticket->statusList);
$config->ticket->search['params']['pri']            = array('operator' => '=', 'control' => 'select',  'values' => $lang->ticket->priList);
$config->ticket->search['params']['type']           = array('operator' => '=', 'control' => 'select',  'values' => $lang->ticket->typeList);
$config->ticket->search['params']['module']         = array('operator' => '=', 'control' => 'select',  'values' => '');
$config->ticket->search['params']['id']             = array('operator' => '=', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['desc']           = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['openedBuild']    = array('operator' => '=', 'control' => 'select',  'values' => '');
$config->ticket->search['params']['customer']       = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['contact']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['notifyEmail']    = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['deadline']       = array('operator' => '=', 'control' => 'input',  'values' => 'date');
$config->ticket->search['params']['assignedTo']     = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['mailto']         = array('operator' => 'include', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['openedBy']       = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['openedDate']     = array('operator' => '=', 'control' => 'input',  'values' => '', 'class' => 'date');
$config->ticket->search['params']['source']         = array('operator' => '=', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['startedBy']      = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['startedDate']    = array('operator' => '=', 'control' => 'input',  'values' => '', 'class' => 'date');
$config->ticket->search['params']['activatedBy']    = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['activatedDate']  = array('operator' => '=', 'control' => 'input',  'values' => '', 'class' => 'date');
$config->ticket->search['params']['activatedCount'] = array('operator' => '=', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['resolvedBy']     = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['resolution']     = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['resolvedDate']   = array('operator' => '=', 'control' => 'input',  'values' => '', 'class' => 'date');
$config->ticket->search['params']['closedBy']       = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['closedDate']     = array('operator' => '=', 'control' => 'input',  'values' => '', 'class' => 'date');
$config->ticket->search['params']['closedReason']   = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->ticket->search['params']['lastEditedBy']   = array('operator' => '=', 'control' => 'select',  'values' => 'users');
$config->ticket->search['params']['lastEditedDate'] = array('operator' => '=', 'control' => 'input',  'values' => '', 'class' => 'date');

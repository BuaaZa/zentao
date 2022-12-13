<?php
$config->bug->editor->launchdeliberation   = array('id' => 'comment', 'tools' => 'bugTools');
$config->bug->editor->recorddeliberation   = array('id' => 'comment', 'tools' => 'bugTools');

//影响menu里面的输入textarea的工具栏

$config->deliberation = new stdClass();
$config->deliberation->batchrecord = 10;


$config->deliberation->record = new stdclass();
$config->deliberation->record->requiredFields = 'deliberateddate, tostatus';


$config->deliberation->list = new stdclass();
$config->deliberation->list->allFields = 'id, frombugid, deliberateddate, description, tostatus, launcherid, organizerid, times';

$config->deliberation->list->defaultFields = 'id, frombugid, tostatus, launcherid, organizerid, times';

$config->deliberation->editor = new stdclass();
$config->deliberation->editor->record = array('id' => 'comment', 'tools' => 'bugTools');




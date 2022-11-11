<?php
$config->vm->create         = new stdClass();
$config->vm->edit           = new stdClass();
$config->vm->createtemplate = new stdClass();
$config->vm->edittemplate   = new stdClass();
$config->vm->create->requiredFieldsFirst    = 'osCategory,osType,osVersion,vmTemplate';
$config->vm->create->requiredFields         = 'name,osLang,osCpu,osMemory,osDisk';
$config->vm->edit->requiredFields           = '';
$config->vm->createtemplate->requiredFields = 'name,hostID,templateName,osCategory,osType,osVersion,osLang,cpuCoreNum,memorySize,diskSize';
$config->vm->edittemplate->requiredFields   = $config->vm->createtemplate->requiredFields;

$config->vm->os = new stdClass();
$config->vm->os->list = array();
$config->vm->os->list['windows'] = 'Windows';
$config->vm->os->list['linux']   = 'Linux';

$config->vm->os->cpu = array();
$config->vm->os->cpu['1']  = '1';
$config->vm->os->cpu['2']  = '2';
$config->vm->os->cpu['4']  = '4';
$config->vm->os->cpu['6']  = '6';
$config->vm->os->cpu['8']  = '8';
$config->vm->os->cpu['12'] = '12';
$config->vm->os->cpu['16'] = '16';

$config->vm->os->memory = array();
$config->vm->os->memory['512']   = '512MB';
$config->vm->os->memory['1024']  = '1GB';
$config->vm->os->memory['2048']  = '2GB';
$config->vm->os->memory['4096']  = '4GB';
$config->vm->os->memory['9120']  = '8GB';
$config->vm->os->memory['16384'] = '16GB';

$config->vm->os->disk = array();
$config->vm->os->disk['10240']  = '10GB';
$config->vm->os->disk['20480']  = '20GB';
$config->vm->os->disk['40960']  = '40GB';
$config->vm->os->disk['61440']  = '60GB';
$config->vm->os->disk['81920']  = '80GB';
$config->vm->os->disk['102400'] = '100GB';
$config->vm->os->disk['204800'] = '200GB';
$config->vm->os->disk['307200'] = '300GB';

$config->vm->os->type = array();
$config->vm->os->type['windows']['winServer'] = 'Windows Server';
$config->vm->os->type['windows']['win11']     = 'Windows 11';
$config->vm->os->type['windows']['win10']     = 'Windows 10';
$config->vm->os->type['windows']['win7']      = 'Windows 7';
$config->vm->os->type['windows']['winxp']     = 'Windows XP';
$config->vm->os->type['linux']['ubuntu']      = 'Ubuntu';
$config->vm->os->type['linux']['centos']      = 'CentOS';
$config->vm->os->type['linux']['debian']      = 'Debian';

global $lang;
$config->vm->search['module'] = 'vm';
$config->vm->search['fields']['name']       = $lang->vm->name;
$config->vm->search['fields']['osType']     = $lang->vm->osType;
$config->vm->search['fields']['osVersion']  = $lang->vm->osVersion;
$config->vm->search['fields']['hostID']     = $lang->vm->hostName;
$config->vm->search['fields']['status']     = $lang->vm->status;
$config->vm->search['fields']['osCpu']      = $lang->vm->cpu;
$config->vm->search['fields']['osMemory']   = $lang->vm->memory;
$config->vm->search['fields']['osDisk']     = $lang->vm->disk;
$config->vm->search['fields']['macAddress'] = $lang->vm->macAddress;
$config->vm->search['fields']['publicIP']   = $lang->vm->ip;
$config->vm->search['params']['name']       = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->vm->search['params']['osType']     = array('operator' => '=', 'control' => 'select',  'values' => array('' => '') + $config->vm->os->type['windows'] + $config->vm->os->type['linux']);
$config->vm->search['params']['hostID']     = array('operator' => '=', 'control' => 'select',  'values' => '');
$config->vm->search['params']['status']     = array('operator' => '=', 'control' => 'select',  'values' => array('' => '') + $lang->vm->statusList);
$config->vm->search['params']['osCpu']      = array('operator' => '=', 'control' => 'select',  'values' => array('' => '') + $config->vm->os->cpu);
$config->vm->search['params']['osMemory']   = array('operator' => '=', 'control' => 'select',  'values' => array('' => '') + $config->vm->os->memory);
$config->vm->search['params']['osDisk']     = array('operator' => '=', 'control' => 'select',  'values' => array('' => '') + $config->vm->os->disk);

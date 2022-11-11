<?php
if(!defined('TABLE_SERVERROOM'))    define('TABLE_SERVERROOM',    '`' . $config->db->prefix . 'serverroom`');
if(!defined('TABLE_SERVICE'))       define('TABLE_SERVICE',       '`' . $config->db->prefix . 'service`');
if(!defined('TABLE_ASSET'))         define('TABLE_ASSET',         '`' . $config->db->prefix . 'asset`');
if(!defined('TABLE_HOST'))          define('TABLE_HOST',          '`' . $config->db->prefix . 'host`');
if(!defined('TABLE_ACCOUNT'))       define('TABLE_ACCOUNT',       '`' . $config->db->prefix . 'account`');
if(!defined('TABLE_DEPLOY'))        define('TABLE_DEPLOY',        '`' . $config->db->prefix . 'deploy`');
if(!defined('TABLE_DEPLOYPRODUCT')) define('TABLE_DEPLOYPRODUCT', '`' . $config->db->prefix . 'deployproduct`');
if(!defined('TABLE_DEPLOYSTEP'))    define('TABLE_DEPLOYSTEP',    '`' . $config->db->prefix . 'deploystep`');
if(!defined('TABLE_DEPLOYSCOPE'))   define('TABLE_DEPLOYSCOPE',   '`' . $config->db->prefix . 'deployscope`');
if(!defined('TABLE_DOMAIN'))        define('TABLE_DOMAIN',        '`' . $config->db->prefix . 'domain`');
if(!defined('TABLE_VM'))            define('TABLE_VM',            '`' . $config->db->prefix . 'vm`');
if(!defined('TABLE_BASEIMAGE'))     define('TABLE_BASEIMAGE',     '`' . $config->db->prefix . 'baseimage`');
if(!defined('TABLE_VMTEMPLATE'))    define('TABLE_VMTEMPLATE',    '`' . $config->db->prefix . 'vmtemplate`');

$config->objectTables['serverroom'] = TABLE_SERVERROOM;
$config->objectTables['service']    = TABLE_SERVICE;
$config->objectTables['asset']      = TABLE_ASSET;
$config->objectTables['host']       = TABLE_ASSET;
$config->objectTables['deploy']     = TABLE_DEPLOY;
$config->objectTables['deploystep'] = TABLE_DEPLOYSTEP;
$config->objectTables['domain']     = TABLE_DOMAIN;
$config->objectTables['account']    = TABLE_ACCOUNT;
$config->objectTables['vm']         = TABLE_VM;
$config->objectTables['baseimage']  = TABLE_BASEIMAGE;
$config->objectTables['vmtemplate'] = TABLE_VMTEMPLATE;

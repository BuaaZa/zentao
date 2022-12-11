<?php
$config->bizVersion = '7.7';

$filter->file->ajaxwopifiles = new stdclass();
$filter->file->ajaxwopifiles->get['access_token'] = 'code';

$filter->traincourse = new stdclass();
$filter->traincourse->browse = new stdclass();
$filter->traincourse->browse->cookie['courseModule'] = 'int';
$filter->traincourse->admin = new stdclass();
$filter->traincourse->admin->cookie['courseModule'] = 'int';

if(!defined('TABLE_TRAINCOURSE')) define('TABLE_TRAINCOURSE', '`' . $config->db->prefix . 'traincourse`');
if(!defined('TABLE_TRAINCONTENTS')) define('TABLE_TRAINCONTENTS', '`' . $config->db->prefix . 'traincontents`');
if(!defined('TABLE_TRAINCATEGORY')) define('TABLE_TRAINCATEGORY', '`' . $config->db->prefix . 'traincategory`');
if(!defined('TABLE_TRAINRECORDS')) define('TABLE_TRAINRECORDS', '`' . $config->db->prefix . 'trainrecords`');

$config->objectTables['traincourse']   = TABLE_TRAINCOURSE;
$config->objectTables['traincategory'] = TABLE_TRAINCATEGORY;
$config->objectTables['traincontents'] = TABLE_TRAINCONTENTS;
$config->objectTables['trainrecords']  = TABLE_TRAINRECORDS;

$config->openMethods[] = 'traincourse.playvideo';

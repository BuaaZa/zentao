<?php
/**
 * The lang file of calendar module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     calendar
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->resource->company->todo      = 'companyTodo';
$lang->resource->company->calendar  = 'effortCalendar';
$lang->resource->company->allTodo   = 'allTodo';

if(!isset($lang->resource->effort))  $lang->resource->effort  = new stdclass();
if(!isset($lang->resource->execution)) $lang->resource->execution = new stdclass();
$lang->resource->effort->calendar          = 'calendar';
$lang->resource->execution->calendar       = 'calendar';
$lang->resource->execution->effortCalendar = 'effortCalendar';
$lang->resource->todo->calendar            = 'calendar';
$lang->resource->user->effortcalendar      = 'effortcalendar';
$lang->resource->user->todocalendar        = 'todocalendar';

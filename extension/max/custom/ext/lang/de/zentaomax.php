<?php
$lang->custom->estimate             = 'Estimate';
$lang->custom->estimateConfig       = 'Config Estimate';
$lang->custom->estimateUnit         = 'Estimate Unit';
$lang->custom->estimateEfficiency   = 'Efficiency';
$lang->custom->estimateCost         = 'Unit labor cost';
$lang->custom->estimateHours        = 'Hours/day';
$lang->custom->estimateDays         = 'Days/week';

$lang->custom->conceptOptions->estimateUnit = array();
$lang->custom->conceptOptions->estimateUnit['0'] = 'Hour(H)';
$lang->custom->conceptOptions->estimateUnit['1'] = 'Story Points(SP)';
$lang->custom->conceptOptions->estimateUnit['2'] = 'Function Point(FP)';

$lang->custom->object['baseline']    = 'Baseline';
$lang->custom->object['issue']       = 'Issue';
$lang->custom->object['risk']        = 'Risk';
$lang->custom->object['opportunity'] = 'Opportunity';
$lang->custom->object['nc']          = 'QA';

$lang->custom->menuOrder[46] = 'issue';
$lang->custom->menuOrder[47] = 'risk';
$lang->custom->menuOrder[48] = 'opportunity';
$lang->custom->menuOrder[49] = 'nc';
$lang->custom->menuOrder[61] = 'baseline';

$lang->custom->dividerMenu .= 'issue,';

$lang->custom->baseline = new stdClass();
$lang->custom->baseline->fields['objectList'] = 'Object';

$lang->custom->issue = new stdClass();
$lang->custom->issue->fields['typeList']     = 'Type';
$lang->custom->issue->fields['severityList'] = 'Severity';
$lang->custom->issue->fields['priList']      = 'Priority';

$lang->custom->risk = new stdClass();
$lang->custom->risk->fields['sourceList']   = 'Source';
$lang->custom->risk->fields['categoryList'] = 'Category';

$lang->custom->opportunity= new stdClass();
$lang->custom->opportunity->fields['sourceList'] = 'Source';
$lang->custom->opportunity->fields['typeList']   = 'Type';

$lang->custom->nc = new stdClass();
$lang->custom->nc->fields['typeList']     = 'Type';
$lang->custom->nc->fields['severityList'] = 'Severity';

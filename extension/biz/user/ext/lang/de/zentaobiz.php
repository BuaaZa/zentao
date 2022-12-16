<?php
$lang->user->expireBizWaring = "<p style='color:yellow'>Your enterprise license will expire in %s days. Please renew it.</p>";
$lang->user->noticeUserLimit = "Number of R&D users has reached the limit of the licensed. No more user can be added now!";
$lang->user->noticeFeedbackUserLimit = "Number of Non R&D users has reached the limit of the licensed. No more user can be added now!";

$lang->user->userAddWarning     = "The left authorized number of R&D integrated account is %d, and the left authorized number of Lite account is %d. The new members will not be saved after exceeding the authorized number";
$lang->user->rndUserAddWarning  = 'The left authorized number of R&D integrated account is %d, and the new members will not be saved after exceeding the authorized number';
$lang->user->liteUserAddWarning = 'The left authorized number of Lite account is %d, and the new members will not be saved after exceeding the authorized number';

if(!isset($lang->dept)) $lang->dept = new stdclass();
$lang->dept->manager = 'Manager';

$lang->user->isFeedback[0] = 'Developer User';
$lang->user->isFeedback[1] = 'Feedback User';

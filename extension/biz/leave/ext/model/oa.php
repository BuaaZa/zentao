<?php
public function isClickable($leave, $action)
{
	$action    = strtolower($action);
	$clickable = commonModel::hasPriv('leave', $action);
	if(!$clickable) return false;

	$account = $this->app->user->account;

	switch($action)
	{
	case 'back':
		$canBack = $leave->status == 'pass' && date('Y-m-d H:i:s') > "$leave->begin $leave->start" && date('Y-m-d H:i:s') < "$leave->end $leave->finish" && $leave->backDate != "$leave->end $leave->finish" && $leave->createdBy == $account;

		return $canBack;
	case 'edit':
	case 'delete':
		$canEdit = strpos(',wait,draft,reject,', ",{$leave->status},") !== false && $leave->createdBy == $account;

		return $canEdit;
	case 'switchstatus':
		$canSwitch = strpos(',wait,draft,', ",{$leave->status},") !== false && $leave->createdBy == $account;

		return $canSwitch;
	case 'review':
		$reviewedBy = $this->getReviewedBy($leave->createdBy);
		$canReview  = strpos(',wait,doing,back,', ",$leave->status,") !== false && $reviewedBy == $account;

		return $canReview;
	}

	return true;
}

public function getList($type = 'personal', $year = '', $month = '', $account = '', $dept = '', $status = '', $orderBy = 'id_desc')
{
    $date     = '';
    $length   = 0;
    $position = 0;
    if($year)
    {
        $position = 1;
        $length   = 4;
        $date     = $year;
        if($month)
        {
            $length = 7;
            $date   = "$year-$month";
        }
    }
    elseif($month)
    {
        $date     = $month;
        $position = 6;
        $length   = 2;
    }

    $leaveList = $this->dao->select('t1.*, t2.realname, t2.dept')
        ->from(TABLE_LEAVE)->alias('t1')
        ->leftJoin(TABLE_USER)->alias('t2')->on("t1.createdBy=t2.account")
        ->where(1)
        ->beginIf($date)
        ->andWhere("SUBSTRING(t1.begin, $position, $length)", true)->eq($date)
        ->orWhere("SUBSTRING(t1.end, $position, $length)")->eq($date)
        ->markRight(1)
        ->fi()
        ->beginIf($account != '')->andWhere('t1.createdBy')->eq($account)->fi()
        ->beginIf($dept != '')->andWhere('t2.dept')->in($dept)->fi()
        ->beginIf($status != '')->andWhere('t1.status')->in($status)->fi()
        ->beginIf($type == 'browseReview')->andWhere('t1.status')->in('wait,back')->fi()
        ->beginIf($type == 'company')->andWhere('t1.status')->ne('draft')->fi()
        ->orderBy("t2.dept,t1.{$orderBy}")
        ->fetchAll();
    $this->session->set('leaveQueryCondition', $this->dao->get());

    return $this->processStatus($leaveList);
}

/**
 * Get reviewer of leave.
 *
 * @param  string $account
 * @param  string $module
 * @param  string $app
 * @access public
 * @return string
 */
public function getReviewedBy($account = '', $module = 'leave', $app = 'oa')
{
    if($module != 'leave') $this->app->loadModuleConfig($module, $app);

    $reviewedBy = zget($this->config->attend, 'reviewedBy', '');
    $reviewedBy = zget($this->config->$module, 'reviewedBy', $reviewedBy);

    /* If reviewer is empty get dept manager as reviewer. */
    if(!$reviewedBy && $account) $reviewedBy = $this->attend->getDeptManager($account);

    return $reviewedBy;
}
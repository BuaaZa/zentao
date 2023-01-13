<?php
// 关闭问题处理
public function close(stdClass $fb, string $closedReason='', string $repeatFeedback='0'):array
{
    $oldfb = clone $fb;
    $now = helper::now();
    $fb->status = 'closed';
    $fb->closedReason = $closedReason;
    $fb->repeatFeedback = (int)$repeatFeedback;
    $fb->assignedTo = 'closed';
    $fb->closedBy = $this->app->user->account;
    $fb->closedDate =$now;
    $fb->updateDate = $now;
    $this->dao->update(TABLE_FEEDBACK)->data($fb)->autoCheck()->checkFlow()->where('id')->eq((int)$fb->id)->exec();
    return common::createChanges($oldfb, $fb);
    // $this->dao->update(TABLE_FEEDBACK)
    // ->set('status')->eq('closed')
    // ->set('closedReason')->eq($closedReason)
    // ->set('repeatFeedback')->eq($repeatFeedback)
    // ->set('assignedTo')->eq('closed')
    // ->set('closedBy')->eq($this->app->user->account)
    // ->set('closedDate')->eq(helper::now())
    // ->where('id')->eq((int)$fbID)
    // ->exec();
}

// 关闭页面下拉选项值
public function getFeedbacks4Select(stdClass $fb):array
{
    $feedbacks = array();
    $feedbacks['0']='';
    $productIDList = array($fb->product);
    $sort = common::appendOrder('');
    $allFeedbacks = $this->getFeedbacks($productIDList, array(), 'all', 'all', '', '', $sort, null, $this->projectID);
    if (is_array($allFeedbacks)) {
        $id = $fb->id;
        foreach ($allFeedbacks as $fbEle) {
            $curId = $fbEle->id;
            if ($id!=$curId) {
                $feedbacks[$curId]='#'.$fbEle->id.' '.$fbEle->title;
            }
        }
    }
    return $feedbacks;
}
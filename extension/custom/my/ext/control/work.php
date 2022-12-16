
<?php


class myMy extends my
{
    
    /**
     * My work view.
     *
     * @param  string     $mode
     * @param  string     $type
     * @param  string|int $param
     * @param  string     $orderBy
     * @param  int        $recTotal
     * @param  int        $recPerPage
     * @param  int        $pageID
     * @access public
     * @return void
     */
    public function work($mode = 'task', $type = 'assignedTo', $param = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        echo $this->fetch('my', $mode, "type=$type&param=$param&orderBy=$orderBy&recTotal=$recTotal&recPerPage=$recPerPage&pageID=$pageID");
        // 使用自己的方法
        $this->showWorkCountNew($recTotal, $recPerPage, $pageID);
    }

 /**
     * Show to-do work count.
     *
     * @param int    $recTotal
     * @param int    $recPerPage
     * @param int    $pageID
     * @access public
     * @return void
     */
    public function showWorkCountNew($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->loadModel('task');
        $this->loadModel('story');
        $this->loadModel('bug');
        $this->loadModel('testcase');
        $this->loadModel('testtask');
        $this->loadModel('ticket');

        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if($this->app->getViewType() == 'mhtml') $recPerPage = 10;
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        /* Get the number of tasks assigned to me. */
        $tasks     = $this->task->getUserTasks($this->app->user->account, 'assignedTo', 0, $pager);
        $taskCount = $pager->recTotal;

        /* Get the number of stories assigned to me. */
        $assignedToStories    = $this->story->getUserStories($this->app->user->account, 'assignedTo', 'id_desc', $pager, 'story', false);
        $assignedToStoryCount = $pager->recTotal;
        $reviewByStories      = $this->story->getUserStories($this->app->user->account, 'reviewBy', 'id_desc', $pager, 'story', false);
        $reviewByStoryCount   = $pager->recTotal;
        $storyCount           = $assignedToStoryCount + $reviewByStoryCount;

        $requirementCount = 0;
        $isOpenedURAndSR  = $this->config->URAndSR;
        if($isOpenedURAndSR)
        {
            /* Get the number of requirements assigned to me. */
            $assignedRequirements     = $this->story->getUserStories($this->app->user->account, 'assignedTo', 'id_desc', $pager, 'requirement');
            $assignedRequirementCount = $pager->recTotal;
            $reviewByRequirements     = $this->story->getUserStories($this->app->user->account, 'reviewBy', 'id_desc', $pager, 'requirement');
            $reviewByRequirementCount = $pager->recTotal;
            $requirementCount         = $assignedRequirementCount + $reviewByRequirementCount;
        }

        /* Get the number of bugs assigned to me. */
        $bugs     = $this->bug->getUserBugs($this->app->user->account, 'assignedTo', 'id_desc', 0, $pager);
        $bugCount = $pager->recTotal;

        /* Get the number of testcases assigned to me. */
        $cases     = $this->testcase->getByAssignedTo($this->app->user->account, 'id_desc', $pager, 'skip');
        $caseCount = $pager->recTotal;

        /* Get the number of testtasks assigned to me. */
        $testTasks     = $this->testtask->getByUser($this->app->user->account, $pager, 'id_desc', 'wait');
        $testTaskCount = $pager->recTotal;

        $issueCount   = 0;
        $riskCount    = 0;
        $reviewCount  = 0;
        $ncCount      = 0;
        $qaCount      = 0;
        $meetingCount = 0;
        $ticketCount  = 0;
        $isMax        = $this->config->edition == 'max' ? 1 : 0;

        $feedbackCount = 0;
        $isBiz         = $this->config->edition == 'biz' ? 1 : 0;

        $feedbacks     = $this->loadModel('feedback')->getList('assigntome', 'id_desc', $pager);
        $feedbackCount = $pager->recTotal;

        if($isMax)
        {
            $this->loadModel('issue');
            $this->loadModel('risk');
            $this->loadModel('review');
            $this->loadModel('meeting');

            /* Get the number of issues assigned to me. */
            $issues     = $this->issue->getUserIssues('assignedTo', 0, $this->app->user->account, 'id_desc', $pager);
            $issueCount = $pager->recTotal;

            /* Get the number of risks assigned to me. */
            $risks     = $this->risk->getUserRisks('assignedTo', $this->app->user->account, 'id_desc', $pager);
            $riskCount = $pager->recTotal;

            /* Get the number of reviews assigned to me. */
            $pendingList = $this->loadModel('approval')->getPendingReviews('review');
            $reviewList  = $this->review->getByList($pendingList, 'id_desc', $pager);
            $reviewCount = $pager->recTotal;

            /* Get the number of nc assigned to me. */
            $ncList  = $this->my->getNcList('assignedToMe', 'id_desc', $pager, 'active');
            $ncCount = $pager->recTotal;

            /* Get the number of nc assigned to me. */
            $auditplanList  = $this->loadModel('auditplan')->getList(0, 'mychecking', '', 'id_desc', $pager);
            $auditplanCount = $pager->recTotal;
            $qaCount        = $ncCount + $auditplanCount;

            /* Get the number of meetings assigned to me. */
            $meetings     = $this->meeting->getListByUser('futureMeeting', 'id_desc', 0, $pager);
            $meetingCount = $pager->recTotal;

            $ticketList  = $this->ticket->getList('assignedtome', 'id_desc', $pager);
            $ticketCount = $pager->recTotal;
        }

echo <<<EOF
<script>
var taskCount     = $taskCount;
var storyCount    = $storyCount;
var bugCount      = $bugCount;
var caseCount     = $caseCount;
var testTaskCount = $testTaskCount;

var isOpenedURAndSR = $isOpenedURAndSR;
if(isOpenedURAndSR !== 0) var requirementCount = $requirementCount;

var isMax = $isMax;
var isBiz = $isBiz;

var feedbackCount = $feedbackCount;

if(isMax !== 0)
{
    var issueCount   = $issueCount;
    var riskCount    = $riskCount;
    var reviewCount  = $reviewCount;
    var qaCount      = $qaCount;
    var meetingCount = $meetingCount;
    var ticketCount  = $ticketCount;
}
</script>
EOF;
    }

}
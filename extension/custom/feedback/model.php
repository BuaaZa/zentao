<?php
class feedbackModel extends model
{

    /**
     * Set menu.
     *
     * @param  array  $products
     * @param  int    $productID
     * @param  int    $branch
     * @param  int    $moduleID
     * @param  string $browseType
     * @param  string $orderBy
     * @access public
     * @return void
     */
    public function setMenu($products, $productID, $branch = 0, $moduleID = 0, $browseType = 'unclosed', $orderBy = '')
    {
        $currentModule = $this->app->moduleName;
        $currentMethod = $this->app->methodName;
        $this->loadModel('product');//->setMenu($productID, $branch, $moduleID, 'feedback');
        // if($this->lang->navGroup->feedback == 'feedback' and $this->app->methodName == 'browse') {
        //     $products = array(0 => $this->lang->feedback->allProduct) + $products;
        // }
        $fromModule = 'feedback';
        $dropMenuLink = helper::createLink('feedback', 'ajaxGetDropMenu', "objectID=all&module=$currentModule&method=$currentMethod");

        $currentProductName = $this->lang->feedback->allProduct;
        if($productID){
            foreach($products as $key=>$value){
                if($key == $productID){
                    $currentProductName = $value;
                }
            }
        }
        $output  = "<div class='btn-group header-btn' id='swapper'><button data-toggle='dropdown' type='button' class='btn' id='currentItem' title='{$currentProductName}'><span class='text'>{$currentProductName}</span> <span class='caret' style='margin-bottom: -1px'></span></button><div id='dropMenu' class='dropdown-menu search-list' data-ride='searchList' data-url='$dropMenuLink'>";
        $output .= '<div class="input-control search-box has-icon-left has-icon-right search-example"><input type="search" class="form-control search-input" /><label class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label><a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a></div>';
        $output .= "</div></div>";

        $this->lang->switcherMenu = $output;
    }
    /**
     * Create a feedback.
     *
     * @param  string $from   object that is transfered to bug.
     * @param  string $extras.
     * @access public
     * @return array|bool
     */
    public function create($from = '', $extras = '')
    {
        $extras = str_replace(array(',', ' '), array('&', ''), $extras);
        parse_str($extras, $output);

        $now = helper::now();
        $feedback = fixer::input('post')
            ->setDefault('openedBy', $this->app->user->account)
            ->setDefault('openedDate', $now)
            ->setDefault('product,', 0)
            ->setDefault('notifyEmail', '')
            ->setDefault('status','wait')
            ->setIF($this->post->assignedTo != '', 'assignedDate', $now)
            ->stripTags($this->config->feedback->editor->create['id'], $this->config->allowedTags)
            ->cleanInt('product,execution,module,severity')
            ->trim('title')
            ->join('mailto', ',')
            ->remove('files,labels,uid,oldTaskID,contactListMenu,region,lane,ticket')
            ->get();

        $feedback->status = 'noreview';// 暂时默认需要预审
        //if($bug->execution != 0) $bug->project = $this->dao->select('project')->from(TABLE_EXECUTION)->where('id')->eq($bug->execution)->fetch('project');

        /* Check repeat bug. */
        $result = $this->loadModel('common')->removeDuplicate('feedback', $feedback, "product={$feedback->product}");
        if($result and $result['stop']) return array('status' => 'exists', 'id' => $result['duplicate']);

        $feedback = $this->loadModel('file')->processImgURL($feedback, $this->config->feedback->editor->create['id'], $this->post->uid);

        /* Use classic mode to replace required project. */
        //if($this->config->systemMode == 'classic' and strpos($this->config->bug->create->requiredFields, 'project') !== false) $this->config->bug->create->requiredFields = str_replace('project', 'execution', $this->config->bug->create->requiredFields);

        $this->dao->insert(TABLE_FEEDBACK)->data($feedback)
            ->autoCheck()
            ->checkIF($feedback->notifyEmail, 'notifyEmail', 'email')
            ->batchCheck($this->config->feedback->create->requiredFields, 'notempty')
            ->checkFlow()
            ->exec();

        if(!dao::isError())
        {
            $feedbackID = $this->dao->lastInsertID();

            $this->file->updateObjectID($this->post->uid, $feedbackID, 'feedback');
            $this->file->saveUpload('feedback', $feedbackID);
            //empty($feedback->case) ? $this->loadModel('score')->create('feedback', 'create', $feedbackID) : $this->loadModel('score')->create('feedback', 'createFormCase', $feedback->case);

            /* Callback the callable method to process the related data for object that is transfered to bug. */
            if($from && is_callable(array($this, $this->config->feedback->fromObjects[$from]['callback']))) call_user_func(array($this, $this->config->feedback->fromObjects[$from]['callback']), $feedbackID);

            return array('status' => 'created', 'id' => $feedbackID);
        }
        return false;
    }    
     /**
     * Get getFeedbacks.
     *
     * @param  array       $productIDList
     * @param  array       $executions
     * @param  int|string  $branch
     * @param  string      $browseType
     * @param  int         $moduleID
     * @param  int         $queryID
     * @param  string      $sort
     * @param  object      $pager
     * @param  int         $projectID
     * @access public
     * @return array
     */
    public function getFeedbacks($productIDList, $executions, $branch, $browseType, $moduleID, $queryID, $sort, $pager, $projectID)
    {
      /* Set modules and browse type. */
      $modules    = $moduleID ? $this->loadModel('tree')->getAllChildId($moduleID) : '0';
      $browseType = ($browseType == 'bymodule' and $this->session->bugBrowseType and $this->session->bugBrowseType != 'bysearch') ? $this->session->bugBrowseType : $browseType;
      $browseType = $browseType == 'bybranch' ? 'bymodule' : $browseType;

      if(strpos($sort, 'pri_') !== false) $sort = str_replace('pri_', 'priOrder_', $sort);
      if(strpos($sort, 'severity_') !== false) $sort = str_replace('severity_', 'severityOrder_', $sort);
      $feedbacks = array();
      if($browseType == 'all')          $feedbacks = $this->getAllFeedbacks($productIDList, $branch, $modules, $executions, $sort, $pager, $projectID);
      elseif($browseType == 'wait')     $feedbacks = $this->getByStatus($productIDList, $branch, $modules, $executions, $browseType, $sort, $pager, $projectID);
      elseif($browseType == 'review')     $feedbacks = $this->getByStatus($productIDList, $branch, $modules, $executions, 'noreview', $sort, $pager, $projectID);
      return $feedbacks;
    }

    /**
     * Get all getFeedbacks.
     *
     * @param  array       $productIDList
     * @param  int|string  $branch
     * @param  array       $modules
     * @param  array       $executions
     * @param  string      $orderBy
     * @param  object      $pager
     * @param  int         $projectID
     * @access public
     * @return array
     */
    public function getAllFeedbacks($productIDList, $branch, $modules, $executions, $orderBy, $pager = null, $projectID = 0)
    {
        $feedbacks = $this->dao->select("t1.*, t1.title as planTitle, IF(t1.`pri` = 0, {$this->config->maxPriValue}, t1.`pri`) as priOrder")->from(TABLE_FEEDBACK)->alias('t1')
            ->where('t1.product')->in($productIDList)
            ->beginIF($modules)->andWhere('t1.module')->in($modules)->fi()
            ->andWhere('t1.deleted')->eq(0)
            ->orderBy($orderBy)->page($pager)->fetchAll();

        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'feedback');

        return $feedbacks;
    }   
    
    public function getList($browseType, $orderBy, $pager)
    {
        $status = '';
        if($browseType == "assigntome") {
            $status = "wait";
        }
        $feedbacks = $this->dao->select("t1.*, t1.title as title, IF(t1.`pri` = 0, {$this->config->maxPriValue}, t1.`pri`) as priOrder")->from(TABLE_FEEDBACK)->alias('t1')
            ->where('t1.status')->eq($status)->fi()
            ->beginIF($browseType == "assigntome")->andWhere('t1.assignedTo')->eq($this->app->user->account)->fi()
            ->andWhere('t1.deleted')->eq(0)
            ->orderBy($orderBy)->page($pager)->fetchAll();

        $this->loadModel('common')->saveQueryCondition($this->dao->get(), 'feedback');

        return $feedbacks;
    }

    public function getFeedbackPairs($method)
    {
        return $this->dao->select('id, title')->from(TABLE_FEEDBACK)
        ->where('deleted')->eq(0)
        ->beginIF(!$this->app->user->admin)->andWhere('id')->in($this->app->user->view->products)->fi()
        ->fetchPairs();
    }

     /**
     * Get getByStatus the status is active or unclosed.
     *
     * @param  array       $productIDList
     * @param  int|string  $branch
     * @param  array       $modules
     * @param  array       $executions
     * @param  string      $status
     * @param  string      $orderBy
     * @param  object      $pager
     * @param  int         $projectID
     * @access public
     * @return array
     */
    public function getByStatus($productIDList, $branch, $modules, $executions, $status, $orderBy, $pager, $projectID)
    {
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
            ->where('product')->in($productIDList)
            ->beginIF($modules)->andWhere('module')->in($modules)->fi()
            ->andWhere('status')->eq($status)->fi()
            ->andWhere('deleted')->eq(0)
            ->orderBy($orderBy)->page($pager)
            ->fetchAll();
    }

    /**
     * Check force review for user.
     *
     * @access public
     * @return bool
     */
    public function checkForceReview()
    {
        $forceReview = false;

        $forceField       = $this->config->feedback->needReview == 0 ? 'forceReview' : 'forceNotReview';
        $forceReviewRoles = !empty($this->config->feedback->{$forceField . 'Roles'}) ? $this->config->feedback->{$forceField . 'Roles'} : '';
        $forceReviewDepts = !empty($this->config->feedback->{$forceField . 'Depts'}) ? $this->config->feedback->{$forceField . 'Depts'} : '';

        $forceUsers = '';
        if(!empty($this->config->feedback->{$forceField})) $forceUsers = $this->config->feedback->{$forceField};

        if(!empty($forceReviewRoles) or !empty($forceReviewDepts))
        {
            $users = $this->dao->select('account')->from(TABLE_USER)
                ->where('deleted')->eq(0)
                ->andWhere(0, true)
                ->beginIF(!empty($forceReviewRoles))
                ->orWhere('(role', true)->in($forceReviewRoles)
                ->andWhere('role')->ne('')
                ->markRight(1)
                ->fi()
                ->beginIF(!empty($forceReviewDepts))->orWhere('dept')->in($forceReviewDepts)->fi()
                ->markRight(1)
                ->fetchAll('account');

            $forceUsers .= "," . implode(',', array_keys($users));
        }

        $forceReview = $this->config->feedback->needReview == 0 ? strpos(",{$forceUsers},", ",{$this->app->user->account},") !== false : strpos(",{$forceUsers},", ",{$this->app->user->account},") === false;

        return $forceReview;
    }

    /**
     * Print cell data.
     *
     * @param  object $col
     * @param  object $bug
     * @param  array  $users
     * @param  array  $builds
     * @param  array  $branches
     * @param  array  $modulePairs
     * @param  array  $executions
     * @param  array  $plans
     * @param  array  $stories
     * @param  array  $tasks
     * @param  string $mode
     * @param  array  $projectPairs
     *
     * @access public
     * @return void
     * 
     * $value, $feedback, $users, $allProducts, $depts, $modulePairs, $viewMethod, $browseType, $stories, $bugs, $todos, $tasks
     */
    public function printCell($col, $feedback, $users, $allProducts, $depts, $modulePairs, $viewMethod, $browseType='', $stories = array(), $bugs = array(), $todos = array(),$tasks = array())
    {
        /* Check the product is closed. */
        $canBeChanged = common::canBeChanged('feedback', $feedback);

        $canBatchEdit         = ($canBeChanged and common::hasPriv('feedback', 'batchEdit'));
        $canBatchConfirm      = ($canBeChanged and common::hasPriv('feedback', 'batchConfirm'));
        $canBatchClose        = common::hasPriv('feedback', 'batchClose');
        $canBatchActivate     = ($canBeChanged and common::hasPriv('feedback', 'batchActivate'));
        $canBatchChangeBranch = ($canBeChanged and common::hasPriv('feedback', 'batchChangeBranch'));
        $canBatchChangeModule = ($canBeChanged and common::hasPriv('feedback', 'batchChangeModule'));
        $canBatchResolve      = ($canBeChanged and common::hasPriv('feedback', 'batchResolve'));
        $canBatchAssignTo     = ($canBeChanged and common::hasPriv('feedback', 'batchAssignTo'));

        $canBatchAction = ($canBatchEdit or $canBatchConfirm or $canBatchClose or $canBatchActivate or $canBatchChangeBranch or $canBatchChangeModule or $canBatchResolve or $canBatchAssignTo);

        $canView = common::hasPriv('feedback', 'view');

        $hasCustomSeverity = false;
        foreach($this->lang->bug->severityList as $severityKey => $severityValue)
        {
            if(!empty($severityKey) and (string)$severityKey != (string)$severityValue)
            {
                $hasCustomSeverity = true;
                break;
            }
        }

        $feedbackLink     = helper::createLink('feedback', 'view',"feedbackID=$feedback->id&browseType=$browseType");
        $account     = $this->app->user->account;
        $id          = $col->id;
        $os          = '';
        $browser     = '';
        $osList      = explode(',', $feedback->os);
        $browserList = explode(',', $feedback->browser);
        foreach($osList as $value)
        {
            if(empty($value)) continue;
            $os .= $this->lang->bug->osList[$value] . ',';
        }
        foreach($browserList as $value)
        {
            if(empty($value)) continue;
            $browser .= $this->lang->bug->browserList[$value] . ',';
        }
        $os      = trim($os, ',');
        $browser = trim($browser, ',');
        if($col->show)
        {
            $class = "c-$id";
            $title = '';
            switch($id)
            {
                case 'id':
                    $class .= ' cell-id';
                    break;
                case 'status':
                    $class .= ' bug-' . $feedback->status;
                    $title  = "title='" . $this->processStatus('feedback', $feedback) . "'";
                    break;
                case 'confirmed':
                    $class .= ' text-center';
                    break;
                case 'title':
                    $class .= ' text-left';
                    $title  = "title='{$feedback->title}'";
                    break;
                case 'type':
                    $title  = "title='" . zget($this->lang->feedback->typeList, $feedback->type) . "'";
                    break;
                case 'assignedTo':
                    $class .= ' has-btn text-left';
                    if($feedback->assignedTo == $account) $class .= ' red';
                    break;
                case 'resolvedBy':
                    $class .= ' c-user';
                    $title  = "title='" . zget($users, $feedback->resolvedBy) . "'";
                    break;
                case 'openedBy':
                    $class .= ' c-user';
                    $title  = "title='" . zget($users, $feedback->openedBy) . "'";
                    break;
                case 'resolvedBuild':
                    $class .= ' text-ellipsis';
                    $title  = "title='" . $feedback->resolvedBuild . "'";
                    break;
                case 'os':
                    $class .= ' text-ellipsis';
                    $title  = "title='" . $os . "'";
                    break;
                case 'browser':
                    $class .= ' text-ellipsis';
                    $title  = "title='" . $browser . "'";
                    break;
                case 'deadline':
                    $class .= ' text-center';
                    break;
            }

            if($id == 'deadline' && isset($feedback->delay) && $feedback->status == 'active') $class .= ' delayed';
            if(strpos(',type,execution,story,plan,task,openedBuild,', ",{$id},") !== false) $class .= ' text-ellipsis';

            echo "<td class='" . $class . "' $title>";
            if($this->config->edition != 'open') $this->loadModel('flow')->printFlowCell('feedback', $feedback, $id);
            switch($id)
            {
            case 'id':
                if($canBatchAction)
                {
                    echo html::checkbox('feedbackIDList', array($feedback->id => '')) . html::a($feedbackLink, sprintf('%03d', $feedback->id), '', "data-app='{$this->app->tab}'");
                }
                else
                {
                    printf('%03d', $feedback->id);
                }
                break;
            case 'pri':
                echo "<span class='label-pri label-pri-" . $feedback->pri . "' title='" . zget($this->lang->feedback->priList, $feedback->pri, $feedback->pri) . "'>";
                echo zget($this->lang->feedback->priList, $feedback->pri, $feedback->pri);
                echo "</span>";
                break;
            case 'confirmed':
                $class = 'confirm' . $feedback->confirmed;
                echo "<span class='$class' title='" . zget($this->lang->bug->confirmedList, $feedback->confirmed, $feedback->confirmed) . "'>" . zget($this->lang->feedback->confirmedList, $feedback->confirmed, $feedback->confirmed) . "</span> ";
                break;
            case 'title':
                //$showBranch = isset($this->config->bug->browse->showBranch) ? $this->config->bug->browse->showBranch : 1;
                //if(isset($branches[$feedback->branch]) and $showBranch) echo "<span class='label label-outline label-badge' title={$branches[$feedback->branch]}>{$branches[$feedback->branch]}</span> ";
                if($feedback->module and isset($modulePairs[$feedback->module])) echo "<span class='label label-gray label-badge'>{$modulePairs[$feedback->module]}</span> ";
                echo $canView ? html::a($feedbackLink, $feedback->title, null, "style='color: $feedback->color' data-app={$this->app->tab}") : "<span style='color: $feedback->color'>{$feedback->title}</span>";
                if($feedback->case) echo html::a(helper::createLink('testcase', 'view', "caseID=$feedback->case&version=$feedback->caseVersion"), "[" . $this->lang->testcase->common  . "#$feedback->case]", '', "class='feedback' title='$feedback->case'");
                break;
            case 'product':
                echo zget($allProducts,$feedback->product,'');
                break;
            case 'toTask':
                if(isset($tasks[$feedback->toTask]))
                {
                    $task = $tasks[$feedback->toTask];
                    echo common::hasPriv('task', 'view') ? html::a(helper::createLink('task', 'view', "taskID=$task->id", 'html', true), $task->name, '', "class='iframe'") : $task->name;
                }
                break;
            case 'type':
                echo zget($this->lang->feedback->typeList, $feedback->type);
                break;
            case 'status':
                echo "<span class='status-feedback status-{$feedback->status}'>";
                echo $this->processStatus('feedback', $feedback);
                echo  '</span>';
                break;
            case 'activatedCount':
                echo $feedback->activatedCount;
                break;
            case 'activatedDate':
                echo helper::isZeroDate($feedback->activatedDate) ? '' : substr($feedback->activatedDate, 5, 11);
                break;
            case 'found':
                echo zget($users, $feedback->found);
                break;
            case 'openedBy':
                echo zget($users, $feedback->openedBy);
                break;
            case 'openedDate':
                echo helper::isZeroDate($feedback->openedDate) ? '' : substr($feedback->openedDate, 5, 11);
                break;
            case 'assignedTo':
                $this->printAssignedHtml($feedback, $users);
                break;
            case 'assignedDate':
                echo helper::isZeroDate($feedback->assignedDate) ? '' : substr($feedback->assignedDate, 5, 11);
                break;
            case 'deadline':
                echo helper::isZeroDate($feedback->deadline) ? '' : '<span>' . substr($feedback->deadline, 5, 11) . '</span>';
                break;
            case 'resolvedBy':
                echo zget($users, $feedback->resolvedBy, $feedback->resolvedBy);
                break;
            case 'resolution':
                echo zget($this->lang->bug->resolutionList, $feedback->resolution);
                break;
            case 'resolvedDate':
                echo helper::isZeroDate($feedback->resolvedDate) ? '' : substr($feedback->resolvedDate, 5, 11);
                break;
            case 'resolvedBuild':
                echo $feedback->resolvedBuild;
                break;
            case 'closedBy':
                echo zget($users, $feedback->closedBy);
                break;
            case 'closedDate':
                echo helper::isZeroDate($feedback->closedDate) ? '' : substr($feedback->closedDate, 5, 11);
                break;
            case 'lastEditedBy':
                echo zget($users, $feedback->lastEditedBy);
                break;
            case 'lastEditedDate':
                echo helper::isZeroDate($feedback->lastEditedDate) ? '' : substr($feedback->lastEditedDate, 5, 11);
                break;
            case 'actions':
                echo $this->buildOperateMenu($feedback, 'browse');
                break;
            }
            echo '</td>';
        }
    }
    /**
     * Print assigned html.
     *
     * @param  object $bug
     * @param  array  $users
     * @access public
     * @return void
     */
    public function printAssignedHtml($feedback, $users)
    {
        $btnTextClass   = '';
        $btnClass       = '';
        $assignedToText = !empty($feedback->assignedTo) ? zget($users, $feedback->assignedTo) : $this->lang->feedback->noAssigned;
        if(empty($feedback->assignedTo)) $btnClass = $btnTextClass = 'assigned-none';
        if($feedback->assignedTo == $this->app->user->account) $btnClass = $btnTextClass = 'assigned-current';
        if(!empty($feedback->assignedTo) and $feedback->assignedTo != $this->app->user->account) $btnClass = $btnTextClass = 'assigned-other';

        $btnClass    .= $feedback->assignedTo == 'closed' ? ' disabled' : '';
        $btnClass    .= ' iframe btn btn-icon-left btn-sm';

        $assignToLink = helper::createLink('feedback', 'assignTo', "feedbackID=$feedback->id", '', true);
        $assignToHtml = html::a($assignToLink, "<i class='icon icon-hand-right'></i> <span title='" . zget($users, $feedback->assignedTo) . "'>{$assignedToText}</span>", '', "class='$btnClass'");

        echo !common::hasPriv('feedback', 'assignTo', $feedback) ? "<span style='padding-left: 21px' class='{$btnTextClass}'>{$assignedToText}</span>" : $assignToHtml;
    }
    /**
     * Build bug menu.
     *
     * @param  object $bug
     * @param  string $type
     * @access public
     * @return string
     */
    public function buildOperateMenu($feedback, $type = 'view')
    {
        $menu          = '';
        $params        = "feedbackID=$feedback->id";
        $extraParams   = "extras=fromType=feedback,fromID=$feedback->id";
        $moduleName = 'feedback';
        // if($this->app->tab == 'project')   $extraParams .= ",projectID={$bug->project}";
        // if($this->app->tab == 'execution') $extraParams .= ",executionID={$bug->execution}";
        $copyParams    = "productID=$feedback->product&branch=$feedback->branch&$extraParams";
        $convertParams = "productID=$feedback->product&branch=$feedback->branch&moduleID=0&from=feedback&feedbackID=$feedback->id";
        $toStoryParams = "productID=$feedback->product&$extraParams";

        // if(false) {
        //     $menu .= $this->buildMenu('bug', 'confirmBug', $params, $feedback, $type, 'ok', '', "iframe", true);
        //     if($type == 'view' and $feedback->status != 'closed') $menu .= $this->buildMenu('bug', 'assignTo', $params, $feedback, $type, '', '', "iframe", true);
        //     $menu .= $this->buildMenu('bug', 'resolve', $params, $feedback, $type, 'checked', '', "iframe showinonlybody", true);
        //     $menu .= $this->buildMenu('bug', 'close', $params, $feedback, $type, '', '', "text-danger iframe showinonlybody", true);
        //     if($type == 'view') $menu .= $this->buildMenu('bug', 'activate', $params, $feedback, $type, '', '', "text-success iframe showinonlybody", true);
        //     if($type == 'view' && $this->app->tab != 'product')
        //     {
        //         $menu .= $this->buildMenu('bug', 'toStory', $toStoryParams, $feedback, $type, $this->lang->icons['story'], '', '', '', "data-app='product' id='tostory'", $this->lang->bug->toStory);
        //         if(common::hasPriv('task', 'create') and !isonlybody()) $menu .= html::a('#toTask', "<i class='icon icon-check'></i><span class='text'>{$this->lang->bug->toTask}</span>", '', "data-app='qa' data-toggle='modal' class='btn btn-link'");
        //         $menu .= $this->buildMenu('bug', 'createCase', $convertParams, $feedback, $type, 'sitemap');
        //     }
        //     if($type == 'view')
        //     {
        //         $menu .= "<div class='divider'></div>";
        //         $menu .= $this->buildFlowMenu('bug', $feedback, $type, 'direct');
        //         $menu .= "<div class='divider'></div>";
        //     }
        //     $menu .= $this->buildMenu('bug', 'edit', $params, $feedback, $type);
        //     if($this->app->tab != 'product') $menu .= $this->buildMenu('bug', 'create', $copyParams, $feedback, $type, 'copy');
        //     if($type == 'view') $menu .= $this->buildMenu('bug', 'delete', $toStoryParams, $feedback, $type, 'trash', 'hiddenwin', "showinonlybody");
    
        //     return $menu;
        // }

        $menu .= $this->buildMenu('feedback', 'edit', $params, $feedback, $type);
        $menu .= $this->buildMenu('feedback', 'reply', $params, $feedback, $type,'restart','','iframe',true);
        if(true)
        {
            $menu .= "<div class='btn-group'>";
            $menu .= "<button type='button' class='btn icon-caret-down dropdown-toggle' data-toggle='context-dropdown' title='{$this->lang->more}' style='width: 16px; padding-left: 0px; border-radius: 4px;'></button>";
            $menu .= "<ul class='dropdown-menu pull-right text-center' role='menu' style='position: unset; min-width: auto; padding: 5px 6px;'>";
            $menu .= $this->buildMenu($moduleName, 'toStory' , $toStoryParams, $feedback, 'browse', $this->lang->icons['story'],'','btn-action',false,'',$this->lang->feedback->toStory);
            $menu .= $this->buildMenu($moduleName, 'toTask' , $toStoryParams, $feedback, 'browse', $this->lang->icons['task'],'','btn-action',false,'',$this->lang->feedback->toTask);
            $menu .= $this->buildMenu($moduleName, 'toBug' , $toStoryParams, $feedback, 'browse', $this->lang->icons['bug'],'','btn-action',false,'',$this->lang->feedback->toBug);
            $menu .= $this->buildMenu($moduleName, 'toTodo' , $toStoryParams, $feedback, 'browse', $this->lang->icons['todo'],'','btn-action',false,'',$this->lang->feedback->toTodo);
            $menu .= "</ul>";
            $menu .= "</div>";
        }

        $menu .= $this->buildMenu('feedback', 'close', $params, $feedback, $type);
        $menu .= $this->buildMenu('feedback', 'delete', $params, $feedback, $type,$this->lang->icons['trash']);
        return $menu;
    }


     /**
     * Get info of a feedback.
     *
     * @param  int    $feedbackID
     * @param  bool   $setImgSize
     * @access public
     * @return object
     */
    public function getById($feedbackID, $setImgSize = false)
    {
        return $this->dao->select("*")->from(TABLE_FEEDBACK)
        ->where('id')->eq($feedbackID)->fetch();        
    }

    public function update($feedbackID) 
    {
        $oldFeedback = $this->getById($feedbackID);
        $now = helper::now();
        $feedback = fixer::input('post')
        ->add('id', $feedbackID)
        ->add('editedDate', $now)
        ->setIF($this->post->assignedTo  != $oldFeedback->assignedTo, 'assignedDate', $now)
        ->setIF($this->post->assignedTo  == '' and $oldFeedback->status == 'closed', 'assignedTo', 'closed')
        ->remove('comment,files,labels,uid,contactListMenu')
        ->get();
        
        $feedback = $this->loadModel('file')->processImgURL($feedback, $this->config->feedback->editor->edit['id'], $this->post->uid);
        $this->dao->update(TABLE_FEEDBACK)->data($feedback, 'deleteFiles')
            ->autoCheck()
            ->checkIF($feedback->notifyEmail, 'notifyEmail', 'email')
            ->where('id')->eq((int)$feedbackID)
            ->exec();

    }

    public function getGrantProducts($flag=true)
    {
        if(!empty($append) and is_array($append)) $append = implode(',', $append);

        $views           = empty($append) ? $this->app->user->view->products : $this->app->user->view->products . ",$append";
        $projectProducts = $this->dao->select('t1.branch, t1.plan, t2.*')
            ->from(TABLE_PROJECTPRODUCT)->alias('t1')
            ->leftJoin(TABLE_PRODUCT)->alias('t2')
            ->on('t1.product = t2.id')
            ->where('t2.deleted')->eq(0)
            ->beginIF(!empty($projectID))->andWhere('t1.project')->eq($projectID)->fi()
            ->beginIF(!$this->app->user->admin and $this->config->vision == 'rnd')->andWhere('t2.id')->in($views)->fi()
            ->andWhere('t2.vision')->eq($this->config->vision)
            ->beginIF(strpos($status, 'noclosed') !== false)->andWhere('t2.status')->ne('closed')->fi()
            ->orderBy($orderBy . 't2.order asc')
            ->fetchAll();

        $products = array();
        foreach($projectProducts as $product)
        {
            if(!isset($products[$product->id]))
            {
                $products[$product->id] = $product;
                $products[$product->id]->branches = array();
                $products[$product->id]->plans    = array();
            }
            $products[$product->id]->branches[$product->branch] = $product->branch;
            if($product->plan) $products[$product->id]->plans[$product->plan] = $product->plan;

            unset($product->branch);
            unset($product->plan);
        }

        return $products;
    }


}
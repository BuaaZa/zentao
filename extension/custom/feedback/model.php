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
        // 提前检查文件数量与enternalId数量是否匹配，防止出现反馈已经保存成功，再提示数量不对的情况
        $enternalIds = array();
        if (isset($_POST['enternalId'])) {
            $enternalIds = explode(',', $_POST['enternalId']);
        }
        $enternalIdLen = count($enternalIds);
        if ($enternalIdLen>0 && $enternalIdLen!=count($_FILES)) {
            $this->loadModel('file');
            return array('result' => 'fail', 'message' => $this->lang->file->misscount);
        }
        // 提前检查文件数量与enternalId数量是否匹配，防止出现反馈已经保存成功，再提示数量不对的情况
        
        $extras = str_replace(array(',', ' '), array('&', ''), $extras);
        parse_str($extras, $output);

        $now = helper::now();
        $feedback = fixer::input('post')
            ->setDefault('openedBy', $this->app->user->account)
            ->setDefault('openedDate', $now)
            ->setDefault('updateDate',$now) //增加更新时间
            ->setDefault('product,', 0)
            ->setDefault('notifyEmail', '')
            ->setDefault('status','wait')
            // 外部数据的主键 chenjj 221230
            ->setDefault('feedbackExId', '')
            // 创建于字段用于区分是禅道还是天唧新增的数据 chenjj 221230
            ->setDefault('createdAt', '')
            ->setIF($this->post->assignedTo != '', 'assignedDate', $now)
            ->stripTags($this->config->feedback->editor->create['id'], $this->config->allowedTags)
            ->cleanInt('product,execution,module,severity')
            ->trim('title')
            ->join('mailto', ',')
            ->remove('files,labels,uid,oldTaskID,contactListMenu,region,lane,ticket')
            // 删除点一些zt_projectuseinfo表的数据 chenjj 221226
            ->remove('serverOS,serverCPU,middleware,database,terminalOS,terminalCPU,browser')
            // 删除publicType chenjj 221227
            ->remove('publicType')
            // 删除enternalId chenjj 221230
            ->remove('enternalId')
            ->get();
            
        if(!empty($feedback->expectDate) && !$this->isDatetime($feedback->expectDate)){
            return array('result' => 'fail', 'message' => $this->lang->feedback->expectDate . $this->lang->feedback->wrongDatetime);
        }
        if (!empty($feedback->contactWay) && !$this->isMobTel($feedback->contactWay)) {
            return array('result' => 'fail', 'message' => $this->lang->feedback->contactWay . $this->lang->feedback->wrongContactWay);
        }

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

            $this->createProjectUseInfo($feedbackID, $_POST);

            $this->file->updateObjectID($this->post->uid, $feedbackID, 'feedback');

            $enternalIds = array();
            if (isset($_POST['enternalId'])) {
                $enternalIds = explode(',', $_POST['enternalId']);
            }
            $ret = $this->loadModel('file')->saveUpload2('feedback', $feedbackID, '', 'files', 'labels', $enternalIds);
            if ($ret=='wrong') {
                $this->loadModel('file');
                return array('result' => 'fail', 'message' => $this->lang->file->misscount);
            }
            //empty($feedback->case) ? $this->loadModel('score')->create('feedback', 'create', $feedbackID) : $this->loadModel('score')->create('feedback', 'createFormCase', $feedback->case);

            /* Callback the callable method to process the related data for object that is transfered to bug. */
            if($from && is_callable(array($this, $this->config->feedback->fromObjects[$from]['callback']))) call_user_func(array($this, $this->config->feedback->fromObjects[$from]['callback']), $feedbackID);

            return array('status' => 'created', 'id' => $feedbackID);
        }
        return false;
    }    

    /**
     * Create a ProjectUseInfo
     */
    public function createProjectUseInfo($feedbackID = '0',$requestBody)
    {
        $projectUseInfo = array();
        $projectUseInfo['feedback'] = (int)$feedbackID;
        $projectUseInfo['serverOS'] = $this->getOrDefault($requestBody['serverOS']);
        $projectUseInfo['serverCPU'] = $this->getOrDefault($requestBody['serverCPU']);
        $projectUseInfo['middleware'] = $this->getOrDefault($requestBody['middleware']);
        $projectUseInfo['database'] = $this->getOrDefault($requestBody['database']);
        $projectUseInfo['terminalOS'] = $this->getOrDefault($requestBody['terminalOS']);
        $projectUseInfo['terminalCPU'] = $this->getOrDefault($requestBody['terminalCPU']);
        $projectUseInfo['browser'] = $this->getOrDefault($requestBody['browser']);
        $projectUseInfo['deleted'] = '0';

        $this->dao->insert(TABLE_PROJECTUSEINFO)->data($projectUseInfo)
            ->autoCheck()
            ->checkFlow()
            ->exec();
    }

    public function getOrDefault($target, $default=''): string
    {
        if (empty($target)) {
            return $default;
        }
        return $target;
    }

     /**
     * Get getFeedbacks.
     *
     * @param  array       $productIDList
     * @param  array       $types
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
    public function getFeedbacks($productIDList, $types, $keyword, $browseType, $moduleID, $queryID, $sort, $pager, $projectID)
    {
      /* Set modules and browse type. */
      $modules    = $moduleID ? $this->loadModel('tree')->getAllChildId($moduleID) : '0';
      $browseType = ($browseType == 'bymodule' and $this->session->bugBrowseType and $this->session->bugBrowseType != 'bysearch') ? $this->session->bugBrowseType : $browseType;
      $browseType = $browseType == 'bybranch' ? 'bymodule' : $browseType;

      if(strpos($sort, 'pri_') !== false) $sort = str_replace('pri_', 'priOrder_', $sort);
      if(strpos($sort, 'severity_') !== false) $sort = str_replace('severity_', 'severityOrder_', $sort);
      $feedbacks = array();
      if($browseType == 'all')          $feedbacks = $this->getAllFeedbacks($productIDList, $keyword, $modules, $types, $sort, $pager, $projectID);
      // 待处理的就只返回待处理的，不再返回'noreview'和'clarify' chenjj 230117
      elseif($browseType == 'wait')     $feedbacks = $this->getByStatus($productIDList, $keyword, $modules, $types, array($browseType), $sort, $pager, $projectID);
      elseif($browseType == 'review')   $feedbacks = $this->getByStatus($productIDList, $keyword, $modules, $types, array('noreview'), $sort, $pager, $projectID);
      elseif($browseType == 'unclosed') $feedbacks = $this->unClosedFeedbacks($productIDList, $keyword, $modules, $types, array('closed'), $sort, $pager, $projectID);
      elseif($browseType == 'public')   $feedbacks = $this->publicFeedbacks($productIDList, $keyword, $modules, $types, array(), $sort, $pager, $projectID);
      elseif($browseType == 'doing')    $feedbacks = array();
      elseif($browseType == 'accept')   $feedbacks = $this->acceptFeedbacks($productIDList, $keyword, $modules, $types, array(), $sort, $pager, $projectID);
      elseif($browseType == 'implemented')  $feedbacks = array();    
      elseif($browseType == 'openedbyme')  $feedbacks = $this->openedByMe($productIDList, $keyword, $modules, $types, array(), $sort, $pager, $projectID);
      elseif($browseType == 'closed')   $feedbacks = $this->getByStatus($productIDList, $keyword, $modules, $types, array('closed'), $sort, $pager, $projectID);
      elseif($browseType == 'clarify')   $feedbacks = $this->getByStatus($productIDList, $keyword, $modules, $types, array('clarify'), $sort, $pager, $projectID);
      // commenting->处理中 替换原有的 doing
      elseif($browseType == 'commenting')   $feedbacks = $this->getByStatus($productIDList, $keyword, $modules, $types, array('commenting'), $sort, $pager, $projectID);
      elseif ($browseType == 'bysearch') $feedbacks = $this->getBySearch($productIDList, $queryID, $sort, $pager, $projectID);
      elseif($browseType == 'tostory') $feedbacks = $this->getBySolution($productIDList,$keyword,array('tostory'), $sort, $pager, $projectID);
      elseif($browseType == 'tobug') $feedbacks = $this->getBySolution($productIDList,$keyword,array('tobug'), $sort, $pager, $projectID);
      elseif($browseType == 'totask') $feedbacks = $this->getBySolution($productIDList,$keyword,array('totask'), $sort, $pager, $projectID);
      elseif($browseType == 'replied') $feedbacks = $this->getByStatus($productIDList, $keyword, $modules, $types, array('replied'), $sort, $pager, $projectID);
      return $feedbacks;
    }

    public function getBySolution($productIDList,$keyword,$solution=array(), $orderBy, $pager, $projectID)
    {
        $openedBy = $_GET['openedBy'];
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
            ->where('product')->in($productIDList)
            ->beginIF(!empty($openedBy))->andWhere('openedBy')->eq($openedBy)->fi()
            ->andWhere('solution')->in($solution)
            ->andWhere('deleted')->eq(0)
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('title')->like($keyword)
            ->orWhere('`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
            ->orderBy($orderBy)->page($pager)
            ->fetchAll();
    }

     /**
     * 获取自己的或者是公开的的反馈
     */
    public function acceptFeedbacks($productIDList, $keyword, $modules, $types, $status, $orderBy, $pager, $projectID)
    {
        $openedBy = $_GET['openedBy'];
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
            ->where(1)
            ->andWhere('product')->in($productIDList)
            ->andWhere('type')->in($types)
            ->beginIF($modules)->andWhere('module')->in($modules)->fi()
            ->beginIF(!empty($openedBy))->andWhere('openedBy')->eq($openedBy)->fi()
            ->andWhere('status')->in($status)
            ->andWhere('deleted')->eq(0)
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('title')->like($keyword)
            ->orWhere('`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
            ->orderBy($orderBy)->page($pager)
            ->fetchAll();
    }

    /**
     * 获取自己的或者是公开的的反馈
     */
    public function openedByMe($productIDList, $keyword, $modules, $types, $status, $orderBy, $pager, $projectID)
    {
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
            ->where(1)
            ->andWhere('product')->in($productIDList)
            ->andWhere('type')->in($types)
            ->beginIF($modules)->andWhere('module')->in($modules)->fi()  
            ->orWhere("openedBy")->eq($this->app->user->account)
            ->andWhere('deleted')->eq(0)
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('title')->like($keyword)
            ->orWhere('`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
            ->orderBy($orderBy)->page($pager)
            ->fetchAll();
    }

    /**
     * 获取所有公开的feedbacks
     */
    public function publicFeedbacks($productIDList, $keyword, $modules, $types, $status, $orderBy, $pager, $projectID)
    {
        $openedBy = $_GET['openedBy'];
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
        ->where(1)
        ->andWhere('product')->in($productIDList)
        ->andWhere('type')->in($types)
        ->beginIF($modules)->andWhere('module')->in($modules)->fi()
        ->beginIF(!empty($openedBy))->andWhere('openedBy')->eq($openedBy)->fi()
        ->andWhere('public')->eq(1)
        ->beginIF(!empty($keyword))->andWhere()
        ->markLeft(1)
        ->where('title')->like($keyword)
        ->orWhere('`desc`')->like($keyword)
        ->markRight(1)
        ->fi()
        ->andWhere('deleted')->eq(0)
        ->orderBy($orderBy)->page($pager)
        ->fetchAll();
    }
    /**
     * 获取自己的或者是公开的的反馈
     */
    public function unClosedFeedbacks($productIDList, $keyword, $modules, $types, $status, $orderBy, $pager, $projectID)
    {
        $openedBy = $_GET['openedBy'];
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
            ->where(1)
            ->andWhere('product')->in($productIDList)
            ->andWhere('type')->in($types)
            ->beginIF($modules)->andWhere('module')->in($modules)->fi()
            ->beginIF(!empty($openedBy))->andWhere('openedBy')->eq($openedBy)->fi()
            ->beginIF(true)
            ->andWhere()
            ->markLeft(1)
            ->Where('public')->eq(1)
            ->beginIF(empty($openedBy))->orWhere("openedBy")->eq($this->app->user->account)->fi()
            ->markRight(1)
            ->fi()
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('title')->like($keyword)
            ->orWhere('`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
            ->andWhere('status')->notin($status)
            ->andWhere('deleted')->eq(0)
            ->orderBy($orderBy)->page($pager)
            ->fetchAll();
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
    public function getAllFeedbacks($productIDList, $keyword, $modules, $types, $orderBy, $pager = null, $projectID = 0)
    {
        $openedBy = $_GET['openedBy'];
        // $isAdmin = common::hasPriv('feedback','admin');
        $feedbacks = $this->dao->select("t1.*, t1.title as planTitle, IF(t1.`pri` = 0, {$this->config->maxPriValue}, t1.`pri`) as priOrder")->from(TABLE_FEEDBACK)->alias('t1')
            ->where('t1.product')->in($productIDList)
            ->beginIF($modules)->andWhere('t1.module')->in($modules)->fi()
            ->beginIF(!empty($openedBy))->andWhere('t1.openedBy')->eq($openedBy)->fi()
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('t1.title')->like($keyword)
            ->orWhere('t1.`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
            // ->beginIF(!$isAdmin)->andWhere('t1.public')->eq(1)->orWhere("t1.openedBy")->eq($this->app->user->account)->fi()
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t1.type')->in($types)
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('title')->like($keyword)
            ->orWhere('`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
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
    public function getByStatus($productIDList, $keyword, $modules, $types, $status, $orderBy, $pager, $projectID)
    {
        $openedBy = $_GET['openedBy'];
        return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
            ->where('product')->in($productIDList)
            ->beginIF($modules)->andWhere('module')->in($modules)->fi()
            ->beginIF(!empty($openedBy))->andWhere('openedBy')->eq($openedBy)->fi()
            ->andWhere('type')->in($types)
            ->andWhere('status')->in($status)
            ->andWhere('deleted')->eq(0)
            ->beginIF(!empty($keyword))->andWhere()
            ->markLeft(1)
            ->where('title')->like($keyword)
            ->orWhere('`desc`')->like($keyword)
            ->markRight(1)
            ->fi()
            ->orderBy($orderBy)->page($pager)
            ->fetchAll();
    }

    /**
    * Get getByStatusNotin the status is not in $status.
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
   public function getByStatusNotin($productIDList, $keyword, $modules, $types, $status, $orderBy, $pager, $projectID)
   {
       return $this->dao->select("*, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)
           ->where('product')->in($productIDList)
           ->beginIF($modules)->andWhere('module')->in($modules)->fi()
           ->andWhere('status')->notin($status)
           ->andWhere('type')->in($types)
           ->andWhere('deleted')->eq(0)
           ->beginIF(!empty($keyword))->andWhere()
           ->markLeft(1)
           ->where('title')->like($keyword)
           ->orWhere('`desc`')->like($keyword)
           ->markRight(1)
           ->fi()
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

    public function canExecAction($feedback,$action)
    {
        $this->loadModel('setting');
        $configItems  = $this->setting->getItems('owner=system&module=feedback&keys');
        foreach($configItems as $configItem)
        {
            if($configItem->key == 'forceReview')$forceReview = $configItem->value;
            if($configItem->key == 'needReview')$needReview = $configItem->value;
            if($configItem->key == 'forceNotReview')$forceNotReview = $configItem->value;
            if($configItem->key == 'reviewer')$reviewer = $configItem->value;
        }
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

        if($type == 'view')
        {
            $menu .= $this->buildMenu('feedback', 'comment', $params.'&type=commented', $feedback, $type,'confirm','','iframe',true);
        }

        $menu .= $this->buildMenu('feedback', 'edit', $params, $feedback, $type,'edit');
        $this->loadModel('setting');
        $reviewer = $this->setting->getItem('owner=system&module=feedback&key=reviewer');
        if($feedback->status =='noreview' &&  $this->app->user->account == $reviewer)
        {
            $menu .= $this->buildMenu('feedback', 'review', $params, $feedback, $type,'glasses','','iframe',true);
        }
        else 
        {
            //$menu .= $this->buildMenu('feedback', 'reply', $params, $feedback, $type,'restart','','iframe',true);
        }
        

        if($feedback->status == 'wait' && $feedback->assignedTo == $this->app->user->account)
        {
            $menu .= "<div class='btn-group'>";
            $menu .= "<button type='button' class='btn icon-caret-down dropdown-toggle' data-toggle='context-dropdown' title='{$this->lang->more}' style='width: 16px; padding-left: 0px; border-radius: 4px;'></button>";
            $menu .= "<ul class='dropdown-menu pull-right text-center' role='menu' style='position: unset; min-width: auto; padding: 5px 6px;'>";
            $menu .= $this->buildMenu($moduleName, 'toStory' , $toStoryParams, $feedback, 'browse', $this->lang->icons['story'],'','btn-action',false,'',$this->lang->feedback->toStory);
            //$menu .= $this->buildMenu($moduleName, 'toTask' , $toStoryParams, $feedback, 'browse', $this->lang->icons['task'],'','iframe btn-action',false,'',$this->lang->feedback->toTask);
            $menu .= '<a href="#toTask" data-toggle="modal" data-id="'.$feedback->id.'" data-product="'.$feedback->product.'" onclick="getFeedbackID(this)" class="btn btn-action" title="转任务"><i class="icon icon-check-sign"></i> </a>';
            $menu .= $this->buildMenu($moduleName, 'toBug' , $toStoryParams, $feedback, 'browse', $this->lang->icons['bug'],'','btn-action',false,'',$this->lang->feedback->toBug);
            // $menu .= $this->buildMenu($moduleName, 'toTodo' , $toStoryParams, $feedback, 'browse', $this->lang->icons['todo'],'','btn-action',false,'',$this->lang->feedback->toTodo);
            $menu .= "</ul>";
            $menu .= "</div>";
        }

        if ($feedback->status != 'clarify') {
            // 提出待完善的问题不能关闭的需求  chenjj 221230
            $menu .= $this->buildMenu('feedback', 'close', $params, $feedback, $type, 'off', '', 'iframe', true);
        }
        $menu .= $this->buildMenu('feedback', 'delete', $params, $feedback, $type,$this->lang->icons['trash'],'hiddenwin','showinonlybody');
        return $menu;
    }

    public function isClickable($feedback, $action)
    {
        $action = strtolower($action);
        if( $action!="delete" && $feedback->status == 'closed'){
           return false;
        }
        // 只有自己可以编辑
        if($action == 'edit' && $feedback->openedBy !=  $this->app->user->account){
            return false;
        }
        return true;
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

    /**
     * 根据id获取反馈（没有被删除的）
     */
    public function getByIdNotDeleted($feedbackID)
    {
        return $this->dao->select("*")
        ->from(TABLE_FEEDBACK)
        ->where('deleted')->eq(0)
        ->andWhere('id')->eq($feedbackID)
        ->fetch();        
    }

    /**
     * 评审时更新反馈单状态 chenjj 230115
     */
    public function updateStatusOnReview($feedbackID,$status,$feedback)
    {
        if($status == 'pass'){
            $status = 'wait';
        }
        
        //reviewedBy
        $now      = helper::now();
        // $date     = helper::today();
        $updateFeedbackInfo    = fixer::input('post')
        ->setDefault('reviewedDate', $now)         
        ->setIF(!$this->post->assignedTo, 'assignedTo', '')   
        ->add('reviewedBy', $feedback->reviewedBy . ',' . $this->app->user->account)
        ->get();
        $this->dao->update(TABLE_FEEDBACK)   
        ->set('status')->eq($status) 
        ->set('updateDate')->eq($now) // 增更新时间
        ->set('assignedTo')->eq($updateFeedbackInfo->assignedTo)
        ->set('reviewedDate')->eq($now)
        ->set('reviewedBy')->eq($feedback->reviewedBy . ',' . $this->app->user->account)
        ->where('id')->eq((int)$feedbackID)
        ->exec();
    }
    
    /**
     * 更新反馈单状态 chenjj 230115
     */
    public function updateStatus($from,$feedbackID,$status,$oldstatus)
    {
        $this->dao->update(TABLE_FEEDBACK)
        ->set('status')->eq('replied')
        ->where('id')->eq((int)$feedbackID)
        ->exec();

        $this->loadModel('action');
        $actionID = $this->action->create('feedback', $feedbackID, 'processed', '');
    }

    public function update($feedbackID)
    {
        $oldFeedback = $this->getById($feedbackID);
        $now = helper::now();
        $feedback = fixer::input('post')
        ->add('id', $feedbackID)
        ->add('editedDate', $now)
        ->add('updateDate',$now) // 增加更新时间
        ->setDefault('editedBy', $this->app->user->account)
        ->setDefault('notifyEmail', '')
        ->setIF($this->post->assignedTo  != $oldFeedback->assignedTo, 'assignedDate', $now)
       // ->setIF($this->post->assignedTo  == '' and $oldFeedback->status == 'closed', 'assignedTo', 'closed')
        ->setIF($oldFeedback->status == 'clarify', 'status', 'noreview')
        ->stripTags($this->config->task->editor->edit['id'], $this->config->allowedTags)
        ->remove('comment,files,labels,uid,contactListMenu')
        // 删除点一些zt_projectuseinfo表的数据 chenjj 221226
        ->remove('serverOS,serverCPU,middleware,database,terminalOS,terminalCPU,browser')
        // 删除publicType chenjj 221227
        ->remove('publicType')
        ->get();

        $feedback = $this->loadModel('file')->processImgURL($feedback, $this->config->feedback->editor->edit['id'], $this->post->uid);
        $this->dao->update(TABLE_FEEDBACK)->data($feedback, 'deleteFiles')
            ->autoCheck()
            ->checkIF($feedback->notifyEmail, 'notifyEmail', 'email')
            ->where('id')->eq((int)$feedbackID)
            ->exec();

        if (!dao::isError()) {
            $this->updateProjectUseInfo($feedbackID, $_POST);
        }
        return common::createChanges($oldFeedback, $feedback);
    }


    /**
     * Update a ProjectUseInfo
     */
    public function updateProjectUseInfo($feedbackID = '0', $requestBody)
    {
        $oldProjectUseInfo = $this->dao->select('*')
            ->from(TABLE_PROJECTUSEINFO)
            ->where('feedback')->eq((int)$feedbackID)
            ->fetch();
        if (!$oldProjectUseInfo) {
            $this->createProjectUseInfo($feedbackID, $requestBody);
            return;
        }

        $projectUseInfo = array();
        $projectUseInfo['feedback'] = (int)$feedbackID;
        $projectUseInfo['serverOS'] = $this->getOrDefault($requestBody['serverOS'], $oldProjectUseInfo->serverOS);
        $projectUseInfo['serverCPU'] = $this->getOrDefault($requestBody['serverCPU'], $oldProjectUseInfo->serverCPU);
        $projectUseInfo['middleware'] = $this->getOrDefault($requestBody['middleware'], $oldProjectUseInfo->middleware);
        $projectUseInfo['database'] = $this->getOrDefault($requestBody['database'], $oldProjectUseInfo->database);
        $projectUseInfo['terminalOS'] = $this->getOrDefault($requestBody['terminalOS'], $oldProjectUseInfo->terminalOS);
        $projectUseInfo['terminalCPU'] = $this->getOrDefault($requestBody['terminalCPU'], $oldProjectUseInfo->terminalCPU);
        $projectUseInfo['browser'] = $this->getOrDefault($requestBody['browser'], $oldProjectUseInfo->browser);
        $projectUseInfo['deleted'] = '0';

        $this->dao->update(TABLE_PROJECTUSEINFO)->data($projectUseInfo)
        ->autoCheck()
        ->checkFlow()
        ->where('id')->eq((int)$oldProjectUseInfo->id)
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

    public function exportFeedbacks()
    {
        $exportTime = helper::now();
        $exportType = $_POST['exportType'];
        $feedbacksArray = $this->dao->select("id,solution,status,subStatus,openedBy,openedDate,reviewedBy,reviewedDate,processedBy,processedDate,closedBy,closedDate,closedReason,editedBy,editedDate,assignedTo,assignedDate,feedbackExId")->from(TABLE_FEEDBACK)
        ->where('feedbackExId')->ne('')
        ->beginIF($exportType == 'inc')
        ->andWhere('(`updateDate` > `exportDate` OR `exportDate` IS NULL)')
        ->fi()
        ->fetchAll();

        // 增量时再更新导出时间
        if($exportType=='inc')
        {
            // $updateIds = array_column($feedbacksArray,'id');
            // $this->dao->update(TABLE_FEEDBACK)
            // ->set('exportDate')->eq($exportTime)
            // ->where('id')->in($updateIds)
            // ->exec();
        }
        return $feedbacksArray;
    }

    public function buildSearchForm($productID, $products, $queryID, $actionURL)
    {
        $projectID     = $this->lang->navGroup->bug == 'qa' ? 0 : $this->session->project;
        $productParams = ($productID and isset($products[$productID])) ? array($productID => $products[$productID]) : $products;
        $productParams = $productParams + array('all' => $this->lang->bug->allProduct);
        $projectParams = $this->getProjects($productID);
        $projectParams = $projectParams + array('all' => $this->lang->bug->allProject);

        /* Get all modules. */
        $modules = array();
        $this->loadModel('tree');
        if($productID) $modules = $this->tree->getOptionMenu($productID, 'bug', 0, '');
        if(!$productID)
        {
            foreach($products as $id => $productName) $modules += $this->tree->getOptionMenu($id, 'bug');
        }

        $this->config->feedback->search['actionURL'] = $actionURL;
        $this->config->feedback->search['queryID']   = $queryID;
        if($this->config->systemMode == 'new') $this->config->feedback->search['params']['project']['values'] = $projectParams;
        $this->config->feedback->search['params']['product']['values']       = $productParams;
        // $this->config->feedback->search['params']['plan']['values']          = $this->loadModel('productplan')->getPairs($productID);
        $this->config->feedback->search['params']['module']['values']        = $modules;
        // $this->config->feedback->search['params']['execution']['values']     = $this->loadModel('product')->getExecutionPairsByProduct($productID, 0, 'id_desc', $projectID);
        // $this->config->feedback->search['params']['severity']['values']      = array(0 => '') + $this->lang->bug->severityList; //Fix bug #939.
        // $this->config->feedback->search['params']['openedBuild']['values']   = $this->loadModel('build')->getBuildPairs($productID, 'all', 'withbranch');
        // $this->config->feedback->search['params']['resolvedBuild']['values'] = $this->config->feedback->search['params']['openedBuild']['values'];

        $this->loadModel('search')->setSearchParams($this->config->feedback->search);
    }

    /**
     * Get project list.
     *
     * @param  int $productID
     * @access public
     * @return array
     */
    public function getProjects($productID)
    {
        return $this->dao->select('t1.id,t1.name')
            ->from(TABLE_PROJECT)->alias('t1')
            ->leftjoin(TABLE_PROJECTPRODUCT)->alias('t2')->on('t1.id = t2.project')
            ->where('t1.type')->eq('project')
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t2.product')->eq($productID)
            ->fetchPairs();
    }
    
    /**
     * Get feedbacks by search.
     *
     * @param  array       $productIDList
     * @param  int         $queryID
     * @param  string      $orderBy
     * @param  object      $pager
     * @param  int         $projectID
     * @access public
     * @return array
     */
    public function getBySearch($productIDList, $queryID = 0, $orderBy = '' , $pager = null, $projectID = 0)
    {
        if($queryID)
        {
            $query = $this->loadModel('search')->getQuery($queryID);
            if($query)
            {
                $this->session->set('feedbackQuery', $query->sql);
                $this->session->set('feedbackForm', $query->form);
            }
            else
            {
                $this->session->set('feedbackQuery', ' 1 = 1');
            }
        }
        else
        {
            if($this->session->feedbackQuery == false) $this->session->set('feedbackQuery', ' 1 = 1');
        }

        $feedbackQuery = $this->getFeedbacksQuery($this->session->feedbackQuery);

        /* If search criteria don't have products, append the selected product from the top left dropdown-menu. */
        if(is_array($productIDList)) $productIDList = implode(',', $productIDList);
        if(strpos($feedbackQuery, '`product`') === false)
        {
            $feedbackQuery .= ' AND `product` IN (' . $productIDList . ')';
        }
        else
        {
            $productParis  = $this->loadModel('product')->getPairs();
            $productIDList = array_keys($productParis);

            if(!empty($productIDList))
            {
                $productIDList = implode(',', $productIDList);
                $feedbackQuery     .= ' AND `product` IN (' . $productIDList . ')';
            }
        }

        $feedbacks = $this->dao->select("*, title as planTitle, IF(`pri` = 0, {$this->config->maxPriValue}, `pri`) as priOrder")->from(TABLE_FEEDBACK)->where($feedbackQuery)
            // ->beginIF(!$this->app->user->admin)->andWhere('execution')->in('0,' . $this->app->user->view->sprints)->fi()
            // ->beginIF($projectID)
            // ->andWhere('project', true)->eq($projectID)
            // ->orWhere('project')->eq(0)
            // ->andWhere('openedBuild')->eq('trunk')
            // ->markRight(1)
            // ->fi()

            ->andWhere('deleted')->eq(0)
            ->beginIF(!$this->app->user->admin)->andWhere('project')->in('0,' . $this->app->user->view->projects)->fi()
            ->orderBy($orderBy)->page($pager)->fetchAll();
        return $feedbacks;
    }

    /**
     * Get feedback query.
     *
     * @param  string $feedbacksQuery
     * @access public
     * @return string
     */
    public function getFeedbacksQuery($feedbacksQuery)
    {
        $allProduct = "`product` = 'all'";
        if(strpos($feedbacksQuery, $allProduct) !== false)
        {
            $products = $this->app->user->view->products;
            $feedbacksQuery = str_replace($allProduct, '1', $feedbacksQuery);
            $feedbacksQuery = $feedbacksQuery . ' AND `product` ' . helper::dbIN($products);
        }

        $allProject = "`project` = 'all'";
        if(strpos($feedbacksQuery, $allProject) !== false)
        {
            $projectIDList = $this->getAllProjectIds();
            if(is_array($projectIDList)) $projectIDList = implode(',', $projectIDList);
            $feedbacksQuery = str_replace($allProject, '1', $feedbacksQuery);
            $feedbacksQuery = $feedbacksQuery . ' AND `project` in (' . $projectIDList . ')';
        }

        /* Fix bug #2878. */
        if(strpos($feedbacksQuery, ' `resolvedDate` ') !== false) $feedbacksQuery = str_replace(' `resolvedDate` ', " `resolvedDate` != '0000-00-00 00:00:00' AND `resolvedDate` ", $feedbacksQuery);
        if(strpos($feedbacksQuery, ' `closedDate` ') !== false)   $feedbacksQuery = str_replace(' `closedDate` ', " `closedDate` != '0000-00-00 00:00:00' AND `closedDate` ", $feedbacksQuery);
        if(strpos($feedbacksQuery, ' `story` ') !== false)
        {
            preg_match_all("/`story`[ ]+(NOT *)?LIKE[ ]+'%([^%]*)%'/Ui", $feedbacksQuery, $out);
            if(!empty($out[2]))
            {
                foreach($out[2] as $searchValue)
                {
                    $story = $this->dao->select('id')->from(TABLE_STORY)->alias('t1')
                        ->leftJoin(TABLE_STORYSPEC)->alias('t2')->on('t1.id=t2.story')
                        ->where('t1.title')->like("%$searchValue%")
                        ->orWhere('t1.keywords')->like("%$searchValue%")
                        ->orWhere('t2.spec')->like("%$searchValue%")
                        ->orWhere('t2.verify')->like("%$searchValue%")
                        ->fetchPairs('id');
                    if(empty($story)) $story = array(0);

                    $feedbacksQuery = preg_replace("/`story`[ ]+(NOT[ ]*)?LIKE[ ]+'%$searchValue%'/Ui", '`story` $1 IN (' . implode(',', $story) .')', $feedbacksQuery);
                }
            }
            $feedbacksQuery .= ' AND `story` != 0';
        }
        return $feedbacksQuery;
    }

    /**
     * 验证是不是手机号码或电话号码
     */
    function isMobTel($numberstr)
    {
        $isMob="/^1[3-9]{1}[0-9]{9}$/";
        $isTel="/^([0-9]{3,4}-?)?[0-9]{7,8}$/";
        if (!preg_match($isMob, $numberstr) && !preg_match($isTel, $numberstr)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 验证是不是datetime日期格式
     */
    function isDatetime($str)
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $str) !== FALSE;
    }


}
<?php
/**
 * The model file of projectStory module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     projectStory
 * @version     $Id
 * @link        http://www.zentao.net
 */
class qastoryModel extends model
{
    /**
     * Set the menu.
     *
     * @param  array $products
     * @param  int   $productID
     * @param  int   $branch
     * @access public
     * @return void
     */
    public function setMenu($products = array(), $productID = 0, $branch = 0)
    {
        /* Determine if the product is accessible. */
        if($products and (!isset($products[$productID]) or !$this->loadModel('product')->checkPriv($productID))) $this->loadModel('product')->accessDenied();

        if(empty($productID)) $productID = key($products);
        $this->loadModel('product')->setMenu($products, $productID, $branch);
        $this->lang->modulePageNav = $this->product->select($products, $productID, 'projectstory', $this->app->rawMethod, '', $branch);
    }

    /**
     * Get the stories for execution linked.
     *
     * @param  int    $projectID
     * @param  array  $storyIdList
     * @access public
     * @return array
     */
    public function getExecutionStories($projectID, $storyIdList = array())
    {
        $stories     = array();
        $storyIdList = (array)$storyIdList;

        if(empty($storyIdList)) return $stories;

        $stories = $this->dao->select('t2.id as id, t2.title as title, t3.id as executionID, t3.name as execution')->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story=t2.id')
            ->leftJoin(TABLE_EXECUTION)->alias('t3')->on('t1.project=t3.id')
            ->where('t1.story')->in($storyIdList)
            ->andWhere('t3.type')->in('sprint,stage,kanban')
            ->andWhere('t3.project')->eq($projectID)
            ->andWhere('t3.deleted')->eq(0)
            ->fetchAll('id');

        return $stories;
    }

    public function batchCreate($storyID = 0, $branch = 0, $type = 'story')
    {

        $this->loadModel('action');
        $branch    = (int)$branch;
        $storyID = (int)$storyID;
        $now       = helper::now();
        $mails     = array();
        $stories   = fixer::input('post')->get();
        $faStory = $this->loadModel('story')->getById($storyID);
        if(!$faStory){
            dao::$errors['message'] = '父需求不存在';
        }
        elseif($faStory->type == 'taskPoint'){
            dao::$errors['message'] = '父需求不能为功能点';
        }


        $result  = $this->loadModel('common')->removeDuplicate('story', $stories, "product={$faStory->product}");
        $stories = $result['data'];

        if(isset($stories->uploadImage)) $this->loadModel('file');

        $now = helper::now();
        $data         = array();
        foreach($stories->title as $i => $title)
        {
            if(empty($title)) continue;
            
            $story = new stdclass();
            $story->type       = $type;
            $story->title      = trim($stories->title[$i]);
            $story->version      = 1;
            $story->color      = $stories->color[$i];
            $story->plan = '';
            $story->notifyEmail = '';
            $story->openedBy = $this->app->user->account;
            $story->openedDate = $now;
            $story->feedbackBy = '';
            $story->fromBug = 0;
            $story->assignedTo = '';
            $story->product    = $faStory->product;
            $story->parent = $faStory->id;
            $story->status = 'active';
            $story->stage = 'projected';
            
            $data[$i] = $story;
        }

        $link2Plans = array();
        foreach($data as $i => $story)
        {
            $this->dao->insert(TABLE_STORY)->data($story)->autoCheck()->checkFlow()->exec();
            if(dao::isError())
            {
                echo js::error(dao::getError());
                return print(js::reload('parent'));
            }

            $storyID = $this->dao->lastInsertID();
            $this->setStage($storyID);

            $specData = new stdclass();
            $specData->story   = $storyID;
            $specData->version = 1;
            $specData->title   = $stories->title[$i];
            $specData->spec    = '';
            $specData->verify  = '';
            if(!empty($stories->spec[$i]))  $specData->spec   = nl2br($stories->spec[$i]);
            if(!empty($stories->verify[$i]))$specData->verify = nl2br($stories->verify[$i]);


            $this->dao->insert(TABLE_STORYSPEC)->data($specData)->exec();

            $this->executeHooks($storyID);

            $actionID = $this->action->create('story', $storyID, 'Opened', '');
            if(!dao::isError()) $this->loadModel('score')->create('story', 'create',$storyID);
            $mails[$i] = new stdclass();
            $mails[$i]->storyID  = $storyID;
            $mails[$i]->actionID = $actionID;
        }

        return $mails;
    }

    public function setStage($storyID)
    {
        $this->loadModel('kanban');

        $storyID = (int)$storyID;
        $account = $this->app->user->account;

        /* Get projects which status is doing. */
        $oldStages = $this->dao->select('*')->from(TABLE_STORYSTAGE)->where('story')->eq($storyID)->fetchAll('branch');
        $this->dao->delete()->from(TABLE_STORYSTAGE)->where('story')->eq($storyID)->exec();

        $story = $this->dao->findById($storyID)->from(TABLE_STORY)->fetch();
        if(!empty($story->stagedBy) and $story->status != 'closed') return false;

        $product    = $this->dao->findById($story->product)->from(TABLE_PRODUCT)->fetch();
        $executions = $this->dao->select('t1.project,t3.branch')->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.id')
            ->leftJoin(TABLE_PROJECTPRODUCT)->alias('t3')->on('t1.project = t3.project')
            ->where('t1.story')->eq($storyID)
            ->andWhere('t2.deleted')->eq(0)
            ->fetchPairs('project', 'branch');

        $hasBranch = ($product and $product->type != 'normal' and empty($story->branch));
        $stages    = array();
        if($hasBranch and $story->plan)
        {
            $plans = $this->dao->select('*')->from(TABLE_PRODUCTPLAN)->where('id')->in($story->plan)->fetchPairs('branch', 'branch');
            foreach($plans as $branch) $stages[$branch] = 'planned';
        }

        /* When the status is closed, stage is also changed to closed. */
        if($story->status == 'closed')
        {
            $this->dao->update(TABLE_STORY)->set('stage')->eq('closed')->where('id')->eq($storyID)->exec();
            foreach($stages as $branch => $stage) $this->dao->replace(TABLE_STORYSTAGE)->set('story')->eq($storyID)->set('branch')->eq($branch)->set('stage')->eq('closed')->exec();
            foreach($executions as $execution => $branch)
            {
                $this->dao->replace(TABLE_STORYSTAGE)->set('story')->eq($storyID)->set('branch')->eq($branch)->set('stage')->eq('closed')->exec();
                $this->kanban->updateLane($execution, 'story', $storyID);
            }
            return false;
        }

        /* If no executions, in plan, stage is planned. No plan, wait. */
        if(!$executions)
        {
            $this->dao->update(TABLE_STORY)->set('stage')->eq('wait')->where('id')->eq($storyID)->andWhere('plan')->eq('')->exec();

            foreach($stages as $branch => $stage)
            {
                if(isset($oldStages[$branch]))
                {
                    $oldStage = $oldStages[$branch];
                    if(!empty($oldStage->stagedBy))
                    {
                        $this->dao->replace(TABLE_STORYSTAGE)->data($oldStage)->exec();
                        continue;
                    }
                }
                $this->dao->replace(TABLE_STORYSTAGE)->set('story')->eq($storyID)->set('branch')->eq($branch)->set('stage')->eq($stage)->exec();
            }
            $this->dao->update(TABLE_STORY)->set('stage')->eq('planned')->where('id')->eq($storyID)->andWhere("(plan != '' AND plan != '0')")->exec();
        }

        if($hasBranch)
        {
            foreach($executions as $executionID => $branch) $stages[$branch] = 'projected';
        }

        /* Search related tasks. */
        $tasks = $this->dao->select('type,execution,status')->from(TABLE_TASK)
            ->where('execution')->in(array_keys($executions))
            ->andWhere('type')->in('devel,test')
            ->andWhere('story')->eq($storyID)
            ->andWhere('deleted')->eq(0)
            ->andWhere('status')->ne('cancel')
            ->andWhere('closedReason')->ne('cancel')
            ->fetchGroup('type');

        /* No tasks, then the stage is projected. */
        if(!$tasks and $executions)
        {
            foreach($stages as $branch => $stage)
            {
                if(isset($oldStages[$branch]))
                {
                    $oldStage = $oldStages[$branch];
                    if(!empty($oldStage->stagedBy))
                    {
                        $this->dao->replace(TABLE_STORYSTAGE)->data($oldStage)->exec();
                        continue;
                    }
                }
                $this->dao->replace(TABLE_STORYSTAGE)->set('story')->eq($storyID)->set('branch')->eq($branch)->set('stage')->eq('projected')->exec();
            }
            $this->dao->update(TABLE_STORY)->set('stage')->eq('projected')->where('id')->eq($storyID)->exec();
        }

        /* Get current stage and set as default value. */
        $currentStage = $story->stage;
        $stage        = $currentStage;

        /* Cycle all tasks, get counts of every type and every status. */
        $branchStatusList = array();
        $branchDevelTasks = array();
        $branchTestTasks  = array();
        $statusList['devel'] = array('wait' => 0, 'doing' => 0, 'done'=> 0, 'pause' => 0);
        $statusList['test']  = array('wait' => 0, 'doing' => 0, 'done'=> 0, 'pause' => 0);
        foreach($tasks as $type => $typeTasks)
        {
            foreach($typeTasks as $task)
            {
                $status = $task->status ? $task->status : 'wait';
                $status = $status == 'closed' ? 'done' : $status;

                $branch = $executions[$task->execution];
                if(!isset($branchStatusList[$branch])) $branchStatusList[$branch] = $statusList;
                if(!isset($branchStatusList[$branch][$task->type])) $branchStatusList[$branch][$task->type] = array();
                if(!isset($branchStatusList[$branch][$task->type][$status])) $branchStatusList[$branch][$task->type][$status] = 0;
                $branchStatusList[$branch][$task->type][$status] ++;
                if($type == 'devel')
                {
                    if(!isset($branchDevelTasks[$branch])) $branchDevelTasks[$branch] = 0;
                    $branchDevelTasks[$branch] ++;
                }
                elseif($type == 'test')
                {
                    if(!isset($branchTestTasks[$branch])) $branchTestTasks[$branch] = 0;
                    $branchTestTasks[$branch] ++;
                }
            }
        }

        /**
         * Judge stage according to the devel and test tasks' status.
         *
         * 1. one doing devel task, all test tasks waiting, set stage as developing.
         * 2. some devel tasks done, all test tasks not done, set stage as developing.
         * 3. all devel tasks done, all test tasks waiting, set stage as developed.
         * 4. one test task doing, set stage as testing.
         * 5. all test tasks done, still some devel tasks not done(wait, doing), set stage as testing.
         * 6. all test tasks done, all devel tasks done, set stage as tested.
         */
        foreach($branchStatusList as $branch => $statusList)
        {
            $stage      = 'projected';
            $testTasks  = isset($branchTestTasks[$branch]) ? $branchTestTasks[$branch] : 0;
            $develTasks = isset($branchDevelTasks[$branch]) ? $branchDevelTasks[$branch] : 0;
            if($statusList['devel']['doing'] > 0 and $statusList['test']['wait'] == $testTasks) $stage = 'developing';
            if($statusList['devel']['wait'] > 0 and $statusList['devel']['done'] > 0 and $statusList['test']['wait'] == $testTasks) $stage = 'developing';
            if(($statusList['devel']['doing'] > 0 or ($statusList['devel']['wait'] > 0 and $statusList['devel']['done'] > 0)) and $statusList['test']['wait'] > 0 and $statusList['test']['done'] > 0) $stage = 'developing';
            if($statusList['devel']['done'] == $develTasks and $develTasks > 0 and $statusList['test']['wait'] == $testTasks) $stage = 'developed';
            if($statusList['devel']['done'] == $develTasks and $develTasks > 0 and $statusList['test']['wait'] > 0 and $statusList['test']['done'] > 0) $stage = 'testing';
            if($statusList['test']['doing'] > 0 or $statusList['test']['pause'] > 0) $stage = 'testing';
            if(($statusList['devel']['wait'] > 0 or $statusList['devel']['doing'] > 0) and $statusList['test']['done'] == $testTasks and $testTasks > 0) $stage = 'testing';
            if($statusList['devel']['done'] == $develTasks and $statusList['test']['done'] == $testTasks and $testTasks > 0) $stage = 'tested';

            $stages[$branch] = $stage;
        }

        $releases = $this->dao->select('*')->from(TABLE_RELEASE)->where("CONCAT(',', stories, ',')")->like("%,$storyID,%")->andWhere('deleted')->eq(0)->fetchPairs('branch', 'branch');
        foreach($releases as $branch) $stages[$branch] = 'released';

        $currentStory = $this->dao->findById($storyID)->from(TABLE_STORY)->fetch();
        if($story->stage != $currentStory->stage)
        {
            foreach($executions as $executionID => $branch)
            {
                $this->kanban->updateLane($executionID, 'story', $storyID);
            }
        }

        if(empty($stages)) return;
        if($hasBranch)
        {
            $stageList   = join(',', array_keys($this->lang->story->stageList));
            $minStagePos = strlen($stageList);
            $minStage    = '';
            foreach($stages as $branch => $stage)
            {
                $this->dao->replace(TABLE_STORYSTAGE)->set('story')->eq($storyID)->set('branch')->eq($branch)->set('stage')->eq($stage)->exec();
                if(isset($oldStages[$branch]))
                {
                    $oldStage = $oldStages[$branch];
                    if(!empty($oldStage->stagedBy))
                    {
                        $this->dao->replace(TABLE_STORYSTAGE)->data($oldStage)->exec();
                        $stage = $oldStage->$stage;
                    }
                }
                if(strpos($stageList, $stage) !== false and strpos($stageList, $stage) < $minStagePos)
                {
                    $minStage    = $stage;
                    $minStagePos = strpos($stageList, $stage);
                }
            }
            $this->dao->update(TABLE_STORY)->set('stage')->eq($minStage)->where('id')->eq($storyID)->exec();
        }
        else
        {
            $this->dao->update(TABLE_STORY)->set('stage')->eq(current($stages))->where('id')->eq($storyID)->exec();
        }

        $currentStory = $this->dao->findById($storyID)->from(TABLE_STORY)->fetch();
        if($story->stage != $currentStory->stage)
        {
            foreach($executions as $executionID => $branch)
            {
                $this->kanban->updateLane($executionID, 'story', $storyID);
            }
        }

        return;
    }

    public function subdivide($storyID, $stories)
    {
        $now      = helper::now();
        $oldStory = $this->dao->findById($storyID)->from(TABLE_STORY)->fetch();
        if($oldStory->type == 'requirement')
        {
            foreach($stories as $id)
            {
                $data = new stdclass();
                $data->product  = $oldStory->product;
                $data->AType    = 'requirement';
                $data->relation = 'subdivideinto';
                $data->BType    = 'story';
                $data->AID      = $storyID;
                $data->BID      = $id;
                $data->AVersion = $oldStory->version;
                $data->BVersion = 1;
                $data->extra    = 1;

                $this->dao->insert(TABLE_RELATION)->data($data)->autoCheck()->exec();

                $data->AType    = 'story';
                $data->relation = 'subdividedfrom';
                $data->BType    = 'requirement';
                $data->AID      = $id;
                $data->BID      = $storyID;
                $data->AVersion = 1;
                $data->BVersion = $oldStory->version;

                $this->dao->insert(TABLE_RELATION)->data($data)->autoCheck()->exec();
            }

            if(dao::isError()) return print(js::error(dao::getError()));

            $isonlybody = isonlybody();
            unset($_GET['onlybody']);
            return print(js::locate(helper::createLink('product', 'browse', "productID=$oldStory->product&branch=0&browseType=unclosed&queryID=0&type=story"), $isonlybody ? 'parent.parent' : 'parent'));
        }
        else
        {
            /* Set parent to child story. */
            $this->dao->update(TABLE_STORY)->set('parent')->eq($storyID)->where('id')->in($stories)->exec();
            $this->computeEstimate($storyID);

            /* Set childStories. */
            $childStories = join(',', $stories);

            $newStory = new stdClass();
            if($oldStory->parent<=0)$newStory->parent         = '-1';
            $newStory->plan           = '';
            $newStory->lastEditedBy   = $this->app->user->account;
            $newStory->lastEditedDate = $now;
            $newStory->childStories   = trim($oldStory->childStories . ',' . $childStories, ',');

            /* Subdivide story. */
            $this->dao->update(TABLE_STORY)->data($newStory)->autoCheck()->where('id')->eq($storyID)->exec();

            $changes = common::createChanges($oldStory, $newStory);
            if($changes)
            {
                $actionID = $this->loadModel('action')->create('story', $storyID, 'createChildrenStory', '', $childStories);
                $this->action->logHistory($actionID, $changes);
            }
        }
    }

    public function computeEstimate($storyID)
    {
        if(!$storyID) return true;

        $stories = $this->dao->select('`id`,`estimate`,status')->from(TABLE_STORY)->where('parent')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll('id');
        if(empty($stories)) return true;

        $estimate = 0;
        foreach($stories as $story) $estimate += $story->estimate;
        $this->dao->update(TABLE_STORY)->set('estimate')->eq($estimate)->autoCheck()->where('id')->eq($storyID)->exec();
        return !dao::isError();
    }
}

<?php

/**
 * Get actions of an object.
 *
 * @param  int    $objectType
 * @param  int    $objectID
 * @access public
 * @return array
 */
public function getList($objectType, $objectID)
{
    $modules   = $objectType == 'module' ? $this->dao->select('id')->from(TABLE_MODULE)->where('root')->eq($objectID)->fetchPairs('id') : array();
    $commiters = $this->loadModel('user')->getCommiters();
    $actions   = $this->dao->select('*')->from(TABLE_ACTION)
        ->beginIF($objectType == 'project')
        ->where("objectType IN('project', 'testtask', 'build')")
        ->andWhere('project')->eq((int)$objectID)
        ->fi()
        ->beginIF($objectType == 'story')
        ->where('objectType')->in('story,requirement')
        ->andWhere('objectID')->eq((int)$objectID)
        ->fi()
        ->beginIF($objectType == 'case')
        ->where('objectType')->in('case,testcase')
        ->andWhere('objectID')->eq((int)$objectID)
        ->fi()
        ->beginIF($objectType == 'module')
        ->where('objectType')->eq($objectType)
        ->andWhere('((action')->ne('deleted')->andWhere('objectID')->eq((int)$objectID)->markRight(1)
        ->orWhere('(action')->eq('deleted')->andWhere('objectID')->in($modules)->markRight(1)->markRight(1)
        ->fi()
        ->beginIF(strpos('project,case,story,module', $objectType) === false)
        ->where('objectType')->eq($objectType)
        ->andWhere('objectID')->eq((int)$objectID)
        ->fi()
        ->orderBy('date, id')
        ->fetchAll('id');

    // 处理转需求，转任务，转bug后的反馈action chenjj 230115
    $actions = $this->feedbackAction($objectType, $objectID, $actions);

    $histories = $this->getHistory(array_keys($actions));
    $this->loadModel('file');

    if($objectType == 'project')
    {
        $this->app->loadLang('build');
        $this->app->loadLang('testtask');
        $actions = $this->processProjectActions($actions);
    }

    foreach($actions as $actionID => $action)
    {
        $actionName = strtolower($action->action);
        if($actionName == 'svncommited' and isset($commiters[$action->actor]))
        {
            $action->actor = $commiters[$action->actor];
        }
        elseif($actionName == 'gitcommited' and isset($commiters[$action->actor]))
        {
            $action->actor = $commiters[$action->actor];
        }
        elseif($actionName == 'linked2execution' or $actionName == 'linked2kanban')
        {
            $execution = $this->dao->select('name,type')->from(TABLE_PROJECT)->where('id')->eq($action->extra)->fetch();
            if(!empty($execution))
            {
                $name      = $execution->name;
                $method    = $execution->type == 'kanban' ? 'kanban' : 'view';
                $action->extra = (!common::hasPriv('execution', $method) or ($method == 'kanban' and isonlybody())) ? $name : html::a(helper::createLink('execution', $method, "executionID=$action->execution"), $name);
            }
        }
        elseif($actionName == 'linked2project')
        {
            $project   = $this->dao->select('name,model')->from(TABLE_PROJECT)->where('id')->eq($action->extra)->fetch();
            $productID = trim($action->product, ',');
            $name      = $project->name;
            $method    = $project->model == 'kanban' ? 'index' : 'view';
            if($name) $action->extra = common::hasPriv('project', $method) ? html::a(helper::createLink('project', $method, "projectID=$action->project"), $name) : $name;
        }
        elseif($actionName == 'linked2plan')
        {
            $title = $this->dao->select('title')->from(TABLE_PRODUCTPLAN)->where('id')->eq($action->extra)->fetch('title');
            if($title) $action->extra = common::hasPriv('productplan', 'view') ? html::a(helper::createLink('productplan', 'view', "planID=$action->extra"), $title) : $title;
        }
        elseif($actionName == 'linked2build')
        {
            $name = $this->dao->select('name')->from(TABLE_BUILD)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('build', 'view') ? html::a(helper::createLink('build', 'view', "builID=$action->extra&type={$action->objectType}"), $name) : $name;
        }
        elseif($actionName == 'linked2bug')
        {
            $name = $this->dao->select('name')->from(TABLE_BUILD)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('build', 'view') ? html::a(helper::createLink('build', 'view', "builID=$action->extra&type={$action->objectType}"), $name) : $name;
        }
        elseif($actionName == 'linked2release')
        {
            $name = $this->dao->select('name')->from(TABLE_RELEASE)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('release', 'view') ? html::a(helper::createLink('release', 'view', "releaseID=$action->extra&type={$action->objectType}"), $name) : $name;
        }
        elseif($actionName == 'linked2testtask')
        {
            $name = $this->dao->select('name')->from(TABLE_TESTTASK)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('testtask', 'view') ? html::a(helper::createLink('testtask', 'view', "taskID=$action->extra"), $name) : $name;
        }
        elseif($actionName == 'moved' and $action->objectType != 'module')
        {
            $name = $this->dao->select('name')->from(TABLE_PROJECT)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('execution', 'task') ? html::a(helper::createLink('execution', 'task', "executionID=$action->extra"), "#$action->extra " . $name) : "#$action->extra " . $name;
        }
        elseif($actionName == 'frombug' and common::hasPriv('bug', 'view'))
        {
            $action->extra = html::a(helper::createLink('bug', 'view', "bugID=$action->extra"), $action->extra);
        }
        elseif($actionName == 'unlinkedfromexecution')
        {
            $name = $this->dao->select('name')->from(TABLE_PROJECT)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('project', 'story') ? html::a(helper::createLink('project', 'story', "projectID=$action->extra"), "#$action->extra " . $name) : "#$action->extra " . $name;
        }
        elseif($actionName == 'unlinkedfromproject')
        {
            $name      = $this->dao->select('name')->from(TABLE_PROJECT)->where('id')->eq($action->extra)->fetch('name');
            $productID = trim($action->product, ',');
            if($name) $action->extra = common::hasPriv('projectstory', 'story') ? html::a(helper::createLink('projectstory', 'story', "projectID=$action->execution&productID=$productID"), "#$action->extra " . $name) : "#$action->extra " . $name;
        }
        elseif($actionName == 'unlinkedfrombuild')
        {
            $name = $this->dao->select('name')->from(TABLE_BUILD)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('build', 'view') ? html::a(helper::createLink('build', 'view', "builID=$action->extra&type={$action->objectType}"), $name) : $name;
        }
        elseif($actionName == 'unlinkedfromrelease')
        {
            $name = $this->dao->select('name')->from(TABLE_RELEASE)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('release', 'view') ? html::a(helper::createLink('release', 'view', "releaseID=$action->extra&type={$action->objectType}"), $name) : $name;
        }
        elseif($actionName == 'unlinkedfromplan')
        {
            $title = $this->dao->select('title')->from(TABLE_PRODUCTPLAN)->where('id')->eq($action->extra)->fetch('title');
            if($title) $action->extra = common::hasPriv('productplan', 'view') ? html::a(helper::createLink('productplan', 'view', "planID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
        }
        elseif($actionName == 'unlinkedfromtesttask')
        {
            $name = $this->dao->select('name')->from(TABLE_TESTTASK)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('testtask', 'view') ? html::a(helper::createLink('testtask', 'view', "taskID=$action->extra"), $name) : $name;
        }
        elseif($action->objectType != 'feedback' and $actionName == 'tostory')
        {
            $title = $this->dao->select('title')->from(TABLE_STORY)->where('id')->eq($action->extra)->fetch('title');
            if($title) $action->extra = common::hasPriv('story', 'view') ? html::a(helper::createLink('story', 'view', "storyID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
        }
        elseif($action->objectType == 'feedback')
        {
            if($actionName == 'tostory'){
                $title = $this->dao->select('title')->from(TABLE_STORY)->where('id')->eq($action->extra)->fetch('title');
                if($title) $action->extra = common::hasPriv('story', 'view') ? html::a(helper::createLink('story', 'view', "storyID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
            }elseif($actionName == 'tobug'){
                $title = $this->dao->select('title')->from(TABLE_BUG)->where('id')->eq($action->extra)->fetch('title');
                if($title) $action->extra = common::hasPriv('bug', 'view') ? html::a(helper::createLink('bug', 'view', "bugID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
            }elseif($actionName == 'totask'){
                $title = $this->dao->select('name')->from(TABLE_TASK)->where('id')->eq($action->extra)->fetch('name');
                if($title) $action->extra = common::hasPriv('task', 'view') ? html::a(helper::createLink('task', 'view', "taskID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
            }
        }
        elseif($actionName == 'fromfeedback')
        {
            if($action->objectType == 'story'||$action->objectType == 'bug'||$action->objectType == 'task'){
                $title = $this->dao->select('title')->from(TABLE_FEEDBACK)->where('id')->eq($action->extra)->fetch('title');
                if($title) $action->extra = common::hasPriv('feedback', 'view') ? html::a(helper::createLink('feedback', 'view', "feedbackID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
            }
        }
        elseif($actionName == 'importedcard')
        {
            $title = $this->dao->select('name')->from(TABLE_KANBAN)->where('id')->eq($action->extra)->fetch('name');
            if($title) $action->extra = common::hasPriv('kanban', 'view') ? html::a(helper::createLink('kanban', 'view', "kanbanID=$action->extra"), "#$action->extra " . $title) : "#$action->extra " . $title;
        }
        elseif($actionName == 'createchildren')
        {
            $names = $this->dao->select('id,name')->from(TABLE_TASK)->where('id')->in($action->extra)->fetchPairs('id', 'name');
            $action->extra = '';
            if($names)
            {
                foreach($names as $id => $name) $action->extra .= common::hasPriv('task', 'view') ? html::a(helper::createLink('task', 'view', "taskID=$id"), "#$id " . $name) . ', ' : "#$id " . $name . ', ';
            }
            $action->extra = trim(trim($action->extra), ',');
        }
        /* Code for waterfall. */
        elseif($actionName == 'createrequirements')
        {
            $names = $this->dao->select('id,title')->from(TABLE_STORY)->where('id')->in($action->extra)->fetchPairs('id', 'title');
            $action->extra = '';
            if($names)
            {
                foreach($names as $id => $name) $action->extra .= common::hasPriv('requriement', 'view') ? html::a(helper::createLink('story', 'view', "storyID=$id"), "#$id " . $name) . ', ' : "#$id " . $name . ', ';
            }
            $action->extra = trim(trim($action->extra), ',');
        }
        elseif($action->objectType != 'feedback' and (strpos(',totask,linkchildtask,unlinkchildrentask,linkparenttask,unlinkparenttask,deletechildrentask,', ",$actionName,") !== false))
        {
            $name = $this->dao->select('name')->from(TABLE_TASK)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('task', 'view') ? html::a(helper::createLink('task', 'view', "taskID=$action->extra"), "#$action->extra " . $name) : "#$action->extra " . $name;
        }
        elseif($actionName == 'linkchildstory' or $actionName == 'unlinkchildrenstory' or $actionName == 'linkparentstory' or $actionName == 'unlinkparentstory' or $actionName == 'deletechildrenstory')
        {
            $name = $this->dao->select('title')->from(TABLE_STORY)->where('id')->eq($action->extra)->fetch('title');
            if($name) $action->extra = common::hasPriv('story', 'view') ? html::a(helper::createLink('story', 'view', "storyID=$action->extra"), "#$action->extra " . $name) : "#$action->extra " . $name;
        }
        elseif($actionName == 'buildopened')
        {
            $name = $this->dao->select('name')->from(TABLE_BUILD)->where('id')->eq($action->objectID)->fetch('name');
            if($name) $action->extra = common::hasPriv('build', 'view') ? html::a(helper::createLink('build', 'view', "buildID=$action->objectID"), "#$action->objectID " . $name) : "#$action->objectID " . $name;
        }
        elseif($actionName == 'testtaskopened' or $actionName == 'testtaskstarted' or $actionName == 'testtaskclosed')
        {
            $name = $this->dao->select('name')->from(TABLE_TESTTASK)->where('id')->eq($action->objectID)->fetch('name');
            if($name) $action->extra = common::hasPriv('testtask', 'view') ? html::a(helper::createLink('testtask', 'view', "testtaskID=$action->objectID"), "#$action->objectID " . $name) : "#$action->objectID " . $name;
        }
        elseif($actionName == 'fromlib' and $action->objectType == 'case')
        {
            $name = $this->dao->select('name')->from(TABLE_TESTSUITE)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('caselib', 'browse') ? html::a(helper::createLink('caselib', 'browse', "libID=$action->extra"), $name) : $name;
        }
        elseif(strpos(',importfromstorylib,importfromrisklib,importfromissuelib,importfromopportunitylib,', ",{$actionName},") !== false and $this->config->edition == 'max')
        {
            $name = $this->dao->select('name')->from(TABLE_ASSETLIB)->where('id')->eq($action->extra)->fetch('name');
            if($name) $action->extra = common::hasPriv('assetlib', $action->objectType) ? html::a(helper::createLink('assetlib', $action->objectType, "libID=$action->extra"), $name) : $name;
        }
        elseif(($actionName == 'closed' and $action->objectType == 'story') or ($actionName == 'resolved' and $action->objectType == 'bug'))
        {
            $action->appendLink = '';
            if(strpos($action->extra, '|') !== false) $action->extra = substr($action->extra, 0, strpos($action->extra, '|'));
            if(strpos($action->extra, ':') !== false)
            {
                list($extra, $id) = explode(':', $action->extra);
                $action->extra    = $extra;
                if($id)
                {
                    $table = $action->objectType == 'story' ? TABLE_STORY : TABLE_BUG;
                    $name  = $this->dao->select('title')->from($table)->where('id')->eq($id)->fetch('title');
                    if($name) $action->appendLink = html::a(helper::createLink($action->objectType, 'view', "id=$id"), "#$id " . $name);
                }
            }
        }
        elseif($actionName == 'finished' and $objectType == 'todo')
        {
            $action->appendLink = '';
            if(strpos($action->extra, ':')!== false)
            {
                list($extra, $id) = explode(':', $action->extra);
                $action->extra    = strtolower($extra);
                if($id)
                {
                    $table = $this->config->objectTables[$action->extra];
                    $field = $this->config->action->objectNameFields[$action->extra];
                    $name  = $this->dao->select($field)->from($table)->where('id')->eq($id)->fetch($field);
                    if($name) $action->appendLink = html::a(helper::createLink($action->extra, 'view', "id=$id"), "#$id " . $name);
                }
            }
        }
        elseif(($actionName == 'opened' or $actionName == 'managed' or $actionName == 'edited') and ($objectType == 'execution' || $objectType == 'project'))
        {
            $this->app->loadLang('execution');
            $linkedProducts = $this->dao->select('id,name')->from(TABLE_PRODUCT)->where('id')->in($action->extra)->fetchPairs('id', 'name');
            $action->extra  = '';
            if($linkedProducts and $this->config->vision == 'rnd')
            {
                foreach($linkedProducts as $productID => $productName) $linkedProducts[$productID] = html::a(helper::createLink('product', 'browse', "productID=$productID"), "#{$productID} {$productName}");
                $action->extra = sprintf($this->lang->execution->action->extra, '<strong>' . join(', ', $linkedProducts) . '</strong>');
            }
        }
        $action->history = isset($histories[$actionID]) ? $histories[$actionID] : array();

        $actionName = strtolower($action->action);
        if($actionName == 'svncommited')
        {
            foreach($action->history as $history)
            {
                if($history->field == 'subversion') $history->diff = str_replace('+', '%2B', $history->diff);
            }
        }
        elseif($actionName == 'gitcommited')
        {
            foreach($action->history as $history)
            {
                if($history->field == 'git') $history->diff = str_replace('+', '%2B', $history->diff);
            }
        }
        elseif(strpos('linkstory,unlinkstory,createchildrenstory', $actionName) !== false)
        {
            $extra = '';
            foreach(explode(',', $action->extra) as $id) $extra .= common::hasPriv('story', 'view') ? html::a(helper::createLink('story', 'view', "storyID=$id"), "#$id ") . ', ' : "#$id, ";
            $action->extra = trim(trim($extra), ',');
        }
        elseif($actionName == 'linkbug' or $actionName == 'unlinkbug')
        {
            $extra = '';
            foreach(explode(',', $action->extra) as $id) $extra .= common::hasPriv('bug', 'view') ? html::a(helper::createLink('bug', 'view', "bugID=$id"), "#$id ") . ', ' : "#$id, ";
            $action->extra = trim(trim($extra), ',');
        }
        // 处理反馈转任务，转需求，转bug后相关任务完成后action chenjj 230115
        if($objectType=='feedback'){
            if($actionName == 'finished' and $action->objectType == 'task')
            {
                $title = $this->dao->select('name')->from(TABLE_TASK)->where('id')->eq($action->objectID)->fetch('name');
                if ($title) {
                    $action->extra = common::hasPriv('task', 'view') ? html::a(helper::createLink('task', 'view', "taskID=$action->objectID"), "#$action->extra " . $title) : "#$action->extra " . $title;
                }
            }elseif($actionName == 'closed' and $action->objectType == 'story')
            {
                $title = $this->dao->select('title')->from(TABLE_STORY)->where('id')->eq($action->objectID)->fetch('title');
                if($title) {
                    $action->extra = common::hasPriv('story', 'view') ? html::a(helper::createLink('story', 'view', "storyID=$action->objectID"), "#$action->extra " . $title) : "#$action->extra " . $title;
                }
            }elseif($actionName == 'resolved' and $action->objectType == 'bug')
            {
                $title = $this->dao->select('title')->from(TABLE_BUG)->where('id')->eq($action->objectID)->fetch('title');
                if ($title) {
                    $action->extra = common::hasPriv('bug', 'view') ? html::a(helper::createLink('bug', 'view', "bugID=$action->objectID"), "#$action->extra " . $title) : "#$action->extra " . $title;
                }
            }
        }

        $action->comment = $this->file->setImgSize($action->comment, $this->config->action->commonImgSize);

        $actions[$actionID] = $action;
    }

    return $actions;
}
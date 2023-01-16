<?php
    function recorddeliberation($bugID, $extra)
    {

        $extra = str_replace(array(',', ' '), array('&', ''), $extra);
        parse_str($extra, $output);
        $bugID      = (int)$bugID;
        $oldBug     = $this->getById($bugID);
        $bug = $oldBug;
        $changes = common::createChanges($oldBug, $bug);

        if($this->post->tostatus=='active'){

            $solveBuild = $this->dao->select('id')
                ->from(TABLE_BUILD)
                ->where("CONCAT(',', bugs, ',')")->like("%,{$bugID},%")
                ->fetch('id');
            $now = helper::now();
            $bug = fixer::input('post')
                ->setDefault('assignedTo',     $oldBug->resolvedBy)
                ->setDefault('assignedDate',   $now)
                ->setDefault('lastEditedBy',   $this->app->user->account)
                ->setDefault('lastEditedDate', $now)
                ->setDefault('activatedDate',  $now)
                ->setDefault('activatedCount', (int)$oldBug->activatedCount)
                ->stripTags($this->config->bug->editor->activate['id'], $this->config->allowedTags)
                ->add('id', $bugID)
                ->add('resolution', '')
                ->add('status', 'active')
                ->add('resolvedDate', '0000-00-00')
                ->add('resolvedBy', '')
                ->add('resolvedBuild', '')
                ->add('closedBy', '')
                ->add('closedDate', '0000-00-00')
                ->add('duplicateBug', 0)
                ->add('toTask', 0)
                ->add('toStory', 0)
                ->join('openedBuild', ',')
                ->remove('comment,files,labels,deliberateddate,tostatus')
                ->get();

            $bug = $this->loadModel('file')->processImgURL($bug, $this->config->bug->editor->recorddeliberation['id'], $this->post->uid);

            $this->dao->update(TABLE_BUG)->data($bug)->autoCheck()->checkFlow()->where('id')->eq((int)$bugID)->exec();

            $this->dao->update(TABLE_BUG)->set('activatedCount = activatedCount + 1')->where('id')->eq((int)$bugID)->exec();

            if($solveBuild)
            {
                $this->loadModel('build');
                $build = $this->build->getByID($solveBuild);
                $build->bugs = trim(str_replace(",$bugID,", ',', ",$build->bugs,"), ',');
                $this->dao->update(TABLE_BUILD)->set('bugs')->eq($build->bugs)->where('id')->eq((int)$solveBuild)->exec();
            }

            if($oldBug->execution)
            {
                $this->loadModel('kanban');
                if(!isset($output['toColID'])) $this->kanban->updateLane($oldBug->execution, 'bug', $bugID);
                if(isset($output['toColID'])) $this->kanban->moveCard($bugID, $output['fromColID'], $output['toColID'], $output['fromLaneID'], $output['toLaneID']);
            }
            $bug->activatedCount += 1;
            $changes= common::createChanges($oldBug, $bug);
        }else{

            $bug    = fixer::input('post')
                ->add('id', $bugID)
                ->add('assignedTo', 'closed')
                ->add('status',     'closed')
                ->add('confirmed',  1)
                ->setDefault('assignedDate',   $now)
                ->setDefault('lastEditedBy',   $this->app->user->account)
                ->setDefault('lastEditedDate', $now)
                ->setDefault('closedBy',       $this->app->user->account)
                ->setDefault('closedDate',     $now)
                ->stripTags($this->config->bug->editor->close['id'], $this->config->allowedTags)
                ->remove('comment,files,labels,deliberateddate,tostatus')
                ->get();

            $bug = $this->loadModel('file')->processImgURL($bug, $this->config->bug->editor->recorddeliberation['id'], $this->post->uid);
            $this->dao->update(TABLE_BUG)->data($bug)->autoCheck()->checkFlow()->where('id')->eq((int)$bugID)->exec();
            if($oldBug->execution)
            {
                $this->loadModel('kanban');
                if(!isset($output['toColID'])) $this->kanban->updateLane($oldBug->execution, 'bug', $bugID);
                if(isset($output['toColID'])) $this->kanban->moveCard($bugID, $output['fromColID'], $output['toColID'], $output['fromLaneID'], $output['toLaneID']);
            }
            // ifÔö¼Ó $this->config->edition == 'open' chenjj 230115
            if(($this->config->edition == 'biz' || $this->config->edition == 'max' || $this->config->edition == 'open') && $oldBug->feedback) $this->loadModel('feedback')->updateStatus('bug', $oldBug->feedback, $bug->status, $oldBug->status);

            $changes= common::createChanges($oldBug, $bug);
        }

        $deliberation = fixer::input('post')
            ->add('description',$this->post->comment)
            ->remove('comment,files,labels')
            ->add('frombugid',(int)$bugID)
            ->add('launcherid',(int)$oldBug->openedBy)
            ->add('organizerid',(int)$this->app->user->account)
            ->add('times',(int)$oldBug->activatedCount)
            ->get();
        $this->dao->insert(TABLE_DELIBERATION)->data($deliberation)
            ->autoCheck()
            ->batchCheck($this->config->bug->recorddeliberation->requiredFields, 'notempty')
            ->checkFlow()
            ->exec();


        return $changes;
    }

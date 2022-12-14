<?php
    function launchdeliberation($bugID, $extra)
    {
        //error_log("1");
        //die("test");
        $extra = str_replace(array(',', ' '), array('&', ''), $extra);
        parse_str($extra, $output);

        $bugID      = (int)$bugID;
        $oldBug     = $this->getById($bugID);
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
            ->add('status', 'tobedeliberated')
            ->add('resolvedDate', '0000-00-00')
            ->add('resolvedBy', '')
            ->add('resolvedBuild', '')
            ->add('closedBy', '')
            ->add('closedDate', '0000-00-00')
            ->add('duplicateBug', 0)
            ->add('toTask', 0)
            ->add('toStory', 0)
            ->join('openedBuild', ',')
            ->remove('comment,files,labels')
            ->get();

        $bug = $this->loadModel('file')->processImgURL($bug, $this->config->bug->editor->launchdeliberation['id'], $this->post->uid);
        $this->dao->update(TABLE_BUG)->data($bug)->autoCheck()->checkFlow()->where('id')->eq((int)$bugID)->exec();
        //$this->dao->update(TABLE_BUG)->set('activatedCount = activatedCount + 1')->where('id')->eq((int)$bugID)->exec();

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
        //$bug->activatedCount += 1;
        return common::createChanges($oldBug, $bug);
    }

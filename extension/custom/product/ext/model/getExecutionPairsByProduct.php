<?php

public function getExecutionPairsByProduct2($productID, $branch = 0, $orderBy = 'id_asc', $projectID = 0, $mode = '')
{
    if(empty($productID)) return array();
    if(empty($projectID) or $this->config->systemMode == 'classic') return $this->getAllExecutionPairsByProduct($productID, $branch, '', $mode);

    $project = $this->loadModel('project')->getByID($projectID);
    $orderBy = $project->model == 'waterfall' ? 'begin_asc,id_asc' : 'begin_desc,id_desc';

    $executions = $this->dao->select('t2.id,t2.name,t2.grade,t2.parent,t2.attribute')->from(TABLE_PROJECTPRODUCT)->alias('t1')
        ->leftJoin(TABLE_PROJECT)->alias('t2')->on('t1.project = t2.project')
        ->where('t1.product')->eq($productID)
        ->andWhere('t2.project')->eq($projectID)
        ->beginIF($branch !== '')->andWhere('t1.branch')->in($branch)->fi()
        ->beginIF(!$this->app->user->admin)->andWhere('t2.id')->in($this->app->user->view->sprints)->fi()
        ->beginIF(strpos($mode, 'noclosed') !== false)->andWhere('t2.status')->ne('closed')->fi()
        ->andWhere('t2.deleted')->eq('0')
        ->orderBy($orderBy)
        ->fetchAll('id');

    /* The waterfall project needs to show the hierarchy and remove the parent stage. */
    $executionList = array('0' => '');
    if($project->model == 'waterfall')
    {
        foreach($executions as $id => $execution)
        {
            if($execution->grade == 2 and isset($executions[$execution->parent]))
            {
                $execution->name = $executions[$execution->parent]->name . '/' . $execution->name;
                $executions[$execution->parent]->children[$id] = $execution->name;
                unset($executions[$id]);
            }
        }

        foreach($executions as $execution)
        {
            if(isset($execution->children))
            {
                $executionList = $executionList + $execution->children;
                continue;
            }
            if(strpos($mode, 'stagefilter') !== false and in_array($execution->attribute, array('request', 'design', 'review'))) continue; // Some stages of waterfall not need.
            $executionList[$execution->id] = $execution->name;
        }
    }
    else
    {
        foreach($executions as $execution) $executionList[$execution->id] = $execution->name;
    }

    return $executionList;
}
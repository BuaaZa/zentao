<?php
/**
 * 查找反馈转化的任务需求缺陷等关联数据
 */
public function feedbackRelations($feedbackID=0):array
{
    $ret = array();
    if ($feedbackID==0) {
        return $ret;
    }
    // 研发需求
    $storyList = $this->dao->select("id,title,pri,status,stage")->from(TABLE_STORY)
        ->where('feedback')->eq($feedbackID)->fetchAll();
    if (!empty($storyList)) {
        foreach ($storyList as $story) {
            $story->statusLabel = $this->lang->story->statusList[$story->status];
        }
        $ret["story"] = $storyList;
    }

    // bug
    $bugList = $this->dao->select("id,title,pri,status")->from(TABLE_BUG)
        ->where('feedback')->eq($feedbackID)->fetchAll();
    if (!empty($bugList)) {
        $this->loadModel('bug');
        foreach ($bugList as $bug) {
            $bug->statusLabel = $this->lang->bug->statusList[$bug->status];
        }
        $ret["bug"] = $bugList;
    }

    // 任务
    $taskList = $this->dao->select("id,name as title,pri,status")->from(TABLE_TASK)
    ->where('feedback')->eq($feedbackID)->fetchAll();
    if (!empty($taskList)) {
        foreach ($taskList as $task) {
            $task->statusLabel = $this->lang->task->statusList[$task->status];
        }
        $ret["task"] = $taskList;
    }

    return $ret;
}

<?php
/**
 * 反馈转化的任务需求缺陷等关联数据关闭时关闭反馈
 */
public function feedbackRelationsClose($feedbackID=0):bool
{
    if ($feedbackID==0) {
        // 没有id
        return false;
    }
    // 研发需求 closed 查找不是已关闭状态的数据
    $storyList = $this->dao->select("id")->from(TABLE_STORY)
        ->where('feedback')->eq($feedbackID)
        ->andWhere('status')->notin('closed')
        ->fetchAll();
    if (!empty($storyList)) {
        // 还有研发需求没有关闭
        return false;
    }

    // 是否没有关联的bug的标记
    $noBug = true;
    // bug closed 查找不是已关闭状态的数据
    $bugList = $this->dao->select("id")->from(TABLE_BUG)
        ->where('feedback')->eq($feedbackID)
        ->andWhere('status')->notin('closed')
        ->fetchAll();
    if (!empty($bugList)) {
        // 还有bug没有关闭
        return false;
    }

    // 是否没有关联的任务的标记
    $noTask = true;
    // 任务 closed 查找不是已关闭状态的数据
    $taskList = $this->dao->select("id")->from(TABLE_TASK)
        ->where('feedback')->eq($feedbackID)
        ->andWhere('status')->notin('closed')
        ->fetchAll();
    if (!empty($taskList)) {
        // 还有任务没有关闭
        return false;
    }

    // 关闭反馈
    $closedReason = "关联记录已关闭或完成";
    $fb = $this->getById($feedbackID);
    $changes = $this->close($fb, $closedReason);
    $action = $this->loadModel('action');
    $actionID = $action->create('feedback', $feedbackID, 'closed', '', $closedReason);
    $action->logHistory($actionID, $changes);

    return true;
}

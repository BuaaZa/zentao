<?php

public function getByFeedbackIds($feedbacksIds,$feedIdMapExtId)
{
  $exportType = $_POST['exportType'];
  $exportTime = helper::now();
  $actions = $this->dao->select('*')->from(TABLE_ACTION)
  ->where('objectType')->eq('feedback')
  ->andWhere('action')->in(array('reviewed','assigned','closed','commented','deleted'))
  ->andWhere('objectID')->in($feedbacksIds)
  // ->beginIF($exportType == 'inc')
  // ->andWhere('(`date` >= `exportDate` OR `exportDate` IS NULL)')
  // ->fi()
  ->fetchAll();
  // $actionsIds = array_column($actions,'id');

  // // 增量时再更新导出时间
  // if($exportType=='inc')
  // {
  //   $this->dao->update(TABLE_ACTION)
  //   ->set('exportDate')->eq($exportTime)
  //   ->where('id')->in($actionsIds)
  //   ->exec();
  // }
  foreach($actions as $action)
  {
    $action->feedbackExId = $feedIdMapExtId[$action->objectID];
  }

  return $actions;
}
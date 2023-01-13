<?php

// 获取天唧的反馈数据
public function getTjFeedbacks()
{
    // feedbackExId字段有值的就是天唧手机的数据
    return $this->dao->select('*')->from(TABLE_FEEDBACK)
    ->where('feedbackExId')->ne('')
    ->fetchAll('feedbackExId');
}


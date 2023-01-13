<?php
// 根据id集合获取多个反馈数据
public function getByIds(array $feedbackIDList):array
{
    $fbs = array();
    if(empty($feedbackIDList)){
        return $fbs;
    }
    return $this->dao->select("*")->from(TABLE_FEEDBACK)
        ->where('id')->in($feedbackIDList)->fetchAll();
}
<?php

public function getByIds($feedbackIds,$actionIds)
{
  return $this->dao->select('*')->from(TABLE_FILE)
  ->where()
  ->markLeft(1)
  ->where('objectType')->eq('comment')
  ->andWhere('objectID')->in($actionIds)
  ->markRight(1)
  ->orWhere()
  ->markLeft(1)
  ->where('objectType')->eq('feedback')
  ->andWhere('objectID')->in($feedbackIds)
  ->markRight(1)
  ->andWhere('deleted')->eq('0')
  ->fetchAll();
}
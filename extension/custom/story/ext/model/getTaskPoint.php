<?php 
public function getTaskPoint($storyID, $append = '')
{
    $stories = $this->dao->select('*')->from(TABLE_STORY)
        ->where('deleted')->eq(0)
        ->andWhere('parent')->eq($storyID)
        ->andWhere('type')->eq('taskPoint')
        ->andWhere('status')->notin('closed,draft')
        ->fetchAll();
    return $stories;
} 
?>
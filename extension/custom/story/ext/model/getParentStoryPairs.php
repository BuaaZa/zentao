<?php 
public function getParentStoryPairs($productID, $append = '')
{
    $stories = $this->dao->select('id, title')->from(TABLE_STORY)
        ->where('deleted')->eq(0)
        ->andWhere('parent')->le(0)
        ->andWhere('type')->eq('story')
        #->andWhere('stage')->eq('wait')
        ->andWhere('status')->notin('closed,draft')
        ->andWhere('product')->eq($productID)
        ->andWhere('plan')->in('0,')
        ->beginIF($append)->orWhere('id')->in($append)->fi()
        ->fetchPairs();
    return array(0 => '') + $stories ;
} 
?>
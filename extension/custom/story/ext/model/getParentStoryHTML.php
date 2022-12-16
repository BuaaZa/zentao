<?php
public function getParentStoryHTML($productID, $executionID = -1, $append = '')
{
    if($executionID != -1){
        $stories = $this->dao->select("distinct t2.id as id, t2.title as title")->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story = t2.id')
            ->andWhere('t1.project')->eq($executionID)
            ->andWhere('t1.product')->eq($productID)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t2.status')->notin('closed,draft')
            ->andWhere('t2.stage')->ne('closed')
            ->andWhere('t2.parent')->le(0)
            ->andWhere('t2.type')->eq('story')
            ->beginIF($append)->orWhere('id')->in($append)->fi()
            ->fetchPairs();
    }else{
        $stories = $this->dao->select('id, title')->from(TABLE_STORY)
            ->where('deleted')->eq(0)
            ->andWhere('parent')->le(0)
            ->andWhere('type')->eq('story')
            ->andWhere('stage')->ne('closed')
            ->andWhere('status')->notin('closed,draft')
            ->andWhere('product')->eq($productID)
            ->andWhere('plan')->in('0,')
            ->beginIF($append)->orWhere('id')->in($append)->fi()
            ->fetchPairs();
    }
    return array(0 => '') + $stories ;
}
?>
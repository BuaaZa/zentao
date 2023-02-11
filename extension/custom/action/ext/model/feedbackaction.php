<?php

// 处理反馈解决后的特殊action chenjj 230115
public function feedbackAction($objectType, $objectID, $actions=array())
{
    if($objectType!='feedback'){
        return $actions;
    }
    $this->loadModel('feedback');
    $feedback = $this->feedback->getByID($objectID);
    if(!$feedback||!isset($feedback->status)||$feedback->status!='replied'){
        return $actions;
    }
    if (isset($feedback->solution)&&isset($feedback->result)) {
        $action = null;
        if ($feedback->solution=='tobug') {
            $action = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq('bug')
            ->andWhere('objectID')->eq((int)($feedback->result))
            ->andWhere('action')->eq('resolved')
            ->fetch();
        } elseif ($feedback->solution=='tostory') {
            $action = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq('story')
            ->andWhere('objectID')->eq((int)($feedback->result))
            ->andWhere('action')->eq('closed')
            ->fetch();
        } elseif ($feedback->solution=='totask') {
            $action = $this->dao->select('*')->from(TABLE_ACTION)
            ->where('objectType')->eq('task')
            ->andWhere('objectID')->eq((int)($feedback->result))
            ->andWhere('action')->eq('finished')
            ->fetch();
        }
        if ($action) {
            array_push($actions, $action);
        }
    }
    return $actions;
}

<?php

class taskBatchStartEntry extends Entry
{
    /**
     * POST method.
     *
     * @param int $taskID
     * @access public
     * @return void
     */
    public function post($id = 0)
    {
        if(!isset($this->requestBody->tasks))
        {
            return $this->send400('Need tasks.');
        }
        $tasks = $this->request("tasks");
        $control = $this->loadController('task', 'start');
        foreach($tasks as $task){
            if(!isset($task->taskId)){
                $this->send400('taskId is needed.');
            }
            if(!isset($task->left)){
                $this->send400('left is needed.');
            }
            $this->setPost('assignedTo',     $task->assignedTo);
            $this->setPost('realStarted',     $task->realStarted);
            $this->setPost('consumed',     $task->consumed);
            $this->setPost('left',     $task->left);
            $this->setPost('comment',     $task->comment);
            $control->start($task->taskId);
            #$data = $this->getData();
            #if (!$data) return $this->send400('error');
            #if (isset($data->status) and $data->status == 'fail') return $this->sendError(zget($data, 'code', 400), $data->message);
        }
        $this->getData();
        $this->sendSuccess(200, 'success');
    }
}

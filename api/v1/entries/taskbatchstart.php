<?php

class taskBatchStartEntry extends Entry
{

    public task $taskController;

    /**
     * POST method.
     *
     * @access public
     * @return void
     */
    public function post()
    {
        if (!isset($this->requestBody->tasks))
            return $this->send400('Need tasks like tasks: [1, 2, 3].');
        $tasks = $this->request("tasks");

        $this->taskController = $this->loadController('task', 'start');
        foreach ($tasks as $task) {
            $this->dao->update(TABLE_TASK)
                ->set('status')->eq('doing')
                ->where('id')->eq($task)->exec();
//            $this->setPost('assignedTo',     $task->assignedTo);
//            $this->setPost('realStarted',     $task->realStarted);
//            $this->setPost('consumed',     $task->consumed);
//            $this->setPost('left',     $task->left);
//            $this->setPost('comment',     $task->comment);
//            $this->taskController->start($task->taskId);
//            $data = $this->getData();
//            if (!$data) return $this->send400('error');
//            if (isset($data->status) and $data->status == 'fail') return $this->sendError(zget($data, 'code', 400), $data->message);
        }
//        $this->getData();
        $this->sendSuccess(200, 'success');
    }
}

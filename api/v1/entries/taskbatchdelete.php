<?php
class taskBatchDeleteEntry extends Entry
{
    /**
     * DELETE method.
     * @param  int    $id
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
        if(!is_array($tasks) || count($tasks)==0){
            return $this->send400('Tasks must be an array and should not be empty.');
        }
        $control = $this->loadController('task', 'delete');
        foreach($tasks as $index => $taskID){
            if(!is_int($taskID)){
                return $this->send400('Task_ID must be integer.');
            }
            $control->delete(0, $taskID, 'true');

        }
        $this->getData();//截断因调用$control->delete所产生的冗余返回数据
        $this->sendSuccess(200, 'success');
    }
}
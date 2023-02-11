<?php
/**
 * The tasks entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class tasksMultipleEntry extends entry
{
    public task $taskController;
    public taskModel $task;

    /**
     * 支持多人任务的创建
     *
     * @param int $executionID
     * @access public
     * @return void
     */
    public function post(int $executionID)
    {
        $fields = 'name,type,assignedTo,estimate,story,execution,project,module,pri,desc,estStarted,deadline,mailto,team,teamEstimate,uid,mode';
        $this->batchSetPost($fields);
        $this->setPost('multiple', 1);

        $assignedTo = $this->request('assignedTo');
        if($assignedTo and !is_array($assignedTo)) $this->setPost('assignedTo', array($assignedTo));
        $this->setPost('execution', $executionID);

        $control = $this->loadController('task', 'create');
        $this->requireFields('name,assignedTo,type,estStarted,deadline');

        $control->create($executionID, $this->request('storyID', 0), $this->request('moduleID', 0), $this->request('copyTaskID', 0), $this->request('copyTodoID', 0));

        $data = $this->getData();
        if(!isset($data->id)) return $this->sendError(400, $data->message);

        $task = $this->loadModel('task')->getByID($data->id);

        $this->send(201, $this->format($task, 'deadline:date,openedBy:user,openedDate:time,assignedTo:user,assignedDate:time,realStarted:time,finishedBy:user,finishedDate:time,closedBy:user,closedDate:time,canceledBy:user,canceledDate:time,lastEditedBy:user,lastEditedDate:time,deleted:bool,mailto:userList'));
    }

    public function put($taskID) {
        $oldTask = $this->loadModel('task')->getByID($taskID);

        /* Set $_POST variables. */
//        if (isset($this->requestBody->team))
            $fields = 'name,type,desc,assignedTo,pri,story,parent,execution,module,closedReason,status,estStarted,deadline,team,teamEstimate,teamConsumed,teamLeft,multiple,mailto,uid';
//        else
//            $fields = 'name,type,desc,assignedTo,pri,story,parent,execution,module,closedReason,status,estStarted,deadline,teamEstimate,teamConsumed,teamLeft,multiple,mailto,uid';
//
//        $file = fopen("lalala.txt", "a+");
//        fwrite($file, "team: " . (isset($_POST['team']) ? "true" : "false") . "\n");
//        fclose($file);
        $this->batchSetPost($fields, $oldTask);
        $this->setPost('mode', 'multi');

//        $file = fopen("lalala.txt", "a+");
//        fwrite($file, __LINE__ . " ==============");
//        foreach ($this->post->team as $row => $obj)
//        {
//            fwrite($file, __LINE__ . ": " . $row . ": " . json_encode($obj) . "\n");
//        }
//        foreach ($_POST['team'] as $row => $obj)
//        {
//            fwrite($file, __LINE__ . ": " . $row . ": " . json_encode($obj) . "\n");
//        }
//        fwrite($file, "==============");
//        fclose($file);

        $this->taskController = $this->loadController('task', 'edit');
        $this->taskController->edit($taskID);

        $data = $this->getData();
        if(isset($data->status) and $data->status == 'fail') return $this->sendError(zget($data, 'code', 400), $data->message);
        $task = $this->task->getByID($taskID);
        $this->send(200, $this->format($task, 'deadline:date,openedBy:user,openedDate:time,assignedTo:user,assignedDate:time,realStarted:time,finishedBy:user,finishedDate:time,closedBy:user,closedDate:time,canceledBy:user,canceledDate:time,lastEditedBy:user,lastEditedDate:time,deleted:bool,mailto:userList'));
    }
}

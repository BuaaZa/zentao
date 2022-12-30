<?php

/**
 * 执行API，该API仅支持创建
 * 在创建执行时自动将执行所属的项目成员进行添加
 */
class executionsWithMemberEntry extends Entry
{
    public userModel $user;

    public function post($projectID = 0)
    {
        // 拼接怪，把executionControl 中 ajaxGetTeamMembers 函数截取
        $this->loadModel('user');
        $type = 'execution';
        if($this->config->systemMode == 'new')
        {
            $type = $this->dao->findById($projectID)->from(TABLE_PROJECT)->fetch('type');
            if($type != 'project') $type = 'execution';
        }

        $members = $this->user->getTeamMemberPairs($projectID, $type);

        $ob = new stdClass();
        $ob->members = array_keys($members);

        $fields = 'project,code,name,begin,end,lifetime,desc,days';
        $this->batchSetPost($fields);

        $projectID = $this->param('project', $projectID);
        $this->setPost('project',   $projectID);
        $this->setPost('acl',       $this->request('acl', 'private'));
        $this->setPost('PO',        $this->request('PO', ''));
        $this->setPost('PM',        $this->request('PM', ''));
        $this->setPost('QD',        $this->request('QD', ''));
        $this->setPost('RD',        $this->request('RD', ''));
        $this->setPost('whitelist', $this->request('whitelist', array()));
        $this->setPost('products',  $this->request('products', array()));
        $this->setPost('plans',     $this->request('plans', array()));
        $this->setPost('teamMembers', array_keys($members));

        $control = $this->loadController('execution', 'create');
        $this->requireFields('name,code,begin,end,days');
        $control->create($projectID);

        $data = $this->getData();
        if(isset($data->result) and $data->result == 'fail')
            return $this->sendError(400, $data->message);

        $execution = $this->loadModel('execution')->getByID($data->id);

        // dwr: 对于POST/projects/{id}/executions请求，只保留id
        unset($execution->project);
        unset($execution->model);
        unset($execution->type);
        unset($execution->lifetime);
        unset($execution->budget);
        unset($execution->budgetUnit);
        unset($execution->attribute);
        unset($execution->percent);
        unset($execution->milestone);
        unset($execution->output);
        unset($execution->auth);
        unset($execution->parent);
        unset($execution->path);
        unset($execution->grade);
        unset($execution->name);
        unset($execution->code);
        unset($execution->begin);
        unset($execution->end);
        unset($execution->realBegan);
        unset($execution->realEnd);
        unset($execution->days);
        unset($execution->status);
        unset($execution->subStatus);
        unset($execution->pri);
        unset($execution->desc);
        unset($execution->version);
        unset($execution->parentVersion);
        unset($execution->planDuration);
        unset($execution->realDuration);
        unset($execution->openedBy);
        unset($execution->openedDate);
        unset($execution->openedVersion);
        unset($execution->lastEditedBy);
        unset($execution->lastEditedDate);
        unset($execution->closedBy);
        unset($execution->closedDate);
        unset($execution->canceledBy);
        unset($execution->canceledDate);
        unset($execution->suspendedDate);
        unset($execution->PO);
        unset($execution->PM);
        unset($execution->QD);
        unset($execution->RD);
        unset($execution->team);
        unset($execution->acl);
        unset($execution->whitelist);
        unset($execution->order);
        unset($execution->vision);
        unset($execution->displayCards);
        unset($execution->fluidBoard);
        unset($execution->colWidth);
        unset($execution->minColWidth);
        unset($execution->maxColWidth);
        unset($execution->deleted);
        unset($execution->delay);
        unset($execution->totalHours);
        unset($execution->totalEstimate);
        unset($execution->totalConsumed);
        unset($execution->totalLeft);

//        $this->send(201, $this->format($execution, 'openedBy:user,openedDate:time,lastEditedBy:user,lastEditedDate:time,closedBy:user,closedDate:time,canceledBy:user,canceledDate:time,PM:user,PO:user,RD:user,QD:user,whitelist:userList,begin:date,end:date,realBegan:date,realEnd:date,deleted:bool'));

        $execution->message = "success";
        $this->send(201, $this->format($execution, ""));
    }
}
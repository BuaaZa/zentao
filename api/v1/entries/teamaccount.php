<?php
/**

 */
class teamAccountEntry extends Entry
{
    /**
     * GET method.
     *
     * @param  int    $teamID
     * @access public
     * @return void
     */
    public function get($teamID)
    {
        $fields = $this->param('fields');
        $status = $this->param('status', 'all');

        $control = $this->loadController('team', 'view');
        $control->view($teamID);

        $data = $this->getData();
        if(!$data or !isset($data->status)) return $this->send400('error');
        if(isset($data->status) and $data->status == 'fail') return $this->sendError(zget($data, 'code', 400), $data->message);

        $team = $this->format($data->data->team, 'openedBy:user,openedDate:time,lastEditedBy:user,lastEditedDate:time,closedBy:user,closedDate:time,canceledBy:user,canceledDate:time,PM:user,PO:user,RD:user,QD:user,whitelist:userList,begin:date,end:date,realBegan:date,realEnd:date,deleted:bool');

        $team->progress    = ($team->totalConsumed + $team->totalLeft) ? round($team->totalConsumed / ($team->totalConsumed + $team->totalLeft) * 100, 1) : 0;
        $team->teamMembers = array_values((array)$data->data->teamMembers);
        $team->products    = array();
        foreach($data->data->products as $productID => $teamProduct)
        {
            if($status == 'noclosed' and $teamProduct->status == 'closed') continue;

            $product = new stdclass();
            $product->id = $teamProduct->id;
            $product->name = $teamProduct->name;
            $product->plans = array();
            foreach($teamProduct->plans as $planID)
            {
                $plan = new stdclass();
                $plan->id   = trim($planID, ',');
                $plan->name = $data->data->planGroups->{$productID}->{$plan->id};
                $product->plans[] = $plan;
            }
            $team->products[] = $product;
        }

        $this->loadModel('testcase');
        $team->caseReview = ($this->config->testcase->needReview or !empty($this->config->testcase->forceReview));

        if(!$fields) $this->send(200, $team);

        $users = $data->data->users;

        /* Set other fields. */
        $fields = explode(',', strtolower($fields));
        foreach($fields as $field)
        {
            switch($field)
            {
                case 'modules':
                    $control = $this->loadController('tree', 'browsetask');
                    $control->browsetask($teamID);
                    $data = $this->getData();
                    if(isset($data->status) and $data->status == 'success')
                    {
                        $team->modules = $data->data->tree;
                    }
                case 'builds':
                    $team->builds  = $this->loadModel('build')->getBuildPairs($productID, 'all', 'noempty,noterminate,nodone', $teamID, 'team');
                    break;
                case 'moduleoptionmenu':
                    $team->moduleOptionMenu = $this->loadModel('tree')->getTaskOptionMenu($teamID, 0, 0, 'allModule');
                    break;
                case 'members':
                    $team->members = $this->loadModel('user')->getTeamMemberPairs($teamID, 'team', 'nodeleted');;
                    unset($team->members['']);
                    break;
                case 'stories':
                    $stories = $this->loadModel('story')->getteamStories($teamID);
                    foreach($stories as $storyID => $story) $stories[$storyID] = $this->filterFields($story, 'id,title,module,pri,status,stage,estimate');

                    $team->stories = array_values($stories);
                    break;
                case 'actions':
                    $actions = $data->data->actions;
                    $team->actions = $this->loadModel('action')->processActionForAPI($actions, $users, $this->lang->team);
                    break;
                case "dynamics":
                    $dynamics = $data->data->dynamics;
                    $team->dynamics = $this->loadModel('action')->processDynamicForAPI($dynamics);
                    break;
                case 'chartdata':
                    list($dateList, $interval) = $this->loadModel('team')->getDateList($team->begin, $team->end, 'noweekend', '0', 'Y-m-d');
                    $team->chartData = $this->team->buildBurnData($teamID, $dateList, 'noweekend', 'left');
                    break;
            }
        }

        return $this->send(200, $team);
    }

    /**
     * PUT method.
     *
     * @param  int    $teamID
     * @access public
     * @return void
     */
    public function put($teamID)
    {
       // $oldteam = $this->loadModel('team')->getByID($teamID);

        /* Set $_POST variables. */
        $fields = 'project,code,name,begin,end,lifetime,desc,days,acl,status,PO,PM,QD,RD';
        //$this->batchSetPost($fields, $oldteam);

       // $this->setPost('whitelist', $this->request('whitelist', explode(',', $oldteam->whitelist)));

        $products = $this->loadModel('product')->getProducts($teamID);
        //$this->setPost('products', $this->request('products', array_keys($products)));

        $control = $this->loadController('team', 'edit');
        $control->edit($teamID);

        $data = $this->getData();
        if(isset($data->result) and $data->result == 'fail') return $this->sendError(400, $data->message);
        if(!isset($data->result)) return $this->sendError(400, 'error');

        $team = $this->team->getByID($teamID);
        
        $this->send(200, $this->format($team, 'openedBy:user,openedDate:time,lastEditedBy:user,lastEditedDate:time,closedBy:user,closedDate:time,canceledBy:user,canceledDate:time,PM:user,PO:user,RD:user,QD:user,whitelist:userList,begin:date,end:date,realBegan:date,realEnd:date,deleted:bool'));
    }

    /**
     * DELETE method.
     *
     * @param  int    $teamID
     * @access public
     * @return void
     */
    public function delete($teamID)
    {
        //$control = $this->loadController('team', 'delete');
        //$control->delete($teamID, 'true');
        $team = $this->dao->select("*")->from(TABLE_TEAM)
                          ->where('id')->eq($teamID)
                          ->fetchALL();
        if(empty($team)){
            $data["error"] = "No such team member";
            return $this->send(200,$this->format($data,""));
        }
       
        //delete id,account
        //$this->getData();
        $this->dao->delete()->from(TABLE_TEAM)->where('id')->eq($teamID)->exec();
        $this->sendSuccess(200, 'success');
    }
}

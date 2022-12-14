<?php
class myCompany extends company{
    public function dynamic($browseType = 'today', $param = '', $recTotal = 0, $date = '', $direction = 'next', $userID = '', $productID = 0, $projectID = 0, $executionID = 0, $orderBy = 'date_desc')
    {
        $this->company->setMenu();
        $this->app->loadLang('user');
        $this->app->loadLang('execution');
        $this->loadModel('action');

        /* Save session. */
        $uri = $this->app->getURI(true);
        $this->session->set('productList',     $uri, 'product');
        $this->session->set('productPlanList', $uri, 'product');
        $this->session->set('releaseList',     $uri, 'product');
        $this->session->set('storyList',       $uri, 'product');
        $this->session->set('projectList',     $uri, 'project');
        $this->session->set('riskList',        $uri, 'project');
        $this->session->set('opportunityList', $uri, 'project');
        $this->session->set('trainplanList',   $uri, 'project');
        $this->session->set('taskList',        $uri, 'execution');
        $this->session->set('buildList',       $uri, 'execution');
        $this->session->set('bugList',         $uri, 'qa');
        $this->session->set('caseList',        $uri, 'qa');
        $this->session->set('testtaskList',    $uri, 'qa');
        $this->session->set('effortList',      $uri, 'my');
        $this->session->set('meetingList',     $uri, 'my');
        $this->session->set('meetingList',     $uri, 'project');
        $this->session->set('meetingroomList', $uri, 'admin');

        /* Set the pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage = 50, $pageID = 1);

        /* Append id for secend sort. */
        if($direction == 'next') $orderBy = 'date_desc';
        if($direction == 'pre')  $orderBy = 'date_asc';

        $queryID = ($browseType == 'bysearch') ? (int)$param : 0;
        $date    = empty($date) ? '' : date('Y-m-d', $date);

        /* Get products' list.*/
        $products = $this->loadModel('product')->getPairs('nocode');
        $products = array($this->lang->company->product) + $products;
        $this->view->products = $products;

        /* Get projects' list.*/
        $projects = $this->loadModel('project')->getPairsByProgram();
        $this->view->projects = array($this->lang->company->project) + $projects;;

        /* Get executions' list.*/
        $executions = $this->loadModel('execution')->getPairs(0, 'all', 'nocode');
        $executionsIDList = array_keys($executions);
        $executionsList = $this->execution->getByIdList($executionsIDList);
        foreach($executionsList as $executionsID => $executionObj)
        {
            foreach($projects as $projectsID => $projectsName)
            {
                if($executionObj->project == $projectsID) $executions[$executionObj->id] = $projectsName . '/' . $executionObj->name;
            }
        }
        $executions = array($this->lang->execution->common) + $executions;
        $this->view->executions = $executions;

        /* Set account and get users.*/
        $user    = $userID ? $this->loadModel('user')->getById($userID, 'id') : '';
        $account = $user ? $user->account : 'all';

        $userIdPairs = $this->loadModel('user')->getPairs('noclosed|nodeleted|noletter|useid');
        $userIdPairs[''] = $this->lang->company->user;
        $this->view->userIdPairs = $userIdPairs;

        $accountPairs = $this->user->getPairs('nodeleted|noletter|all');
        $accountPairs[''] = '';

        /* Get account=>ip pairs from users */
        $accountPairsForGetIp= $accountPairs;
        unset($accountPairsForGetIp['']);
        unset($accountPairsForGetIp['closed']);
        $userIpPairs = $this->dao->select('account, ip')->from(TABLE_USER)->where('account')->in(array_keys($accountPairsForGetIp))->fetchPairs();
        $this->view->userIpPairs = $userIpPairs;

        /* The header and position. */
        $this->view->title      = $this->lang->company->common . $this->lang->colon . $this->lang->company->dynamic;
        $this->view->position[] = $this->lang->company->dynamic;

        /* Get actions. */

        if($browseType != 'bysearch')
        {
            if(!$productID)   $productID   = 'all';
            if(!$projectID)   $projectID   = 'all';
            if(!$executionID) $executionID = 'all';
            $actions = $this->action->getDynamic($account, $browseType, $orderBy, $pager, $productID, $projectID, $executionID, $date, $direction);
        }
        else
        {
            $actions = $this->action->getDynamicBySearch($products, $projects, $executions, $queryID, $orderBy, $pager, $date, $direction);
        }

        /* Build search form. */
        $executions[0] = '';
        $products[0]   = '';
        $projects[0]   = '';
        ksort($executions);
        ksort($products);
        ksort($projects);
        $executions['all'] = $this->lang->execution->allExecutions;
        $products['all']   = $this->lang->product->allProduct;
        $projects['all']   = $this->lang->project->all;

        foreach($this->lang->action->search->label as $action => $name)
        {
            if($action) $this->lang->action->search->label[$action] .= " [ $action ]";
        }

        $this->config->company->dynamic->search['actionURL'] = $this->createLink('company', 'dynamic', "browseType=bysearch&param=myQueryID");
        $this->config->company->dynamic->search['queryID'] = $queryID;
        $this->config->company->dynamic->search['params']['action']['values']    = $this->lang->action->search->label;
        if($this->config->vision == 'rnd') $this->config->company->dynamic->search['params']['product']['values']   = $products;
        $this->config->company->dynamic->search['params']['project']['values']   = $projects;
        $this->config->company->dynamic->search['params']['execution']['values'] = $executions;
        $this->config->company->dynamic->search['params']['actor']['values']     = $accountPairs;
        $this->loadModel('search')->setSearchParams($this->config->company->dynamic->search);

        /* Assign. */
        $this->view->recTotal     = $recTotal;
        $this->view->browseType   = $browseType;
        $this->view->account      = $account;
        $this->view->accountPairs = $accountPairs;
        $this->view->productID    = $productID;
        $this->view->projectID    = $projectID;
        $this->view->executionID  = $executionID;
        $this->view->queryID      = $queryID;
        $this->view->orderBy      = $orderBy;
        $this->view->pager        = $pager;
        $this->view->userID       = $userID;
        $this->view->param        = $param;
        $this->view->dateGroups   = $this->action->buildDateGroup($actions, $direction, $browseType, $orderBy);
        $this->view->direction    = $direction;
        $this->display();
    }
}

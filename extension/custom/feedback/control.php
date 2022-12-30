<?php
class feedback extends control
{
      /**
     * Construct function.
     *
     * @access public
     * @return void
     */
    public function __construct($module = '', $method = '')
    {
        parent::__construct($module, $method);
        $this->loadModel('product');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('action');
        $this->loadModel('story');
        $this->loadModel('task');
        $this->loadModel('qa');

        $this->projectID = $this->session->project ? $this->session->project : 0;

        /* Get product data. */
        $products = array();
        $objectID = 0;
        $tab      = ($this->app->tab == 'project' or $this->app->tab == 'execution') ? $this->app->tab : 'qa';
        if(!isonlybody())
        {
            if($this->app->tab == 'project' or $this->app->tab == 'execution')
            {
                $objectID = $this->app->tab == 'project' ? $this->session->project : $this->session->execution;
                $products = $this->product->getProducts($objectID, 'all', '', false);
            }
            else
            {
                $mode     = ($this->app->methodName == 'create' and empty($this->config->CRProduct)) ? 'noclosed' : '';
                $products = $this->product->getPairs($mode, 0, 'program_asc');
            }
            if(empty($products) and !helper::isAjaxRequest()) return print($this->locate($this->createLink('product', 'showErrorNone', "moduleName=$tab&activeMenu=bug&objectID=$objectID")));
        }
        else
        {
            $mode     = (empty($this->config->CRProduct)) ? 'noclosed' : '';
            $products = $this->product->getPairs($mode, 0, 'program_asc');
        }
        $this->view->products = $this->products = $products;
        $this->view->allProducts = $this->allProducts = $products;

        $this->view->users = $this->user->getPairs('realname|noletter');

    }
    /**
      * Browse feedbacks.
      *
      * @param  int    $productID
      * @param  string $browseType
      * @param  int    $param
      * @param  string $orderBy
      * @param  int    $recTotal
      * @param  int    $recPerPage
      * @param  int    $pageID
      * @access public
      * @return void
      */
   public function admin($browseType = '', $productID = "all", $orderBy = '', $recTotal = 0, $recPerPage = 20, $pageID = 1)
   {
      $moduleID= 'all';
      $branch = '';
      $this->loadModel('datatable');
      $this->session->set('feedbackList', $this->app->getURI(true), 'feedback');
    //   $productID = $this->product->saveState($productID, $this->products);
      $product   = $this->product->getById($productID);
      if(!empty($product) && $product->type != 'normal')
      {
          /* Set productID, moduleID, queryID and branch. */
          $branch = ($this->cookie->preBranch !== '' and $branch === '') ? $this->cookie->preBranch : $branch;
          setcookie('preProductID', $productID, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);
          setcookie('preBranch', $branch, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);
      }
      else
      {
          $branch = 'all';
      }
      if($browseType == "byProduct"){
        $browseType = "all";
      }

      $this->feedback->setMenu($this->allProducts, $productID, $branch);
      /* Process the order by field. */
    //   if(!$orderBy) $orderBy = $this->cookie->qaBugOrder ? $this->cookie->qaBugOrder : 'id_desc';
    //   setcookie('qaBugOrder', $orderBy, 0, $this->config->webRoot, '', $this->config->cookieSecure, true);

      /* Append id for secend sort. */
      $sort = common::appendOrder($orderBy);
      /* Load pager. */
      $this->app->loadClass('pager', $static = true);
      if($this->app->getViewType() == 'mhtml' || $this->app->getViewType() == 'xhtml') $recPerPage = 10;
      $pager = new pager($recTotal, $recPerPage, $pageID);

      //$this->qa->setMenu($this->products, $productID, $branch);

     
      /* Get product id list. */
      $productIDList = $productID!="all" ? array($productID) : array_keys($this->products);
      $moduleTree = $this->tree->getFeedbackTreeMenu($this->projectID, $productIDList, 0, array('treeModel', 'createFeedbackLink'),array());

      $feedbacks = $this->feedback->getFeedbacks($productIDList, array(), $branch, $browseType, '', '', $sort, $pager, $this->projectID);
      /* Set browse type. */
      $browseType = strtolower($browseType);
      $this->view->moduleTree      = $moduleTree;
      $this->view->browseType      = $browseType;
      $this->view->feedbacks = $feedbacks;
      $this->view->pager           = $pager;
      $this->view->moduleName      = ($moduleID and $moduleID !== 'all') ? $this->tree->getById($moduleID)->name : $this->lang->tree->all;

      $this->display();
    }

     /**
     * Create a bug.
     *
     * @param  int    $productID
     * @param  string $branch
     * @param  string $extras       others params, forexample, executionID=10,moduleID=10
     * @access public
     * @return void
     */
    public function create($productID, $branch = '', $extras = '')
    {
      if(empty($this->products)) $this->locate($this->createLink('feedback', 'create'));
      if(!empty($_POST))
      {
        $response['result'] = 'success';

        /* Set from param if there is a object to transfer bug. */
        setcookie('lastFeedbackModule', (int)$this->post->module, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, false);

        $feedbackResult = $this->feedback->create('', $extras);
        if(!$feedbackResult or dao::isError())
        {
            $response['result']  = 'fail';
            $response['message'] = dao::getError();
            return $this->send($response);
        }
        $feedbackID = $feedbackResult['id'];
        if($feedbackResult['status'] == 'exists')
        {
            $response['message'] = sprintf($this->lang->duplicate, $this->lang->feedback->common);
            $response['locate']  = $this->createLink('feedback', 'view', "feedbackID=$feedbackID");
            $response['id']      = $feedbackResult['id'];
            return $this->send($response);
        }
        if(isonlybody()){
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'locate' => inlink('admin-all')));
        } 
        if($this->app->getViewType() == 'xhtml') $location = $this->createLink('feedback', 'view', "feedbackID=$feedbackID", 'html');
        $response['message'] = $this->lang->saveSuccess;
        $response['locate']  = $location;
        return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'locate' => inlink('admin-all')));
      }
      $this->display();
    }

     /**
     * Edit a feedback.
     *
     * @param  int    $feedbackID
     * @param  bool   $comment
     * @param  string $kanbanGroup
     * @access public
     * @return void
     */
    public function edit($feedbackID, $comment = false, $kanbanGroup = 'default')
    {
        if(!empty($_POST))
        {
            $changes = array();
            $files   = array();
            if($comment == false)
            {
                $changes = $this->feedback->update($feedbackID);
                if(dao::isError())
                {
                    if(defined('RUN_MODE') && RUN_MODE == 'api') return $this->send(array('status' => 'error', 'message' => dao::getError()));
                    return print(js::error(dao::getError()));
                }
            }

            if($this->post->comment != '' or !empty($changes))
            {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $actionID = $this->action->create('feedback', $feedbackID, $action, $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'locate' => inlink('admin-all')));
        }
        $feedback             = $this->feedback->getById($feedbackID);

        $this->view->feedback = $feedback;
        $this->display();
    }

    public function view($feedbackID,$browseType = '')
    {
        $feedback             = $this->feedback->getById($feedbackID);
        $this->view->feedback = $feedback;
        $this->view->browseType      = $browseType;

        $this->display();
    }

    public function toStory($productID=0)
    {
        $menuTest = $this->fetch('story', 'create', "productID=$productID");
        return print($menuTest);
        //$this->display();
    }

    public function comment($type='')
    {        
        $this->view->title = $this->lang->feedback->comment;
        if($type=='replied') $this->view->title = $this->lang->feedback->reply;
        $this->view->type=$type;
        $this->display();
    }
    public function reply()
    {
        $menuTest = $this->fetch('feedback', 'comment', "type=replied");
        return print($menuTest);
    }

    /**
     * Ajax get feedback status.
     *
     * @param  string $method
     * @param  string $params
     * @access public
     * @return void
     */
    public function ajaxGetStatus($method, $params = '')
    {
        parse_str(str_replace(',', '&', $params), $params);
        $status = '';
        if($method == 'create')
        {
            $status = 'wait';
            if(!empty($params['needNotReview'])) $status = 'active';
            if(!empty($params['project']))       $status = 'active';
            if($this->feedback->checkForceReview()) $status = 'wait';
        }
        elseif($method == 'update')
        {
            $oldFeedback = $this->dao->findById((int)$params['feedbackID'])->from(TABLE_FEEDBACK)->fetch();
            $status   = $oldFeedback->status;            
        }
        elseif($method == 'review')
        {
            $oldStory = $this->dao->findById((int)$params['feedbackID'])->from(TABLE_FEEDBACK)->fetch();
            $status   = $oldStory->status;
            if($params['result'] == 'revert') $status = 'active';
        }
        echo $status;
    }    

    public function ajaxGetModule($productId) {
        $moduleOptionMenu = $this->tree->getOptionMenu($productId, 'feedback', $startModuleID = 0);
        return print(html::select('module', $moduleOptionMenu, 0, "class='form-control'"));
    }

        /**
     * Drop menu page.
     *
     * @param  int    $productID
     * @param  string $module
     * @param  string $method
     * @param  string $extra
     * @access public
     * @return void
     */
    public function ajaxGetDropMenu($productID, $module, $method, $extra = '')
    {
        $menuTest = $this->fetch('product', 'ajaxGetDropMenu', "id=$productID&module=$module&method=$method&extra=$extra&from=1");
        return print($menuTest);
    }
}
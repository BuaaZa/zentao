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
        $this->loadModel('file');

        $this->projectID = $this->session->project ? $this->session->project : 0;

        /* Get product data. */
        $products = array();
        $objectID = 0;
        $tab      = ($this->app->tab == 'project' or $this->app->tab == 'execution') ? $this->app->tab : 'qa';
        if (!isonlybody()) {
            if ($this->app->tab == 'project' or $this->app->tab == 'execution') {
                $objectID = $this->app->tab == 'project' ? $this->session->project : $this->session->execution;
                $products = $this->product->getProducts($objectID, 'all', '', false);
            } else {
                $mode     = ($this->app->methodName == 'create' and empty($this->config->CRProduct)) ? 'noclosed' : '';
                $products = $this->product->getPairs($mode, 0, 'program_asc');
            }
            if (empty($products) and !helper::isAjaxRequest()) return print($this->locate($this->createLink('product', 'showErrorNone', "moduleName=$tab&activeMenu=bug&objectID=$objectID")));
        } else {
            // $mode     = (empty($this->config->CRProduct)) ? 'noclosed' : '';
            $products = $this->product->getPairs('', 0, 'program_asc');
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
    public function admin(
        $browseType = '',
        $productID = "all",
        $orderBy = '',
        $param = 0,
        $recTotal = 0,
        $recPerPage = 20,
        $pageID = 1
    ) {
        $moduleID = 'all';
        $keyword = $_GET['keyword'];
        if (!empty($keyword)) {
            $keyword = '%' . $keyword . '%';
        } else {
            $keyword = '';
        }
        // 获取反馈类型 all 或者 $this->lang->feedback->typeList 中的 1...n个key值用,连接的字符串
        $type = $_GET['type'];
        $types = array();
        $this->loadModel('datatable');
        $this->session->set('feedbackList', $this->app->getURI(true), 'feedback');

        if ($browseType == "byProduct") {
            $browseType = "all";
        }
        if (!isset($type) || $type == 'all') {
            $types = array_keys($this->lang->feedback->typeList);
        } else {
            $types = explode(",", $type);
        }

        $this->feedback->setMenu($this->allProducts, $productID, '');
        /* Process the order by field. */
        if (!$orderBy) $orderBy = $this->cookie->qaFeedbackOrder ? $this->cookie->qaFeedbackOrder : 'id_desc';
        setcookie('qaFeedbackOrder', $orderBy, 0, $this->config->webRoot, '', $this->config->cookieSecure, true);

        /* Append id for secend sort. */

        /* Process the order by field. */
        $sort = common::appendOrder($orderBy);
        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        if ($this->app->getViewType() == 'mhtml' || $this->app->getViewType() == 'xhtml') $recPerPage = 10;
        $pager = new pager($recTotal, $recPerPage, $pageID);

        //$this->qa->setMenu($this->products, $productID, $branch);

        /* Set browse type. */
        $browseType = strtolower($browseType);

        /* Build the search form. */
        $queryID  = ($browseType == 'bysearch') ? (int)$param : 0;

        /* Get product id list. */
        $productIDList = $productID != "all" ? explode(",", $productID) : array_keys($this->products);
        $moduleTree = $this->tree->getProductsTreeMenu($this->projectID, $productIDList, 0, array('treeModel', 'createFeedbackLink'), array());

        $feedbacks = $this->feedback->getFeedbacks($productIDList, $types, $keyword, $browseType, '', $queryID, $sort, $pager, $this->projectID);
        if (defined('RUN_MODE') && RUN_MODE == 'api') {
            $feedbacks = $this->feedback->processForApi($feedbacks);
        }

        $actionURL = $this->createLink('feedback', 'admin', "browseType=bySearch&productID=$productID&orderBy=$orderBy&queryID=myQueryID");
        $this->config->feedback->search['onMenuBar'] = 'yes';
        $this->feedback->buildSearchForm($productID, $this->products, $queryID, $actionURL, '');

        $this->view->moduleTree      = $moduleTree;
        $this->view->browseType      = $browseType;
        $this->view->feedbacks = $feedbacks;
        $this->view->pager           = $pager;
        $this->view->param = $productID;
        $this->view->orderBy = $orderBy;
        // 替换掉左上角的所有模块字样
        $this->view->moduleName      = $this->lang->feedback->allProduct; //($moduleID and $moduleID !== 'all') ? $this->tree->getById($moduleID)->name : $this->lang->tree->all;

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
        if (empty($this->products)) $this->locate($this->createLink('feedback', 'create'));
        if (!empty($_POST)) {
            $response['result'] = 'success';

            /* Set from param if there is a object to transfer bug. */
            setcookie('lastFeedbackModule', (int)$this->post->module, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, false);

            $feedbackResult = $this->feedback->create('', $extras);
            if (!$feedbackResult or dao::isError()) {
                $response['result']  = 'fail';
                $response['message'] = dao::getError();
                return $this->send($response);
            }
            $feedbackID = $feedbackResult['id'];
            if ($feedbackResult['status'] == 'exists') {
                $response['message'] = sprintf($this->lang->duplicate, $this->lang->feedback->common);
                $response['locate']  = $this->createLink('feedback', 'view', "feedbackID=$feedbackID");
                $response['id']      = $feedbackResult['id'];
                $response['exists']      = 1;
                return $this->send($response);
            }
            if ($feedbackResult['result'] == 'fail') {
                $response['result']  = 'fail';
                $response['message'] = $feedbackResult['message'];
                return $this->send($response);
            }

            if ($branch == "json") {
                return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'id' => $feedbackID));
            }

            if (isonlybody()) {
                return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'locate' => inlink('admin','browseType=all')));
            }
            if ($this->app->getViewType() == 'xhtml') $location = $this->createLink('feedback', 'view', "feedbackID=$feedbackID", 'html');
            $response['message'] = $this->lang->saveSuccess;
            $response['locate']  = $location;
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'locate' => inlink('admin','browseType=all')));
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
        if (!empty($_POST)) {
            $changes = array();
            $files   = array();
            if ($comment == false) {
                $changes = $this->feedback->update($feedbackID);
                if (dao::isError()) {
                    if (defined('RUN_MODE') && RUN_MODE == 'api') return $this->send(array('status' => 'error', 'message' => dao::getError()));
                    return print(js::error(dao::getError()));
                }
            }

            if ($this->post->comment != '' or !empty($changes)) {
                $action = !empty($changes) ? 'Edited' : 'Commented';
                $actionID = $this->action->create('feedback', $feedbackID, $action, $this->post->comment);
                $this->action->logHistory($actionID, $changes);
            }
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'closeModal' => true, 'locate' => inlink('admin','browseType=all')));
        }
        $feedback             = $this->feedback->getById($feedbackID);

        $this->view->feedback = $feedback;
        $this->display();
    }

    public function view($feedbackID, $browseType = '')
    {
        $feedback             = $this->feedback->getById($feedbackID);
        if ($feedback) {
            $feedback->files = $this->loadModel('file')->getByObject('feedback', $feedbackID);
        }
        $this->view->feedback = $feedback;
        $this->view->browseType      = $browseType;
        $this->view->actions     = $this->action->getList('feedback', $feedbackID);
        $this->display();
    }

    public function toStory($productID = 0, $extra = '')
    {
        $params = "productID=$productID&branch=0&moduleID=0&storyID=0&objectID=0&bugID=0&planID=0&todoID=0&$extra";
        echo $this->fetch('story', 'createStory', $params);
    }

    public function toBug($productID = 0, $extra = '')
    {
        $params = "productID=$productID&branch=0&$extra";
        echo $this->fetch('bug', 'createBug', $params);
    }

    public function ajaxGetProjects($productID, $branch = 0, $projectID = 0)
    {
        $projects  = array('' => '');
        $projects += $this->product->getProjectPairsByProduct($productID, $branch);
        if ($this->app->getViewType() == 'json') return print(json_encode($projects));

        return print(html::select('project', $projects, $projectID, "class='form-control' onchange='loadProductExecutions({$productID}, this.value)'"));
    }

    public function ajaxGetExecutions($productID, $projectID = 0, $branch = 0, $number = '', $executionID = 0, $from = '')
    {
        if ($this->app->tab == 'execution' and $this->session->execution) {
            $execution = $this->loadModel('execution')->getByID($this->session->execution);
            if ($execution->type == 'kanban') $projectID = $execution->project;
        }

        $notClosed  = ($from == 'bugToTask' or empty($this->config->CRExecution)) ? 'noclosed' : '';
        $executions = $from == 'showImport' ? $this->product->getAllExecutionPairsByProduct($productID, $branch, $projectID) : $this->product->getExecutionPairsByProduct2($productID, $branch, 'id_desc', $projectID, $notClosed);
        if ($this->app->getViewType() == 'json') return print(json_encode($executions));

        if ($number === '') {
            $event = ''; //$from == 'bugToTask' ? '' : " onchange='loadExecutionRelated(this.value)'";
            return print(html::select('execution', array('' => '') + $executions, $executionID, "class='form-control' $event"));
        } else {
            $executions     = empty($executions) ? array('' => '') : $executions;
            $executionsName = $from == 'showImport' ? "execution[$number]" : "executions[$number]";
            $misc           = $from == 'showImport' ? "class='form-control' onchange='loadImportExecutionRelated(this.value, $number)'" : "class='form-control' onchange='loadExecutionBuilds($productID, this.value, $number)'";
            return print(html::select($executionsName, $executions, '', $misc));
        }
    }

    public function toTask($executionID = '', $storyID = 0, $moduleID = 0, $taskID = 0, $todoID = 0, $extra = '', $bugID = 0)
    {
        $params = 'executionID=' . $executionID . '&storyID=0&moduleID=0&taskID=0&todoID=0&extra=' . $extra;
        echo $this->fetch('task', 'createTask', $params);
    }

    public function selectProject2($productID = 0, $extra = '')
    {
        $feedback             = $this->feedback->getById($feedbackID);
        if ($feedback) {
            $feedback->files = $this->loadModel('file')->getByObject('feedback', $feedbackID);
        }
        $this->view->feedback = $feedback;
        $this->view->browseType      = $browseType;
        $this->view->actions     = $this->action->getList('feedback', $feedbackID);
        $this->display();
    }

    public function comment($feedbackID = 0, $type = '', $enternalIds = array())
    {
        // 提前检查文件数量与enternalId数量是否匹配，防止出现反馈评论已经保存成功，再提示数量不对的情况
        $enternalIdLen = count($enternalIds);
        if ($enternalIdLen > 0 && $enternalIdLen != count($_FILES)) {
            $this->loadModel('file');
            return $this->send(array('status' => 'error', 'message' => $this->lang->file->misscount));
        }
        // 提前检查文件数量与enternalId数量是否匹配，防止出现反馈评论已经保存成功，再提示数量不对的情况

        if ($this->post->comment != '') {
            $actionID = $this->action->create('feedback', $feedbackID, $type, $this->post->comment);

            if (!empty($actionID)) {
                $this->loadModel('file');
                $this->file->updateObjectID($this->post->uid, $actionID, 'comment');
                $ret = $this->file->saveUpload2('comment', $actionID, '', 'files', 'labels', $enternalIds);
                if ($ret == 'wrong' && defined('RUN_MODE') && RUN_MODE == 'api') {
                    return $this->send(array('status' => 'error', 'message' => $this->lang->file->misscount));
                }
                if (strlen($this->post->commentExId) > 0) {
                    // 如果存在commentExId字段则更新
                    $this->dao->update(TABLE_ACTION)
                        ->set('commentExId')->eq($this->post->commentExId)
                        ->where('id')->eq($actionID)
                        ->exec();
                }
            }
            if (defined('RUN_MODE') && RUN_MODE == 'api') return $this->send(array('status' => 'success', 'data' => $feedbackID, 'actionID' => $actionID,'users'=>$this->view->users));
            return print(js::closeModal('parent.parent'));
            // return print(js::locate($this->createLink('feedback', 'view', "feedbackID=$feedbackID"), 'parent'));
        }
        $this->view->title = $this->lang->feedback->comment;
        if ($type == 'replied') $this->view->title = $this->lang->feedback->reply;
        $this->view->type = $type;
        $this->display();
    }
    public function reply()
    {
        $menuTest = $this->fetch('feedback', 'comment', "type=replied");
        return print($menuTest);
    }

    // 删除评论
    public function deleteComment($commentID = 0)
    {
        $action = $this->action->getById($commentID);
        if (!$action) {
            $error = '没找到评论记录';
            if (defined('RUN_MODE') && RUN_MODE == 'api') {
                return $this->send(array('status' => 'error', 'message' => $error));
            }
            return print(js::error($error));
        }
        if ($action->action != "commented") {
            $error = 'id对应的记录不是评论';
            if (defined('RUN_MODE') && RUN_MODE == 'api') {
                return $this->send(array('status' => 'error', 'message' => $error));
            }
            return print(js::error($error));
        }
        if ($action->objectType != "feedback") {
            $error = 'id对应的记录不是反馈所属的评论';
            if (defined('RUN_MODE') && RUN_MODE == 'api') {
                return $this->send(array('status' => 'error', 'message' => $error));
            }
            return print(js::error($error));
        }
        if ($action->actor != $this->app->user->account) {
            $error = '你不是当前记录的创建人, 无法删除';
            if (defined('RUN_MODE') && RUN_MODE == 'api') {
                return $this->send(array('status' => 'error', 'message' => $error));
            }
            return print(js::error($error));
        }
        $this->dao->delete()->from(TABLE_ACTION)->where('id')->eq($commentID)->exec();
        if (defined('RUN_MODE') && RUN_MODE == 'api') {
            return $this->send(array('status' => 'success', 'data' => $feedbackID));
        }
        $this->display();
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
        if ($method == 'create') {
            $status = 'wait';
            if (!empty($params['needNotReview'])) $status = 'active';
            if (!empty($params['project']))       $status = 'active';
            if ($this->feedback->checkForceReview()) $status = 'wait';
        } elseif ($method == 'update') {
            $oldFeedback = $this->dao->findById((int)$params['feedbackID'])->from(TABLE_FEEDBACK)->fetch();
            $status   = $oldFeedback->status;
        } elseif ($method == 'review') {
            $oldStory = $this->dao->findById((int)$params['feedbackID'])->from(TABLE_FEEDBACK)->fetch();
            $status   = $oldStory->status;
            if ($params['result'] == 'revert') $status = 'active';
        }
        echo $status;
    }

    public function ajaxGetModule($productId)
    {
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

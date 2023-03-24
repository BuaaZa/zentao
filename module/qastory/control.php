<?php
/**
 * The control file of projectStory module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     projectStory
 * @version     $Id: control.php 5094 2013-07-10 08:46:15Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class qaStory extends control
{
    /**
     * All products.
     *
     * @var    array
     * @access public
     */
    public $products = array();

    public function __construct($module = '', $method = '')
    {
        parent::__construct($module, $method);
        $this->loadModel('product');
        $this->loadModel('story');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('action');
    }

    /**
     * Get software requirements from product.
     *
     * @param  int    $projectID
     * @param  int    $productID
     * @param  int    $branch
     * @param  string $browseType
     * @param  int    $param
     * @param  string $storyType
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function story($productID = 0, $projectID = 0,$branch = 0, $browseType = '', $param = 0, $storyType = 'story', $orderBy = '', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        //$this->products = $this->loadModel('product')->getProductPairsByProject($projectID);

        /* Set product list for export. */
        //$this->session->set('exportProductList', $this->products);

        //if(empty($this->products)) return print($this->locate($this->createLink('product', 'showErrorNone', 'moduleName=project&activeMenu=story&projectID=' . $projectID)));
        echo $this->fetch('product', 'browse', "productID=$productID");
    }

    public function batchCreate($productID = 0, $branch = 0, $moduleID = 0, $storyID = 0, $executionID = 0, $plan = 0, $storyType = 'story', $extra = '')
    {
        
        $this->loadModel('qa')->setMenu('',$productID);

        /* Clear title when switching products and set the session for the current product. */
        if($productID != $this->cookie->preProductID) unset($_SESSION['storyImagesFile']);
        setcookie('preProductID', $productID, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);

        /* Check can subdivide or not. */
        if($storyID)
        {
            $story = $this->story->getById($storyID);
            if($storyType != 'taskPoint' && ($story->status != 'active' or $story->stage != 'wait' or $story->parent > 0) and $this->config->vision != 'lite') return print(js::alert($this->lang->story->errorNotSubdivide) . js::locate('back'));
        }

        if(!empty($_POST))
        {
            $mails = $this->qastory->batchCreate($storyID, $branch, $storyType);
            if(dao::isError()) return print(js::error(dao::getError()));
            $stories = array();
            foreach($mails as $mail) $stories[] = $mail->storyID;

            /* If storyID not equal zero, subdivide this story to child stories and close it. */
            if($storyID and !empty($mails))
            {
                $this->story->subdivide($storyID, $stories);
                if(dao::isError()) return print(js::error(dao::getError()));
            }

            if($this->viewType == 'json') return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'idList' => $stories));
            if($storyID)
            {
                return print(js::locate($this->createLink('qastory', 'story', "productID=$productID"), 'parent'));
            }
            elseif($executionID)
            {
                setcookie('storyModuleParam', 0, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
                $moduleName = $execution->type == 'project' ? 'projectstory' : 'execution';
                $param      = $execution->type == 'project' ? "projectID=$executionID&productID=$productID" : "executionID=$executionID&orderBy=id_desc&browseType=unclosed";
                $link       = $this->createLink($moduleName, 'story', $param);
                return print(js::locate($link, 'parent'));
            }
            else
            {
                setcookie('storyModule', 0, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
                $locateLink = $this->session->storyList ? $this->session->storyList : $this->createLink('product', 'browse', "productID=$productID&branch=$branch&browseType=unclosed&queryID=0&storyType=$storyType");
                return print(js::locate($locateLink, 'parent'));
            }
        }

        /* Set branch and module. */
        $product  = $this->product->getById($productID);
        $products = $this->product->getPairs();
        if($product) $this->lang->product->branch = sprintf($this->lang->product->branch, $this->lang->product->branchName[$product->type]);

        $branches = $product->type != 'normal' ? $this->loadModel('branch')->getPairs($productID, 'active') : array();

        $moduleOptionMenu = $this->tree->getOptionMenu($productID, $viewType = 'story', 0, $branch === 'all' ? 0 : $branch);
        $moduleOptionMenu['ditto'] = $this->lang->story->ditto;

        /* Get reviewers. */
        $reviewers = $product->reviewer;
        if(!$reviewers and $product->acl != 'open') $reviewers = $this->loadModel('user')->getProductViewListUsers($product, '', '', '', '');

        /* Init vars. */
        $planID   = $plan;
        $pri      = 3;
        $estimate = '';
        $title    = '';
        $spec     = '';

        /* Process upload images. */
        if($this->session->storyImagesFile)
        {
            $files = $this->session->storyImagesFile;
            foreach($files as $fileName => $file)
            {
                $title = $file['title'];
                $titles[$title] = $fileName;
            }
            $this->view->titles = $titles;
        }
        $plans          = $this->loadModel('productplan')->getPairsForStory($productID, ($branch === 'all' or !in_array($branch, array_keys($branches))) ? 0 : $branch, 'skipParent|unexpired|noclosed');
        $plans['ditto'] = $this->lang->story->ditto;

        $priList          = (array)$this->lang->story->priList;
        $priList['ditto'] = $this->lang->story->ditto;

        $sourceList          = (array)$this->lang->story->sourceList;
        $sourceList['ditto'] = $this->lang->story->ditto;

        /* Set Custom*/
        foreach(explode(',', $this->config->story->list->customBatchCreateFields) as $field)
        {
            if($product->type != 'normal') $customFields[$product->type] = $this->lang->product->branchName[$product->type];
            $customFields[$field] = $this->lang->story->$field;
        }

        if($product->type != 'normal')
        {
            $this->config->story->custom->batchCreateFields = sprintf($this->config->story->custom->batchCreateFields, $product->type);
        }
        else
        {
            $this->config->story->custom->batchCreateFields = trim(sprintf($this->config->story->custom->batchCreateFields, ''), ',');
        }

        $showFields = $this->config->story->custom->batchCreateFields;
        if($product->type == 'normal')
        {
            $showFields = str_replace(array(0 => ",branch,", 1 => ",platform,"), '', ",$showFields,");
            $showFields = trim($showFields, ',');
        }
        if($storyType == 'requirement')
        {
            unset($customFields['plan']);
            $showFields = str_replace('plan', '', $showFields);
        }

        $this->view->customFields = $customFields;
        $this->view->showFields   = $showFields;


        $this->view->title            = $product->name . $this->lang->colon . ($storyID ? $this->lang->story->subdivide : $this->lang->story->batchCreate);
        $this->view->productName      = $product->name;
        $this->view->position[]       = html::a($this->createLink('product', 'browse', "product=$productID&branch=$branch"), $product->name);
        $this->view->position[]       = $this->lang->story->common;
        $this->view->position[]       = $storyID ? $this->lang->story->subdivide : $this->lang->story->batchCreate;
        $this->view->storyID          = $storyID;
        $this->view->products         = $products;
        $this->view->product          = $product;
        $this->view->moduleID         = $moduleID;
        $this->view->moduleOptionMenu = $moduleOptionMenu;
        $this->view->plans            = $plans;
        $this->view->reviewers        = $this->user->getPairs('noclosed|nodeleted', '', 0, $reviewers);
        $this->view->users            = $this->user->getPairs('pdfirst|noclosed|nodeleted');
        $this->view->priList          = $priList;
        $this->view->sourceList       = $sourceList;
        $this->view->planID           = $planID;
        $this->view->pri              = $pri;
        $this->view->productID        = $productID;
        $this->view->estimate         = $estimate;
        $this->view->storyTitle       = isset($story->title) ? $story->title : '';
        $this->view->spec             = $spec;
        $this->view->type             = $storyType;
        $this->view->branch           = $branch;
        $this->view->branches         = $branches;
        /* When the user is product owner or add story in project or not set review, the default is not to review. */
        $this->view->needReview       = ($this->app->user->account == $product->PO or $executionID > 0 or $this->config->story->needReview == 0 or !$this->story->checkForceReview()) ? 0 : 1;
        $this->view->forceReview      = $this->story->checkForceReview();
        $this->view->executionID      = $executionID;

        $this->display();
    }

    public function view($storyID, $version = 0, $param = 0, $storyType = 'story')
    {
        if($storyType = "taskPoint")
            $storyType = "story";
        $uri        = $this->app->getURI(true);
        $tab        = $this->app->tab;
        $buildApp   = $tab == 'product' ?   'project' : $tab;
        $releaseApp = $tab == 'execution' ? 'product' : $tab;
        $this->session->set('productList', $uri . "#app={$tab}", 'product');
        $this->session->set('buildList',   $uri, $buildApp);
        $this->app->loadLang('bug');

        $storyID = (int)$storyID;
        $story   = $this->story->getById($storyID, $version, true);
        $version = empty($version) ? $story->version : $version;
        $linkModuleName = $this->config->vision == 'lite' ? 'project' : 'product';
        if(!$story) return print(js::error($this->lang->notFound) . js::locate($this->createLink($linkModuleName, 'index')));

        $story = $this->story->mergeReviewer($story, true);

        $this->story->replaceURLang($story->type);

        $product       = $this->dao->findById($story->product)->from(TABLE_PRODUCT)->fields('name, id, type, status')->fetch();
        $plan          = $this->dao->findById($story->plan)->from(TABLE_PRODUCTPLAN)->fetch('title');
        $bugs          = $this->dao->select('id,title,status,pri,severity')->from(TABLE_BUG)->where('story')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll();
        $fromBug       = $this->dao->select('id,title')->from(TABLE_BUG)->where('toStory')->eq($storyID)->fetch();
        $cases         = $this->dao->select('id,title,status,pri')->from(TABLE_CASE)->where('story')->eq($storyID)->andWhere('deleted')->eq(0)->fetchAll();
        $linkedMRs     = $this->loadModel('mr')->getLinkedMRPairs($storyID, 'story');
        $modulePath    = $this->tree->getParents($story->module);
        $storyModule   = empty($story->module) ? '' : $this->tree->getById($story->module);
        $linkedStories = isset($story->linkStoryTitles) ? array_keys($story->linkStoryTitles) : array();
        $storyProducts = $this->dao->select('id,product')->from(TABLE_STORY)->where('id')->in($linkedStories)->fetchPairs();

        /* Set the menu. */
        $from = $this->app->tab;
        if($from == 'execution')
        {
            $result = $this->execution->setMenu($param);
            if($result) return;
        }
        elseif($from == 'project')
        {
            $this->loadModel('project')->setMenu($this->session->project);
        }
        elseif($from == 'qa')
        {
            $products = $this->product->getProductPairsByProject(0, 'noclosed');
            $this->loadModel('qa')->setMenu($products, $story->product);
        }
        else
        {
            $this->product->setMenu($story->product, $story->branch);
        }

        if($product->type != 'normal') $this->lang->product->branch = sprintf($this->lang->product->branch, $this->lang->product->branchName[$product->type]);

        $reviewers  = $this->story->getReviewerPairs($storyID, $story->version);
        $reviewedBy = trim($story->reviewedBy, ',');

        $this->executeHooks($storyID);

        $title      = "STORY #$story->id $story->title - $product->name";
        $position[] = html::a($this->createLink('product', 'browse', "product=$product->id&branch=$story->branch"), $product->name);
        $position[] = $this->lang->story->common;
        $position[] = $this->lang->story->view;

        $this->view->title              = $title;
        $this->view->position           = $position;
        $this->view->product            = $product;
        $this->view->branches           = $product->type == 'normal' ? array() : $this->loadModel('branch')->getPairs($product->id);
        $this->view->plan               = $plan;
        $this->view->bugs               = $bugs;
        $this->view->fromBug            = $fromBug;
        $this->view->cases              = $cases;
        $this->view->story              = $story;
        $this->view->linkedMRs          = $linkedMRs;
        $this->view->track              = $this->story->getTrackByID($story->id);
        $this->view->users              = $this->user->getPairs('noletter');
        $this->view->reviewers          = $reviewers;
        $this->view->relations          = $this->story->getStoryRelation($story->id, $story->type);
        $this->view->actions            = $this->action->getList('story', $storyID);
        $this->view->storyModule        = $storyModule;
        $this->view->modulePath         = $modulePath;
        $this->view->storyProducts      = $storyProducts;
        $this->view->version            = $version;
        $this->view->preAndNext         = $this->loadModel('common')->getPreAndNextObject('story', $storyID);
        $this->view->from               = $from;
        $this->view->param              = $param;
        $this->view->builds             = $this->loadModel('build')->getStoryBuilds($storyID);
        $this->view->releases           = $this->loadModel('release')->getStoryReleases($storyID);

        $this->display();
    }
}
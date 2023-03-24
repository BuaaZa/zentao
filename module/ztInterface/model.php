<?php
/**
 * The model file of case module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     case
 * @version     $Id: model.php 5108 2013-07-12 01:59:04Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
?>
<?php
class ztinterfaceModel extends model
{
    public function setMenu($productID)
    {
        $this->loadModel('product');
        if($productID>0)$product = $this->product->getByID($productID);
        if(!$productID||!$product) {
            $products = $this->product->getlist();
            if(!$products){
                $productID = 0;
            }else{
                foreach($products as $p){
                    if($productID == 0||$p->id<$productID)
                        $productID = $p->id;
                }
            }
        }
        $this->lang->switcherMenu = $this->product->getSwitcher($productID);
        common::setMenuVars('ztinterface', $productID);
        return $productID;
    }

    public function getInterfaces($productID, $moduleID, $sort, $pager)
    {
        $modules    = $moduleID ? $this->loadModel('tree')->getAllChildId($moduleID) : '0';
        return $this->dao->select('*')->from(TABLE_INTERFACE)
                ->where('product')->eq((int)$productID)
                ->beginIF(is_array($modules))->andWhere('module')->in($modules)->fi()
                ->andWhere('deleted')->eq('0')
                ->orderBy($sort)
                ->page($pager)
                ->fetchAll('id');
    }

    public function getByID($interfaceID)
    {
        return $this->dao->select('*')->from(TABLE_INTERFACE)
            ->where('deleted')->eq(0)
            ->andWhere('id')->eq($interfaceID)
            ->fetch();
    }


    public function summary($interfaces)
    {
        return sprintf($this->lang->interface->summary, count($interfaces));
    }

    public function printCell($col, $interface, $users, $branches, $modulePairs = array(), $browseType = '', $mode = 'datatable')
    {
        $interfaceLink   = helper::createLink('interface', 'view', "interfaceID=$interface->id");
        $account    = $this->app->user->account;
        $id = $col->id;
        if($col->show)
        {
            $class = $id == 'title' ? 'c-name' : 'c-' . $id;
            $title = '';
            if($id == 'name')
            {
                $class .= ' text-left';
                $title  = "title='{$interface->title}'";
            }
            if($id == 'actions') $class .= ' c-actions';
            if($id == 'lastRunResult') $class .= " {$case->lastRunResult}";

            echo "<td class='{$class}' {$title}>";
            switch($id)
            {
            case 'id':
                printf('%03d', $interface->id);
                break;
            case 'name':
                echo html::a($interfaceLink, $interface->name, null, "style='color: ' data-app='{$this->app->tab}'");
                break;
            case 'method':
                echo "<b style=\"color:{$this->lang->ztinterface->methodColor[$interface->method]};\">$interface->method</b>";
                break;
            case 'url':
                echo '<div style="font-size: 1.3rem; letter-spacing: 0.05em;">' . $interface->url . '</div>';
                break;
            case 'actions':
                $interface ->browseType = $browseType;
                echo $this->buildOperateMenu($interface, 'browse');
                break;
            }
            echo '</td>';
        }
    }

    public function buildOperateMenu($interface, $type = 'view')
    {
        $function = 'buildOperate' . ucfirst($type) . 'Menu';
        return $this->$function($interface);
    }

    public function buildOperateBrowseMenu($interface)
    {
        $menu   = '';
        $params = "interfaceID=$interface->id";

        $menu .= $this->buildMenu('ztinterface', 'sendMessage', $params, $interface, 'browse');
        $menu .= $this->buildMenu('ztinterface', 'message', $params, $interface, 'browse');
        $menu .= $this->buildMenu('ztinterface', 'edit', $params, $interface, 'browse');
        
        $deleteURL = helper::createLink('ztinterface', 'delete', $params."&confirm=yes");
        $class = 'btn';
        $menu .= html::a("javascript:ajaxDelete(\"$deleteURL\",\"interfaceList\",confirmDelete)", '<i class="icon-common-delete icon-trash"></i>', '', "title='{$this->lang->ztinterface->delete}' class='{$class}'");
        
        return $menu;
    }

    public function getBaseURL($productID)
    {
        $datalist   = '<datalist id="baseUrlList">';
        $baseURL = $this->dao->select('*')->from(TABLE_BASEURL)
                ->where('product')->eq($productID)
                ->fetchAll('id');
        ChromePhp::log($baseURL);
        foreach($baseURL as $url){
            $datalist.="<option value=\"$url->url\" label=\"($url->name)\">";
        }
        
        $datalist.="</datalist>";
        return $datalist;
    }
    /**
     * Create a case.
     *
     * @param int $bugID
     * @access public
     * @return void
     */
    public function create($bugID)
    {
        $steps   = $this->post->steps;
        $expects = $this->post->expects;
        foreach($expects as $key => $value)
        {
            if(!empty($value) and empty($steps[$key]))
            {
                dao::$errors[] = sprintf($this->lang->testcase->stepsEmpty, $key);
                return false;
            }
        }

        $now    = helper::now();
        $status = $this->getStatus('create');
        $case   = fixer::input('post')
            ->add('status', $status)
            ->add('version', 1)
            ->add('fromBug', $bugID)
            ->setDefault('openedBy', $this->app->user->account)
            ->setDefault('openedDate', $now)
            ->setIF($this->config->systemMode == 'new' and $this->app->tab == 'project', 'project', $this->session->project)
            ->setIF($this->app->tab == 'execution', 'execution', $this->session->execution)
            ->setIF($this->post->story != false, 'storyVersion', $this->loadModel('story')->getVersion((int)$this->post->story))
            ->remove('steps,expects,files,labels,stepType,forceNotReview,inputs,goal_actions,eval_criterias,stepIoType')
            ->setDefault('story', 0)
            ->cleanInt('story,product,branch,module')
            ->join('stage', ',')
            ->get();

        $param = '';
        if(!empty($case->lib))$param = "lib={$case->lib}";
        if(!empty($case->product))$param = "product={$case->product}";
        $result = $this->loadModel('common')->removeDuplicate('case', $case, $param);
        if($result and $result['stop']) return array('status' => 'exists', 'id' => $result['duplicate']);

        if(empty($case->product)) $this->config->testcase->create->requiredFields = str_replace('story', '', $this->config->testcase->create->requiredFields);

        /* Value of story may be showmore. */
        $case->story = (int)$case->story;
        $this->dao->insert(TABLE_CASE)->data($case)->autoCheck()->batchCheck($this->config->testcase->create->requiredFields, 'notempty')->checkFlow()->exec();
        if(!$this->dao->isError())
        {
            $caseID = $this->dao->lastInsertID();
            $this->loadModel('file')->saveUpload('testcase', $caseID);
            $parentStepID = 0;
            $this->loadModel('score')->create('testcase', 'create', $caseID);

            $data = fixer::input('post')->get();
            foreach($data->steps as $stepID => $stepDesc)
            {
                if(empty($stepDesc)) continue;
                $stepType      = $this->post->stepType;
                $step          = new stdClass();
                $step->type    = ($stepType[$stepID] == 'item' and $parentStepID == 0) ? 'step' : $stepType[$stepID];
                $step->parent  = ($step->type == 'item') ? $parentStepID : 0;
                $step->case    = $caseID;
                $step->version = 1;
                $step->desc    = rtrim(htmlSpecialString($stepDesc));
                $judge = $step->type == 'group' || $step->type == 'item';
                $step->input  = $judge ? '' : rtrim(htmlSpecialString($data->inputs[$stepID]));
                $step->goal_action  = $judge ? '' : rtrim(htmlSpecialString($data->goal_actions[$stepID]));
                $step->expect  = $judge ? '' : rtrim(htmlSpecialString($data->expects[$stepID]));
                $step->eval_criteria  = $judge ? '' : rtrim(htmlSpecialString($data->eval_criterias[$stepID]));
                $step->eval_criteria = strlen($step->eval_criteria) == 0 ? $step->expect : $step->eval_criteria;
                $stepIoType      = $this->post->stepIoType;
                $step->is_out = $stepIoType[$stepID];
                $this->dao->insert(TABLE_CASESTEP)->data($step)->autoCheck()->exec();
                if($step->type == 'group') $parentStepID = $this->dao->lastInsertID();
                if($step->type == 'step')  $parentStepID = 0;
            }

            return array('status' => 'created', 'id' => $caseID, 'caseInfo' => $case);
        }
    }

    /**
     * Batch create cases.
     *
     * @param  int    $productID
     * @param  int    $branch
     * @param  int    $storyID
     * @access public
     * @return array
     */
    public function batchCreate($productID, $branch, $storyID)
    {
        $branch      = (int)$branch;
        $productID   = (int)$productID;
        $now         = helper::now();
        $cases       = fixer::input('post')->get();

        $result = $this->loadModel('common')->removeDuplicate('case', $cases, "product={$productID}");
        $cases  = $result['data'];

        foreach($cases->title as $i => $title)
        {
            if(!empty($cases->title[$i]) and empty($cases->type[$i])) return print(js::alert(sprintf($this->lang->error->notempty, $this->lang->testcase->type)));
        }

        $module = 0;
        $story  = 0;
        $type   = '';
        $pri    = 3;
        foreach($cases->title as $i => $title)
        {
            if(empty($title) and $this->common->checkValidRow('testcase', $cases, $i))
            {
                dao::$errors['message'][] = sprintf($this->lang->error->notempty, $this->lang->testcase->title);
                return false;
            }

            $module = $cases->module[$i] == 'ditto' ? $module : $cases->module[$i];
            $story  = $cases->story[$i] == 'ditto'  ? $story  : $cases->story[$i];
            $type   = $cases->type[$i] == 'ditto'   ? $type   : $cases->type[$i];
            $pri    = $cases->pri[$i] == 'ditto'    ? $pri    : $cases->pri[$i];
            $cases->module[$i] = (int)$module;
            $cases->story[$i]  = !empty($storyID) ? $storyID : (int)$story;
            $cases->type[$i]   = $type;
            $cases->pri[$i]    = $pri;
        }

        $this->loadModel('story');
        $extendFields   = $this->getFlowExtendFields();
        $storyVersions  = array();
        $forceNotReview = $this->forceNotReview();
        $data           = array();
        foreach($cases->title as $i => $title)
        {
            if(empty($title)) continue;

            $data[$i] = new stdclass();
            $data[$i]->product      = $productID;
            if($this->config->systemMode == 'new' && $this->app->tab == 'project') $data[$i]->project = $this->session->project;
            $data[$i]->branch       = $cases->branch[$i];
            $data[$i]->module       = $cases->module[$i];
            $data[$i]->type         = $cases->type[$i];
            $data[$i]->pri          = $cases->pri[$i];
            $data[$i]->stage        = empty($cases->stage[$i]) ? '' : implode(',', $cases->stage[$i]);
            $data[$i]->story        = $cases->story[$i];
            $data[$i]->color        = $cases->color[$i];
            $data[$i]->title        = $cases->title[$i];
            $data[$i]->precondition = $cases->precondition[$i];
            $data[$i]->keywords     = $cases->keywords[$i];
            $data[$i]->openedBy     = $this->app->user->account;
            $data[$i]->openedDate   = $now;
            $data[$i]->status       = $forceNotReview || $cases->needReview[$i] == 0 ? 'normal' : 'wait';
            $data[$i]->version      = 1;

            $caseStory = $data[$i]->story;
            $data[$i]->storyVersion = isset($storyVersions[$caseStory]) ? $storyVersions[$caseStory] : 0;
            if($caseStory and !isset($storyVersions[$caseStory]))
            {
                $data[$i]->storyVersion = $this->story->getVersion($caseStory);
                $storyVersions[$caseStory] = $data[$i]->storyVersion;
            }

            foreach($extendFields as $extendField)
            {
                $data[$i]->{$extendField->field} = $this->post->{$extendField->field}[$i];
                if(is_array($data[$i]->{$extendField->field})) $data[$i]->{$extendField->field} = join(',', $data[$i]->{$extendField->field});

                $data[$i]->{$extendField->field} = htmlSpecialString($data[$i]->{$extendField->field});
            }

            foreach(explode(',', $this->config->testcase->create->requiredFields) as $field)
            {
                $field = trim($field);
                if($field and empty($data[$i]->$field)) return helper::end(js::alert(sprintf($this->lang->error->notempty, $this->lang->testcase->$field)));
            }
        }

        $caseIDList = array();
        foreach($data as $i => $case)
        {
            $this->dao->insert(TABLE_CASE)->data($case)
                ->autoCheck()
                ->batchCheck($this->config->testcase->create->requiredFields, 'notempty')
                ->checkFlow()
                ->exec();

            if(dao::isError())
            {
                echo js::error(dao::getError());
                return print(js::reload('parent'));
            }

            $caseID       = $this->dao->lastInsertID();
            $caseIDList[] = $caseID;

            $this->executeHooks($caseID);

            $this->loadModel('score')->create('testcase', 'create', $caseID);
            $actionID = $this->loadModel('action')->create('case', $caseID, 'Opened');

            /* If the story is linked project, make the case link the project. */
            $this->syncCase2Project($case, $caseID);
        }
        if(!dao::isError()) $this->loadModel('score')->create('ajax', 'batchCreate');
        return $caseIDList;
    }

    /**
     * Get project cases.
     *
     * @param  int    $projectID
     * @param  string $orderBy
     * @param  object $pager
     * @param  string $browseType
     * @access public
     * @return array
     */
    public function getProjectCases($projectID, $orderBy = 'id_desc', $pager = null, $browseType = '')
    {
        return $this->dao->select('distinct t1.*, t2.*')->from(TABLE_PROJECTCASE)->alias('t1')
            ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case=t2.id')
            ->where('t1.project')->eq((int)$projectID)
            ->beginIF($browseType != 'all')->andWhere('t2.status')->eq($browseType)->fi()
            ->andWhere('t2.deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * Get execution cases.
     *
     * @param  int    $executionID
     * @param  int    $productID
     * @param  int    $branchID
     * @param  int    $moduleID
     * @param  string $orderBy
     * @param  object $pager
     * @param  string $browseType   all|wait|needconfirm
     * @access public
     * @return array
     */
    public function getExecutionCases($executionID, $productID = 0, $branchID = 0, $moduleID = 0, $orderBy = 'id_desc', $pager = null, $browseType = '')
    {
        if($browseType == 'needconfirm')
        {
            return $this->dao->select('distinct t1.*, t2.*')->from(TABLE_PROJECTCASE)->alias('t1')
                ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case=t2.id')
                ->leftJoin(TABLE_STORY)->alias('t3')->on('t2.story = t3.id')
                ->leftJoin(TABLE_MODULE)->alias('t4')->on('t2.module=t4.id')
                ->where('t1.project')->eq((int)$executionID)
                ->beginIF(!empty($productID))->andWhere('t1.product')->eq($productID)->fi()
                ->beginIF(!empty($moduleID))->andWhere('t4.path')->like("%,$moduleID,%")->fi()
                ->beginIF(!empty($productID))->andWhere('t2.branch')->eq($branchID)->fi()
                ->andWhere('t2.deleted')->eq('0')
                ->andWhere('t3.version > t2.storyVersion')
                ->andWhere("t3.status")->eq('active')
                ->orderBy($orderBy)
                ->page($pager)
                ->fetchAll('id');
        }

        return $this->dao->select('distinct t1.*, t2.*')->from(TABLE_PROJECTCASE)->alias('t1')
            ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case=t2.id')
            ->leftJoin(TABLE_MODULE)->alias('t3')->on('t2.module=t3.id')
            ->where('t1.project')->eq((int)$executionID)
            ->beginIF($browseType != 'all' and $browseType != 'byModule')->andWhere('t2.status')->eq($browseType)->fi()
            ->beginIF(!empty($productID))->andWhere('t1.product')->eq($productID)->fi()
            ->beginIF(!empty($moduleID))->andWhere('t3.path')->like("%,$moduleID,%")->fi()
            ->beginIF(!empty($productID))->andWhere('t2.branch')->eq($branchID)->fi()
            ->andWhere('t2.deleted')->eq('0')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * Get cases by suite.
     *
     * @param  int         $productID
     * @param  int|string  $branch
     * @param  int         $suiteID
     * @param  array       $moduleIdList
     * @param  string      $orderBy
     * @param  object      $pager
     * @param  string      $auto    no|unit
     * @access public
     * @return array
     */
    public function getBySuite($productID, $branch = 0, $suiteID = 0, $moduleIdList = 0, $orderBy = 'id_desc', $pager = null, $auto = 'no')
    {
        return $this->dao->select('t1.*, t2.title as storyTitle, t3.version as version')->from(TABLE_CASE)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story=t2.id')
            ->leftJoin(TABLE_SUITECASE)->alias('t3')->on('t1.id=t3.case')
            ->where('t1.product')->eq((int)$productID)
            ->beginIF($this->app->tab == 'project')->andWhere('t1.project')->eq($this->session->project)->fi()
            ->andWhere('t3.suite')->eq((int)$suiteID)
            ->beginIF($branch !== 'all')->andWhere('t1.branch')->eq($branch)->fi()
            ->beginIF($moduleIdList)->andWhere('t1.module')->in($moduleIdList)->fi()
            ->beginIF($auto == 'unit')->andWhere('t1.auto')->eq('unit')->fi()
            ->beginIF($auto != 'unit')->andWhere('t1.auto')->ne('unit')->fi()
            ->andWhere('t1.deleted')->eq('0')
            ->orderBy($orderBy)->page($pager)->fetchAll('id');
    }

    /**
     * Get case list.
     *
     * @param  int|array|string $caseIDList
     * @access public
     * @return array
     */
    public function getByList($caseIDList = 0)
    {
        return $this->dao->select('*')->from(TABLE_CASE)
            ->where('deleted')->eq(0)
            ->beginIF($caseIDList)->andWhere('id')->in($caseIDList)->fi()
            ->fetchAll('id');
    }


    /**
     * Get cases by search.
     *
     * @param  int         $productID
     * @param  int         $queryID
     * @param  string      $orderBy
     * @param  object      $pager
     * @param  int|string  $branch
     * @param  string      $auto   no|unit
     * @access public
     * @return array
     */
    public function getBySearch($productID, $queryID, $orderBy, $pager = null, $branch = 0, $auto = 'no')
    {
        if($queryID)
        {
            $query = $this->loadModel('search')->getQuery($queryID);
            if($query)
            {
                $this->session->set('testcaseQuery', $query->sql);
                $this->session->set('testcaseForm', $query->form);
            }
            else
            {
                $this->session->set('testcaseQuery', ' 1 = 1');
            }
        }
        else
        {
            if($this->session->testcaseQuery == false) $this->session->set('testcaseQuery', ' 1 = 1');
        }

        $queryProductID = $productID;
        $allProduct     = "`product` = 'all'";
        $caseQuery      = '(' . $this->session->testcaseQuery;
        if(strpos($this->session->testcaseQuery, $allProduct) !== false)
        {
            $products  = $this->app->user->view->products;
            $caseQuery = str_replace($allProduct, '1', $caseQuery);
            $caseQuery = $caseQuery . ' AND `product` ' . helper::dbIN($products);
            $queryProductID = 'all';
        }

        $allBranch = "`branch` = 'all'";
        if($branch !== 'all' and strpos($caseQuery, '`branch` =') === false) $caseQuery .= " AND `branch` in('$branch')";
        if(strpos($caseQuery, $allBranch) !== false) $caseQuery = str_replace($allBranch, '1', $caseQuery);
        $caseQuery .= ')';
        $caseQuery  = str_replace('`version`', 't1.`version`', $caseQuery);

        if($this->app->tab == 'project') $caseQuery = str_replace('`product`', 't2.`product`', $caseQuery);

        /* Search criteria under compatible project. */
        $sql = $this->dao->select('*')->from(TABLE_CASE)->alias('t1');
        if($this->app->tab == 'project') $sql->leftJoin(TABLE_PROJECTCASE)->alias('t2')->on('t1.id=t2.case');
        $cases = $sql
            ->where($caseQuery)
            ->beginIF($this->app->tab == 'project')->andWhere('t2.project')->eq($this->session->project)->fi()
            ->beginIF($this->app->tab == 'project' and !empty($productID) and $queryProductID != 'all')->andWhere('t2.product')->eq($productID)->fi()
            ->beginIF($this->app->tab != 'project' and !empty($productID) and $queryProductID != 'all')->andWhere('t1.product')->eq($productID)->fi()
            ->beginIF($auto != 'unit')->andWhere('t1.auto')->ne('unit')->fi()
            ->beginIF($auto == 'unit')->andWhere('t1.auto')->eq('unit')->fi()
            ->andWhere('t1.deleted')->eq(0)
            ->orderBy($orderBy)->page($pager)->fetchAll('id');

        return $cases;
    }

    /**
     * Get cases by assignedTo.
     *
     * @param  string $account
     * @param  string $orderBy
     * @param  object $pager
     * @param  string $auto  no|unit|skip
     * @access public
     * @return array
     */
    public function getByAssignedTo($account, $orderBy = 'id_desc', $pager = null, $auto = 'no')
    {
        return $this->dao->select('t1.id as run, t1.task,t1.case,t1.version,t1.assignedTo,t1.lastRunner,t1.lastRunDate,t1.lastRunResult,t1.status as lastRunStatus,t2.id as id,t2.project,t2.pri,t2.title,t2.type,t2.openedBy,t2.color,t2.product,t2.branch,t2.module,t2.status,t3.name as taskName')->from(TABLE_TESTRUN)->alias('t1')
            ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.case = t2.id')
            ->leftJoin(TABLE_TESTTASK)->alias('t3')->on('t1.task = t3.id')
            ->where('t1.assignedTo')->eq($account)
            ->andWhere('t3.deleted')->eq(0)
            ->andWhere('t2.deleted')->eq(0)
            ->andWhere('t3.status')->ne('done')
            ->beginIF(strpos($auto, 'skip') === false and $auto != 'unit')->andWhere('t2.auto')->ne('unit')->fi()
            ->beginIF($auto == 'unit')->andWhere('t2.auto')->eq('unit')->fi()
            ->orderBy($orderBy)->page($pager)->fetchAll(strpos($auto, 'run') !== false? 'run' : 'id');
    }

    /**
     * Get cases by openedBy
     *
     * @param  string $account
     * @param  string $orderBy
     * @param  object $pager
     * @param  string $auto   no|unit|skip
     * @access public
     * @return array
     */
    public function getByOpenedBy($account, $orderBy = 'id_desc', $pager = null, $auto = 'no')
    {
        return $this->dao->findByOpenedBy($account)->from(TABLE_CASE)
            ->beginIF($auto != 'skip')->andWhere('product')->ne(0)->fi()
            ->andWhere('deleted')->eq(0)
            ->beginIF($auto != 'skip' and $auto != 'unit')->andWhere('auto')->ne('unit')->fi()
            ->beginIF($auto == 'unit')->andWhere('auto')->eq('unit')->fi()
            ->orderBy($orderBy)->page($pager)
            ->fetchAll('id');
    }

    /**
     * Get cases by type
     *
     * @param  int    $productID
     * @param  int    $branch
     * @param  string $type    all|needconfirm
     * @param  string $status  all|normal|blocked|investigate
     * @param  int    $moduleID
     * @param  string $orderBy
     * @param  object $pager
     * @param  string $auto    no|unit|skip
     * @access public
     * @return array
     */
    public function getByStatus($productID = 0, $branch = 0, $type = 'all', $status = 'all', $moduleID = 0, $orderBy = 'id_desc', $pager = null, $auto = 'no')
    {
        $modules = $moduleID ? $this->loadModel('tree')->getAllChildId($moduleID) : '0';

        $cases = $this->dao->select('t1.*, t2.title as storyTitle')->from(TABLE_CASE)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story = t2.id')
            ->beginIF($productID)->where('t1.product')->eq((int) $productID)->fi()
            ->beginIF($productID == 0)->where('t1.product')->in($this->app->user->view->products)->fi()
            ->beginIF($branch)->andWhere('t1.branch')->eq($branch)->fi()
            ->beginIF($modules)->andWhere('t1.module')->in($modules)->fi()
            ->beginIF($type == 'needconfirm')->andWhere("t2.status = 'active'")->andWhere('t2.version > t1.storyVersion')->fi()
            ->beginIF($status != 'all')->andWhere('t1.status')->eq($status)->fi()
            ->beginIF($auto == 'unit')->andWhere('t1.auto')->eq('unit')->fi()
            ->beginIF($auto != 'unit')->andWhere('t1.auto')->ne('unit')->fi()
            ->andWhere('t1.deleted')->eq('0')
            ->orderBy($orderBy)->page($pager)
            ->fetchAll('id');
        return $this->appendData($cases);
    }

    /**
     * Get cases by product id.
     *
     * @param  int    $productID
     * @access public
     * @return array
     */
    public function getByProduct($productID)
    {
        return $this->dao->select('*')->from(TABLE_CASE)
            ->where('deleted')->eq(0)
            ->andWhere('product')->eq($productID)
            ->fetchAll('id');
    }

    /**
     * Get case pairs by product id and branch.
     *
     * @param int        $productID
     * @param int|string $branch
     * @access public
     * @return void
     */
    public function getPairsByProduct($productID, $branch = 0)
    {
        return $this->dao->select('id, concat_ws(":", id, title) as title')->from(TABLE_CASE)
            ->where('deleted')->eq(0)
            ->andWhere('product')->eq($productID)
            ->beginIF($branch)->andWhere('branch')->in($branch)->fi()
            ->orderBy('id_desc')
            ->fetchPairs();
    }

    /**
     * Get cases of a story.
     *
     * @param  int    $storyID
     * @access public
     * @return array
     */
    public function getStoryCases($storyID)
    {
        return $this->dao->select('id, project, title, pri, type, status, lastRunner, lastRunDate, lastRunResult')
            ->from(TABLE_CASE)
            ->where('story')->eq((int)$storyID)
            ->andWhere('deleted')->eq(0)
            ->fetchAll('id');
    }

    /**
     * Get counts of some stories' cases.
     *
     * @param  array  $stories
     * @access public
     * @return int
     */
    public function getStoryCaseCounts($stories)
    {
        if(empty($stories)) return array();
        $caseCounts = $this->dao->select('story, COUNT(*) AS cases')
            ->from(TABLE_CASE)
            ->where('story')->in($stories)
            ->andWhere('deleted')->eq(0)
            ->groupBy('story')
            ->fetchPairs();
        foreach($stories as $storyID) if(!isset($caseCounts[$storyID])) $caseCounts[$storyID] = 0;
        return $caseCounts;
    }

    /**
     * Update a case.
     *
     * @param  int    $caseID
     * @param  array  $testtasks
     * @access public
     * @return void
     */
    public function update($caseID, $testtasks = array())
    {
        $steps   = $this->post->steps;
        $expects = $this->post->expects;
        foreach($expects as $key => $value)
        {
            //error_log($steps[$key] . " " . $value);
            if(!empty($value) and empty($steps[$key]))
            {
                dao::$errors[] = sprintf($this->lang->testcase->stepsEmpty, $key);
                return false;
            }
        }

        $now     = helper::now();
        $oldCase = $this->getById($caseID);

        $result = $this->getStatus('update', $oldCase);
        if(!$result or !is_array($result)) return $result;

        list($stepChanged, $status) = $result;

        //判断步骤是否修改仅判断了已有的三个字段，会出bug，暂时改为调用update即必定修改了
        //$stepChanged = true;

        $version = $stepChanged ? $oldCase->version + 1 : $oldCase->version;


        $case = fixer::input('post')
            ->add('id', $caseID)
            ->add('version', $version)
            ->setIF($this->post->story != false and $this->post->story != $oldCase->story, 'storyVersion', $this->loadModel('story')->getVersion($this->post->story))
            ->setIF(!$this->post->linkCase, 'linkCase', '')
            ->setDefault('lastEditedBy',   $this->app->user->account)
            ->add('lastEditedDate', $now)
            ->setDefault('story,branch', 0)
            ->setDefault('stage', '')
            ->setDefault('deleteFiles', array())
            ->join('stage', ',')
            ->join('linkCase', ',')
            ->setForce('status', $status)
            ->cleanInt('story,product,branch,module')
            ->stripTags($this->config->testcase->editor->edit['id'], $this->config->allowedTags)
            ->remove('comment,steps,expects,files,labels,linkBug,stepType,inputs,goal_actions,eval_criterias,stepIoType')
            ->get();

        $requiredFields = $this->config->testcase->edit->requiredFields;
        if($oldCase->lib != 0)
        {
            /* Remove the require field named story when the case is a lib case.*/
            $requiredFields = str_replace(',story,', ',', ",$requiredFields,");
        }
        $case = $this->loadModel('file')->processImgURL($case, $this->config->testcase->editor->edit['id'], $this->post->uid);
        $this->dao->update(TABLE_CASE)->data($case, 'deleteFiles')->autoCheck()->batchCheck($requiredFields, 'notempty')->checkFlow()->where('id')->eq((int)$caseID)->exec();
        if(!$this->dao->isError())
        {
            $this->updateCase2Project($oldCase, $case, $caseID);

            if($stepChanged)
            {
                $parentStepID = 0;
                $isLibCase    = ($oldCase->lib and empty($oldCase->product));
                if($isLibCase)
                {
                    $fromcaseVersion  = $this->dao->select('fromCaseVersion')->from(TABLE_CASE)->where('fromCaseID')->eq($caseID)->fetch('fromCaseVersion');
                    $fromcaseVersion += 1;
                    $this->dao->update(TABLE_CASE)->set('`fromCaseVersion`')->eq($fromcaseVersion)->where('`fromCaseID`')->eq($caseID)->exec();
                }

                /* Ignore steps when post has no steps. */
                if($this->post->steps)
                {
                    $data = fixer::input('post')->get();

                    foreach($data->steps as $stepID => $stepDesc)
                    {
                        if(empty($stepDesc)) continue;
                        $stepType = $this->post->stepType;
                        $step = new stdclass();
                        $step->type    = ($stepType[$stepID] == 'item' and $parentStepID == 0) ? 'step' : $stepType[$stepID];
                        $step->parent  = ($step->type == 'item') ? $parentStepID : 0;
                        $step->case    = $caseID;
                        $step->version = $version;
                        $step->desc    = rtrim(htmlSpecialString($stepDesc));
                        $judge = $step->type == 'group' || $step->type == 'item';
                        $step->input  = $judge ? '' : rtrim(htmlSpecialString($data->inputs[$stepID]));
                        $step->goal_action  = $judge ? '' : rtrim(htmlSpecialString($data->goal_actions[$stepID]));
                        $step->expect  = $judge ? '' : rtrim(htmlSpecialString($data->expects[$stepID]));
                        $step->eval_criteria  = $judge ? '' : rtrim(htmlSpecialString($data->eval_criterias[$stepID]));
                        $step->eval_criteria = strlen($step->eval_criteria) == 0 ? $step->expect : $step->eval_criteria;
                        $stepIoType      = $this->post->stepIoType;
                        $step->is_out = $stepIoType[$stepID];
                        $this->dao->insert(TABLE_CASESTEP)->data($step)->autoCheck()->exec();
                        if($step->type == 'group') $parentStepID = $this->dao->lastInsertID();
                        if($step->type == 'step')  $parentStepID = 0;
                    }
                }
                else
                {
                    foreach($oldCase->steps as $step)
                    {
                        unset($step->id);
                        $step->version = $version;
                        $this->dao->insert(TABLE_CASESTEP)->data($step)->autoCheck()->exec();
                    }
                }
            }

            /* Link bugs to case. */
            $this->post->linkBug = $this->post->linkBug ? $this->post->linkBug : array();
            $linkedBugs = array_keys($oldCase->toBugs);
            $linkBugs   = $this->post->linkBug;
            $newBugs    = array_diff($linkBugs, $linkedBugs);
            $removeBugs = array_diff($linkedBugs, $linkBugs);

            if($newBugs)
            {
                foreach($newBugs as $bugID)
                {
                    $this->dao->update(TABLE_BUG)
                        ->set('`case`')->eq($caseID)
                        ->set('caseVersion')->eq($case->version)
                        ->set('`story`')->eq($case->story)
                        ->set('storyVersion')->eq($case->storyVersion)
                        ->where('id')->eq($bugID)->exec();
                }
            }

            if($removeBugs)
            {
                foreach($removeBugs as $bugID)
                {
                    $this->dao->update(TABLE_BUG)
                        ->set('`case`')->eq(0)
                        ->set('caseVersion')->eq(0)
                        ->set('`story`')->eq(0)
                        ->set('storyVersion')->eq(0)
                        ->where('id')->eq($bugID)->exec();
                }
            }

            /* Join the steps to diff. */
            if($stepChanged and $this->post->steps)
            {
                $oldCase->steps = $this->joinStep($oldCase->steps);
                $case->steps    = $this->joinStep($this->getById($caseID, $version)->steps);
            }
            else
            {
                unset($oldCase->steps);
            }

            if($case->branch and !empty($testtasks))
            {
                $this->loadModel('action');
                foreach($testtasks as $taskID => $testtask)
                {
                    if($testtask->branch != $case->branch and $taskID)
                    {
                        $this->dao->delete()->from(TABLE_TESTRUN)
                            ->where('task')->eq($taskID)
                            ->andWhere('`case`')->eq($caseID)
                            ->exec();
                        $this->action->create('case' ,$caseID, 'unlinkedfromtesttask', '', $taskID);
                    }
                }
            }

            $this->file->processFile4Object('testcase', $oldCase, $case);
            return common::createChanges($oldCase, $case);
        }
    }

    /**
     * Review case
     *
     * @param  int    $caseID
     * @access public
     * @return bool | array
     */
    public function review($caseID)
    {
        if($this->post->result == false) return print(js::alert($this->lang->testcase->mustChooseResult));

        $oldCase = $this->getById($caseID);

        $now    = helper::now();
        $status = $this->getStatus('review', $oldCase);
        $case   = fixer::input('post')
            ->add('id', $caseID)
            ->remove('result,comment')
            ->setDefault('reviewedDate', substr($now, 0, 10))
            ->setDefault('lastEditedBy', $this->app->user->account)
            ->setDefault('lastEditedDate', $now)
            ->stripTags($this->config->testcase->editor->review['id'], $this->config->allowedTags)
            ->setForce('status', $status)
            ->join('reviewedBy', ',')
            ->get();

        $case = $this->loadModel('file')->processImgURL($case, $this->config->testcase->editor->review['id'], $this->post->uid);
        $this->dao->update(TABLE_CASE)->data($case)->autoCheck()->checkFlow()->where('id')->eq($caseID)->exec();

        if(dao::isError()) return false;

        return common::createChanges($oldCase, $case);
    }

    /**
     * Batch review cases.
     *
     * @param  array   $caseIDList
     * @access public
     * @return array
     */
    public function batchReview($caseIdList, $result)
    {
        $now     = helper::now();
        $actions = array();
        $this->loadModel('action');

        $oldCases = $this->getByList($caseIdList);
        foreach($caseIdList as $caseID)
        {
            $oldCase = $oldCases[$caseID];
            if($oldCase->status != 'wait') continue;

            $case = new stdClass();
            $case->reviewedBy     = $this->app->user->account;
            $case->reviewedDate   = substr($now, 0, 10);
            $case->lastEditedBy   = $this->app->user->account;
            $case->lastEditedDate = $now;
            if($result == 'pass') $case->status = 'normal';
            $this->dao->update(TABLE_CASE)->data($case)->autoCheck()->where('id')->eq($caseID)->exec();
            $actions[$caseID] = $this->action->create('case', $caseID, 'Reviewed', '', ucfirst($result));
        }

        return $actions;
    }

    /**
     * Get cases to link.
     *
     * @param  int    $caseID
     * @param  string $browseType
     * @param  int    $queryID
     * @access public
     * @return array
     */
    public function getCases2Link($caseID, $browseType = 'bySearch', $queryID = 0)
    {
        if($browseType == 'bySearch')
        {
            $case       = $this->getById($caseID);
            $cases2Link = $this->getBySearch($case->product, $queryID, 'id', null, $case->branch);
            foreach($cases2Link as $key => $case2Link)
            {
                if($case2Link->id == $caseID) unset($cases2Link[$key]);
                if(in_array($case2Link->id, explode(',', $case->linkCase))) unset($cases2Link[$key]);
            }
            return $cases2Link;
        }
        else
        {
            return array();
        }
    }

    /**
     * Get bugs to link.
     *
     * @param  int    $caseID
     * @param  string $browseType
     * @param  int    $queryID
     * @access public
     * @return array
     */
    public function getBugs2Link($caseID, $browseType = 'bySearch', $queryID = 0)
    {
        $this->loadModel('bug');
        if($browseType == 'bySearch')
        {
            $case      = $this->getById($caseID);
            $bugs2Link = $this->bug->getBySearch($case->product, $case->branch, $queryID, 'id');
            foreach($bugs2Link as $key => $bug2Link)
            {
                if($bug2Link->case != 0) unset($bugs2Link[$key]);
            }
            return $bugs2Link;
        }
        else
        {
            return array();
        }
    }

    /**
     * Batch update testcases.
     *
     * @param  array $testtasks
     * @access public
     * @return array
     */
    public function batchUpdate($testtasks = array())
    {
        $cases      = array();
        $allChanges = array();
        $now        = helper::now();
        $data       = fixer::input('post')->get();
        $caseIDList = $this->post->caseIDList;

        /* Process data if the value is 'ditto'. */
        foreach($caseIDList as $caseID)
        {
            if($data->pris[$caseID]    == 'ditto') $data->pris[$caseID]    = isset($prev['pri'])    ? $prev['pri']    : 3;
            if($data->modules[$caseID] == 'ditto') $data->modules[$caseID] = isset($prev['module']) ? $prev['module'] : 0;
            if($data->types[$caseID]   == 'ditto') $data->types[$caseID]   = isset($prev['type'])   ? $prev['type']   : '';
            if($data->story[$caseID]   == '') $data->story[$caseID] = 0;
            if($data->story[$caseID]   == 'ditto') $data->story[$caseID] = isset($prev['story']) ? $prev['story'] : 0;
            if(isset($data->branches[$caseID]) and $data->branches[$caseID] == 'ditto') $data->branches[$caseID] = isset($prev['branch']) ? $prev['branch'] : 0;

            $prev['pri']    = $data->pris[$caseID];
            $prev['type']   = $data->types[$caseID];
            $prev['story']  = $data->story[$caseID];
            $prev['module'] = $data->modules[$caseID];
            if(isset($data->branches)) $prev['branch'] = $data->branches[$caseID];
        }

        /* Initialize cases from the post data.*/
        $extendFields = $this->getFlowExtendFields();
        foreach($caseIDList as $caseID)
        {
            $case = new stdclass();
            $case->id             = $caseID;
            $case->lastEditedBy   = $this->app->user->account;
            $case->lastEditedDate = $now;
            $case->pri            = $data->pris[$caseID];
            $case->module         = $data->modules[$caseID];
            $case->status         = $data->statuses[$caseID];
            $case->story          = $data->story[$caseID];
            $case->color          = $data->color[$caseID];
            $case->title          = $data->title[$caseID];
            $case->precondition   = $data->precondition[$caseID];
            $case->keywords       = $data->keywords[$caseID];
            $case->type           = $data->types[$caseID];
            $case->stage          = empty($data->stages[$caseID]) ? '' : implode(',', $data->stages[$caseID]);
            if(isset($data->branches[$caseID])) $case->branch = $data->branches[$caseID];

            foreach($extendFields as $extendField)
            {
                $case->{$extendField->field} = $this->post->{$extendField->field}[$caseID];
                if(is_array($case->{$extendField->field})) $case->{$extendField->field} = join(',', $case->{$extendField->field});

                $case->{$extendField->field} = htmlSpecialString($case->{$extendField->field});
            }

            $cases[$caseID] = $case;
            unset($case);
        }

        if(empty($case->product)) $this->config->testcase->edit->requiredFields = str_replace('story', '', $this->config->testcase->edit->requiredFields);

        /* Update cases. */
        $this->loadModel('action');
        foreach($cases as $caseID => $case)
        {
            $oldCase = $this->getByID($caseID);

            $caseChanged = false;
            if($oldCase->title != $case->title)               $caseChanged = true;
            if($oldCase->precondition != $case->precondition) $caseChanged = true;

            $this->dao->update(TABLE_CASE)->data($case)
                ->autoCheck()
                ->batchCheck($this->config->testcase->edit->requiredFields, 'notempty')
                ->checkFlow()
                ->where('id')->eq($caseID)
                ->exec();

            if(!dao::isError())
            {
                $case->product = $oldCase->product;
                $this->updateCase2Project($oldCase, $case, $caseID);

                $this->executeHooks($caseID);

                unset($oldCase->steps);
                $allChanges[$caseID] = common::createChanges($oldCase, $case);

                if(!empty($case->branch) and isset($testtasks[$caseID]))
                {
                    foreach($testtasks[$caseID] as $taskID => $testtask)
                    {
                        if($testtask->branch != $case->branch and $taskID)
                        {
                            $this->dao->delete()->from(TABLE_TESTRUN)
                                ->where('task')->eq($taskID)
                                ->andWhere('`case`')->eq($caseID)
                                ->exec();
                            $this->action->create('case' ,$caseID, 'unlinkedfromtesttask', '', $taskID);
                        }
                    }
                }

                $isLibCase = ($oldCase->lib and empty($oldCase->product));
                if($isLibCase and $caseChanged)
                {
                    $fromcaseVersion  = $this->dao->select('fromCaseVersion')->from(TABLE_CASE)->where('fromCaseID')->eq($caseID)->fetch('fromCaseVersion');
                    $fromcaseVersion += 1;
                    $this->dao->update(TABLE_CASE)->set('`fromCaseVersion`')->eq($fromcaseVersion)->where('`fromCaseID`')->eq($caseID)->exec();
                }
            }
            else
            {
                return helper::end(js::error('case#' . $caseID . dao::getError(true)));
            }
        }

        return $allChanges;
    }

    /**
     * Batch change branch.
     *
     * @param  array  $caseIDList
     * @param  int    $branchID
     * @access public
     * @return array
     */
    public function batchChangeBranch($caseIDList, $branchID)
    {
        $now        = helper::now();
        $allChanges = array();
        $oldCases   = $this->getByList($caseIDList);
        foreach($caseIDList as $caseID)
        {
            $oldCase = $oldCases[$caseID];
            if($branchID == $oldCase->branch) continue;

            $case = new stdclass();
            $case->lastEditedBy   = $this->app->user->account;
            $case->lastEditedDate = $now;
            $case->branch         = $branchID;

            $this->dao->update(TABLE_CASE)->data($case)->autoCheck()->where('id')->eq((int)$caseID)->exec();
            if(!dao::isError()) $allChanges[$caseID] = common::createChanges($oldCase, $case);
        }

        return $allChanges;
    }

    /**
     * Batch change the module of case.
     *
     * @param  array  $caseIDList
     * @param  int    $moduleID
     * @access public
     * @return array
     */
    public function batchChangeModule($caseIDList, $moduleID)
    {
        $now        = helper::now();
        $allChanges = array();
        $oldCases   = $this->getByList($caseIDList);
        foreach($caseIDList as $caseID)
        {
            $oldCase = $oldCases[$caseID];
            if($moduleID == $oldCase->module) continue;

            $case = new stdclass();
            $case->lastEditedBy   = $this->app->user->account;
            $case->lastEditedDate = $now;
            $case->module         = $moduleID;

            $this->dao->update(TABLE_CASE)->data($case)->autoCheck()->where('id')->eq((int)$caseID)->exec();
            if(!dao::isError()) $allChanges[$caseID] = common::createChanges($oldCase, $case);
        }

        return $allChanges;
    }

    /**
     * Batch case type change.
     *
     * @param  array   $caseIDList
     * @param  string  $result
     * @access public
     * @return array
     */
    public function batchCaseTypeChange($caseIdList, $result)
    {
        $now     = helper::now();
        $actions = array();
        $this->loadModel('action');

        $oldCases = $this->getByList($caseIdList);
        foreach($caseIdList as $caseID)
        {
            $case = new stdClass();
            $case->lastEditedBy   = $this->app->user->account;
            $case->lastEditedDate = $now;
            $case->type           = $result;

            $this->dao->update(TABLE_CASE)->data($case)->autoCheck()->where('id')->eq($caseID)->exec();
            $actionID = $this->action->create('case', $caseID, 'Edited', '', ucfirst($result));
            $changes  = common::createChanges($oldCases[$caseID], $case);
            $this->action->logHistory($actionID, $changes);
        }
    }

    /**
     * Join steps to a string, thus can diff them.
     *
     * @param  array   $steps
     * @access public
     * @return string
     */
    public function joinStep($steps)
    {
        $return = '';
        if(empty($steps)) return $return;
        foreach($steps as $step) $return .= $step->desc . ' EXPECT:' . $step->expect . "\n";
        return $return;
    }

    /**
     * Create case steps from a bug's step.
     *
     * @param  string    $steps
     * @access public
     * @return array
     */
    function createStepsFromBug($steps)
    {
        $steps        = strip_tags($steps);
        $caseSteps    = array((object)array('desc' => $steps, 'expect' => ''));   // the default steps before parse.
        $lblStep      = strip_tags($this->lang->bug->tplStep);
        $lblResult    = strip_tags($this->lang->bug->tplResult);
        $lblExpect    = strip_tags($this->lang->bug->tplExpect);
        $lblStepPos   = strpos($steps, $lblStep);
        $lblResultPos = strpos($steps, $lblResult);
        $lblExpectPos = strpos($steps, $lblExpect);

        if($lblStepPos === false or $lblResultPos === false or $lblExpectPos === false) return $caseSteps;

        $caseSteps  = substr($steps, $lblStepPos + strlen($lblStep), $lblResultPos - strlen($lblStep) - $lblStepPos);
        $caseExpect = substr($steps, $lblExpectPos + strlen($lblExpect));
        $caseSteps  = trim($caseSteps);
        $caseExpect = trim($caseExpect);

        $caseSteps = explode("\n", trim($caseSteps));
        $stepCount = count($caseSteps);
        foreach($caseSteps as $key => $caseStep)
        {
            $expect = $key + 1 == $stepCount ? $caseExpect : '';
            $caseSteps[$key] = (object)array('desc' => trim($caseStep), 'expect' => $expect, 'type' => 'item');
        }
        return $caseSteps;
    }

    /**
     * Adjust the action is clickable.
     *
     * @param  object $case
     * @param  string $action
     * @param  string $module
     * @access public
     * @return void
     */
    public static function isClickable($case, $action, $module = 'testcase')
    {
        $action = strtolower($action);

        if($module == 'testcase' && $action == 'createbug') return $case->caseFails > 0;
        if($module == 'testcase' && $action == 'review') return isset($case->caseStatus) ? $case->caseStatus == 'wait' : $case->status == 'wait';

        return true;
    }

    /**
     * Create from import
     *
     * @param  int    $productID
     * @access public
     * @return void
     */
    public function createFromImport($productID, $branch = 0)
    {
        $this->loadModel('action');
        $this->loadModel('story');
        $this->loadModel('file');
        $now    = helper::now();
        $branch = (int)$branch;
        $data   = fixer::input('post')->get();

        $steps = $data->desc;
        foreach($data->expect as $key => $expects)
        {
            foreach($expects as $exportID => $value)
            {
                if(!empty($value) and (!isset($steps[$key][$exportID]) or empty($steps[$key][$exportID])))
                {
                    dao::$errors = sprintf($this->lang->testcase->whichLine, $key) . sprintf($this->lang->testcase->stepsEmpty, $exportID);
                    return false;
                }
            }
        }

        if(!empty($_POST['id']))
        {
            $oldSteps = $this->dao->select('t2.*')->from(TABLE_CASE)->alias('t1')
                ->leftJoin(TABLE_CASESTEP)->alias('t2')->on('t1.id = t2.case')
                ->where('t1.id')->in(($_POST['id']))
                ->andWhere('t1.product')->eq($productID)
                ->andWhere('t1.version=t2.version')
                ->orderBy('t2.id')
                ->fetchGroup('case');
            $oldCases = $this->dao->select('*')->from(TABLE_CASE)->where('id')->in($_POST['id'])->fetchAll('id');
        }

        $cases             = array();
        $line              = 1;
        $fieldNames        = array();
        $storyVersionPairs = $this->story->getVersions($data->story);

        if($this->config->edition != 'open')
        {
            $extendFields = $this->getFlowExtendFields();
            $notEmptyRule = $this->loadModel('workflowrule')->getByTypeAndRule('system', 'notempty');

            foreach($extendFields as $extendField)
            {
                if(strpos(",$extendField->rules,", ",$notEmptyRule->id,") !== false)
                {
                    $this->config->testcase->create->requiredFields .= ',' . $extendField->field;
                }
            }
        }

        foreach($data->product as $key => $product)
        {
            $caseData = new stdclass();

            $caseData->product      = $product;
            $caseData->branch       = isset($data->branch[$key]) ? $data->branch[$key] : $branch;
            $caseData->module       = $data->module[$key];
            $caseData->story        = (int)$data->story[$key];
            $caseData->title        = $data->title[$key];
            $caseData->pri          = (int)$data->pri[$key];
            $caseData->type         = $data->type[$key];
            $caseData->stage        = join(',', $data->stage[$key]);
            $caseData->keywords     = $data->keywords[$key];
            $caseData->frequency    = 1;
            $caseData->precondition = $data->precondition[$key];

            if($this->config->edition != 'open')
            {
                foreach($extendFields as $extendField)
                {
                    $dataArray = $_POST[$extendField->field];
                    $caseData->{$extendField->field} = $dataArray[$key];
                    if(is_array($caseData->{$extendField->field})) $caseData->{$extendField->field} = join(',', $caseData->{$extendField->field});

                    $caseData->{$extendField->field} = htmlSpecialString($caseData->{$extendField->field});
                }
            }

            if(isset($this->config->testcase->create->requiredFields))
            {
                $requiredFields = explode(',', $this->config->testcase->create->requiredFields);
                foreach($requiredFields as $requiredField)
                {
                    $requiredField = trim($requiredField);
                    if(!isset($caseData->$requiredField)) continue;
                    if(empty($caseData->$requiredField) and !isset($fieldNames[$requiredField])) $fieldNames[$requiredField] = $this->lang->testcase->$requiredField;
                }
            }

            $cases[$key] = $caseData;
            $line++;
        }
        if(!empty($fieldNames)) dao::$errors = sprintf($this->lang->testcase->noRequireTip, implode(',', $fieldNames));

        if(dao::isError()) return false;

        $forceNotReview = $this->forceNotReview();
        foreach($cases as $key => $caseData)
        {
            $caseID = 0;
            if(!empty($_POST['id'][$key]) and empty($_POST['insert']))
            {
                $caseID = $data->id[$key];
                if(!isset($oldCases[$caseID])) $caseID = 0;
            }

            if($caseID)
            {
                $stepChanged = false;
                $oldStep     = isset($oldSteps[$caseID]) ? $oldSteps[$caseID] : array();
                $oldCase     = $oldCases[$caseID];

                /* Ignore updating cases for different products. */
                if($oldCase->product != $caseData->product) continue;

                /* Remove the empty setps in post. */
                $steps = array();
                if(isset($_POST['desc'][$key]))
                {
                    foreach($this->post->desc[$key] as $id => $desc)
                    {
                        $desc = trim($desc);
                        if(empty($desc)) continue;
                        $step = new stdclass();
                        $step->type   = $data->stepType[$key][$id];
                        $step->desc   = htmlSpecialString($desc);
                        $step->expect = htmlSpecialString(trim($this->post->expect[$key][$id]));

                        $steps[] = $step;
                    }
                }

                /* If step count changed, case changed. */
                if((!$oldStep != !$steps) or (count($oldStep) != count($steps)))
                {
                    $stepChanged = true;
                }
                else
                {
                    /* Compare every step. */
                    foreach($oldStep as $id => $step)
                    {
                        if(trim($step->desc) != trim($steps[$id]->desc) or trim($step->expect) != $steps[$id]->expect)
                        {
                            $stepChanged = true;
                            break;
                        }
                    }
                }

                $version           = $stepChanged ? $oldCase->version + 1 : $oldCase->version;
                $caseData->version = $version;
                $changes           = common::createChanges($oldCase, $caseData);
                if($caseData->story != $oldCase->story) $caseData->storyVersion = zget($storyVersionPairs, $caseData->story, 1);
                if(!$changes and !$stepChanged) continue;

                if($changes or $stepChanged)
                {
                    $caseData->lastEditedBy   = $this->app->user->account;
                    $caseData->lastEditedDate = $now;
                    if($stepChanged and !$forceNotReview) $caseData->status = 'wait';
                    $this->dao->update(TABLE_CASE)->data($caseData)->where('id')->eq($caseID)->autoCheck()->checkFlow()->exec();

                    if(!dao::isError())
                    {
                        if($stepChanged)
                        {
                            $parentStepID = 0;
                            foreach($steps as $id => $step)
                            {
                                $step = (array)$step;
                                if(empty($step['desc'])) continue;
                                $stepData = new stdclass();
                                $stepData->type    = ($step['type'] == 'item' and $parentStepID == 0) ? 'step' : $step['type'];
                                $stepData->parent  = ($stepData->type == 'item') ? $parentStepID : 0;
                                $stepData->case    = $caseID;
                                $stepData->version = $version;
                                $stepData->desc    = $step['desc'];
                                $stepData->expect  = $step['expect'];
                                $this->dao->insert(TABLE_CASESTEP)->data($stepData)->autoCheck()->exec();
                                if($stepData->type == 'group') $parentStepID = $this->dao->lastInsertID();
                                if($stepData->type == 'step')  $parentStepID = 0;
                            }
                        }
                        $oldCase->steps  = $this->joinStep($oldStep);
                        $caseData->steps = $this->joinStep($steps);
                        $changes  = common::createChanges($oldCase, $caseData);

                        $this->updateCase2Project($oldCase, $caseData, $caseID);

                        $actionID = $this->action->create('case', $caseID, 'Edited');
                        $this->action->logHistory($actionID, $changes);
                    }
                }
            }
            else
            {
                if($this->config->systemMode == 'new' && $this->app->tab == 'project') $caseData->project = $this->session->project;
                $caseData->version    = 1;
                $caseData->openedBy   = $this->app->user->account;
                $caseData->openedDate = $now;
                $caseData->branch     = isset($data->branch[$key]) ? $data->branch[$key] : $branch;
                if($caseData->story) $caseData->storyVersion = zget($storyVersionPairs, $caseData->story, 1);
                $caseData->status = !$forceNotReview ? 'wait' : 'normal';
                $this->dao->insert(TABLE_CASE)->data($caseData)->autoCheck()->checkFlow()->exec();

                if(!dao::isError())
                {
                    $caseID       = $this->dao->lastInsertID();
                    $parentStepID = 0;
                    if($this->post->desc)
                    {
                        foreach($this->post->desc[$key] as $id => $desc)
                        {
                            $desc = trim($desc);
                            if(empty($desc)) continue;
                            $stepData = new stdclass();
                            $stepData->type    = ($data->stepType[$key][$id] == 'item' and $parentStepID == 0) ? 'step' : $data->stepType[$key][$id];
                            $stepData->parent  = ($stepData->type == 'item') ? $parentStepID : 0;
                            $stepData->case    = $caseID;
                            $stepData->version = 1;
                            $stepData->desc    = htmlSpecialString($desc);
                            $stepData->expect  = htmlSpecialString($this->post->expect[$key][$id]);
                            $this->dao->insert(TABLE_CASESTEP)->data($stepData)->autoCheck()->exec();
                            if($stepData->type == 'group') $parentStepID = $this->dao->lastInsertID();
                            if($stepData->type == 'step')  $parentStepID = 0;
                        }
                    }

                    $this->action->create('case', $caseID, 'Opened');

                    $this->syncCase2Project($caseData, $caseID);
                }
            }
        }

        if($this->post->isEndPage)
        {
            unlink($this->session->fileImport);
            unset($_SESSION['fileImport']);
        }
    }

    /**
     * Get fields for import.
     *
     * @access public
     * @return array
     */
    public function getImportFields($productID = 0)
    {
        $product    = $this->loadModel('product')->getById($productID);
        if($product->type != 'normal') $this->lang->testcase->branch = $this->lang->product->branchName[$product->type];

        $caseLang   = $this->lang->testcase;
        $caseConfig = $this->config->testcase;
        $fields     = explode(',', $caseConfig->exportFields);
        foreach($fields as $key => $fieldName)
        {
            $fieldName = trim($fieldName);
            $fields[$fieldName] = isset($caseLang->$fieldName) ? $caseLang->$fieldName : $fieldName;
            unset($fields[$key]);
        }

        return $fields;
    }

    /**
     * Import case from Lib.
     *
     * @param  int    $productID
     * @param  int    $libID
     * @param  int    $branch
     * @access public
     * @return void
     */
    public function importFromLib($productID, $libID, $branch)
    {
        $data = fixer::input('post')->get();

        $prevModule = 0;
        $prevBranch = 0;
        foreach($data->module as $i => $module)
        {
            if($module != 'ditto') $prevModule = $module;
            if($module == 'ditto') $data->module[$i] = $prevModule;
        }

        $caseModules = array();
        $this->loadModel('testsuite');
        if(isset($data->branch))
        {
            foreach($data->branch as $i => $branch)
            {
                if($branch != 'ditto') $prevBranch = $branch;
                if($branch == 'ditto') $data->branch[$i] = $prevBranch;
                if(!isset($caseModules[$data->branch[$i]])) $caseModules[$data->branch[$i]] = $this->testsuite->getCanImportModules($productID, $libID,  $data->branch[$i]);
            }
        }
        else
        {
            $caseModules[$branch] = $this->loadModel('testsuite')->getCanImportModules($productID, $libID,  $branch);
        }

        $libCases = $this->dao->select('*')->from(TABLE_CASE)->where('deleted')->eq(0)->andWhere('id')->in($data->caseIdList)->fetchAll('id');
        $libSteps = $this->dao->select('*')->from(TABLE_CASESTEP)->where('`case`')->in($data->caseIdList)->orderBy('id')->fetchGroup('case');
        $libFiles = $this->dao->select('*')->from(TABLE_FILE)->where('objectID')->in($data->caseIdList)->andWhere('objectType')->eq('testcase')->fetchGroup('objectID', 'id');
        $imported = '';
        foreach($libCases as $libCaseID => $case)
        {
            $case->fromCaseID      = $case->id;
            $case->fromCaseVersion = $case->version;
            $case->product         = $productID;
            if(isset($data->module[$case->id])) $case->module = $data->module[$case->id];
            if(isset($data->branch[$case->id])) $case->branch = $data->branch[$case->id];
            unset($case->id);

            $branch = isset($case->branch) ? $case->branch : 0;
            if(empty($caseModules[$branch][$case->fromCaseID][$case->module]))
            {
                $imported .= "$case->fromCaseID,";
                continue;
            }

            $this->dao->insert(TABLE_CASE)->data($case)->autoCheck()->exec();

            if(!dao::isError())
            {
                $caseID = $this->dao->lastInsertID();
                if(isset($libSteps[$libCaseID]))
                {
                    foreach($libSteps[$libCaseID] as $step)
                    {
                        $step->case = $caseID;
                        unset($step->id);
                        $this->dao->insert(TABLE_CASESTEP)->data($step)->exec();
                    }
                }

                /* If under the project module, the cases is imported need linking to the project. */
                if($this->app->tab == 'project')
                {
                    $lastOrder = (int)$this->dao->select('*')->from(TABLE_PROJECTCASE)->where('project')->eq($this->session->project)->orderBy('order_desc')->limit(1)->fetch('order');

                    $this->dao->insert(TABLE_PROJECTCASE)
                        ->set('project')->eq($this->session->project)
                        ->set('product')->eq($case->product)
                        ->set('case')->eq($caseID)
                        ->set('version')->eq($case->version)
                        ->set('order')->eq(++ $lastOrder)
                        ->exec();
                }

                /* Fix bug #1518. */
                $oldFiles = zget($libFiles, $libCaseID, array());
                foreach($oldFiles as $fileID => $file)
                {
                    $file->objectID  = $caseID;
                    $file->addedBy   = $this->app->user->account;
                    $file->addedDate = helper::now();
                    $file->downloads = 0;
                    unset($file->id);
                    $this->dao->insert(TABLE_FILE)->data($file)->exec();
                }
                $this->loadModel('action')->create('case', $caseID, 'fromlib', '', $case->lib);
            }
        }
        if(!empty($imported))
        {
            $imported = trim($imported, ',');
            return print(js::error(sprintf($this->lang->testcase->importedCases, $imported)));
        }
    }
    /**
     * Export case to word with only one table.
     * @param  int    $caseID
     * @access public
     * @return void
     */
    public function exportToWord_1table($caseID){
        $case = $this->getById($caseID);
        $document = new TemplateProcessor('templateWord/case_template.docx');
        $steps = $case->steps;
        $rows = count($steps);
        $document->cloneRow('stepID',$rows);
        $id = 0;
        foreach($steps as $step){
            if($step->type=='item')continue;
            else $id++;
            $document->setValue("stepID#".$id,$id);
            $document->setValue("precondition#".$id,$case->precondition);
            $document->setValue("step_input#".$id,$step->input);
            $document->setValue("step_goal_action#".$id,$step->goal_action);
            $document->setValue("stepExpect#".$id,$step->expect);
            $document->setValue("step_eval_criteria#".$id,$step->eval_criteria);
        }
        if($id<$rows){
            for($i = $id+1;$i<=$rows;$i++){
                $document->setValue("stepID#".$i,"");
                $document->setValue("precondition#".$i,"");
                $document->setValue("step_input#".$i,"");
                $document->setValue("step_goal_action#".$i,"");
                $document->setValue("stepExpect#".$i,"");
                $document->setValue("step_eval_criteria#".$i,"");
            }
        }
        $filepath = 'tmp_case/' . $caseID . '_1.docx';
        $document->saveAs($filepath);//另存为
        $this->loadModel('file')->sendDownHeader($caseID . '_1.docx', 'docx', realpath($filepath), 'file', false);
        //$this->downfile('tmp_case/' . $caseID . '_1.docx', $caseID . '_1');
    }
    /**
     * Export a case to word.
     *
     * @param  int    $caseID
     * @param  array  $sample_data_all
     * @param  \PhpOffice\PhpWord\PhpWord  $PHPWord
     * @access public
     * @return \PhpOffice\PhpWord\PhpWord
     */
    public function exportToWord($caseID, $sample_data_all, $PHPWord){
        $cellRowSpan = ['vMerge' => 'restart', 'valign' => 'center']; // 设置可跨行，且文字在居中
        $cellRowContinue = ['vMerge' => 'continue']; //使行连接，且无边框线
        $cellHCentered = ['align' => 'center']; //段落居中
        $cellLeft = ['align' => 'left'];//段落居左对齐
        //定义样式数组
        $styleTable = [
            'borderSize'=>6,
            'borderColor'=>'070707',
            'cellMargin'=>80
        ];
        $SignTableStyle = [
            'borderSize'=>6,
            'borderColor'=>'070707',
            'cellMargin'=>80,
        ];
        //定义第一行的样式
        $styleFirstRow = [
            'borderBottomSize'=>18,
            'borderBottomColor'=>'070707',
            'bgColor'=>'c3bcbb'
        ];
        //定义第一行的字体
        $fontStyle = ['bold'=>true,'align'=>'center','size' => 10];

        //定义单元格样式数组  居中
        $styleCell = ['valign'=>'center'];
        $styleCellBTLR = ['valign'=>'center'];
        $sectionStyle = array('orientation' => 'landscape',
            'marginLeft' => 2.54*567,
            'marginRight' => 2.54*567,
            'marginTop' => 3.18*567,
            'marginBottom' => 3.18*567);
        $section = $PHPWord->addSection($sectionStyle);
        $section->addTitle("用例ID：" . $caseID,2);
        $section->addTextBreak(1);
        $PHPWord->addTableStyle('myOwnTableStyle',$styleTable,$styleFirstRow);
        $SignTable1 = $section->addTable('myOwnTableStyle');
        $SignTable1->addRow(250);
        $SignTable1->addCell(2800)->addText('测试要点名称/标识',$fontStyle,$cellHCentered);
        $SignTable1->addCell(4800)->addText('XXXX/XXXX-GN-XXXX（需求或者功能点）',$fontStyle,$cellHCentered);
        $SignTable1->addCell(3800)->addText('测试用例名称/标识',$fontStyle,$cellHCentered);
        $SignTable1->addCell(3800)->addText('XXXX/XXXX-GN-XXXX-XXXX',$fontStyle,$cellHCentered);
        $SignTable2 = $section->addTable('myOwnTableStyle');
        $SignTable2->addRow(250);
        $SignTable2->addCell(1280)->addText('测试步骤',$fontStyle,$cellHCentered);
        $SignTable2->addCell(2320)->addText('前提和约束',$fontStyle,$cellHCentered);
        $SignTable2->addCell(2320)->addText('输入',$fontStyle,$cellHCentered);
        $SignTable2->addCell(2320)->addText('目的和动作',$fontStyle,$cellHCentered);
        $SignTable2->addCell(2320)->addText('预期结果',$fontStyle,$cellHCentered);
        $SignTable2->addCell(2320)->addText('评价准则',$fontStyle,$cellHCentered);
        $SignTable2->addCell(2320)->addText('实际结果',$fontStyle,$cellHCentered);
        $case = $this->getById($caseID);
        $steps = $case->steps;
        $id = 0;
        foreach($steps as $step){
            if($step->type=='item')continue;
            else $id++;
            $SignTable2->addRow(250);
            $SignTable2->addCell(1280)->addText($id,$fontStyle,$cellHCentered);
            $SignTable2->addCell(2320)->addText($case->precondition,$fontStyle,$cellHCentered);
            $SignTable2->addCell(2320)->addText($step->input,$fontStyle,$cellHCentered);
            $SignTable2->addCell(2320)->addText($step->goal_action,$fontStyle,$cellHCentered);
            $SignTable2->addCell(2320)->addText($step->expect,$fontStyle,$cellHCentered);
            $SignTable2->addCell(2320)->addText($step->eval_criteria,$fontStyle,$cellHCentered);
            $SignTable2->addCell(2320)->addText('',$fontStyle,$cellHCentered);
        }
        $section->addTextBreak(1);
        $sample_num = count($sample_data_all);
        if($sample_num>0){
            $SignTable3 = $section->addTable('myOwnTableStyle');
            $SignTable3->addRow(250);
            $SignTable3->addCell(2800)->addText('数据样本名称/标识',$fontStyle,$cellHCentered);
            $SignTable3->addCell(4*3800-2800)->addText('XXXXX数据样本/XXXX-GN-MMMM-BBBB-D1',$fontStyle,$cellHCentered);
            $SignTable4 = $section->addTable('myOwnTableStyle');
            $SignTable4->addRow(250);
            $SignTable4->addCell(2000)->addText('输入/输出项',$fontStyle,$cellHCentered);
            $SignTable4->addCell(2000)->addText('输入/输出项名称',$fontStyle,$cellHCentered);

            $sample_width = (4*3800-4000)/($sample_num+1);
            $comment_width = 4*3800-4000-$sample_width*$sample_num;
            for($i = 1;$i <= $sample_num;$i++){
                $SignTable4->addCell($sample_width)->addText('样本'.$i,$fontStyle,$cellHCentered);
            }
            $SignTable4->addCell($comment_width)->addText('备注',$fontStyle,$cellHCentered);
            $reference_io = $sample_data_all[0];
            $reference_in_num = isset($reference_io['sample_in']) ? count($reference_io['sample_in']): 0;
            $reference_out_num = isset($reference_io['sample_out']) ? count($reference_io['sample_out']): 0;
            $reference_result_num = $reference_out_num;
            $reference_in_steps = array("");
            $reference_out_steps = array("");
            $reference_result_steps = array("");
            foreach($reference_io['sample_in'] as $step_id => $sample_in_data){
                array_push($reference_in_steps, $steps[$step_id]);
            }
            foreach($reference_io['sample_out'] as $step_id => $sample_out_data){
                array_push($reference_out_steps, $steps[$step_id]);
            }
            $reference_result_steps = $reference_out_steps;
            if($reference_in_num > 0){
                for($i = 1;$i <= $reference_in_num;$i++){
                    $SignTable4->addRow(250);
                    if($i==1){
                        if($reference_in_num>1)
                            $SignTable4->addCell(2000,$cellRowSpan)->addText('输入项',$fontStyle,$cellHCentered);
                        else
                            $SignTable4->addCell(2000)->addText('输入项',$fontStyle,$cellHCentered);
                    }else{
                        $SignTable4->addCell(2000, $cellRowContinue);
                    }
                    $SignTable4->addCell(2000)->addText($reference_in_steps[$i]->desc,$fontStyle,$cellHCentered);
                    for($j = 1;$j<=$sample_num;$j++){
                        $SignTable4->addCell($sample_width)->addText($sample_data_all[$j-1]['sample_in'][$reference_in_steps[$i]->id],$fontStyle,$cellHCentered);
                    }
                    $SignTable4->addCell($comment_width)->addText('',$fontStyle,$cellHCentered);
                }
            }
            if($reference_out_num > 0){
                for($i = 1;$i <= $reference_out_num;$i++){
                    $SignTable4->addRow(250);
                    if($i==1){
                        if($reference_out_num>1)
                            $SignTable4->addCell(2000,$cellRowSpan)->addText('预期输出',$fontStyle,$cellHCentered);
                        else
                            $SignTable4->addCell(2000)->addText('预期输出',$fontStyle,$cellHCentered);
                    }else{
                        $SignTable4->addCell(2000, $cellRowContinue);
                    }
                    $SignTable4->addCell(2000)->addText($reference_out_steps[$i]->desc,$fontStyle,$cellHCentered);
                    for($j = 1;$j<=$sample_num;$j++){
                        $SignTable4->addCell($sample_width)->addText($sample_data_all[$j-1]['sample_out'][$reference_out_steps[$i]->id],$fontStyle,$cellHCentered);
                    }
                    $SignTable4->addCell($comment_width)->addText('',$fontStyle,$cellHCentered);
                }
            }
            if($reference_result_num > 0){
                for($i = 1;$i <= $reference_result_num;$i++){
                    $SignTable4->addRow(250);
                    if($i==1){
                        if($reference_result_num>1)
                            $SignTable4->addCell(2000,$cellRowSpan)->addText('实际结果',$fontStyle,$cellHCentered);
                        else
                            $SignTable4->addCell(2000)->addText('实际结果',$fontStyle,$cellHCentered);
                    }else{
                        $SignTable4->addCell(2000, $cellRowContinue);
                    }
                    $SignTable4->addCell(2000)->addText($reference_result_steps[$i]->desc,$fontStyle,$cellHCentered);
                    for($j = 1;$j<=$sample_num;$j++){
                        $SignTable4->addCell($sample_width)->addText($sample_data_all[$j-1]['sample_result'][$reference_result_steps[$i]->id],$fontStyle,$cellHCentered);
                    }
                    $SignTable4->addCell($comment_width)->addText('',$fontStyle,$cellHCentered);
                }
            }
        }else{
            $section->addTitle("该用例无数据样本信息",2);
        }
        $section->addTextBreak(1);
        return $PHPWord;
    }
    public function downfile($filepath,$downloadName = 'notset')
    {
        $filename=realpath($filepath); //文件名
        if($downloadName == 'notset'){
            $downloadName=date("Ymd-H:i:m");
        }
        Header( "Content-type: application/octet-stream ");
        Header( "Accept-Ranges: bytes ");
        Header( "Accept-Length: " .filesize($filename));
        header( "Content-Disposition: attachment; filename= {$downloadName}.docx");
        echo file_get_contents($filename);
        readfile($filename);
        exit;
    }

    /**
     * Import cases to lib.
     *
     * @param  int    $caseIdList
     * @access public
     * @return void
     */
    public function importToLib($caseIdList = 0)
    {
        if(empty($caseIdList)) $caseIdList = $this->post->caseIdList;
        $caseIdList = explode(',' , $caseIdList);
        $libID      = $this->post->lib;

        if(empty($libID)) return dao::$errors[] = sprintf($this->lang->error->notempty, $this->lang->testcase->caselib);

        $this->loadModel('action');
        $cases          = $this->dao->select('*')->from(TABLE_CASE)->where('deleted')->eq(0)->andWhere('id')->in($caseIdList)->fetchAll('id');
        $caseSteps      = $this->dao->select('*')->from(TABLE_CASESTEP)->where('`case`')->in($caseIdList)->orderBy('id')->fetchGroup('case');
        $caseFiles      = $this->dao->select('*')->from(TABLE_FILE)->where('objectID')->in($caseIdList)->andWhere('objectType')->eq('testcase')->fetchGroup('objectID', 'id');
        $libCases       = $this->loadModel('caselib')->getLibCases($libID, 'all');
        $libFiles       = $this->dao->select('*')->from(TABLE_FILE)->where('objectID')->in(array_keys($libCases))->andWhere('objectType')->eq('testcase')->fetchGroup('objectID', 'id');
        $libCases       = $this->dao->select('*')->from(TABLE_CASE)->where('lib')->eq($libID)->andWhere('product')->eq(0)->andWhere('deleted')->eq('0')->fetchGroup('fromCaseID', 'id');
        $maxOrder       = $this->dao->select('max(`order`) as maxOrder')->from(TABLE_CASE)->where('deleted')->eq(0)->fetch('maxOrder');
        $maxModuleOrder = $this->dao->select('max(`order`) as maxOrder')->from(TABLE_MODULE)->where('deleted')->eq(0)->fetch('maxOrder');
        foreach($cases as $caseID => $case)
        {
            $libCase = new stdclass();
            $libCase->lib             = $libID;
            $libCase->title           = $case->title;
            $libCase->precondition    = $case->precondition;
            $libCase->keywords        = $case->keywords;
            $libCase->pri             = $case->pri;
            $libCase->type            = $case->type;
            $libCase->stage           = $case->stage;
            $libCase->status          = $case->status;
            $libCase->fromCaseID      = $case->id;
            $libCase->fromCaseVersion = $case->version;
            $libCase->order           = ++ $maxOrder;
            $libCase->module          = empty($case->module) ? 0 : $this->importCaseRelatedModules($libID, $case->module, $maxModuleOrder);

            if(empty($libCases[$caseID]))
            {
                $libCase->openedBy   = $this->app->user->account;
                $libCase->openedDate = helper::now();
                $this->dao->insert(TABLE_CASE)->data($libCase)->autoCheck()->exec();
                if(!dao::isError()) $libCaseID = $this->dao->lastInsertID();
                $this->action->create('case', $libCaseID, 'tolib', '', $caseID);
            }
            else
            {
                $libCaseID = array_keys($libCases[$caseID])[0];

                $libCase->lastEditedBy   = $this->app->user->account;
                $libCase->lastEditedDate = helper::now();
                $libCase->version        = $libCases[$caseID][$libCaseID]->version + 1;
                $this->dao->update(TABLE_CASE)->data($libCase)->autoCheck()->where('id')->eq((int)$libCaseID)->exec();

                $this->action->create('case', $libCaseID, 'updatetolib', '', $caseID);

                $this->dao->delete()->from(TABLE_CASESTEP)->where('`case`')->eq($libCaseID)->exec();

                $removeFiles = zget($libFiles, $libCaseID, array());
                $this->dao->delete()->from(TABLE_FILE)->where('`objectID`')->eq($libCaseID)->andWhere('objectType')->eq('testcase')->exec();
                foreach($removeFiles as $fileID => $file)
                {
                    $filePath = pathinfo($file->pathname, PATHINFO_BASENAME);
                    $datePath = substr($file->pathname, 0, 6);
                    $filePath = $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" . "{$datePath}/" . $filePath;
                    unlink($filePath);
                }
            }

            if(!dao::isError())
            {
                if(isset($caseSteps[$caseID]))
                {
                    foreach($caseSteps[$caseID] as $index => $step)
                    {
                        if($step->version != $case->version) continue;
                        $oldStepID     = $step->id;
                        $step->case    = $libCaseID;
                        $step->version = $libCase->version;
                        unset($step->id);

                        $this->dao->insert(TABLE_CASESTEP)->data($step)->exec();
                    }
                }

                $oldFiles = zget($caseFiles, $caseID, array());
                foreach($oldFiles as $fileID => $file)
                {
                    $originName = pathinfo($file->pathname, PATHINFO_FILENAME);
                    $datePath   = substr($file->pathname, 0, 6);
                    $originFile = $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" . "{$datePath}/" . $originName;

                    $copyName = $originName . 'copy' . $libCaseID;
                    $copyFile = $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" . "{$datePath}/" .  $copyName;
                    copy($originFile, $copyFile);

                    $newFileName    = $file->pathname;
                    $newFileName    = str_replace('.', "copy$libCaseID.", $newFileName);
                    $file->pathname = $newFileName;

                    $file->objectID  = $libCaseID;
                    $file->addedBy   = $this->app->user->account;
                    $file->addedDate = helper::now();
                    $file->downloads = 0;
                    unset($file->id);
                    $this->dao->insert(TABLE_FILE)->data($file)->exec();
                }
            }
        }
    }

    /**
     * Import case related modules.
     *
     * @param  int    $libID
     * @param  int    $oldModuleID
     * @param  int    $maxOrder
     * @access public
     * @return void
     */
    public function importCaseRelatedModules($libID, $oldModuleID = 0, $maxOrder = 0)
    {
        $moduleID = $this->checkModuleImported($libID, $oldModuleID);
        if($moduleID) return $moduleID;

        $oldModule = $this->dao->select('name, parent, grade, `order`, short')->from(TABLE_MODULE)->where('id')->eq($oldModuleID)->fetch();

        $oldModule->root   = $libID;
        $oldModule->from   = $oldModuleID;
        $oldModule->type   = 'caselib';
        if(!empty($maxOrder)) $oldModule->order = $maxOrder + $oldModule->order;
        $this->dao->insert(TABLE_MODULE)->data($oldModule)->autoCheck()->exec();

        if(!dao::isError())
        {
            $newModuleID = $this->dao->lastInsertID();

            if($oldModule->parent)
            {
                $parentModuleID = $this->importCaseRelatedModules($libID, $oldModule->parent, !empty($maxOrder) ? $maxOrder : 0);
                $parentModule   = $this->dao->select('id, path')->from(TABLE_MODULE)->where('id')->eq($parentModuleID)->fetch();
                $parent         = $parentModule->id;
                $path           = $parentModule->path . "$newModuleID,";
            }
            else
            {
                $path   = ",$newModuleID,";
                $parent = 0;
            }

            $this->dao->update(TABLE_MODULE)->set('parent')->eq($parent)->set('path')->eq($path)->where('id')->eq($newModuleID)->exec();

            return $newModuleID;
        }
    }

    /**
     * Adjust module is can import.
     *
     * @param  int    $libID
     * @param  int    $oldModule
     * @access public
     * @return int
     */
    public function checkModuleImported($libID, $oldModule = 0)
    {
        $module = $this->dao->select('id')->from(TABLE_MODULE)
            ->where('root')->eq($libID)
            ->andWhere('`from`')->eq($oldModule)
            ->andWhere('type')->eq('caselib')
            ->andWhere('deleted')->eq(0)
            ->fetch();

        if(!$module) return '';

        return $module->id;
    }

    /**
     * Build search form.
     *
     * @param  int    $productID
     * @param  array  $products
     * @param  int    $queryID
     * @param  string $actionURL
     * @param  string $projectID
     * @access public
     * @return void
     */
    public function buildSearchForm($productID, $products, $queryID, $actionURL, $projectID = 0)
    {
        $product = ($this->app->tab == 'project' and empty($productID)) ? $products : array($productID => $products[$productID]) + array('all' => $this->lang->testcase->allProduct);
        $this->config->testcase->search['params']['product']['values'] = $product;

        $module = $this->loadModel('tree')->getOptionMenu($productID, 'case', 0);
        if(!$productID)
        {
            $module = array();
            foreach($products as $id => $product) $module += $this->loadModel('tree')->getOptionMenu($id, 'case', 0);
        }
        $this->config->testcase->search['params']['module']['values'] = $module;

        $this->config->testcase->search['params']['lib']['values'] = $this->loadModel('caselib')->getLibraries();

        if($this->session->currentProductType == 'normal')
        {
            unset($this->config->testcase->search['fields']['branch']);
            unset($this->config->testcase->search['params']['branch']);
        }
        else
        {
            $productInfo = $this->loadModel('product')->getByID($productID);
            $this->config->testcase->search['fields']['branch'] = sprintf($this->lang->product->branch, $this->lang->product->branchName[$productInfo->type]);
            $this->config->testcase->search['params']['branch']['values'] = array('' => '', '0' => $this->lang->branch->main) + $this->loadModel('branch')->getPairs($productID, '', $projectID) + array('all' => $this->lang->branch->all);
        }
        if(!$this->config->testcase->needReview) unset($this->config->testcase->search['params']['status']['values']['wait']);
        $this->config->testcase->search['actionURL'] = $actionURL;
        $this->config->testcase->search['queryID']   = $queryID;

        $this->loadModel('search')->setSearchParams($this->config->testcase->search);
    }
    /**
     * Append bugs and results.
     *
     * @param  int    $cases
     * @param  string $type
     * @param  array  $caseIdlist
     * @access public
     * @return void
     */
    public function appendData($cases, $type = 'case', $caseIdlist = array())
    {
        if(empty($caseIdlist)) $caseIdList = array_keys($cases);
        if($type == 'case')
        {
            $caseBugs   = $this->dao->select('count(*) as count, `case`')->from(TABLE_BUG)->where('`case`')->in($caseIdList)->andWhere('deleted')->eq(0)->groupBy('`case`')->fetchPairs('case', 'count');
            $results    = $this->dao->select('count(*) as count, `case`')->from(TABLE_TESTRESULT)->where('`case`')->in($caseIdList)->groupBy('`case`')->fetchPairs('case', 'count');

            $caseFails = $this->dao->select('count(*) as count, `case`')->from(TABLE_TESTRESULT)
                ->where('caseResult')->eq('fail')
                ->andwhere('`case`')->in($caseIdList)
                ->groupBy('`case`')
                ->fetchPairs('case','count');

            $steps = $this->dao->select('count(distinct t1.id) as count, t1.`case`')->from(TABLE_CASESTEP)->alias('t1')
                ->leftJoin(TABLE_CASE)->alias('t2')->on('t1.`case`=t2.`id`')
                ->where('t1.`case`')->in($caseIdList)
                ->andWhere('t1.type')->ne('group')
                ->andWhere('t1.version=t2.version')
                ->groupBy('t1.`case`')
                ->fetchPairs('case', 'count');
        }
        else
        {
            $caseBugs = $this->dao->select('count(*) as count, `case`')->from(TABLE_BUG)->where('`result`')->in($caseIdList)->andWhere('deleted')->eq(0)->groupBy('`case`')->fetchPairs('case', 'count');
            $results  = $this->dao->select('count(*) as count, `case`')->from(TABLE_TESTRESULT)->where('`run`')->in($caseIdList)->groupBy('`run`')->fetchPairs('case', 'count');

            $caseFails = $this->dao->select('count(*) as count, `case`')->from(TABLE_TESTRESULT)
                ->where('caseResult')->eq('fail')
                ->andwhere('`run`')->in($caseIdList)
                ->groupBy('`case`')
                ->fetchPairs('case','count');

            $steps = $this->dao->select('count(distinct t1.id) as count, t1.`case`')->from(TABLE_CASESTEP)->alias('t1')
                ->leftJoin(TABLE_TESTRUN)->alias('t2')->on('t1.`case`=t2.`case`')
                ->where('t2.`id`')->in($caseIdList)
                ->andWhere('t1.type')->ne('group')
                ->andWhere('t1.version=t2.version')
                ->groupBy('t1.`case`')
                ->fetchPairs('case', 'count');
        }

        foreach($cases as $key => $case)
        {
            $caseID = $type == 'case' ? $case->id : $case->case;
            $case->bugs       = isset($caseBugs[$caseID])  ? $caseBugs[$caseID]   : 0;
            $case->results    = isset($results[$caseID])   ? $results[$caseID]    : 0;
            $case->caseFails  = isset($caseFails[$caseID]) ? $caseFails[$caseID]  : 0;
            $case->stepNumber = isset($steps[$caseID])     ? $steps[$caseID]      : 0;
        }

        return $cases;
    }

    /**
     * Check whether force not review.
     *
     * @access public
     * @return bool
     */
    public function forceNotReview()
    {
        if(empty($this->config->testcase->needReview))
        {
            if(!isset($this->config->testcase->forceReview)) return true;
            if(strpos(",{$this->config->testcase->forceReview},", ",{$this->app->user->account},") === false) return true;
        }
        if($this->config->testcase->needReview && isset($this->config->testcase->forceNotReview) && strpos(",{$this->config->testcase->forceNotReview},", ",{$this->app->user->account},") !== false) return true;

        return false;
    }


    /**
     * Sync case to project.
     *
     * @param  object $case
     * @param  int    $caseID
     * @access public
     * @return void
     */
    public function syncCase2Project($case, $caseID)
    {
        $projects = array();
        if(!empty($case->story))
        {
            $projects = $this->dao->select('project')->from(TABLE_PROJECTSTORY)->where('story')->eq($case->story)->fetchPairs();
        }
        elseif($this->app->tab == 'project' and empty($case->story))
        {
            $projects = array($this->session->project);
        }
        elseif($this->app->tab == 'execution' and empty($case->story))
        {
            $projects = array($this->session->execution);
        }
        if(empty($projects)) return;

        $this->loadModel('action');
        $objectInfo = $this->dao->select('*')->from(TABLE_PROJECT)->where('id')->in($projects)->fetchAll('id');

        foreach($projects as $projectID)
        {
            $lastOrder = (int)$this->dao->select('*')->from(TABLE_PROJECTCASE)->where('project')->eq($projectID)->orderBy('order_desc')->limit(1)->fetch('order');
            $data = new stdclass();
            $data->project = $projectID;
            $data->product = $case->product;
            $data->case    = $caseID;
            $data->version = 1;
            $data->order   = ++ $lastOrder;
            $this->dao->insert(TABLE_PROJECTCASE)->data($data)->exec();

            $objectType = $objectInfo[$projectID]->type;
            if($objectType == 'project') $this->action->create('case', $caseID, 'linked2project', '', $projectID);
            if(in_array($objectType, array('sprint', 'stage'))) $this->action->create('case', $caseID, 'linked2execution', '', $projectID);
        }
    }

    /**
     * Deal with the relationship between the case and project when edit the case.
     *
     * @param  object  $oldCase
     * @param  object  $case
     * @param  int     $caseID
     * @access public
     * @return void
     */
    public function updateCase2Project($oldCase, $case, $caseID)
    {
        $productChanged = ($oldCase->product != $case->product);
        $storyChanged   = ($oldCase->story   != $case->story);

        if($productChanged)
        {
            $this->dao->update(TABLE_PROJECTCASE)
                ->set('product')->eq($case->product)
                ->set('version')->eq($case->version)
                ->where('`case`')->eq($oldCase->id)
                ->exec();
        }

        /* The related story is changed. */
        if($storyChanged)
        {
            /* If the new related story isn't linked the project, unlink the case. */
            $projects = $this->dao->select('project')->from(TABLE_PROJECTSTORY)->where('story')->eq($oldCase->story)->fetchAll('project');

            $projectIdList = array_keys($projects);
            $this->dao->delete()->from(TABLE_PROJECTCASE)
                ->where('project')->in()
                ->andWhere('`case`')->eq($oldCase->id)
                ->exec();

            /* If the new related story is not null, make the case link the project which link the new related story. */
            if(!empty($case->story))
            {
                $projects = $this->dao->select('*')->from(TABLE_PROJECTSTORY)->where('story')->eq($case->story)->fetchAll('project');
                if($projects)
                {
                    $projects = array_keys($projects);
                    foreach($projects as $projectID)
                    {
                        $lastOrder = (int)$this->dao->select('*')->from(TABLE_PROJECTCASE)->where('project')->eq($projectID)->orderBy('order_desc')->limit(1)->fetch('order');
                        $data = new stdclass();
                        $data->project = $projectID;
                        $data->product = $case->product;
                        $data->case    = $caseID;
                        $data->version = $oldCase->version;
                        $data->order   = ++ $lastOrder;
                        $this->dao->replace(TABLE_PROJECTCASE)->data($data)->exec();
                    }
                }
            }
        }
    }

    /**
     * Get status for different method.
     *
     * @param  string $methodName
     * @param  object $case
     * @access public
     * @return mixed    string | bool | array
     */
    public function getStatus($methodName, $case = null)
    {
        if($methodName == 'create')
        {
            if($this->forceNotReview() || $this->post->forceNotReview) return 'normal';
            return 'wait';
        }

        if($methodName == 'review')
        {
            $status = zget($case, 'status', '');

            if($this->post->result == 'pass') return 'normal';

            return $status;
        }

        if($methodName == 'update')
        {
            if(!empty($_POST['lastEditedDate']) and $case->lastEditedDate != $this->post->lastEditedDate)
            {
                dao::$errors[] = $this->lang->error->editedByOther;
                return false;
            }

            $status      = $this->post->status ? $this->post->status : $case->status;
            $stepChanged = false;
            $steps       = array();

            /* ---------------- Judge steps changed or not.-------------------- */

            /* Remove the empty setps in post. */
            if($this->post->steps)
            {
                $data = fixer::input('post')->get();
                foreach($data->steps as $key => $desc)
                {
                    $desc     = trim($desc);
                    $stepType = isset($data->stepType[$key]) ? $data->stepType[$key] : 'step';
                    if(!empty($desc)) $steps[] = array('desc' => $desc, 'type' => $stepType, 'expect' => trim($data->expects[$key]));
                }

                /* If step count changed, case changed. */
                if(count($case->steps) != count($steps))
                {
                    $stepChanged = true;
                }
                else
                {
                    /* Compare every step. */
                    $i = 0;
                    foreach($case->steps as $key => $oldStep)
                    {
                        if(trim($oldStep->desc) != trim($steps[$i]['desc']) or trim($oldStep->expect) != $steps[$i]['expect'] or trim($oldStep->type) != $steps[$i]['type'])
                        {
                            $stepChanged = true;
                            break;
                        }
                        $i++;
                    }
                }
            }

            if(!$this->forceNotReview() and $stepChanged) $status = 'wait';

            if(!empty($_POST['title']) and $case->title != $this->post->title)                      $stepChanged = true;
            if(!empty($_POST['precondition']) and $case->precondition != $this->post->precondition) $stepChanged = true;

            return array($stepChanged, $status);
        }

        return '';
    }


    /**
     * Build test case view menu.
     *
     * @param  object $case
     * @access public
     * @return string
     */
    public function buildOperateViewMenu($case)
    {
        if($case->deleted) return '';

        $menu        = '';
        $params      = "caseID=$case->id";
        $extraParams = "runID=$case->runID&$params";
        if(!$case->needconfirm)
        {
            if(!$case->isLibCase)
            {
                if($this->app->getViewType() == 'xhtml')
                {
                    $menu .= $this->buildMenu('testtask', 'runCase', "$extraParams&version=$case->currentVersion", $case, 'view', 'play', '', 'showinonlybody', false, "data-width='95%'");
                    $menu .= $this->buildMenu('testtask', 'results', "$extraParams&version=$case->version",        $case, 'view', '', '', 'showinonlybody', false, "data-width='95%'");
                    $menu .= $this->buildMenu('testcase', 'importToLib', $params,                                  $case, 'view', 'assets', '', 'showinonlybody iframe', true, "data-width='500px'");
                }
                else
                {
                    $menu .= $this->buildMenu('testtask', 'runCase', "$extraParams&version=$case->currentVersion", $case, 'view', 'play', '', 'showinonlybody iframe', false, "data-width='95%'");
                    $menu .= $this->buildMenu('testtask', 'results', "$extraParams&version=$case->version",        $case, 'view', '', '', 'showinonlybody iframe', false, "data-width='95%'");
                    $menu .= $this->buildMenu('testcase', 'importToLib', $params,                                  $case, 'view', 'assets', '', 'showinonlybody iframe', true, "data-width='500px'");
                }
                if($case->caseFails > 0)
                {
                    $menu .= $this->buildMenu('testcase', 'createBug', "product=$case->product&branch=$case->branch&extra=$params,version=$case->version,runID=$case->runID", $case, 'view', 'bug', '', 'iframe', '', "data-width='90%'");
                }
            }
            if($this->config->testcase->needReview || !empty($this->config->testcase->forceReview))
            {
                $menu .= $this->buildMenu('testcase', 'review', $params, $case, 'view', '', '', 'iframe', '', '', $this->lang->testcase->reviewAB);
            }
        }
        else
        {
            $menu .= $this->buildMenu('testcase', 'confirmstorychange', $params, $case, 'view', 'confirm', 'hiddenwin', '', '', '', $this->lang->confirm);
        }
        #导出为word
        $menu .= $this->buildMenu('testcase', 'exportToWord', $params, $case, 'view', 'export', '', 'showinonlybody iframe', true, "data-width='500px'");
        $menu .= "<div class='divider'></div>";
        $menu .= $this->buildFlowMenu('testcase', $case, 'view', 'direct');
        $menu .= "<div class='divider'></div>";

        if(!$case->needconfirm)
        {
            if(!isonlybody())
            {
                $editParams = $params;
                if($this->app->tab == 'project')   $editParams .= "&comment=false&projectID={$this->session->project}";
                if($this->app->tab == 'execution') $editParams .= "&comment=false&executionID={$this->session->execution}";
                $menu .= $this->buildMenu('testcase', 'edit', $editParams, $case, 'view', '', '', 'showinonlybody');
            }
            if(!$case->isLibCase && $case->auto != 'unit')
            {
                $menu .= $this->buildMenu('testcase', 'create', "productID=$case->product&branch=$case->branch&moduleID=$case->module&from=testcase&param=$case->id", $case, 'view', 'copy');
            }
            if($case->isLibCase && common::hasPriv('caselib', 'createCase'))
            {
                echo html::a(helper::createLink('caselib', 'createCase', "libID=$case->lib&moduleID=$case->module&param=$case->id"), "<i class='icon-copy'></i>", '', "class='btn' title='{$this->lang->testcase->copy}'");
            }

            $menu .= $this->buildMenu('testcase', 'delete', $params, $case, 'view', 'trash', 'hiddenwin', '');
        }

        return $menu;
    }


    /**
     * processDatas
     *
     * @param  array  $datas
     * @access public
     * @return void
     */
    public function processDatas($datas)
    {
        if(isset($datas->datas)) $datas = $datas->datas;
        $columnKey  = array();
        $caseData   = array();
        $stepData   = array();
        $stepVars   = 0;

        foreach($datas as $row => $cellValue)
        {
            foreach($cellValue as $field => $value)
            {
                if($field != 'stepDesc' and $field != 'stepExpect') continue;
                if($field == 'stepDesc' or $field == 'stepExpect')
                {
                    $steps = $value;
                    if(strpos($value, "\n"))
                    {
                        $steps = explode("\n", $value);
                    }
                    elseif(strpos($value, "\r"))
                    {
                        $steps = explode("\r", $value);
                    }
                    if(is_string($steps)) $steps = explode("\n", $steps);

                    $stepKey  = str_replace('step', '', strtolower($field));

                    $caseStep = array();
                    foreach($steps as $step)
                    {
                        $trimedStep = trim($step);
                        if(empty($trimedStep)) continue;
                        if(preg_match('/^(([0-9]+)\.[0-9]+)([.、]{1})/U', $step, $out) and ($field == 'stepDesc' or ($field == 'stepExpect' and isset($stepData[$row]['desc'][$out[1]]))))
                        {
                            $num     = $out[1];
                            $parent  = $out[2];
                            $sign    = $out[3];
                            $signbit = $sign == '.' ? 1 : 3;
                            $step    = trim(substr($step, strlen($num) + $signbit));
                            if(!empty($step)) $caseStep[$num]['content'] = $step;
                            $caseStep[$num]['type']    = 'item';
                            $caseStep[$parent]['type'] = 'group';
                        }
                        elseif(preg_match('/^([0-9]+)([.、]{1})/U', $step, $out) and ($field == 'stepDesc' or ($field == 'stepExpect' and isset($stepData[$row]['desc'][$out[1]]))))
                        {
                            $num     = $out[1];
                            $sign    = $out[2];
                            $signbit = $sign == '.' ? 1 : 3;
                            $step    = trim(substr($step, strpos($step, $sign) + $signbit));
                            if(!empty($step)) $caseStep[$num]['content'] = $step;
                            $caseStep[$num]['type'] = 'step';
                        }
                        elseif(isset($num))
                        {
                            if(!isset($caseStep[$num]['content'])) $caseStep[$num]['content'] = '';
                            if(!isset($caseStep[$num]['type']))    $caseStep[$num]['type']    = 'step';
                            $caseStep[$num]['content'] .= "\n" . $step;
                        }
                        else
                        {
                            if($field == 'stepDesc')
                            {
                                $num = 1;
                                $caseStep[$num]['content'] = $step;
                                $caseStep[$num]['type']    = 'step';
                            }
                            if($field == 'stepExpect' and isset($stepData[$row]['desc']))
                            {
                                end($stepData[$row]['desc']);
                                $num = key($stepData[$row]['desc']); $caseStep[$num]['content'] = $step;
                            }
                        }
                    }

                    unset($num);
                    unset($sign);
                    $stepVars += count($caseStep, COUNT_RECURSIVE) - count($caseStep);
                    $stepData[$row][$stepKey] = $caseStep;
                }

            }
        }
        return $stepData;
    }
}

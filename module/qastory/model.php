<?php
/**
 * The model file of projectStory module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     projectStory
 * @version     $Id
 * @link        http://www.zentao.net
 */
class qastoryModel extends model
{
    /**
     * Set the menu.
     *
     * @param  array $products
     * @param  int   $productID
     * @param  int   $branch
     * @access public
     * @return void
     */
    public function setMenu($products = array(), $productID = 0, $branch = 0)
    {
        /* Determine if the product is accessible. */
        if($products and (!isset($products[$productID]) or !$this->loadModel('product')->checkPriv($productID))) $this->loadModel('product')->accessDenied();

        if(empty($productID)) $productID = key($products);
        $this->loadModel('product')->setMenu($products, $productID, $branch);
        $this->lang->modulePageNav = $this->product->select($products, $productID, 'projectstory', $this->app->rawMethod, '', $branch);
    }

    /**
     * Get the stories for execution linked.
     *
     * @param  int    $projectID
     * @param  array  $storyIdList
     * @access public
     * @return array
     */
    public function getExecutionStories($projectID, $storyIdList = array())
    {
        $stories     = array();
        $storyIdList = (array)$storyIdList;

        if(empty($storyIdList)) return $stories;

        $stories = $this->dao->select('t2.id as id, t2.title as title, t3.id as executionID, t3.name as execution')->from(TABLE_PROJECTSTORY)->alias('t1')
            ->leftJoin(TABLE_STORY)->alias('t2')->on('t1.story=t2.id')
            ->leftJoin(TABLE_EXECUTION)->alias('t3')->on('t1.project=t3.id')
            ->where('t1.story')->in($storyIdList)
            ->andWhere('t3.type')->in('sprint,stage,kanban')
            ->andWhere('t3.project')->eq($projectID)
            ->andWhere('t3.deleted')->eq(0)
            ->fetchAll('id');

        return $stories;
    }

    public function batchCreate($storyID = 0, $branch = 0, $type = 'story')
    {

        $this->loadModel('action');
        $branch    = (int)$branch;
        $storyID = (int)$storyID;
        $now       = helper::now();
        $mails     = array();
        $stories   = fixer::input('post')->get();
        $faStory = $this->loadModel('story')->getById($storyID);
        if(!$faStory){
            dao::$errors['message'] = '父需求不存在';
        }
        elseif($faStory->type == 'taskPoint'){
            dao::$errors['message'] = '父需求不能为功能点';
        }


        $result  = $this->loadModel('common')->removeDuplicate('story', $stories, "product={$faStory->product}");
        $stories = $result['data'];

        if(isset($stories->uploadImage)) $this->loadModel('file');

        $now = helper::now();
        $data         = array();
        foreach($stories->title as $i => $title)
        {
            if(empty($title)) continue;
            
            $story = new stdclass();
            $story->type       = $type;
            $story->title      = trim($stories->title[$i]);
            $story->version      = 1;
            $story->color      = $stories->color[$i];
            $story->plan = '';
            $story->notifyEmail = '';
            $story->openedBy = $this->app->user->account;
            $story->openedDate = $now;
            $story->feedbackBy = '';
            $story->fromBug = 0;
            $story->assignedTo = '';
            $story->product    = $faStory->product;
            $story->parent = $faStory->id;
            $story->status = 'active';
            $story->stage = 'projected';
            
            $data[$i] = $story;
        }

        $link2Plans = array();
        foreach($data as $i => $story)
        {
            ChromePhp::log($data);
            $this->dao->insert(TABLE_STORY)->data($story)->autoCheck()->checkFlow()->exec();
            if(dao::isError())
            {
                echo js::error(dao::getError());
                return print(js::reload('parent'));
            }
            ChromePhp::log('save success');

            $storyID = $this->dao->lastInsertID();
            $this->setStage($storyID);

            $specData = new stdclass();
            $specData->story   = $storyID;
            $specData->version = 1;
            $specData->title   = $stories->title[$i];
            $specData->spec    = '';
            $specData->verify  = '';
            if(!empty($stories->spec[$i]))  $specData->spec   = nl2br($stories->spec[$i]);
            if(!empty($stories->verify[$i]))$specData->verify = nl2br($stories->verify[$i]);


            $this->dao->insert(TABLE_STORYSPEC)->data($specData)->exec();

            $this->executeHooks($storyID);

            $actionID = $this->action->create('story', $storyID, 'Opened', '');
            if(!dao::isError()) $this->loadModel('score')->create('story', 'create',$storyID);
            $mails[$i] = new stdclass();
            $mails[$i]->storyID  = $storyID;
            $mails[$i]->actionID = $actionID;
        }

        return $mails;
    }

}

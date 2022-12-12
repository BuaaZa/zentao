<?php

/**
 * The team batch create entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class teamBatchCreateEntry extends Entry
{
    /**
     * POST method.
     *
     * @param int $projectID
     * @access public
     * @return void
     */
    public function post(int $projectID = 0)
    {
        $res = new stdclass();

        $res->success = false;
        $res->error = array();
        $res->memberIDList = array();
        $res->parentIDList = array();

        # 检查请求体
        if (!isset($this->requestBody->members)) {
            $res->error[] = '请求体缺少『members』';
            $this->send(200, $this->format($res, ''));
        }

        # 查询项目(执行)
        $project = $this->dao->select('project,type,deleted')->from(TABLE_PROJECT)
            ->where('id')->eq($projectID)
            ->fetch();

        # 判断是否存在项目(执行)
        if (empty($project)) {
            $res->error[] = "不存在的项目(执行)ID『{$projectID}』";
            $this->send(200, $this->format($res, ''));
        }elseif ($project->deleted == '1' ){
            $res->error[] = "项目(执行)『{$projectID}』已被删除";
            $this->send(200, $this->format($res, ''));
        }

        $parent=$project->project;
        # 检查和准备数据
        $checkedMemberList=array();
        foreach ($this->request('members') as $index => $person) {
            if (empty($person))
                continue;

            # 检查必填字段
            $this->checkFields($index+1, $person, 'name,days', $res);

            # 检查系统用户是否存在
            $user = $this->loadModel("user")->getById($person->name,'account');
            if(!$user){
                $res->error[] = "请先创建系统用户『{$person->name}』";
                $this->send(200, $this->format($res, ''));
            }

            # 检查同名团队成员是否存在
            $team = $this->dao->select('account')->from(TABLE_TEAM)
                ->where('root')->eq($projectID)
                ->andWhere('account')->eq($person->name)
                ->fetch();
            if($team){
                $res->error[] = "已存在团队成员『{$person->name}』";
                $this->send(200, $this->format($res, ''));
            }

            # 检查 可用工时/天
            if((float)$person->hours > 24)
            {
                $res->error[] = "可用工时/天不能大于『24』";
                $this->send(200, $this->format($res, ''));
            }

            $defaultWorkhours =  '7.0'; # 默认可用工时/天

            # 准备数据
            $member             = new stdClass();
            $member->root       = $projectID;
            $member->type       = ($project->type=='project')?'project':'execution';
            $member->account    = $person->name;
            $member->role       = $person->role ?? '';
            $member->limited    = $person->limited ?? 'no';
            $member->join       = helper::today();
            $member->days       = $person->days ?? 0;
            $member->hours      = $person->hours ?? $defaultWorkhours;

            $checkedMemberList[$person->name] = $member;
        }

        # 插入数据库
        foreach ( $checkedMemberList as $member){

            $this->dao->insert(TABLE_TEAM)->data($member)
                ->autoCheck()
                ->exec();

            $resMember = new stdClass();
            $resMember->id = $this->dao->lastInsertId();
            $resMember->name = $member->account;

            $res->memberIDList[] = $resMember;
        }

        if (dao::isError()){
            $res->error = dao::getError();
            $this->send(200, $this->format($res, ''));
        }

        # 添加执行团队时添加项目团队
        if($parent!=0) {
            $this->loadModel('execution')->addProjectMembers($parent, $checkedMemberList);
            $parentTeam = $this->dao->select('id,account')->from(TABLE_TEAM)
                ->where('root')->eq($parent)
                ->andWhere('account')->in( array_keys($checkedMemberList))
                ->fetchAll();
            foreach ($parentTeam as $member){
                $resMember = new stdClass();
                $resMember->id = strval($member->id);
                $resMember->name = $member->account;

                $res->parentIDList[]=$resMember;
            }
        }

        $res->success=true;
        $this->send(200, $this->format($res, ''));
    }

    /**
     * 确保字段不能为空.
     * Make sure the fields is not empty.
     *
     * @param integer $index
     * @param object $object
     * @param string $fields
     * @param object $res
     * @access public
     * @return void
     */
    public function checkFields(int $index, object $object, string $fields, object $res): void
    {
        $fields = explode(',', $fields);
        $success = true;
        foreach ($fields as $field) {
            if (!isset($object->$field)) {
                $res->error[] = "添加的第 $index 个成员缺少『{$field}』字段";
                $success = false;
            }
        }
        if(!$success)
            $this->send(200, $this->format($res, ''));
    }
}

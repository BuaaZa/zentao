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
    public function post($projectID = 0)
    {
        $res = new stdclass();

        $res->memberIDList = array();
        $res->success = false;
        $res->error = '';

        # 检查请求体
        if (!isset($this->requestBody->members)) {
            $res->error = '请求体缺少 members ';
            $this->send(200, $this->format($res, ''));
        }

        # 查询项目(执行)
        $project = $this->dao->select('project,type')->from(TABLE_PROJECT)
            ->where('id')->eq($projectID)
            ->fetch();

        # 判断是否存在项目(执行)
        if (empty($project)) {
            $res->error = "不存在的项目(执行)ID $projectID ";
            $this->send(200, $this->format($res, ''));
        }

        # 查询全部项目(执行)团队成员
        $team = $this->dao->select('account')->from(TABLE_TEAM)
            ->where('root')->eq($projectID)
            ->fetchAll();

        $teamMembers = array();

        foreach ($team as $member){
            array_push($teamMembers,$member->account);
        }

        # 批量插入数据库
        foreach ($this->request('members') as $index => $person) {
            if (empty($person))
                continue;

            # 检查必填字段
            $this->checkFields($index, $person, 'name', $res);

            # 检查用户是否已经存在
            if (in_array($person->name, $teamMembers)) {
                $res->error = "已存在用户 $person->name ";
                $this->send(200, $this->format($res, ''));
            }

            # 准备数据
            $member = new stdClass();
            $member->root = $projectID;
            $member->type = $project->type;
            $member->account = $person->name;
            $member->role = $person->role ?? '';
            $member->limited = $person->limited ?? 'no';
            $member->join = helper::now();
            $member->days = $person->days ?? 0;
            $member->hours = $person->hours ?? '0.0';

            var_dump($member);

            # 插入数据库
            $this->dao->insert(TABLE_TEAM)->data($member)->exec();
            array_push($res->memberIDList, $this->dao->lastInsertId());

//            $teamMembers[$person->account] = $member;
        }

        if (dao::isError()){
            $res->error = "数据库操作错误";
            $this->send(200, $this->format($res, ''));
        }

        # 添加执行团队时添加项目团队
//        if($this->config->systemMode == 'new') $this->loadModel('execution')->addProjectMembers($projectID, $teamMembers);

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
    public function checkFields($index, $object, $fields, $res)
    {
        $fields = explode(',', $fields);
        foreach ($fields as $field) {
            if (!isset($object->$field)) {
                $res->error = "添加的第${index}个成员缺少 $field 字段";
                $this->send(200, $this->format($res, ''));
            }
        }
    }
}

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
        # 检查请求参数，获取请求参数
        if (!$projectID)
            $projectID = $this->param('project', 0);
        if (!$projectID)
            $this->send400('Need project or execution id.');

        # 检查请求体
        if (!isset($this->requestBody->members)) {
            $this->send400('Need team’s members.');
        }

        # 批量插入数据库
        $teamMembers = array();
        $memberIDList = new stdClass();
        $memberIDList->memberIDList=array();
        foreach ($this->request('members') as $person) {
            if (empty($person))
                continue;
            if(!isset($person->name) )
                $this->send400('Member must have name.');

            $member = new stdClass();
            $member->root = $projectID;
            $member->type = 'project';
            $member->account = $person->name;
            $member->role = zget($person->role, 'role', '');
            $member->join = helper::now();
            $member->days = zget($person->days, 'days', 0);
            $member->hours = $this->config->execution->defaultWorkhours;
            $this->dao->insert(TABLE_TEAM)->data($member)->exec();
            array_push($memberIDList->memberIDList, $this->dao->lastInsertId());
            $teamMembers[$person->account] = $member;
        }

        if (dao::isError())
            $this->send400('Database error.');

        # 添加执行团队时添加项目团队
//        if($this->config->systemMode == 'new') $this->loadModel('execution')->addProjectMembers($projectID, $teamMembers);

        $this->send(201, $this->format($memberIDList, ''));
    }
}

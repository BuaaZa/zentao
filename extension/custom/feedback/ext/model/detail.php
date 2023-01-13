<?php
// 封装反馈详情
public function detail(stdClass $fb)
{
    $this->setUserInfo($fb);
    $this->setActionInfo($fb);
}

// 设置用户相关信息
private function setUserInfo(stdClass $fb)
{
    // 加载user模块
    $user = $this->loadModel('user');
    if (!$user) {
        return;
    }
    // 收集涉及用户的字段
    $accounts = array();
    // 反馈中设计用户的字段名称集合
    // 创建人,由谁评审,由谁处理,由谁关闭,最后处理人,反馈者
    $userBys = array("openedBy","reviewedBy","processedBy","closedBy","editedBy","feedbackBy","assignedTo","mailto");
    foreach ($userBys as $userBy) {
        $userByVal = $fb->$userBy;
        if ($userByVal) {
            if (str_starts_with($userByVal, ",")) {
                $accounts = array_merge($accounts, explode(",", $userByVal));
            } else {
                array_push($accounts, $userByVal);
            }
        }
    }
    // 去空
    $accounts = array_filter($accounts);
    // 去重
    $accounts = array_unique($accounts);
    // 按账号查询用户数据
    $users = $user->getListByAccounts($accounts, "account");
    if (empty($users)) {
        return;
    }

    foreach ($userBys as $userBy) {
        $userByVal = $fb->$userBy;
        if ($userByVal) {
            if (str_starts_with($userByVal, ",")) {
                $userByVals = explode(",", $userByVal);
                // 去空
                $userByVals = array_filter($userByVals);
                // 去重
                $userByVals = array_unique($userByVals);
                $userInfos = array();
                foreach ($userByVals as $userByVal) {
                    $userInfo = $users[$userByVal];
                    if ($userInfo) {
                        array_push($userInfos, array(
                            'id' => $userInfo->id,
                            'account' => $userInfo->account,
                            'realname' => $userInfo->realname,
                            'avatar' => $userInfo->avatar));
                    }
                }
                $fb->$userBy = $userInfos;
            } else {
                $userInfo = $users[$fb->$userBy];
                if ($userInfo) {
                    $fb->$userBy = array(
                    'id' => $userInfo->id,
                    'account' => $userInfo->account,
                    'realname' => $userInfo->realname,
                    'avatar' => $userInfo->avatar);
                }
            }
        }
    }
}

// 设置action相关信息
private function setActionInfo(stdClass $fb)
{
    $action = $this->loadModel('action');
    if (!$action) {
        return;
    }
    $actions = $action->getList('feedback', $fb->id);
    if (empty($actions)) {
        $fb->actions = array();
        return;
    }
    $newActions = array();
    foreach ($actions as $action) {
        array_push($newActions,$action);
    }
    $fb->actions = $newActions;
}
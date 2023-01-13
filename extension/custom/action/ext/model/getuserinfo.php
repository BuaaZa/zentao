<?php

public function getUserInfo()
{
    $userListByAccount = array();
    $this->loadModel('user');
    $userList=$this->user->getList();
    if (empty($userList)) {
        return $userListByAccount;
    }
    foreach ($userList as $user) {
        $userListByAccount[$user->account]  =$user;
    }
    return $userListByAccount;
}

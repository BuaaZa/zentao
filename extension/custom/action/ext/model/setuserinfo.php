<?php

public function setuserinfo($action,$userInfoList)
{
    if (array_key_exists($action->actor, $userInfoList)) {
        $user=$userInfoList[$action->actor];
        $action->openedBy = array(
            'id'=>$user->id,
            'account'=>$user->account,
            'avatar'=>$user->avatar,
            'realname'=>$user->realname,
        );
    }
}
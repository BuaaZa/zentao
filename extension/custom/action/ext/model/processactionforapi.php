<?php
/**
 * Process action for API.
 *
 * @param  array  $actions
 * @param  array  $users
 * @param  array  $objectLang
 * @access public
 * @return array
 */
public function processActionForAPI($actions, $users = array(), $objectLang = array())
{
    $actions = (array)$actions;
    // 修改此处让评论可以返回附件信息 -> chenjj 221225
    $commentIDs = array();
    // 修改此处让评论可以返回更多用户信息 -> chenjj 221225
    $userInfoList=$this->getuserinfo();
    foreach($actions as $action)
    {
        // 修改此处让评论可以返回更多用户信息 -> chenjj 221225
        $this->setuserinfo($action,$userInfoList);
        // 修改此处让评论可以返回附件信息 -> chenjj 221225
        array_push($commentIDs, $action->id);
        $action->actor = zget($users, $action->actor);
        if($action->action == 'assigned') $action->extra = zget($users, $action->extra);
        if(strpos($action->actor, ':') !== false) $action->actor = substr($action->actor, strpos($action->actor, ':') + 1);

        ob_start();
        $this->printAction($action);
        $action->desc = ob_get_contents();
        ob_end_clean();

        if($action->history)
        {
            foreach($action->history as $i => $history)
            {
                $history->fieldName = zget($objectLang, $history->field);
                $action->history[$i] = $history;
            }
        }
    }

    // 修改此处让评论可以返回附件信息 -> chenjj 221225
    $this->setfileinfo($actions, $commentIDs);

    return array_values($actions);
}
<?php

// 批量指派
class myFeedback extends feedback
{
    public function batchAssignTo()
    {
        // 先检查传入的id是否能查到记录
        $feedbackIDList = $this->post->feedbackIDList;
        $fbs = $this->feedback->getByIds($feedbackIDList);
        if (count($fbs)==0) {
            return print(js::error('找不到需要指派的反馈记录'));
        }

        $assignedTo = $this->post->assignedTo;
        foreach ($fbs as $fb) {
            $feedbackID = $fb->id;
            $changes = $this->feedback->assignTo($fb, $assignedTo, '');
            $actionID = $this->action->create('feedback', $feedbackID, 'assigned', '', $assignedTo);
            $this->action->logHistory($actionID, $changes);
        }
        return print(js::reload('parent'));
    }
}

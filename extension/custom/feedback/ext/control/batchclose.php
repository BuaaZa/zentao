<?php

// 批量关闭
class myFeedback extends feedback
{
    public function batchClose(string $reason = '')
    {
        // 先检查传入的id是否能查到记录
        $feedbackIDList = $this->post->feedbackIDList;
        $fbs = $this->feedback->getByIds($feedbackIDList);
        if (count($fbs)==0) {
            return print(js::error('找不到需要关闭的反馈记录'));
        }

        // 待完善的不能删除的反馈的标题
        $toBeClarified = array();
        foreach ($fbs as $fb) {
            if ($fb->status=='clarify') {
                array_push($toBeClarified, $fb->id.'->    '.$fb->title);
            }
        }
        if (!empty($toBeClarified)) {
            return print(js::error($this->lang->feedback->clarifyclose.'\n'. join('\n', $toBeClarified)));
        }

        foreach ($fbs as $fb) {
            $feedbackID = $fb->id;
            $changes = $this->feedback->close($fb, $reason, '');
            $actionID = $this->action->create('feedback', $feedbackID, 'closed', '', $reason);
            $this->action->logHistory($actionID, $changes);
        }
        return print(js::reload('parent'));
    }
}

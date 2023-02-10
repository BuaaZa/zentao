<?php

class myFeedback extends feedback
{
    public function close(int $feedbackID, string $extra = '', string $from = '')
    {
        $fb = $this->feedback->getById($feedbackID);

        if (!$fb) {
            return print(js::error('找不到对应的反馈记录'));
            // return $this->send(array('status' => 'success', 'data' => $bugID));
        }

        if (empty($_POST)) {
            $this->view->feedbacks = $this->feedback->getFeedbacks4Select($fb);
            $this->display();
            return;
        }

        if ($fb->status=='clarify') {
            // 待完善的不能删除
            return print(js::error($this->lang->feedback->clarifyclose));
        }

        $closedReason = $this->post->closedReason;
        // if(!$closedReason){
        //   return print(js::error('关闭原因不能为空'));
        // }

        $repeatFeedback = '';
        if ('repeat'===$closedReason) {
            $repeatFeedback = $this->post->repeatFeedback;
            $closedReason=$closedReason.':'.$repeatFeedback;
        }

        $comment = $this->post->comment;
        // if(!$comment){
        //   return print(js::error('备注不能为空'));
        // }

        $changes = $this->feedback->close($fb, $closedReason, $repeatFeedback);
        $actionID = $this->action->create('feedback', $feedbackID, 'closed', $comment, $closedReason);
        $this->action->logHistory($actionID, $changes);

        if (defined('RUN_MODE') && RUN_MODE == 'api') {
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        return print(js::closeModal('parent.parent'));
    }
}

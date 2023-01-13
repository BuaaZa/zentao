<?php

class myFeedback extends feedback
{
    public function assignTo(int $feedbackID, string $reqType='')
    {
        $fb = $this->feedback->getById($feedbackID);

        if (!$fb) {
            return print(js::error('找不到对应的反馈记录'));
        }

        if (empty($_POST)) {
            // 提供前台表单数据
            $this->view->feedback = $fb;
            $actions = $this->action->getList('feedback', $feedbackID);
            // 历史记录
            $this->view->actions = $actions;
            $this->display();
            return;
        }

        $assignedTo = $this->post->assignedTo;
        $mailto = $this->post->mailto;
        if (!$mailto) {
            $mailto = array();
        }
        $comment = $this->post->comment;

        $changes = $this->feedback->assignTo($fb, $assignedTo, join(',', $mailto));
        $actionID = $this->action->create('feedback', $feedbackID, 'assigned', $comment, $assignedTo);
        $this->action->logHistory($actionID, $changes);
        if (defined('RUN_MODE') && RUN_MODE == 'api') {
            return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }
        return print(js::closeModal('parent.parent'));
    }
}

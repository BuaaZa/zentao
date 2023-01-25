<?php

// 批量编辑 chenjj 230116
class myFeedback extends feedback
{
    public function batchEdit(string $browseType = '')
    {
        
        if ($this->post->titles) {
            $allChanges = $this->feedback->batchUpdate();

            foreach ($allChanges as $feedbackID => $changes) {
                if (empty($changes)) {
                    continue;
                }

                $actionID = $this->action->create('feedback', $feedbackID, 'edited');
                $this->action->logHistory($actionID, $changes);

            }
            return print(js::locate($this->session->feedbackList, 'parent'));
        }

        // 先检查传入的id是否能查到记录
        $feedbackIDList = $this->post->feedbackIDList;
        $fbs = $this->feedback->getByIds($feedbackIDList);
        if (count($fbs)==0) {
            return print(js::error('找不到需要指派的反馈记录'));
        }
        $this->view->browseType =$browseType;
        $this->view->feedbacks = $fbs;
        $moduleList = array();
        if (!empty($this->products)) {
            foreach ($this->products as $id=>$name) {
                if (!array_key_exists($id, $moduleList)) {
                    $moduleList[$id] = array("/"=>"/");
                }
            }
        }
        $this->view->moduleList = $moduleList;

        $this->display();
    }
}

<?php

// 删除反馈
class myFeedback extends feedback
{
    public function delete($feedbackID, $confirm = 'no', $from = '')
    {
        $fb = $this->feedback->getById($feedbackID);
        if (!$fb) {
            return print(js::error('找不到对应的反馈记录'));
        }

        // 是不是api过来的请求
        $api = defined('RUN_MODE') && RUN_MODE == 'api';
        if ($fb->createdAt!='ztservice' && !$api) {
            // 不能删除非本服务创建的数据（api可以）
            return print(js::error($this->lang->feedback->externallyDelete));
        }

        if ($confirm == 'no') {
            return print(js::confirm($this->lang->feedback->confirmDelete, $this->createLink('feedback', 'delete', "feedbackID=$feedbackID&confirm=yes&from=$from")));
        }

        $this->feedback->delete(TABLE_FEEDBACK, $feedbackID);
        // 删掉关联记录
        $this->dao->delete()->from(TABLE_PROJECTUSEINFO)
            ->where('feedback')->eq($feedbackID)
            ->exec();
        return print(js::reload('parent'));
    }
}

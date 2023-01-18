<?php

class myCustom extends custom
{
    /**
     * 工作流设置
     */
    public function ajaxSetupFlow()
    {
        if (!empty($_POST)) {
            // 判断是不是数组并记录请求参数 chenjj 230116
            $this->app->saveLog(E_NOTICE, '##################### set feedback flow ' . (empty($_POST)?'':json_encode($_POST)), 'ajaxsetupflow.php', '11');
            $needReview = $_POST['needReview'];
            $forceReview = $_POST['forceReview'];
            $forceNotReview = $_POST['forceNotReview'];
            $reviewer = $_POST['reviewer'];
            if (!is_array($forceNotReview)) {
                $errMsg = $this->lang->custom->forceNotReview.' 需要是一个数组';
                return $this->sendError($errMsg);
            }
            $forceNotReview = join(',', $forceNotReview);
            
            if (!is_array($forceReview)) {
                $errMsg = $this->lang->custom->forceReview.' 需要是一个数组';
                return $this->sendError($errMsg);
            }
            $forceReview = join(',', $forceReview);
            $this->loadModel('setting');
            $this->setting->setItem('system.feedback.forceReview@rnd', $forceReview);
            $this->setting->setItem('system.feedback.forceNotReview@rnd', $forceNotReview);
            $this->setting->setItem('system.feedback.needReview@rnd', $needReview);
            $this->setting->setItem('system.feedback.reviewer@rnd', $reviewer);
        }

        $this->sendSuccess(array('id'=>'test'));
        //echo json_encode(array('aaa'=>'bbbbccc'));
    }
}
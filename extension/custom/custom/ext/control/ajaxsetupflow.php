<?php

class myCustom extends custom
{
    /**
     * 工作流设置
     */
    public function ajaxSetupFlow()
    {
        if(!empty($_POST))
        {            
            $needReview = $_POST['needReview'];
            $forceReview = $_POST['forceReview'];
            $forceNotReview = $_POST['forceNotReview'];
            $reviewer = $_POST['reviewer'];
            $forceNotReview = join(',',$forceNotReview);
            $forceReview = join(',',$forceReview);
            $this->loadModel('setting');
            $this->setting->setItem('system.feedback.forceReview@rnd',$forceReview);
            $this->setting->setItem('system.feedback.forceNotReview@rnd',$forceNotReview);
            $this->setting->setItem('system.feedback.needReview@rnd',$needReview);
            $this->setting->setItem('system.feedback.reviewer@rnd',$reviewer);
        }

        $this->sendSuccess(array('id'=>'test'));
        //echo json_encode(array('aaa'=>'bbbbccc'));
    }
}
<?php

// 反馈详情接口
class myFeedback extends feedback
{
    public function adminView($feedbackID)
    {
        $fb = $this->feedback->getById($feedbackID);
        if (!$fb) {
            $data = array('feedback'=>new stdClass());
            return $this->send(array('status'=>'fail','message'=>'id对应的数据不存在','data'=>json_encode($data)));
        }
        $this->feedback->processForApi(array($fb));
        $files = $this->loadModel('file')->getByObject('feedback', $feedbackID);
        $filesAry = array();
        // 转成数组
        if (!empty($files)) {
            foreach ($files as $file) {
                array_push($filesAry, $file);
            }
        }
        $fb->files = $filesAry;
        $this->view->feedback = $fb;
        $this->view->actions     = $this->action->getList('feedback', $feedbackID);
        $this->display();
        // return $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'data'=>$data));
    }
}

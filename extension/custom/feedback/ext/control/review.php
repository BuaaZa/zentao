<?php
// 扩展评审
class myFeedback extends feedback
{
    public function review($feedbackID)
    {
        $feedback             = $this->feedback->getById($feedbackID);

        if(!empty($_POST) && isonlybody())
        {            
            $result = $_POST['result'];
            $comment =$_POST['comment'];
            $action = 'review';
            if(empty($result)){
                return print(js::error($this->lang->feedback->mustChooseResult));
            }
            // clarify 待完善
            if($result == 'clarify'){
                $this->feedback->updateStatus($feedbackID,$result,$feedback);
            }else if ($result == "pass"){
                $this->feedback->updateStatus($feedbackID,$result,$feedback);
            }
            $this->action->create('feedback', $feedbackID, 'reviewed', $comment,ucfirst($result));
            return print(js::closeModal('parent.parent'));           
        }
        $this->view->feedback = $feedback;
        $this->view->actions     = $this->action->getList('feedback', $feedbackID);
        $this->display();
    }
}
<?php

// 批量更新 chenjj 230116
public function batchUpdate()
{
    $feedbacks        = array();
    $allChanges       = array();
    $now              = helper::now();
    $data             = fixer::input('post')->get();
    $feedbackIDList   = $this->post->feedbackIDList ? $this->post->feedbackIDList : array();

    if(!empty($feedbackIDList))
    {
        $oldFeedbacksAry = $feedbackIDList ? $this->getByIds($feedbackIDList) : array();
        $oldFeedbacks = array();
        foreach($oldFeedbacksAry as $idx=>$feedback){
            $oldFeedbacks[$feedback->id] = $feedback;
        }
        foreach($feedbackIDList as $feedbackID)
        {
            $oldFeedback = $oldFeedbacks[$feedbackID];

            $feedback = new stdclass();
            foreach($oldFeedback as $prop=>$value){
                $feedback->$prop = $value;
            }
            $feedback->editedBy       = $this->app->user->account;
            $feedback->editedDate     = $now;
            $feedback->updateDate     = $now;
            $feedback->product        = $data->products[$feedbackID];
            $feedback->module         = $data->modules[$feedbackID] ? $data->modules[$feedbackID] : 0;
            $feedback->title          = $data->titles[$feedbackID];
            $feedback->assignedTo     = $data->assignedTos[$feedbackID];

            if($feedback->assignedTo != $oldFeedback->assignedTo) $feedback->assignedDate = $now;

            $feedbacks[$feedbackID] = $feedback;
            unset($feedback);
        }

        /* Update feedbacks. */
        foreach($feedbacks as $feedbackID => $feedback)
        {
            $oldFeedback = $oldFeedbacks[$feedbackID];

            $this->dao->update(TABLE_FEEDBACK)->data($feedback)
                ->autoCheck()
                ->batchCheck($this->config->feedback->edit->requiredFields, 'notempty')
                ->checkFlow()
                ->where('id')->eq((int)$feedbackID)
                ->exec();

            if(!dao::isError())
            {
                $this->executeHooks($feedbackID);
                $allChanges[$feedbackID] = common::createChanges($oldFeedback, $feedback);
            }
            else
            {
                return helper::end(js::error('feedback#' . $feedbackID . dao::getError(true)));
            }
        }
    }
    return $allChanges;
}
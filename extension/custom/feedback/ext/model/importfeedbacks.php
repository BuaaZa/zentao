<?php

/**
 * 导入天唧反馈信息表
 * $saveFeedbacks 新增的反馈列表
 * $updateFeedbacks 更新的反馈列表
 * $projectUseInfoArray 项目使用环境列表
 * $attachmentArray 要导入的附件列表
 */
public function importFeedbacks($saveFeedbacks,$updateFeedbacks,$projectUseInfoArray,$attachmentArray,$extractFolder)
{
    // 获取需要更新的使用环境列表 
    $feedbackArray = array_column($updateFeedbacks,"id");// 已经有的反馈环境的列表，新增的反馈肯定没有已经存在的环境
    $dbFeedbackMapProjectUserInfo =$this->dao->select('*')->from(TABLE_PROJECTUSEINFO)
    ->where('feedback')->in($feedbackArray)
    ->fetchAll('feedback');

    $attachIdArray = array_column($attachmentArray,"id");// 所有附件的id列表
    $dbAttachmentMap = $this->dao->select('*')->from(TABLE_FILE)
    ->where('enternalId')->in($attachIdArray)
    ->fetchAll('enternalId');

    $feedbackExtIdMapZtIdMap = $this->dao->select('feedbackExId,id')
    ->from(TABLE_FEEDBACK)
    ->fetchPairs();

    $feedbackIdMapUser = array();
    
    $this->dao->begin();
    // 插入反馈信息
    foreach($saveFeedbacks as $feedback)
    {
        $this->dao->insert(TABLE_FEEDBACK)->data($feedback)
        ->autoCheck()
        ->exec();
        $newId = $this->dao->lastInsertId();
        $extId = $feedback->feedbackExId;
        $feedbackExtIdMapZtIdMap[$extId] = $newId;
        $projectUseInfo = $projectUseInfoArray[$extId];
        if(isset($projectUseInfo))
        {
            $projectUseInfoArray[$extId]->feedback = $newId;
        }
        $feedbackIdMapUser[$extId] = $feedback->openedBy;
    }
    // 更新反馈信息
    foreach($updateFeedbacks as $upFeedback)
    {
        $this->dao->update(TABLE_FEEDBACK)->data($upFeedback)
        ->where('id')->eq($upFeedback->id)
        ->exec();        
        $extId = $upFeedback->feedbackExId;
        $projectUseInfo = $projectUseInfoArray[$extId];
        if(isset($projectUseInfo))
        {
            $projectUseInfoArray[$extId]->feedback = $upFeedback->id;
        }
        $feedbackIdMapUser[$extId] = $upFeedback->openedBy;
    }

    // 更新或者新增使用环境信息
    foreach($projectUseInfoArray as $key=>$value)
    {
        if(key_exists($value->feedback,$dbFeedbackMapProjectUserInfo)){
            $this->dao->update(TABLE_PROJECTUSEINFO)->data($value)
            ->where('feedback')->eq($value->feedback)
            ->exec();        
        }else{
            $this->dao->insert(TABLE_PROJECTUSEINFO)->data($value)
            ->exec();
        }
    }

    // 导入附件及相关信息
    foreach($attachmentArray as $attachInfo)
    {
        $attachSave = new stdclass();
        $attachSave->addedDate = date("Y-m-d\TH:i:s\Z",$attachInfo->updateDate->time/1000);
        $saveMonthPath = date('Ym/', $attachInfo->updateDate->time/1000);
        $companyPath =  $this->app->getAppRoot() . "www/data/upload/{$this->app->company->id}/" ;
        $savePath =  $companyPath . $saveMonthPath .  $attachInfo->relativePath .'/';
        if(!file_exists($savePath))
        {
            @mkdir($savePath, 0777, true);
            touch($savePath . 'index.html');
        }

        $attachSave->pathname = $saveMonthPath . $attachInfo->relativePath . '/' . $attachInfo->fileName;
        $attachSave->title = $attachInfo->fileName;
        $attachSave->extension = str_replace('.','',strrchr($attachSave->pathname,'.'));        
        $attachSave->objectType = 'feedback';
        $attachSave->addedBy = $feedbackIdMapUser[$attachInfo->feedbackId];

        // 开始计算附件路径和附件大小
        $writeFilePath = $companyPath.$attachSave->pathname;
        $writeFilePath = str_replace(strrchr($writeFilePath,'.'),"",$writeFilePath);
        $zipFilePath = $extractFolder.'attachment/' . $attachInfo->relativePath . '/' . $attachInfo->fileName;
        copy($zipFilePath,$writeFilePath);
        $attachSave->size = filesize($writeFilePath);
        if($attachSave->size == false)
        {
            $this->dao->rollBack();
            $errorMessage = '附件复制失败';
            return print(js::alert($errorMessage));
        }
        
        // 如果数据库中有，那就是更新
        if(key_exists($attachInfo->id,$dbAttachmentMap)) 
        {
            $this->dao->update(TABLE_FILE)->data($attachSave)
            ->where('enternalId',$attachInfo->id)
            ->exec();
        }else{
            //数据库就没有新增
            $attachSave->objectID =  $feedbackExtIdMapZtIdMap[$attachInfo->feedbackId];
            $attachSave->enternalId = $attachInfo->id;
            $this->dao->insert(TABLE_FILE)->data($attachSave)
            ->exec();
        }
    }

    // 开始更新附件
    $this->dao->commit();
    return true;
}
<?php


// 反馈详情接口
class myFeedback extends feedback
{
    public function import($feedbackID=0)
    {
        if($_FILES)
        {
            $file = $this->loadModel('file')->getUpload('file');
            $file = $file[0];

            $currentTicket = $this->app->user->account .'_'. time();
            $fileName = $this->file->savePath . $currentTicket . '.zip';
            move_uploaded_file($file['tmpname'], $fileName);
            // $fileName            
            $this->app->loadClass('pclzip', true);
            $archive    = new pclzip($fileName);
            $extractFolder = $this->app->getAppRoot() . 'tmp/import/json/' . $currentTicket.'/';
            mkdir($extractFolder,0755,true);
            $archive->extract(PCLZIP_OPT_PATH,$extractFolder);

            // 开始导入feedbacks
            $feedbackFilePath = $extractFolder . 'Feedback.json';
            $feedbackArray = array();
            if(file_exists($feedbackFilePath))
            {
                $feedbackArrayStr = file_get_contents($feedbackFilePath);
                $feedbackArray = json_decode($feedbackArrayStr);
            }

            $saveFeedbackArray = array();   // 新增反馈列表
            $updateFeedbackArray = array(); // 更新反馈列表
            $projectUseInfoArray = array(); // 更新环境信息列表


            $dbFeedbacks = $this->feedback->getTjFeedbacks();
            if(!isset($dbFeedbacks)){
                $dbFeedbacks = array();
            }

            // 获取附件信息 Attachment.json
            $attachmentFilePath = $extractFolder . 'Attachment.json';
            $attachmentArray = array();

            if(file_exists($attachmentFilePath))
            {
                $attachmentArrayStr = file_get_contents($attachmentFilePath);
                $attachmentArray = json_decode($attachmentArrayStr);
            }

            // 获取数据库中已有反馈列表
            if(count($feedbackArray)>0)
            {                
                // 遍历反馈
                foreach($feedbackArray as $feedbackInfo)
                {
                    $saveFeedback = new stdclass();
                    
                    $saveFeedback->feedbackExId = $feedbackInfo->id;
                    $saveFeedback->openedBy = $feedbackInfo->openedBy;
                    $saveFeedback->openedDate = date("Y-m-d\TH:i:s\Z",$feedbackInfo->openedDate->time/1000);
                    //$saveFeedback->openedDate = $feedbackInfo->openedDate;
                    $saveFeedback->title = $feedbackInfo->title;
                    $saveFeedback->type = $feedbackInfo->type;
                    $saveFeedback->notify = $feedbackInfo->notify;
                    $saveFeedback->deleted = $feedbackInfo->deleted;
                    $saveFeedback->contactWay = $feedbackInfo->contactWay;
                    $saveFeedback->desc= $feedbackInfo->details;
                    $saveFeedback->product = $feedbackInfo->product;
                    $saveFeedback->editedDate = date("Y-m-d\TH:i:s\Z",$feedbackInfo->updateDate->time/1000);
                    $saveFeedback->updateDate = date("Y-m-d\TH:i:s\Z",$feedbackInfo->updateDate->time/1000); // 更新时间为导入记录的最后更新时间
                    $saveFeedback->exportDate = date("Y-m-d\TH:i:s\Z",$feedbackInfo->updateDate->time/1000); // 设置为导出时间，因为刚导入的肯定不需要增量导出
                    $saveFeedback->editedBy = $feedbackInfo->openedBy; // 创建人就是编辑人
                    $saveFeedback->usedProject = $feedbackInfo->usedProject;
                    $saveFeedback->productVersion = $feedbackInfo->productVersion;
                    $saveFeedback->createdAt = 'tjservice';// 天唧的数据标记
                    

                    if(isset($feedbackInfo->expectDate))
                    {
                        $saveFeedback->expectDate = date("Y-m-d\TH:i:s\Z",$feedbackInfo->expectDate->time/1000);
                    }

                    $projectUseInfo = new stdclass();
                    $r = count((array)$projectUseInfo);
                    if(isset($feedbackInfo->serverOS)) $projectUseInfo->serverOS = $feedbackInfo->serverOS;
                    if(isset($feedbackInfo->serverCPU)) $projectUseInfo->serverCPU= $feedbackInfo->serverCPU;
                    if(isset($feedbackInfo->middleware)) $projectUseInfo->middleware= $feedbackInfo->middleware;
                    if(isset($feedbackInfo->shujuku)) $projectUseInfo->database= $feedbackInfo->shujuku;  // 待确认
                    if(isset($feedbackInfo->terminalOS)) $projectUseInfo->terminalOS= $feedbackInfo->terminalOS;
                    if(isset($feedbackInfo->terminalCPU)) $projectUseInfo->terminalCPU= $feedbackInfo->terminalCPU;
                    if(isset($feedbackInfo->browser)) $projectUseInfo->browser= $feedbackInfo->browser;
                    if(count((array)$projectUseInfo)>0)
                    {
                        $projectUseInfo->feedback=$feedbackInfo->id;
                        $projectUseInfoArray[$feedbackInfo->id] = $projectUseInfo;
                    }
                    //$saveFeedback->updateDate = $feedbackInfo->updateDate;
                   
                    if(array_key_exists($feedbackInfo->id,$dbFeedbacks)){
                        // 现在数据库里面的状态  
                        $oldStatus = $dbFeedbacks[$feedbackInfo->id]->status;
                        if($oldStatus == 'clarify'){ // 只有是clarify的状态才需要变更为noreview 其它状态不需要更新status
                            $saveFeedback->status = 'noreview';
                        }
                        $saveFeedback->id = $dbFeedbacks[$feedbackInfo->id]->id;// 真实的主键
                        // 存在即为更新
                        array_push($updateFeedbackArray,$saveFeedback);
                    }else{
                        // 新增
                        $saveFeedback->status = $feedbackInfo->status;
                        array_push($saveFeedbackArray,$saveFeedback);
                    }
                    //$feedbackInfo->id
                }
                $retVal = $this->feedback->importFeedbacks($saveFeedbackArray,$updateFeedbackArray,$projectUseInfoArray,$attachmentArray,$extractFolder);
                $classFile = $this->app->loadClass('zfile');
                if(is_dir($extractFolder))
                {
                    $classFile->removeDir($extractFolder); // 删除上传zip，解压出来的文件
                }
                if(file_exists($fileName))
                {
                    unlink($fileName);// 删除上传的zip
                }

                if($retVal ==false){
                    return ;
                }
                return print(js::locate(inlink('admin','browser=all', ""), 'parent.parent'));
            }
        }
        $this->view->title = '天唧离线导入';
        $this->display();
    }
}
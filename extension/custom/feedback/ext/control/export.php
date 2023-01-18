<?php

// 反馈详情接口
class myFeedback extends feedback
{
  /**
   * 导出数据
   */
  public function export($feedbackID)
  {
    if($_POST)
    {
      // $exportType = $_POST['exportType'];
      // // 全量导出
      // if($exportType == 'all'){
        
      // }
      $currentTicket = $this->app->user->account .'_'. time();
      $outFile =$this->file->savePath. ''. $currentTicket.'.zip';//放在这里面主要是sendDownHeader有限制路径下载
      $this->app->loadClass('pclzip', true);
      $archive    = new pclzip($outFile);
      $exportFolder = $this->app->getAppRoot() . 'tmp/export/json/' . $currentTicket.'/';
      mkdir($exportFolder,0755,true);
      
      // 开启事务
      $this->dao->begin();
      // 1 获取所有的反馈
      $feedbacks = $this->feedback->exportFeedbacks();
      $feedbacksStr = json_encode($feedbacks,JSON_UNESCAPED_UNICODE);
      file_put_contents($exportFolder.'zt_feebacks.json',($feedbacksStr));
      
      $feedIdMapExtId = array();
      foreach($feedbacks as $tempFeedback)
      {
        $feedIdMapExtId[$tempFeedback->id] = $tempFeedback->feedbackExId;
      }

      $feedbacksIds = array_column($feedbacks,'id');
      // 2 获取所有反馈的评论
      $actions = $this->action->getByFeedbackIds($feedbacksIds,$feedIdMapExtId);
      $actionsStr = json_encode($actions,JSON_UNESCAPED_UNICODE);
      file_put_contents($exportFolder.'zt_action.json',($actionsStr));
      $actionsIds = array_column($actions,'id');

      // 3 获取所有反馈及评论附件
      // $files = $this->file->getByIds($feedbacksIds,$actionsIds);
      // $filesStr = json_encode($files,JSON_UNESCAPED_UNICODE);
      // file_put_contents($exportFolder.'zt_file.json',($filesStr));

      // foreach($files as $myFile)
      // {
      //   $fullPath = $this->file->savePath . $myFile->pathname;
      //   $writePath = $exportFolder.$myFile->pathname;

      //   $fullPath = str_replace(strrchr($fullPath,'.'),"",$fullPath); // 实际文件是去掉扩展名
      //   $writePath = str_replace(strrchr($writePath,'.'),"",$writePath); // 实际文件是去掉扩展名
      //   $dirWritePath = dirname($writePath);
      //   mkdir($dirWritePath,0755,true);
      //   copy($fullPath,$writePath);
      //   // file_put_contents($writePath,$filesStr);
      // }


      $archive->create($exportFolder, PCLZIP_OPT_REMOVE_PATH, $exportFolder);
      $this->dao->commit();
      $this->file->sendDownHeader($currentTicket, 'zip',$outFile,'file');
      return ;
    }else{
      $this->display();
    }
    
  }
}
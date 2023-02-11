<?php
/**
 * 反馈附件上传的接口
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFeedbackUploadEntry extends Entry
{
    /**
     * POST method.
     *
     * @access public
     * @return void
     */
    public function post($feedbackID)
    {
        // 记录请求参数，临时，后面删除
        $token = '';
        if(isset($_SERVER['HTTP_COOKIE'])){
            $token = $_SERVER['HTTP_COOKIE'];
        }
        if(isset($_SERVER['HTTP_TOKEN'])){
            $token = $_SERVER['HTTP_TOKEN'];
        }
        $this->app->saveLog(E_NOTICE, '##################### upload to feedback '. $token . ' '. (empty($_POST)?'':json_encode($_POST)), 'extfeedbackupload.php', '30');

        $this->loadModel('feedback');
        $oldFeedback = $this->feedback->getByIdNotDeleted($feedbackID);

        if (!$oldFeedback) {
            return $this->sendError(400, $this->lang->feedback->notFoundDeleted);
        }

        // 检查用户是否有权限操作（是否有当前反馈所在产品的权限）
        // $grantProducts = $this->feedback->getGrantProducts();
        // if (!in_array($oldFeedback->product, array_keys($grantProducts))) {
        //     return $this->sendError(400, $this->lang->feedback->accessDenied);
        // }

        $enternalIds = array();
        if(isset($_POST['enternalId'])){
            $enternalIds = explode(',',$_POST['enternalId']);
        }
        $this->loadModel('file');
        $ret = $this->file->saveUpload2('feedback', $feedbackID, '','files','labels',$enternalIds);
        if ($ret=='wrong') {
            return $this->sendError(400, $this->lang->file->misscount);
        }

        $data = $this->getData();
        if (isset($data->status) and $data->status == 'error') {
            return $this->sendError(400, $data->message);
        }
        if (isset($data->result) and $data->result == 'fail') {
            return $this->sendError(400, $data->message);
        }

        $feedback = $this->feedback->getByID($feedbackID);
        
        $files = $this->file->getByObject('feedback', $feedbackID);
        $filesAry = array();
        // 转成数组
        if (!empty($files)) {
            foreach ($files as $file) {
                array_push($filesAry, $file);
            }
        }
        $feedback->files = $filesAry;
        $this->feedback->processPropertity($feedback);

        return $this->send(200, $this->format($feedback, 'openedBy:user,openedDate:time,reviewedBy:user,reviewedDate:time,processedBy:user,processedDate:time,closedBy:user,closedDate:time,editedBy:user,editedDate:time,mailto:userList,deleted:bool'));
    }
}

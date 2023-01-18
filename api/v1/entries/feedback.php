<?php
/**
 * The product entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class feedbackEntry extends Entry
{
    /**
     * GET method.
     *
     * @param  int    $feedbackID
     * @access public
     * @return void
     */
    public function get($feedbackID)
    {

        $oldFeedback = $this->loadModel('feedback')->getByIdNotDeleted($feedbackID);
        if (!$oldFeedback) {
            return $this->sendError(400, $this->lang->feedback->notFoundDeleted);
        }

        // 检查用户是否有权限操作（是否有当前反馈所在产品的权限）
        // 关于getGrantProducts方法
        // 产品访问控制是公开（私有时需要在白名单中）且产品下需要有项目这里才能搜出来
        // $grantProducts = $this->loadModel('feedback')->getGrantProducts();
        // if (!in_array($oldFeedback->product, array_keys($grantProducts))) {
        //     return $this->sendError(400, $this->lang->feedback->accessDenied);
        // }

        $control = $this->loadController('feedback', 'adminView');
        $control->adminView($feedbackID);

        $data = $this->getData();

        $feedback = $data->data->feedback;

        // $feedback->publicStatus = $feedback->public;
        // $feedback->productName  = $data->data->product;
        $feedback->moduleName   = isset($data->data->modulePath[0]->name) ? $data->data->modulePath[0]->name : '/';
        // $feedback->resultType   = $data->data->type;
        if(isset($feedback->resultInfo) and $feedback->resultInfo->deleted == 0) $feedback->resultStatus = $this->loadModel('feedback')->processStatus($feedback->resultType, $feedback->resultInfo);

        if(!$data or !isset($data->status)) return $this->send400('error');
        if(isset($data->status) and $data->status == 'fail') return $this->sendError(zget($data, 'code', 400), $data->message);

        $feedback->actions = $this->loadModel('action')->processActionForAPI($data->data->actions, $data->data->users, $this->lang->feedback);

        // 产品使用环境信息
        $projectUseInfo = $this->dao->select('*')
                    ->from(TABLE_PROJECTUSEINFO)
                    ->where('feedback')->eq((int)$feedbackID)
                    ->fetch();
        if ($projectUseInfo) {
            $feedback->projectUseInfo = $projectUseInfo;
        } else {
            $feedback->projectUseInfo = null;
        }

        $this->send(200, $this->format($feedback, 'activatedDate:time,openedBy:user,openedDate:time,assignedTo:user,assignedDate:time,mailto:userList,resolvedBy:user,resolvedDate:time,closedBy:user,closedDate:time,lastEditedBy:user,lastEditedDate:time,deadline:date,deleted:bool'));
    }

    // /**
    //  * PUT method.
    //  *
    //  * @param  int    $feedbackID
    //  * @access public 
    //  * @return void
    //  */
    // public function put($feedbackID)
    // {
        
    //     // 记录请求参数，临时，后面删除
    //     $token = '';
    //     if(isset($_SERVER['HTTP_COOKIE'])){
    //         $token = $_SERVER['HTTP_COOKIE'];
    //     }
    //     if(isset($_SERVER['HTTP_TOKEN'])){
    //         $token = $_SERVER['HTTP_TOKEN'];
    //     }
    //     $this->app->saveLog(E_NOTICE, '##################### updte feedback token '. $token . ', requestBody ' . (isset($this->requestBody)?json_encode($this->requestBody):''), 'feedback.php', '80');
    //     $oldFeedback = $this->loadModel('feedback')->getByIdNotDeleted($feedbackID);
    //     if(!$oldFeedback){
    //         return $this->sendError(400, $this->lang->feedback->notFoundDeleted);
    //     }

    //     // 检查用户是否有权限操作（是否有当前反馈所在产品的权限）
    //     // $grantProducts = $this->loadModel('feedback')->getGrantProducts();
    //     // if (!in_array($oldFeedback->product, array_keys($grantProducts))) {
    //     //     return $this->sendError(400, $this->lang->feedback->accessDenied);
    //     // }

    //     $fields = 'module,product,type,title,public,publicType,desc,status,feedbackBy,notify,uid,notifyEmail,productVersion,usedProject,expectDate,contactWay,serverOS,serverCPU,middleware,database,terminalOS,terminalCPU,browser';
    //     $this->batchSetPost($fields, $oldFeedback);
        
    //     // ************ publicType 转 public ************ chenjj 221226
    //     // $this->setPost('public', $this->request('publicType', ''));
    //     $public = '';
    //     if (isset($_POST['publicType'])) {
    //         $public = $_POST['publicType'];
    //         unset($_POST['publicType']);
    //     }
    //     $this->setPost('public', (int)$public);
    //     // ************ publicType 转 public ************ chenjj 221226

    //     // ************ notify 处理 ************ chenjj 221227
    //     if (!isset($_POST['notify'])||($_POST['notify']!=0&&$_POST['notify']!=1)) {
    //         // 只要不是0或者1就设置为0
    //         $this->setPost('notify', 0);
    //     }
    //     // ************ notify 处理 ************ chenjj 221227

    //     $control = $this->loadController('feedback', 'edit');
    //     $control->edit($feedbackID, '');

    //     $data = $this->getData();
    //     if(isset($data->status) and $data->status == 'error') return $this->sendError(400, $data->message);
    //     if(isset($data->result) and $data->result == 'fail') return $this->sendError(400, $data->message);
    //     if(!isset($data->result)) return $this->sendError(400, 'error');

    //     $feedback = $this->feedback->getByID($feedbackID);

    //     $this->loadModel('feedback')->processPropertity($feedback);
    //     return $this->send(200, $this->format($feedback, 'openedBy:user,openedDate:time,reviewedBy:user,reviewedDate:time,processedBy:user,processedDate:time,closedBy:user,closedDate:time,editedBy:user,editedDate:time,mailto:userList,deleted:bool'));
    // }

    /**
     * DELETE method.
     *
     * @param  int    $feedbackID
     * @access public
     * @return void
     */
    public function delete($feedbackID)
    {
        // 记录请求参数，临时，后面删除
        $token = '';
        if(isset($_SERVER['HTTP_COOKIE'])){
            $token = $_SERVER['HTTP_COOKIE'];
        }
        if(isset($_SERVER['HTTP_TOKEN'])){
            $token = $_SERVER['HTTP_TOKEN'];
        }
        $this->app->saveLog(E_NOTICE, '##################### delete feedback，token：'. $token . ' feedbackID：'. $feedbackID, 'feedback.php', '150');

        $oldFeedback = $this->loadModel('feedback')->getByIdNotDeleted($feedbackID);
        if (!$oldFeedback) {
            return $this->sendError(400, $this->lang->feedback->notFoundDeleted);
        }
        // 检查用户是否有权限操作（是否有当前反馈所在产品的权限）
        // $grantProducts = $this->loadModel('feedback')->getGrantProducts();
        // if (!in_array($oldFeedback->product, array_keys($grantProducts))) {
        //     return $this->sendError(400, $this->lang->feedback->accessDenied);
        // }

        $control = $this->loadController('feedback', 'delete');
        $control->delete($feedbackID, 'yes');

        $data = $this->getData();
        if ($data&&isset($data->data)&&isset($data->data->result)&&$data->data->result=='fail'&&isset($data->data->message)) {
            return $this->sendError(400, $data->data->message);
        }

        $this->sendSuccess(200, 'success');
    }
}


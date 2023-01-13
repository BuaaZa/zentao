<?php
/**
 * 反馈更新接口
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFeedbackUpdateEntry extends Entry
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
        $this->app->saveLog(E_NOTICE, '##################### updte feedback token '. $token . ', requestBody ' . (isset($this->requestBody)?json_encode($this->requestBody):''), 'extfeedbackupdate.php', '30');
        $oldFeedback = $this->loadModel('feedback')->getByIdNotDeleted($feedbackID);
        if(!$oldFeedback){
            return $this->sendError(400, $this->lang->feedback->notFoundDeleted);
        }

        // 检查用户是否有权限操作（是否有当前反馈所在产品的权限）
        // $grantProducts = $this->loadModel('feedback')->getGrantProducts();
        // if (!in_array($oldFeedback->product, array_keys($grantProducts))) {
        //     return $this->sendError(400, $this->lang->feedback->accessDenied);
        // }

        $fields = 'module,product,type,title,public,publicType,desc,status,mailto,feedbackBy,notify,uid,notifyEmail,productVersion,usedProject,expectDate,contactWay,serverOS,serverCPU,middleware,database,terminalOS,terminalCPU,browser';
        $this->batchSetPost($fields, $oldFeedback);
        
        // ************ publicType 转 public ************ chenjj 221226
        // $this->setPost('public', $this->request('publicType', ''));
        $public = '';
        if (isset($_POST['publicType'])) {
            $public = $_POST['publicType'];
            unset($_POST['publicType']);
        }
        $this->setPost('public', (int)$public);
        // ************ publicType 转 public ************ chenjj 221226

        // ************ notify 处理 ************ chenjj 221227
        if (!isset($_POST['notify'])||($_POST['notify']!=0&&$_POST['notify']!=1)) {
            // 只要不是0或者1就设置为0
            $this->setPost('notify', 0);
        }
        // ************ notify 处理 ************ chenjj 221227

        $control = $this->loadController('feedback', 'edit');
        $control->edit($feedbackID, '');

        $data = $this->getData();
        if(isset($data->status) and $data->status == 'error') return $this->sendError(400, $data->message);
        if(isset($data->result) and $data->result == 'fail') return $this->sendError(400, $data->message);
        if(!isset($data->result)) return $this->sendError(400, 'error');

        $feedback = $this->feedback->getByID($feedbackID);

        $this->loadModel('feedback')->processPropertity($feedback);
        return $this->send(200, $this->format($feedback, 'openedBy:user,openedDate:time,reviewedBy:user,reviewedDate:time,processedBy:user,processedDate:time,closedBy:user,closedDate:time,editedBy:user,editedDate:time,mailto:userList,deleted:bool'));
    }
}

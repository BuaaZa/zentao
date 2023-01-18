<?php
/**
 * 反馈评论的接口
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFeedbackCommentEntry extends Entry
{
    /**
     * POST method.
     *
     * @access public
     * @return void
     */
    public function post($feedbackID)
    {
        $this->loadModel('feedback');
        $oldFeedback = $this->feedback->getByIdNotDeleted($feedbackID);
        if(!$oldFeedback){
            return $this->sendError(400, $this->lang->feedback->notFoundDeleted);
        }

        $fields = 'comment,commentExId';
        $this->batchSetPost($fields, $oldFeedback);
        // 记录请求参数，临时，后面删除
        $token = '';
        if(isset($_SERVER['HTTP_COOKIE'])){
            $token = $_SERVER['HTTP_COOKIE'];
        }
        if(isset($_SERVER['HTTP_TOKEN'])){
            $token = $_SERVER['HTTP_TOKEN'];
        }
        $this->app->saveLog(E_NOTICE, '##################### create comment '. $token . ' '. (empty($_POST)?'':json_encode($_POST)), 'extfeedbackcomment.php', '34');

        $this->requireFields('comment');

        $enternalIds = array();
        if (isset($_POST['enternalId'])) {
            $enternalIds = explode(',', $_POST['enternalId']);
        }

        $control = $this->loadController('feedback', 'comment');
        $control->comment($feedbackID, 'commented',$enternalIds);

        $data = $this->getData();
        if (isset($data->status) and $data->status == 'error') {
            return $this->sendError(400, $data->message);
        }
        if (isset($data->result) and $data->result == 'fail') {
            return $this->sendError(400, $data->message);
        }

        if(isset($data->actionID)){
            $this->loadModel('action');
            $action     = $this->action->getByID($data->actionID);
            if($action){
                $actions = $this->action->processActionForAPI(array($action), $data->users, $this->lang->feedback);
                return $this->send(200, $actions[0]);
            }
        }
        return $this->sendError(400, $this->lang->feedback->notFoundDeleted);

        // $feedback = $this->feedback->getByID($feedbackID);
        // $this->feedback->processPropertity($feedback);

        // return $this->send(200, $this->format($feedback, 'openedBy:user,openedDate:time,reviewedBy:user,reviewedDate:time,processedBy:user,processedDate:time,closedBy:user,closedDate:time,editedBy:user,editedDate:time,mailto:userList,deleted:bool'));
    }

    /**
     * DELETE method.
     *
     * @param  int    $commentID
     * @access public
     * @return void
     */
    public function delete($commentID)
    {
        // 记录请求参数，临时，后面删除
        $token = '';
        if(isset($_SERVER['HTTP_COOKIE'])){
            $token = $_SERVER['HTTP_COOKIE'];
        }
        if(isset($_SERVER['HTTP_TOKEN'])){
            $token = $_SERVER['HTTP_TOKEN'];
        }
        $this->app->saveLog(E_NOTICE, '##################### delete comment，token：'. $token . ' commentID：'. $commentID, 'extfeedbackcomment.php', '76');

        $this->loadModel('action');
        $action = $this->action->getById($commentID);
        if (!$action) {
            return $this->sendError(400, '没找到id对应的评论记录');
        }
        if ($action->action!="commented") {
            return $this->sendError(400, 'id对应的记录不是评论');
        }
        if ($action->objectType!="feedback") {
            return $this->sendError(400, 'id对应的记录不是反馈所属的评论');
        }
        if ($action->actor!=$this->app->user->account) {
            return $this->sendError(400, '你不是当前记录的创建人,无法删除');
        }
        $this->dao->delete()->from(TABLE_ACTION)->where('id')->eq($commentID)->exec();

        $this->sendSuccess(200, 'success');
        
        // $control = $this->loadController('feedback', 'deleteComment');
        // $control->deleteComment($commentID, 'yes');

        // $data = $this->getData();
        // if (isset($data->status) and $data->status == 'error') {
        //     return $this->sendError(400, $data->message);
        // }
        // $this->sendSuccess(200, 'success');
    }



}

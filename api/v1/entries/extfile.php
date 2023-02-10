<?php
/**
 * 操作文件接口
 */
class extFileEntry extends Entry
{
    /**
     * DELETE method.
     *
     * @param  int    $fileID
     * @access public
     * @return void
     */
    public function delete($fileID)
    {
        // 记录请求参数，临时，后面删除
        $token = '';
        if(isset($_SERVER['HTTP_COOKIE'])){
            $token = $_SERVER['HTTP_COOKIE'];
        }
        if(isset($_SERVER['HTTP_TOKEN'])){
            $token = $_SERVER['HTTP_TOKEN'];
        }
        $this->app->saveLog(E_NOTICE, '##################### delete file，token：'. $token . ' fileID：'. $fileID, 'extfile.php', '24');

        $file = $this->loadModel('file')->getById($fileID);
        if (!$file) {
            return $this->sendError(404, $this->lang->file->dataNotFound);
        }
        $this->dao->delete()->from(TABLE_FILE)->where('id')->eq($fileID)->exec();
        $this->loadModel('action')->create($file->objectType, $file->objectID, 'deletedFile', '', $extra=$file->title);

        // 确认记录被删除了就把文件删除
        $fileRecord = $this->dao->select('id')->from(TABLE_FILE)->where('pathname')->eq($file->pathname)->fetch();
        if (empty($fileRecord)) {
            // 删除物理文件
            @unlink($file->realPath);
        }

        $this->sendSuccess(200, 'success');
    }

    /**
     * 以文件流的形式下载文件
     *
     * @access public
     * @return void
     */
    public function get($fileID)
    {

        $file = $this->loadModel('file')->getById($fileID);

        if (!$file) {
            return $this->sendError(400, $this->lang->file->dataNotFound);
        }
        $this->loadController('file', 'download')->download($fileID);
    }
}

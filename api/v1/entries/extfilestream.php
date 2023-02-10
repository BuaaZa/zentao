<?php
/**
 * file stream
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFileStreamEntry extends Entry
{
    /**
     * 以文件流的形式下载文件
     *
     * @access public
     * @return void
     */
    public function get($fileID)
    {
        // 改成返回base64了
        // $this->loadController('file', 'download')->download($fileID);

        $file = $this->loadModel('file')->getById($fileID);

        if (!$file) {
            return $this->sendError(400, $this->lang->file->dataNotFound);
        }

        $filePath = $file->realPath;
        if (!file_exists($filePath)) {
            return $this->sendError(400, $this->lang->file->fileNotFound);
        }

        $mime_type= mime_content_type($filePath);
        $base64_data = base64_encode(file_get_contents($filePath));
        $base64_file = 'data:'.$mime_type.';base64,'.$base64_data;

        return $this->send(200, array('data'=>$base64_file));
    }
}

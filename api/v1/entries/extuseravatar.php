<?php
/**
 * 获取用户头像
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extUserAvatarEntry extends Entry
{
    /**
     * 以文件流的返回用户头像
     *
     * @access public
     * @return void
     */
    public function get($account)
    {
        $user = $this->loadModel('user')->getById($account, 'account');
        if (!$user) {
            return $this->sendError(400, $this->lang->user->error->noUser);
        }

        // 修改为用户没有头像返回默认头像，头像文件丢失也返回默认头像，默认头像丢失则返回错误 chenjj 231017
        $fileController = $this->loadModel('file');

        $realPathName = '';
        if (!empty($user->avatar)) {
            // 头像路径默认时处理成web访问的，需要剔除路径中的webPath
            $realPathName = $fileController->savePath . str_replace($fileController->webPath, "", $user->avatar);
        }

        if (!$realPathName||!file_exists($realPathName)) {
            $this->app->saveLog(E_NOTICE, '##################### ' . $account .' return default avatar '. $realPathName, 'extuseravatar.php', '37');
            $realPathName   = $this->app->getAppRoot(). "www/default-avatar.jpeg";
            if (!file_exists($realPathName)) {
                return $this->sendError(400, $this->lang->user->error->nodefaultavatar);
            }
        }

        $mime_type= mime_content_type($realPathName);
        $base64_data = base64_encode(file_get_contents($realPathName));
        $base64_file = 'data:'.$mime_type.';base64,'.$base64_data;

        return $this->send(200, array('data'=>$base64_file));
    }
}

<?php
/**
 * 反馈状态的接口
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFeedbackStatusEntry extends Entry
{
    /**
     * GET method.
     *
     * @access public
     * @return void
     */
    public function get()
    {
        $this->loadModel('feedback');
        $status = $this->lang->feedback->statusList;
        $ret = array();
        if (!empty($status)) {
            foreach ($status as $statusKey=>$statusTitle) {
                if (!empty($statusKey)) {
                    $retEle = array('value'=>$statusKey,'label'=>$statusTitle);
                    array_push($ret, $retEle);
                }
            }
        }
        $this->send(200, $ret);
    }
}

<?php
/**
 * 反馈类型的接口
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFeedbackTypesEntry extends Entry
{
    /**
     * GET method.
     *
     * @access public
     * @return void
     */
    public function get()
    {
        // $this->loadModel('lang');
        $this->loadModel('feedback');
        $types = $this->lang->feedback->typeList;
        $ret = array(array(
            'value'=>'all',
            'label'=>'全部'
        ));
        if (!empty($types)) {
            foreach ($types as $typeKey=>$typeTitle) {
                if (!empty($typeKey)) {
                    $retEle = array('value'=>$typeKey,'label'=>$typeTitle);
                    array_push($ret, $retEle);
                }
            }
        }
        $this->send(200, $ret);
    }
}

<?php
/**
 * 反馈处理结果的接口
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class extFeedbackSolutionsEntry extends Entry
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
        // $solutions = $this->lang->feedback->solutionList;
        $solutions = $this->lang->feedback->featureBar['admin'];
        $ret = array();
        if (!empty($solutions)) {
            foreach ($solutions as $solutionKey=>$solutionTitle) {
                if (!empty($solutionKey)&&$solutionKey!='more') {
                    $retEle = array('value'=>$solutionKey,'label'=>$solutionTitle);
                    array_push($ret, $retEle);
                }
            }
        }
        $this->send(200, $ret);
    }
}

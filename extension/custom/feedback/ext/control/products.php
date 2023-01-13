<?php


// 扩展feedback的产品设置页面
class myFeedback extends feedback
{
    public function products($recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = pager::init($recTotal, $recPerPage, $pageID);

        $this->view->pager       = $pager;
        $this->display();
    }
}
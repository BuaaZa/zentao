<?php
/**
 * The control file of qa module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     qa
 * @version     $Id: control.php 4129 2013-01-18 01:58:14Z wwccss $
 * @link        http://www.zentao.net
 */
class qa extends control
{

    public productModel $product;
    public qaModel $qa;

    /**
     * The index of qa, go to bug's browse page.
     *
     * @access public
     * @param string $locate
     * @param int $productID
     * @param int $projectID
     * @return int
     */
    public function index($locate = 'auto', $productID = 0, $projectID = 0): int
    {
        $this->product = $this->loadModel('product');
        $this->qa = $this->loadModel('qa');

        $products = $this->product->getProductPairsByProject($projectID, 'noclosed');
        if(empty($products)) return print($this->locate($this->createLink('product', 'showErrorNone', "moduleName=qa&activeMenu=index")));
        if($locate == 'yes') $this->locate($this->createLink('bug', 'browse'));

        $productID = $this->product->saveState($productID, $products);
        $branch    = (int)$this->cookie->preBranch;
        $this->qa->setMenu($products, $productID, $branch);

        $this->view->title      = $this->lang->qa->index;
        $this->view->position[] = $this->lang->qa->index;
        $this->view->products   = $products;
        $this->display();
        return 0;
    }
}

<?php
/**
 * The control file of projectStory module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     projectStory
 * @version     $Id: control.php 5094 2013-07-10 08:46:15Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
class qaStory extends control
{
    /**
     * All products.
     *
     * @var    array
     * @access public
     */
    public $products = array();

    /**
     * Get software requirements from product.
     *
     * @param  int    $projectID
     * @param  int    $productID
     * @param  int    $branch
     * @param  string $browseType
     * @param  int    $param
     * @param  string $storyType
     * @param  string $orderBy
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function story($productID = 0, $projectID = 0,$branch = 0, $browseType = '', $param = 0, $storyType = 'story', $orderBy = '', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
        //$this->products = $this->loadModel('product')->getProductPairsByProject($projectID);

        /* Set product list for export. */
        //$this->session->set('exportProductList', $this->products);

        //if(empty($this->products)) return print($this->locate($this->createLink('product', 'showErrorNone', 'moduleName=project&activeMenu=story&projectID=' . $projectID)));
        echo $this->fetch('product', 'browse', "productID=$productID");
    }
}
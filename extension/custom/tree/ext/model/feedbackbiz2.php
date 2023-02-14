<?php

// 由于不适用模块，所以这里改成项目集和产品的树（产品集暂不可点击）
public function getProductsTreeMenu($rootID, $productListId =array(), $startModule = 0, $userFunc = '', $extra = '')
{
    $modelId = 'feedback';
    $extra += array('executionID' => $rootID, 'projectID' => $rootID, 'productID' => $productID, 'tip' => true);
    $tab    = $this->app->tab;
    
    $productTreeDatas = $this->loadModel('product')->getProductsTree(true);
    // /* If createdVersion <= 4.1, go to getTreeMenu(). */
    // $products      = $this->loadModel('product')->getByIdList($productListId);  
    /* createdVersion > 4.1. */
    $menu = "<ul id='modules' class='tree' data-ride='tree' data-name='tree-feedback'>";
    
    $moduleName = strpos(',project,execution,', ",$tab,") !== false ? $this->app->tab  : $modelId;
    $methodName = strpos(',project,execution,', ",$tab,") !== false ? $modelId : 'admin';
    $param      = "&browseType=byProduct&" ;
    $idx=1;
    foreach($productTreeDatas as $product)
    {
        if(isset($product['children'])){
            // $product 是产品集
            $children=$product['children'];
            $subMenu = '';
            $ids=array();
            foreach($children as $child){
                $id = $child["value"];
                array_push($ids,$id);
                $extra['productID'] = $id;
                // 单独查看某一个产品反馈的链接
                $link  = helper::createLink($moduleName, $methodName, "{$param}productID=$id");
                $subMenu .= "<li>" . html::a($link, $child["label"], '_self', "id='product$id'");
            }

            $programID = $product["value"];
            // 可以查看产品集下所有产品反馈的链接
            $link  = helper::createLink($moduleName, $methodName, "{$param}productID=".join(',',$ids));
            $menu .= "<li>" . html::a($link, $product["label"], '_self', "id='program$programID'");
            $menu .= "<ul data-idx='$idx'>";
            $menu .= $subMenu;
            $menu .= "</ul></li>";
        }else{
            // $product 是产品
            $id = $product["value"];
            $extra['productID'] = $id;
            // 单独查看某一个产品反馈的链接
            $link  = helper::createLink($moduleName, $methodName, "{$param}productID=$id");
            $menu .= "<li>" . html::a($link, $product["label"], '_self', "id='product$id'");
        }
        $idx++;
    }
    $menu .= '</ul>';
    return $menu;  
}
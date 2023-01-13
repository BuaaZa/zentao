<?php

public function getFeedbackTreeMenu($rootID, $productListId =array(), $startModule = 0, $userFunc = '', $extra = '')
{
    $modelId = 'feedback';
    $extra += array('executionID' => $rootID, 'projectID' => $rootID, 'productID' => $productID, 'tip' => true);
    $tab    = $this->app->tab;
  
    /* If createdVersion <= 4.1, go to getTreeMenu(). */
    $products      = $this->loadModel('product')->getByIdList($productListId);  
    /* createdVersion > 4.1. */
    $menu = "<ul id='modules' class='tree' data-ride='tree' data-name='tree-feedback'>";
  
    /* Set the start module. */
    $startModulePath = '';
    if($startModule > 0)
    {
        $startModule = $this->getById($startModule);
        if($startModule) $startModulePath = $startModule->path . '%';
    }
  
    $executionModules = $this->getTaskTreeModules($rootID, true, $modelId);
  
    /* Get module according to product. */
    $productNum = count($products);
    $moduleName = strpos(',project,execution,', ",$tab,") !== false ? $this->app->tab  : $modelId;
    $methodName = strpos(',project,execution,', ",$tab,") !== false ? $modelId : 'admin';
    $param      = "&browseType=byProduct&" ;
    foreach($products as $id => $product)
    {
        $extra['productID'] = $id;
        $link  = helper::createLink($moduleName, $methodName, "{$param}productID=$id");
        $menu .= "<li>" . html::a($link, is_object($product) ? $product->name : $product, '_self', "id='product$id'");
  
        /* tree menu. */
        $tree = '';
        $query = $this->dao->select('*')->from(TABLE_MODULE)->where("(root = $id and type = 'feedback')")
        ->beginIF($startModulePath)->andWhere('path')->like($startModulePath)->fi()
        ->andWhere('deleted')->eq(0)
        ->orderBy('grade desc, `order`, type')
        ->get();
        $treeMenu = array();
        $stmt     = $this->dbh->query($query);
        while($module = $stmt->fetch())
        {
          $this->buildTree($treeMenu, $module, $modelId, $userFunc, $extra);
        }
        $tree .= isset($treeMenu[0]) ? $treeMenu[0] : '';
  
        if($tree) $tree = "<ul>" . $tree . "</ul>\n</li>";
        $menu .= $tree;
    }
    $menu .= '</ul>';
    return $menu;  
}
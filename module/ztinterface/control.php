<?php
/**
 * The control file of case currentModule of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     case
 * @version     $Id: control.php 5112 2013-07-12 02:51:33Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
require_once __DIR__ . '/../../vendor/autoload.php';
class ztinterface extends control
{
    /**
     * All products.
     *
     * @var    array
     * @access public
     */
    public $products = array();

    /**
     * Project id.
     *
     * @var    int
     * @access public
     */
    public $projectID = 0;

    /**
     * Construct function, load product, tree, user auto.
     *
     * @access public
     * @return void
     */
    public function __construct($moduleName = '', $methodName = '')
    {
        parent::__construct($moduleName, $methodName);
        $this->loadModel('product');
        $this->loadModel('tree');
        $this->loadModel('user');
        $this->loadModel('qa');
        $this->loadModel('ztinterface');

        /* Get product data. */
        $products = array();
        $objectID = 0;
        $tab      = ($this->app->tab == 'project' or $this->app->tab == 'execution' or $this->app->tab == 'interface') ? $this->app->tab : 'qa';
        if(!isonlybody())
        {
            $mode     = ($this->app->methodName == 'create' and empty($this->config->CRProduct)) ? 'noclosed' : '';
            $products = $this->product->getPairs($mode);
            if(empty($products) and !helper::isAjaxRequest()) return print($this->locate($this->createLink('product', 'showErrorNone', "moduleName=$tab&activeMenu=testcase&objectID=$objectID")));
        }
        else
        {
            $products = $this->product->getPairs();
        }
        $this->view->products = $this->products = $products;
    }


    public function browse($productID = 0, $browseType = 'all', $param = 0, $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1, $projectID = 0)
    {
        $response['result'] = 'success';

        /* Set browse type. */
        $browseType = strtolower($browseType);

        /* Set browseType, productID, moduleID and queryID. */
        $productID = $this->ztinterface->setMenu($productID);
        //$productID = $this->product->saveState($productID, $this->products);
        setcookie('preProductID', $productID, $this->config->cookieLife, $this->config->webRoot, '', $this->config->cookieSecure, true);
        
        if($this->cookie->preProductID != $productID)
        {
            $_COOKIE['caseModule'] = 0;
            setcookie('caseModule', 0, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
        }          
        if($browseType == 'bymodule') setcookie('caseModule', (int)$param, 0, $this->config->webRoot, '', $this->config->cookieSecure, false);
        if($browseType != 'bymodule') $this->session->set('caseBrowseType', $browseType);
        $moduleID = ($browseType == 'bymodule') ? (int)$param : ($browseType == 'bysearch' ? 0 : ($this->cookie->caseModule ? $this->cookie->caseModule : 0));

        $uri = $this->app->getURI(true);
        $this->session->set('interfaceList', $uri, $this->app->tab);
        $this->session->set('productID', $productID);
        $this->session->set('moduleID', $moduleID);
        $this->session->set('browseType', $browseType);
        $this->session->set('orderBy', $orderBy);


        /* Load pager. */
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $sort  = common::appendOrder($orderBy);

        /* Get test cases. */
        $interfaces = $this->ztinterface->getInterfaces($productID, $moduleID, $sort, $pager);
        if(empty($cases) and $pageID > 1)
        {
            $pager = pager::init(0, $recPerPage, 1);
            $interfaces = $this->ztinterface->getInterfaces($productID, $moduleID, $sort, $pager);
        }

        /* Get module tree.*/
        $moduleTree = $this->tree->getTreeMenu($productID, 'ztinterface', 0, array('treeModel', 'createInterfaceLink'), array('productID' => $productID), $branch);
        

        $showBranch      = false;
        $branchOption    = array();
        $branchTagOption = array();

        /* Assign. */
        $tree = $moduleID ? $this->tree->getByID($moduleID) : '';
        $this->view->title           = $this->products[$productID] . $this->lang->colon . $this->lang->ztinterface->common;
        $this->view->position[]      = html::a($this->createLink('ztinterface', 'browse', "productID=$productID"), $this->products[$productID]);
        $this->view->position[]      = $this->lang->ztinterface->common;
        $this->view->productID       = $productID;
        $this->view->product         = $product;
        $this->view->productName     = $this->products[$productID];
        $this->view->modules         = $this->tree->getOptionMenu($productID, $viewType = 'case', $startModuleID = 0, $branch == 'all' ? '0' : $branch);
        $this->view->moduleTree      = $moduleTree;
        $this->view->moduleName      = $moduleID ? $tree->name : $this->lang->tree->all;
        $this->view->moduleID        = $moduleID;
        $this->view->summary         = $this->ztinterface->summary($interfaces);
        $this->view->pager           = $pager;
        $this->view->users           = $this->user->getPairs('noletter');
        $this->view->orderBy         = $orderBy;
        $this->view->browseType      = $browseType;
        $this->view->param           = $param;
        $this->view->interfaces      = $interfaces;
        $this->view->branchOption    = $branchOption;
        $this->view->branchTagOption = $branchTagOption;
        $this->view->setModule       = false;
        $this->view->modulePairs     = $this->tree->getModulePairs($productID, 'case', $showModule);
        $this->view->showBranch      = $showBranch;

        
        $this->display();
    }

    public function sendMessage($interfaceID)
    {
        $interfaceID = (int)$interfaceID;
        $interface   = $this->ztinterface->getByID($interfaceID);
        if(!$interface)
        {
            return print(js::error($this->lang->notFound) . js::locate($this->createLink('ztinterface', 'browse')));
        }
        $this->session->set('interfaceList', $this->createLink('ztinterface', 'browse',"productID=$interface->product"), $this->app->tab);

        $productID = $interface->product;
        $product   = $this->product->getByID($productID);
        $temp = explode(',', $interface->format);
        $format = array();
        foreach($temp as $str){
            $str = strtolower($str);
            $format[$str] = $str;
        }

        $this->ztinterface->setMenu($productID);

        $this->view->title       = $interface->name;
        $this->view->format       = $format;
        $this->view->product     = $product;
        $this->view->productName = $product->name;
        $this->view->header = json_decode($interface->header,TRUE);
        $this->view->data = json_decode($interface->data,TRUE);
        $this->view->bodyHtml = $this->ztinterface->generateBody($this->view->data["content"],0,'');
        $this->view->baseURLList = $this->ztinterface->getBaseURLDataList($productID);
        $this->view->position[] = $this->lang->ztinterface->common;
        $this->view->position[] = $this->lang->ztinterface->view;
        $this->view->interface  = $interface;
        $this->view->mocklist = $this->ztinterface->generateMockList(); 

        $this->display();
    }

    public function delete($interfaceID, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            return print(js::confirm($this->lang->ztinterface->confirmDelete, inlink('delete', "interfaceID=$interfaceID&confirm=yes")));
        }
        else
        {
            $interface = $this->ztinterface->getByID($interfaceID);
            $this->ztinterface->delete(TABLE_INTERFACE, $interfaceID);

            /* if ajax request, send result. */
            if($this->server->ajax)
            {
                if(dao::isError())
                {
                    $response['result']  = 'fail';
                    $response['message'] = dao::getError();
                }
                else
                {
                    $response['result']  = 'success';
                    $response['message'] = '';
                }
                return $this->send($response);
            }

            $browseList = $this->createLink('ztinterface', 'browse', "productID=$interface->product");
            return print(js::locate($browseList, 'parent'));
        }
    }

    public function mockBase($data = '', $return = false)
    {
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }

        $data["type"] = strtolower($data["type"]);
        if($data["type"] == 'string'){
            return $this->mockKeyword($data, $return);
        }else if($data["type"] == 'integer'){
            return $this->mockInteger($data, $return);
        }else if($data["type"] == 'float'){
            return $this->mockFloat($data, $return);
        }else if($data["type"] == 'array'){
            return $this->mockArray($data, $return);
        }else if($data["type"] == 'object'){
            return $this->mockObject($data, $return);
        }
        $response['error'] = '无此类型';
        if($response['error']){
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
    }

    public function mockKeyword($data='', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('string'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }

        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }
        $genStr =  $this->ztinterface->mockStringBykeyword($data['name']);
        if($genStr){
            $response["value"] = $genStr;
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        return $this->mockString($data, $return);
    }

    public function mockString($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('string'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = $this->ztinterface->parseParams($data["params"]);
        $min = 1;
        $max = 20;
        if(isset($args[1]) and is_numeric($args[1]) and (int)$args[1]>=0){
            $min = (int)$args[1];
        }
        if(isset($args[2]) and is_numeric($args[2]) and (int)$args[2]>=0){
            $max = (int)$args[2];
        }
        if($min>$max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }
        $regex = '[\w]';
        if(isset($args[0])){
            $chars = $this->ztinterface->parseSymbol($args[0]);
            if(!$chars){
                $response["error"] = '参数不合法,按默认字符集生成';
            }else{
                $regex = $chars;
            }
        }
        $regex = $regex.'{'.$min.','.$max.'}';
        $response['value'] = $this->ztinterface->mockStringByRegex($regex);
        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockRegex($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('string','integer','float'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = $this->ztinterface->parseParams($data["params"]);
        
        if(!isset($args[0])){
            $response["error"] = "需要正则表达式";
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        $regex = join(',',$args);

        if(substr($regex,-1) !== substr($regex,0,1) or substr($regex,-1) !== '/'){
            $regex = '/'.$regex.'/';
        }
        if (@preg_match($regex, '') === false) {
            $response["error"] = "非法的正则表达式";
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        $response['value'] = $this->ztinterface->mockStringByRegex($regex);
        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockFunc($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('string'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = $this->ztinterface->parseParams($data["params"]);
        $faker = "";
        $gen = $data['funcName'];

        if($args[0]){
            $faker = $this->ztinterface->getFaker($this->ztinterface->trimQuotation($args[0]));
        }
        if(!$faker){
            if(in_array(strtolower($gen),$this->lang->ztinterface->fakerCN)){
                $faker = $this->ztinterface->getFaker('zh_CN');
            }else{
                $faker = $this->ztinterface->getFaker('en_US');
            }
        }
        
        if(strtolower($gen) === 'colorname')
            $gen = 'safe'.$gen;
        try{
            $response['value'] = $faker->$gen;
        }catch(Exception $e){
            $response['error'] = '生成模式不存在';
        }

        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockDatetime($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('string'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = json_decode($data["params"]);
        $gen = $data['funcName'];

        $format = 'Y-m-d H:i:s';
        if($args[0]){
            $format = $this->ztinterface->trimQuotation($args[0]);
        }
        
        $response['value'] = $this->ztinterface->mockDate($format);
        
        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockInteger($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('integer'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(mt_rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = $this->ztinterface->parseParams($data["params"]);
        $min = -65535;
        $max = 65535;

        if(isset($args[0]) and is_numeric($args[0])){
            $min = (int)$args[0];
            if($min != (float)$args[0]){
                $min = $min+1;
            }
        }
        if(isset($args[1]) and is_numeric($args[1])){
            $max = (int)$args[1];
        }

        if($min>$max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }

        $faker = $this->ztinterface->getFaker('en_US');
        $response['value'] = $faker->numberBetween($min,$max);

        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockFloat($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('float'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = $this->ztinterface->parseParams($data["params"]);
        $min = NULL;
        $max = NULL;

        if(isset($args[0]) and is_numeric($args[0])){
            $min = (float)$args[0];
        }
        if(isset($args[1]) and is_numeric($args[1])){
            $max = (float)$args[1];
        }
        if($min and $max and $min>$max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }

        $faker = $this->ztinterface->getFaker('en_US');
        $response['value'] = $faker->randomFloat(NULL, $min, $max);

        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockRegexnum($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('float','integer'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }

        $n = 5;
        while($n > 0){
            $response = $this->mockRegex($data,true);
            if($response['value']){
                if(is_numeric($response['value']) or $response['value']=='null')
                    break;
                $n -= 1;
                continue;
            }
            if($response['error']){
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
            $n -= 1;
        }
        if(isset($response['value']) and (is_numeric($response['value']) or $response['value']=='null')){
            if(strtolower($data['type'] == 'float')){
                $response['value'] = (float)$response['value'];
            }
            if(strtolower($data['type'] == 'integer')){
                $response['value'] = (int)$response['value'];
            }
        }else if(!$response['error']){
            $response['error'] = '正则表达式无法产生合法的'.$data['type'];
        }

        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }
    
    public function mockArray($data = '', $return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('array'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }

        $args = $this->ztinterface->parseParams($data["params"]);
        $min = 1;
        $max = 10;

        if(isset($args[0]) and is_numeric($args[0]) and (int)$args[0]>=0){
            $min = (int)$args[0];
        }
        if(isset($args[1]) and is_numeric($args[1]) and (int)$args[1]>=0){
            $max = (int)$args[1];
        }
        if($min>$max){
            $temp = $min;
            $min = $max;
            $max = $temp;
        }

        $times = mt_rand($min,$max);
        if($times == 0){
            if($return){
                $response["value"] = array();
                return $response;
            }else{
                $response["value"] = json_encode(array());
                echo json_encode($response);
                return;
            }
        }
        $ans = array();
        if(!$data['item'][0]){
            $data['item'][0] = array();
            $data['item'][0]['type'] = 'string';
        }
        $data['item'][0]['name'] = $data['name'];
        for($i = 0; $i < $times; $i++){
            $res = $this->findMock($data['item'][0]);
            if(isset($res['value'])){
                if($res['value'] == 'null'){
                    $ans[$i] = NULL;
                }else{
                    $ans[$i] = $res['value'];
                }
            }
            if($res['error']){
                $response['item']['error'] = $res['error'];
            }
        }
        $data['item'][0]['name'] = 'items';

        if(!empty($ans)){
            if($return){
                $response['value'] = $ans;
            }else{
                $response['value'] = json_encode($ans);
            }
        }else{
            $response['error'] = '生成数组为空,请检查Mock函数';
        }

        if($return){
            return $response;
        }else{
            echo json_encode($response);
            return;
        }
    }

    public function mockObject($data = '',$return = false){
        $response = array();
        if(!$data and !empty($_POST)){
            $data = array();
            foreach($_POST as $key=>$value){
                $data[$key] = $value;
            }
        }
        $response['id'] = $data['id'];
        if(!in_array(strtolower($data['type']),array('object'))){
            $response['error'] = 'Mock函数与类型不符';
            if($return){
                return $response;
            }else{
                echo json_encode($response);
                return;
            }
        }
        if($data['notNull'] == 'false'){
            if(rand(0,5) == 0){
                $response["value"] = "null";
                if($return){
                    return $response;
                }else{
                    echo json_encode($response);
                    return;
                }
            }
        }
        $response["value"] = array();
        $response['value']['response'] = array();
        $response['value']['object'] = new stdClass();
        foreach($data['item'] as $it){
            $res = $this->findMock($it);
            $itKey = $it['name'];
            if($it['type'] == 'array'){
                if(isset($res['value'])){
                    $response['value']['object']->$itKey = $res['value'];
                }else{
                    $response['value']['object']->$itKey = 'mock error';
                }
                if($res['value'] != 'null')$res['value'] = json_encode($res['value']);
                $response['value']['response'][] = $res;
            }else if($it['type'] == 'object'){
                if($res['value'] != 'null'){
                    $response['value']['object']->$itKey = $res['value']['object'];
                    $response['value']['response'][] = array('id'=>$it['id'], 'value'=>'input');
                    $response['value']['response'] = array_merge($response['value']['response'], $res['value']['response']);
                }else{
                    $response['value']['object']->$itKey = $res['value'];
                    $response['value']['response'][] = $res;
                }
            }else{
                if(isset($res['value'])){
                    $response['value']['object']->$itKey = $res['value'];
                }else{
                    $response['value']['object']->$itKey = 'mock error';
                }
                $response['value']['response'][] = $res;
            }
        }
        if($return){
            return $response;
        }else{
            echo json_encode($response['value']['response']);
            return;
        }
    }

    public function findMock($data = ''){
        $response = array();
        $response['id'] = $data['id'];
        if(!$data['funcName']){
            return $this->mockBase($data, true);
        }
        if(in_array(strtolower($data['funcName']),$this->lang->ztinterface->funcTable)){
            return $this->mockFunc($data, true);
        }
        $funcName = 'mock'.ucfirst(strtolower($data['funcName']));
        if (method_exists($this, $funcName)) {
            return $this->$funcName($data, true);
        }
        $response['error'] = "Mock函数不存在";
        return $response;
    }

    public function saveMock($id){
        $res = $this->ztinterface->saveMock($id,$_POST['data']);
        if(dao::isError()) $res = dao::getError();
        echo json_encode(array('message'=>$res));
    }

    public function genMessage($type = 'update'){
        $response = array();
        $response['error'] = array();
        if(empty($_POST)){
            $response['error'][] = array('message'=>'无请求体','from'=>'alter');
            echo json_encode($response);
            return;
        }
        $interface = $this->ztinterface->getByID((int)$_POST['id']);
        if(!$interface){
            $response['error'][] = array('message'=>'接口不存在','from'=>'alter');
            echo json_encode($response);
            return;
        }
        $url = rtrim($_POST['baseUrl'], '/') . '/' . ltrim($interface->url, '/');
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $url = 'http://127.0.0.1'. '/' . ltrim($interface->url, '/');
            if(filter_var($url, FILTER_VALIDATE_URL) === false){
                $response['error'][] = array('message'=>'URL部分不合法','from'=>'baseURL');
                echo $response;
                return;
            }
            $response['error'][] = array('message'=>'基地址为空或不合法,已采用http://127.0.0.1/作为基地址','from'=>'baseURL');
        }
        $obj = new stdClass();
        if($type === 'update'){
            $res = $this->ztinterface->genObject($_POST['object']);
            $obj = $res['object'];
            $response['error'] = array_merge($response['error'],$res['error']);
        }else{
            $response['value'] = $this->mockObject($_POST['object'], true)['value'];
            $obj = $response['value']['object'];
        }
        $obj = $this->ztinterface->convertStrToNULL($obj);
        $response['value']['message'] = $this->ztinterface->genMessage($_POST['head'], $obj, $interface->method, $url, $_POST['format']);
        echo json_encode($response);
        return;
    }

    public function checkAndSend($confirm = false){
        if($confirm === 'true')
            $confirm = true;
        $response = array();
        $response['error'] = array();
        $body = json_decode($_POST['body']);
        $interface = $this->ztinterface->getByID((int)$_POST['id']);
        if(!$interface){
            $response['error'][] = array('message'=>'接口不存在','from'=>'alter');
            echo json_encode($response);
            return;
        }
        if(!$body){
            if($_POST['body']){
                $response['error'][] = array('message'=>'请提供合法的请求体','from'=>'alter');
                echo json_encode($response);
                return;
            }else{
                $body = new stdClass();
            }
        }

        $url = rtrim($_POST['baseUrl'], '/') . '/' . ltrim($interface->url, '/');
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            $url = 'http://127.0.0.1'. '/' . ltrim($interface->url, '/');
            if(filter_var($url, FILTER_VALIDATE_URL) === false){
                $response['error'][] = array('message'=>'URL部分不合法','from'=>'baseURL');
                echo $response;
                return;
            }
            $response['error'][] = array('message'=>'基地址为空或不合法,已采用http://127.0.0.1/作为基地址','from'=>'baseURL');
        }

        $data = json_decode($interface->data, true);
        $res = $this->ztinterface->checkObject($body, $data,'');
        if(!$confirm and !empty($res['error'])){
            $response['error'] = array_merge($response['error'], $res['error']);
        }else{
            $res = $this->ztinterface->sendMessage($_POST['head'], $body, $interface->method, $url);
            if(isset($res['error'])){
                $response['error'] = array_merge($response['error'], $res['error']);
            }
            if(isset($res['response'])){
                $response['response'] = $res['response'];
                $response['code'] = $res['code'];
            }
        }
        echo json_encode($response);
    }

    public function editbaseurl($productID){
        if(!empty($_POST)){
            if(isset($_POST['delete']) and $_POST['delete'] === 'on'){
                $this->ztinterface->editBaseURL($productID, 1);
            }else{
                $this->ztinterface->editBaseURL($productID, 0);
            }
            $newDataList = $this->ztinterface->getBaseURLDataList($productID);
            return print(js::closeModal('parent.parent', '', "parent.parent.updateBaseURL('$newDataList')"));
        }
        $this->view->product = $this->loadModel('product')->getById($productID);
        $this->view->baseURLList = $this->ztinterface->getBaseURLList($productID);
        $this->view->baseURLPairs = $this->ztinterface->getBaseURLPairs($productID);
        $this->display();
    }
}


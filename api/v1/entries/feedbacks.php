<?php
/**
 * The executions entry point of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2021 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     entries
 * @version     1
 * @link        http://www.zentao.net
 */
class feedbacksEntry extends entry
{
    /**
     * GET method.
     *
     * @access public
     * @return void
     */
    public function get()
    {
        if(strpos(strtolower($this->param('fields')), 'moduleandproduct') !== false) return $this->getModuleAndProduct();

        $control = $this->loadController('feedback', 'admin');
        $searchProductName = $this->param('product', '');

        // 1、获取所有产品
        $this->loadModel('product');
        // $allProduct = $this->product->getPairs();
        // 修改此处产品的获取方式（只能获取到被授权的产品） chenjj 221226
        $productIDList = $this->loadModel('feedback')->getGrantProducts();
        $filterProduct = array();
        foreach ($productIDList as $productId =>$product) {
            // 2、如果输入了产品名称,用输入的产品名称与已有产品比对
            if ($searchProductName!='') {
                if (substr_count($product->name, $searchProductName)) {
                    array_push($filterProduct, $productId);
                }
            } else {// 没输入产品名称，或者为空，就是所有产品
                array_push($filterProduct, $productId);
            }
        }
        $this->setParam('type',$this->param('type','all'));// 增加类型过滤条件
        $this->setParam('keyword',$this->param('keyword',''));// 增加关键字过滤
        $this->setParam('openedBy',$this->param('openedBy',''));// 增加openedBy过滤
        $control->admin($this->param('solution', 'unclosed'),join(',',$filterProduct), $this->param('orderBy', 'id_desc'), 0, 0, $this->param('limit', 20), $this->param('page', 1));
        $data = $this->getData();

        if(!$data or !isset($data->status)) return $this->sendError(400, 'error');
        if(isset($data->status) and $data->status == 'fail') return $this->sendError(400, $data->message);

        $feedbacks = $data->data->feedbacks;
        $pager     = $data->data->pager;

        $result = array();
        foreach($feedbacks as $feedback)
        {
            $result[] = $this->format($feedback, 'openedBy:user,openedDate:time,reviewedBy:user,reviewedDate:time,processedBy:user,processedDate:time,closedBy:user,closedDate:time,editedBy:user,editedDate:time,assignedTo:user,mailto:userList,deleted:bool');
        }

        $data = array();
        $data['page']      = $pager->pageID;
        $data['total']     = $pager->recTotal;
        $data['limit']     = $pager->recPerPage;
        $data['feedbacks'] = $result;

        return $this->send(200, $data);
    }

    /**
     * POST method.
     *
     * @access public
     * @return void
     */
    public function post()
    {
        // 记录请求参数，临时，后面删除
        $token = '';
        if(isset($_SERVER['HTTP_COOKIE'])){
            $token = $_SERVER['HTTP_COOKIE'];
        }
        if(isset($_SERVER['HTTP_TOKEN'])){
            $token = $_SERVER['HTTP_TOKEN'];
        }
        $this->app->saveLog(E_NOTICE, '##################### create feedback '. $token . ' '. (empty($_POST)?'':json_encode($_POST)), 'feedbacks.php', '86');

        $fields = 'module,product,type,title,public,desc,status,feedbackBy,notify,uid,productVersion,usedProject,expectDate,contactWay,serverOS,serverCPU,middleware,database,terminalOS,terminalCPU,browser,feedbackExId';
        $this->batchSetPost($fields);

        $this->setPost('notifyEmail', $this->request('notifyEmail', ''));

        // ************ publicType 转 public ************ chenjj 221226
        $public = '';
        if (isset($_POST['publicType'])) {
            $public = $_POST['publicType'];
            unset($_POST['publicType']);
        }
        $this->setPost('public', (int)$public);
        // ************ publicType 转 public ************ chenjj 221226

        // ************ notify 处理 ************ chenjj 221226
        $public = '';
        if (!isset($_POST['notify'])||($_POST['notify']!=0&&$_POST['notify']!=1)) {
            // 只要不是0或者1就设置为0
            $this->setPost('notify', 0);
        }
        // ************ notify 处理 ************ chenjj 221226
        $control = $this->loadController('feedback', 'create');
        $this->requireFields('title,product');
        $control->create("", 'json');

        $data = $this->getData();
        if(isset($data->result) and $data->result == 'fail') return $this->sendError(400, $data->message);

        // $config->duplicateTime配置的30s内不能重复，超30s就可以继续增加
        // 诸如标题重复不能新增的错误 chenjj 221226
        if (isset($data->exists)&&isset($data->message)) {
            return $this->sendError(400, $data->message);
        }

        $feedback = $this->loadModel('feedback')->getById($data->id);

        $this->loadModel('feedback')->processPropertity($feedback);
        $this->send(201, $this->format($feedback, 'openedBy:user,openedDate:time,reviewedBy:user,reviewedDate:time,processedBy:user,processedDate:time,closedBy:user,closedDate:time,editedBy:user,editedDate:time,assignedTo:user,assignedDate:time,feedbackBy:user,mailto:userList,deleted:bool'));
    }

    /**
     * GET method.
     *
     * @access public
     * @return void
     */
    public function getModuleAndProduct()
    {
        $control = $this->loadController('feedback', 'create');
        $control->create();

        $data = $this->getData();

        $modules  = $data->data->modules;
        $products = $data->data->products;

        $data = array();
        $data['modules']  = $modules;
        $data['products'] = $products;

        return $this->send(200, $data);
    }

}

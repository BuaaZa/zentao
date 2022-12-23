<?php
/**
 * The model file of calendar module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 青岛易软天创网络科技有限公司 (QingDao Nature Easy Soft Network Technology Co,LTD www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     calendar
 * @version     $Id$
 * @link        http://www.zentao.net
 */
public function getEfforts4Calendar($account = '', $year = '', $type = '', $id = 0)
{
    if($type == 'execution') return $this->loadModel('execution')->getEfforts4Calendar($id, $account, $year);
    return $this->loadExtension('calendar')->getEfforts4Calendar($account, $year);
}

public function printCell($col, $effort, $mode = 'datatable')
{
    $canView  = common::hasPriv('effort', 'view');
    $account  = $this->app->user->account;
    $id       = $col->id;
    if($col->show)
    {
        $class = '';
        $title = '';
        if($id == 'work') $title = " title='{$effort->work}'";
        if($id == 'objectType' and isset($effort->objectTitle)) $title = " title='{$effort->objectTitle}'";

        if($id == 'work' or $id == 'objectType') $class .= ' c-name';

        if($id == 'product')
        {
            static $products;
            if(empty($products)) $products = $this->loadModel('product')->getPairs();

            $effort->productName = '';
            $effortProducts      = explode(',', trim($effort->product, ','));
            foreach($effortProducts as $productID) $effort->productName .= zget($products, $productID, '') . ' ';
            $title = " title='{$effort->productName}'";
        }

        if($id == 'execution')
        {
            static $executions;
            if(empty($executions)) $executions = $this->loadModel('execution')->getPairs();
            $effort->executionName = zget($executions, $effort->execution, '');
            $title = " title='{$effort->executionName}'";
        }

        if($id == 'project')
        {
            static $projects;
            if(empty($projects)) $projects = $this->loadModel('project')->getPairsByProgram();
            $effort->projectName = zget($projects, $effort->project, '');
            $title = " title='{$effort->projectName}'";
        }

        if($id == 'dept')
        {
            static $depts;
            if(empty($depts)) $depts = $this->loadModel('dept')->getOptionMenu();
            $effort->deptName = zget($depts, $effort->dept, '');
            $title = " title='{$effort->deptName}'";
        }

        echo "<td class='c-{$id}" . $class . "'" . $title . ">";
        switch($id)
        {
        case 'id':
            if($this->app->getModuleName() == 'my')
            {
                echo html::checkbox('effortIDList', array($effort->id => sprintf('%03d', $effort->id)));
            }
            else
            {
                printf('%03d', $effort->id);
            }
            break;
        case 'date':
            echo $effort->date;
            break;
        case 'account':
            static $users;
            if(empty($users)) $users = $this->loadModel('user')->getPairs('noletter');
            echo zget($users, $effort->account);
            break;
        case 'dept':
            echo $effort->deptName;
            break;
        case 'work':
            echo $canView ? html::a(helper::createLink('effort', 'view', "id=$effort->id&from=my", '', true), $effort->work, '', "class='iframe'") : $effort->work;
            break;
        case 'consumed':
            echo $effort->consumed;
            break;
        case 'left':
            echo $effort->objectType == 'task' ? $effort->left : '';
            break;
        case 'objectType':
            if($effort->objectType != 'custom')
            {
                $viewLink = helper::createLink($effort->objectType, 'view', "id=$effort->objectID");
                $objectTitle = zget($this->lang->effort->objectTypeList, $effort->objectType, strtoupper($effort->objectType)) . " #{$effort->objectID} " . $effort->objectTitle;
                echo common::hasPriv($effort->objectType, 'view') ? html::a($viewLink, $objectTitle) : $objectTitle;
            }
            break;
        case 'product':
            echo $effort->productName;
            break;
        case 'execution':
            echo $effort->executionName;
            break;
        case 'project':
            echo $effort->projectName;
            break;
        case 'actions':
            common::printIcon('effort', 'edit',   "id=$effort->id", $effort, 'list', '', '', 'iframe', true);
            common::printIcon('effort', 'delete', "id=$effort->id", $effort, 'list', 'trash', 'hiddenwin');
            break;
        }
        echo '</td>';
    }
}

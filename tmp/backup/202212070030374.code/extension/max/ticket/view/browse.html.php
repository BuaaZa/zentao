<?php
/**
 * The admin view file of ticket module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     ticket
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php
$canBatchEdit     = common::hasPriv('ticket', 'batchEdit');
$canBatchActivate = common::hasPriv('ticket', 'batchActivate');
$canBatchFinish   = common::hasPriv('ticket', 'batchFinish');
$canBatchAssignTo = common::hasPriv('ticket', 'batchAssignTo');
$canBatchAction   = ($canBatchEdit or $canBatchActivate or $canBatchFinish or $canBatchAssignTo);
?>
<?php
js::set('browseType', isset($browseType) ? $browseType : '');
js::set('sessionBrowseType', $this->session->ticketBrowseType);
js::set('sessionObjectID', $this->session->ticketObjectID);
js::set('productID', $productID);
?>
<div id='mainMenu' class="clearfix">
  <div id="sidebarHeader">
    <div class="title">
      <?php
      echo $moduleName;
      if($moduleID != 'all' and $browseType != 'bysearch')
      {
          $removeLink = inlink('browse', "browseType=byProduct&param=all&orderBy=$orderBy&recTotal=0");
          echo html::a($removeLink, "<i class='icon icon-sm icon-close'></i>", '', "class='text-muted'");
      }
      ?>
    </div>
  </div>
  <div class='btn-toolbar pull-left'>
    <?php foreach($lang->ticket->tabList as $type => $name):?>
    <?php if($browseType == 'byProduct' or $browseType == 'byModule') $browseType = 'all';?>
    <?php $active = (isset($browseType) and $type == $browseType) ? "btn-active-text" : ''?>
    <?php echo html::a(inlink('browse', "browseType=$type"), "<span class='text'>{$name}</span>", '', "id='{$type}Tab' class='btn btn-link $active'")?>
    <?php endforeach?>
  </div>
  <a class="btn btn-link querybox-toggle" id='bysearchTab'><i class="icon icon-search muted"></i> <?php echo $lang->ticket->search;?></a>
  <div class="btn-toolbar pull-right">
    <?php if(common::hasPriv('ticket', 'create')) echo html::a($this->createLink('ticket', 'create', "productID=$productID"), "<i class='icon-plus'></i> {$lang->ticket->create}", '', "class='btn btn-primary'");?>
  </div>
</div>
<div id='queryBox' data-module='ticket' class='cell <?php if($browseType == 'bysearch') echo 'show';?>'></div>
<div id='mainContent' class="main-row fade">
  <div class="side-col" id="sidebar">
    <div class="sidebar-toggle"><i class="icon icon-angle-left"></i></div>
    <div class="cell">
      <?php if(!$moduleTree):?>
      <hr class="space">
      <div class="text-center text-muted"><?php echo $lang->feedback->noModule;?></div>
      <hr class="space">
      <?php endif;?>
      <?php echo $moduleTree;?>
      <div class="text-center">
        <?php if($productID != 'all'):?>
        <?php $productID = $this->session->ticketProduct;?>
        <?php common::printLink('tree', 'browse', "productID=$productID&view=ticket", $lang->feedback->manageCate, '', "class='btn btn-info btn-wide' data-group='ticket'");?>
        <?php endif;?>
        <hr class="space-sm" />
      </div>
    </div>
  </div>
  <?php if(empty($tickets)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->ticket->noTicket;?></span>
    </p>
  </div>
  <?php else:?>
  <form class='main-table' id='opportunityForm' method='post' data-ride="table">
    <table class="table has-sort-head" id='ticketList'>
    <?php $vars = "browseType=$browseType&param=0&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
    <?php $canView = common::hasPriv('ticket', 'view');?>
      <thead>
        <th class="c-id">
        <?php
        if($canView and $canBatchAction) echo "<div class='checkbox-primary check-all' title='{$lang->selectAll}'><label></label></div>";
        common::printOrderLink('id', $orderBy, $vars, $lang->ticket->idAB);
        ?>
        </th>
        <th class="c-product w-120px"><?php common::printOrderLink('product', $orderBy, $vars, $lang->ticket->product);?></th>
        <th class='c-title'><?php common::printOrderLink('title', $orderBy, $vars, $lang->ticket->title);?></th>
        <th class='c-pri w-60px' title='<?php echo $lang->pri;?>'><?php common::printOrderLink('pri', $orderBy, $vars, $lang->ticket->priAB);?></th>
        <th class='c-status w-70px'><?php common::printOrderLink('status', $orderBy, $vars, $lang->ticket->status);?></th>
        <th class="c-type"><?php common::printOrderLink('type', $orderBy, $vars, $lang->ticket->type);?></th>
        <th class='c-openedBy w-100px'><?php common::printOrderLink('openedBy', $orderBy, $vars, $lang->ticket->createdBy);?></th>
        <th class='c-openedDate w-120px'><?php common::printOrderLink('openedDate', $orderBy, $vars, $lang->ticket->createdDate);?></th>
        <th class='c-assignedTo w-150px'><?php common::printOrderLink('assignedTo', $orderBy, $vars, $lang->ticket->assignedTo);?></th>
        <th class='c-actions'><?php echo $lang->actions;?></th>
      </thead>
      <tbody>
        <?php foreach($tickets as $ticket): ?>
        <tr>
          <td class='c-id'><?php echo $canView ? $this->ticket->printIdCell($ticket) : $ticket->id;?></td>
          <td class='no-wrap' title="<?php echo zget($products, $ticket->product);?>"><?php echo zget($products, $ticket->product);?></td>
          <td class='no-wrap' title="<?php echo $ticket->title;?>"><?php echo $canView ? html::a($this->createLink('ticket', 'view', "id={$ticket->id}"), $ticket->title) : $ticket->title;?></td>
          <td><span class='label-pri label-pri-<?php echo $ticket->pri;?>' title='<?php echo zget($lang->ticket->priList, $ticket->pri, $ticket->pri);?>'><?php echo zget($lang->ticket->priList, $ticket->pri); ?></span></td>
          <td><span class="status-task status-<?php echo $ticket->status;?>"><?php echo zget($lang->ticket->statusList, $ticket->status);?></span></td>
          <td><?php echo zget($lang->ticket->typeList, $ticket->type);?></td>
          <td class='no-wrap' title="<?php echo zget($users, $ticket->openedBy);?>"><?php echo zget($users, $ticket->openedBy);?></td>
          <td><?php echo substr($ticket->openedDate, 5, 11);?></td>
          <td class='no-wrap'><?php echo $this->ticket->printAssignedHtml($ticket, $users);?></td>
          <td class='c-actions'><?php echo $this->ticket->buildOperateBrowseMenu($ticket->id);?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div class='table-footer'>
      <?php if($canBatchAction):?>
      <div class="checkbox-primary check-all"><label><?php echo $lang->selectAll?></label></div>
      <?php endif;?>
      <?php $pager->show('right', 'pagerjs');?>
      <div class="table-actions btn-toolbar">
      <?php if($canBatchEdit):?>
      <?php
      $actionLink = $this->createLink('ticket', 'batchEdit');
      $misc       = "onclick=\"setFormAction('$actionLink')\"";
      echo html::commonButton($lang->edit, $misc);
      ?>
      <?php endif;?>

      <?php if($canBatchAssignTo):?>
      <div class="btn-group dropup">
        <button data-toggle="dropdown" type="button" class="btn"><?php echo $lang->ticket->assign;?> <span class="caret"></span></button>
        <?php $withSearch = count($users) > 10;?>
        <?php if($withSearch):?>
        <div class="dropdown-menu search-list search-box-sink" data-ride="searchList">
          <div class="input-control search-box has-icon-left has-icon-right search-example">
            <input id="userSearchBox" type="search" autocomplete="off" class="form-control search-input" />
            <label for="userSearchBox" class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label>
            <a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a>
          </div>
          <?php $usersPinYin = common::convert2Pinyin($users);?>
        <?php else:?>
        <div class="dropdown-menu search-list">
        <?php endif;?>
          <div class="list-group">
          <?php
          $actionLink = $this->createLink('ticket', 'batchAssignTo');
          echo html::select('assignedTo', $users, '', 'class="hidden"');
          foreach($users as $key => $value)
          {
              if(empty($key)) continue;
              $searchKey = $withSearch ? ('data-key="' . zget($usersPinYin, $value, '') . " @$key\"") : "data-key='@$key'";
              echo html::a("javascript:$(\"#assignedTo\").val(\"$key\");setFormAction(\"$actionLink\",\"hiddenwin\")", $value, '', $searchKey);
          }
          ?>
          </div>
        </div>
      </div>
      <?php endif;?>

      <?php if($canBatchFinish):?>
      <?php
      $actionLink = $this->createLink('ticket', 'batchFinish');
      $misc       = "onclick=\"setFormAction('$actionLink')\"";
      echo html::commonButton($lang->ticket->finish, $misc);
      ?>
      <?php endif;?>

      <?php if($canBatchActivate):?>
      <?php
      $actionLink = $this->createLink('ticket', 'batchActivate');
      $misc       = "onclick=\"setFormAction('$actionLink')\"";
      echo html::commonButton($lang->ticket->activate, $misc);
      ?>
      <?php endif;?>

      </div>
    </div>
  </form>
<?php endif;?>
</div>
<script>
$(function()
{
    if(browseType != 'bysearch' && sessionObjectID && productID)
    {
      if(sessionBrowseType == 'byProduct')
      {
          $('#product' + sessionObjectID).closest('li').addClass('active');
      }
      else if(sessionBrowseType == 'byModule')
      {
          $('#module' + sessionObjectID).closest('li').addClass('active');
      }
    }
});

if(browseType == 'byProduct' || browseType == 'byModule') browseType = 'all';
$("#" + browseType + 'Tab').find('.text').after(" <span class='label label-light label-badge'><?php echo $pager->recTotal;?></span>");
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

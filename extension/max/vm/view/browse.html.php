<?php
/**
 * The browse view file of vm module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      xiawenlong <xiawenlong@cnezsoft.com>
 * @package     vm
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('confirmDelete', $lang->vm->confirmDelete)?>
<?php js::set('confirmBoot', $lang->vm->confirmBoot)?>
<?php js::set('confirmReboot', $lang->vm->confirmReboot)?>
<?php js::set('confirmShutdown', $lang->vm->confirmShutdown)?>
<?php js::set('actionSuccess', $lang->vm->actionSuccess)?>
<div id='mainMenu' class='clearfix'>
  <div class='pull-left btn-toolbar'>
    <?php echo html::a($this->createLink('vm', 'browse'), "<span class='text'>{$lang->vm->all}</span>", '', "class='btn btn-link btn-active-text'");?>
    <a href='#' id='bysearchTab' class='btn btn-link querybox-toggle'><i class='icon-search icon'></i>&nbsp;<?php echo $lang->vm->byQuery;?></a>
  </div>

  <?php if(common::hasPriv('vm', 'create')):?>
  <div class="btn-toolbar pull-right" id='createActionMenu'>
    <?php
    $misc = "class='btn btn-primary iframe' data-width='600px'";
    $link = $this->createLink('vm', 'create', '', '', true);
    echo html::a($link, "<i class='icon icon-plus'></i>" . $lang->vm->create, '', $misc);
    ?>
  </div>
  <?php endif;?>
</div>
<div id='queryBox' class='cell <?php if($browseType =='bysearch') echo 'show';?>' data-module='vm'></div>
<div id='mainContent' class='main-table'>
<?php $vars = "browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
  <div class="table-responsive">
    <?php if(empty($vmList)):?>
    <div class="table-empty-tip">
      <p>
        <span class="text-muted"><?php echo $lang->vm->empty;?></span>
        <?php if(common::hasPriv('vm', 'create')) common::printLink('vm', 'create', '', '<i class="icon icon-plus"></i> ' . $lang->vm->create, '', 'class="btn btn-info"');?>
      </p>
    </div>
    <?php else:?>
    <table class='table has-sort-head table-fixed' id='vmList'>
      <thead>
        <tr>
          <th class='w-60px'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
          <th class='w-200px'><?php common::printOrderLink('name', $orderBy, $vars, $lang->vm->name);?></th>
          <th class='w-100px'><?php common::printOrderLink('hostID', $orderBy, $vars, $lang->vm->hostName);?>
          <th class='w-120px'><?php common::printOrderLink('osType', $orderBy, $vars, $lang->vm->osType);?></th>
          <th class='w-100px'><?php common::printOrderLink('osCpu', $orderBy, $vars, $lang->vm->cpu);?></th>
          <th class='w-60px'><?php common::printOrderLink('osMemory', $orderBy, $vars, $lang->vm->memory);?></th>
          <th class='w-60px'><?php common::printOrderLink('osDisk', $orderBy, $vars, $lang->vm->disk);?></th>
          <th class='w-80px'><?php common::printOrderLink('status', $orderBy, $vars, $lang->vm->status);?></th>
          <th class='w-80px'><?php common::printOrderLink('createdBy', $orderBy, $vars, $lang->vm->creater);?></th>
          <th class='c-actions-5'><?php echo $lang->actions?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($vmList as $vm):?>
        <tr>
          <td><?php echo $vm->id;?></td>
          <td title="<?php echo $vm->name;?>"><?php echo html::a($this->inlink('view', "id=$vm->id", 'html', true), $vm->name, '',"class='iframe'");?></td>
          <td title="<?php echo $vm->hostName;?>"><?php echo $vm->hostName;?></td>
          <?php $osType = $config->vm->os->type[$vm->osCategory][$vm->osType] . ' ' . $lang->vm->versionList[$vm->osType][$vm->osVersion];?>
          <td title="<?php echo $osType;?>"><?php echo $osType;?></td>
          <td><?php echo zget($config->vm->os->cpu, $vm->osCpu);?></td>
          <td><?php echo zget($config->vm->os->memory, $vm->osMemory);?></td>
          <td><?php echo zget($config->vm->os->disk, $vm->osDisk);?></td>
          <td><?php echo zget($lang->vm->statusList, $vm->status);?></td>
          <td><?php echo zget($users, $vm->createdBy);?></td>
          <td class='c-actions'>
            <?php
            $startClass = $vm->status == 'running' ? 'disabled' : '';
            $stopClass  = $vm->status == 'suspend' ? 'disabled' : '';
            common::printLink('vm', 'suspend', "vmID={$vm->id}", "<i class='icon icon-pause'></i> ", '', "title='{$lang->vm->suspend}' class='btn btn-primary' {$stopClass} target='hiddenwin' onclick='if(confirm(\"{$lang->vm->confirmSuspend}\")==false) return false;'");
            common::printLink('vm', 'resume', "vmID={$vm->id}", "<i class='icon icon-back'></i> ", '', "title='{$lang->vm->resume}' class='btn btn-primary' {$startClass} target='hiddenwin' onclick='if(confirm(\"{$lang->vm->confirmResume}\")==false) return false;'");
            common::printLink('vm', 'reboot', "vmID={$vm->id}", "<i class='icon icon-restart'></i> ", '', "title='{$lang->vm->reboot}' class='btn btn-primary' {$stopClass} target='hiddenwin' onclick='if(confirm(\"{$lang->vm->confirmReboot}\")==false) return false;'");
            common::printLink('vm', 'destroy', "vmID={$vm->id}", "<i class='icon icon-trash'></i> ", '', "title='{$lang->vm->destroy}' class='btn btn-primary' target='hiddenwin' onclick='if(confirm(\"{$lang->vm->confirmDelete}\")==false) return false;'");
            common::printIcon('vm', 'getVNC', "vmID={$vm->id}", '', 'list', 'link', 'hiddenwin', $stopClass);
            ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <div class='table-footer'>
    <?php $pager->show('right', 'pagerjs');?>
  </div>
  <?php endif;?>
</div>

<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

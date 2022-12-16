<?php
/**
 * The template browse view file of vm module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      xiawenlong <liyuchun@easycorp.ltd>
 * @package     vm
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id='mainMenu' class='clearfix'>
  <?php if(common::hasPriv('vm', 'createTemplate')):?>
  <div class="btn-toolbar pull-right" id='createActionMenu'>
    <?php
    $misc = "class='btn btn-primary'";
    $link = $this->createLink('vm', 'createTemplate');
    echo html::a($link, "<i class='icon icon-plus'></i>" . $lang->vm->createTemplate, '', $misc);
    ?>
  </div>
  <?php endif;?>
</div>
<div id='mainContent' class='main-table'>
  <?php $vars = "orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
  <?php if(empty($templateList)):?>
  <div class="table-empty-tip">
    <p>
      <span class="text-muted"><?php echo $lang->vm->templateEmpty;?></span>
      <?php if(common::hasPriv('vm', 'createTemplate')) common::printLink('vm', 'createTemplate', '', '<i class="icon icon-plus"></i> ' . $lang->vm->createTemplate, '', 'class="btn btn-info"');?>
    </p>
  </div>
  <?php else:?>
  <table class='table has-sort-head table-fixed' id='vmList'>
    <thead>
      <tr>
        <th class='c-id'><?php common::printOrderLink('id', $orderBy, $vars, $lang->idAB);?></th>
        <th class='c-name'><?php common::printOrderLink('name', $orderBy, $vars, $lang->vm->name);?></th>
        <th class='c-host'><?php common::printOrderLink('hostID', $orderBy, $vars, $lang->vm->hostName);?>
        <th class='c-type w-150px'><?php common::printOrderLink('osType', $orderBy, $vars, $lang->vm->osType);?></th>
        <th class='c-lang'><?php common::printOrderLink('osLang', $orderBy, $vars, $lang->vm->osLang);?></th>
        <th class='c-number w-100px'><?php common::printOrderLink('cpuCoreNum', $orderBy, $vars, $lang->vm->cpu);?></th>
        <th class='c-number w-100px'><?php common::printOrderLink('memorySize', $orderBy, $vars, $lang->vm->memory);?></th>
        <th class='c-number w-100px'><?php common::printOrderLink('diskSize', $orderBy, $vars, $lang->vm->disk);?></th>
        <th class='c-actions-1'><?php echo $lang->actions?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($templateList as $template):?>
      <tr>
        <td><?php echo $template->id;?></td>
        <td title="<?php echo $template->name;?>"><?php echo $template->name;?></td>
        <td title="<?php echo zget($hosts, $template->hostID, '');?>"><?php echo zget($hosts, $template->hostID, '');?></td>
        <td><?php echo $config->vm->os->type[$template->osCategory][$template->osType] . $lang->vm->versionList[$template->osType][$template->osVersion];?></td>
        <td><?php echo zget($lang->vm->langList, $template->osLang);?></td>
        <td><?php echo zget($config->vm->os->cpu, $template->cpuCoreNum);?></td>
        <td><?php echo zget($config->vm->os->memory, $template->memorySize);?></td>
        <td><?php echo zget($config->vm->os->disk, $template->diskSize);?></td>
        <td class='c-actions'>
          <?php common::printLink('vm', 'editTemplate', "vmID={$template->id}", "<i class='icon icon-edit'></i> ", '', "title='{$lang->edit}' class='btn btn-primary'"); ?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class='table-footer'>
    <?php $pager->show('right', 'pagerjs');?>
  </div>
  <?php endif;?>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

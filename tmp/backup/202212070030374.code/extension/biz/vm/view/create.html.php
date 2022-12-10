<?php
/**
 * The create view file of vm module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      xiawenlong <xiawenlong@cnezsoft.com>
 * @package     host
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2><?php echo $lang->vm->create;?></h2>
  </div>
  <form method='post' target='hiddenwin'>
    <?php js::set('vmConfig',   $config->vm);?>
    <?php js::set('vmLang',     $lang->vm);?>
    <?php js::set('templateID', $templateID);?>
    <table class='table table-form'>
      <?php if(!$templateID):?>
      <tr>
        <th class='w-110px'><?php echo $lang->vm->osCategory;?></th>
        <td><?php echo html::select('osCategory', $config->vm->os->list, $templateID ? $template->osCategory : '', "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->osType;?></th>
        <td><?php echo html::select('osType', '', $templateID ? $template->osType : '', "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->osVersion;?></th>
        <td><?php echo html::select('osVersion', '', $templateID ? $template->osVersion : '', "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->vmTemplate;?></th>
        <td id="template"><?php echo html::select('vmTemplate', '', $templateID, "class='form-control chosen' required")?></td>
      </tr>
      <?php else:?>
      <tr>
        <th class='w-120px'><?php echo $lang->vm->name;?></th>
        <td><?php echo html::input('name', '', "class='form-control' placeholder=\"{$lang->vm->nameValid}\"");?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->osLang;?></th>
        <td><?php echo html::select('osLang', $lang->vm->langList, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->cpu;?></th>
        <td><?php echo html::select('osCpu', $config->vm->os->cpu, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->memory;?></th>
        <td><?php echo html::select('osMemory', $config->vm->os->memory, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vm->disk;?></th>
        <td><?php echo html::select('osDisk', $config->vm->os->disk, '', "class='form-control chosen'")?></td>
      </tr>
      <?php endif;?>
      <tr>
        <?php if(!$templateID):?>
        <td colspan="2" class='text-center form-actions'>
        <?php else:?>
        <th></th>
        <td class='text-center form-actions'>
        <?php endif;?>
          <?php echo html::submitButton();?>
          <?php unset($_GET['onlybody']);?>
          <?php echo html::a(inlink('browse'), $lang->goback, $templateID ? '' : '_parent', "class='btn btn-wide btn-back'");?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>


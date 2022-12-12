<?php
/**
 * The create template view file of vm module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Li yuchun<liyuhcun@easycorp.ltd>
 * @package     host
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('vmConfig', $config->vm);?>
<?php js::set('vmLang',   $lang->vm);?>
<?php js::set('templateID', '');?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2><?php echo $lang->vm->createTemplate;?></h2>
  </div>
  <form  class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data'>
    <table class='table table-form'>
      <tr>
        <th class='w-150px'><?php echo $lang->vmtemplate->name;?></th>
        <td><?php echo html::input('name', '', "class='form-control'");?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->hostID;?></th>
        <td><?php echo html::select('hostID', $hosts, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->templateName;?></th>
        <td id="template"><?php echo html::select('templateName', '', '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osCategory;?></th>
        <td><?php echo html::select('osCategory', $config->vm->os->list, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osType;?></th>
        <td><?php echo html::select('osType', '', '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osVersion;?></th>
        <td><?php echo html::select('osVersion', '', '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osLang;?></th>
        <td><?php echo html::select('osLang', $lang->vm->langList, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->cpuCoreNum;?></th>
        <td><?php echo html::select('cpuCoreNum', $config->vm->os->cpu, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->memorySize;?></th>
        <td><?php echo html::select('memorySize', $config->vm->os->memory, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->diskSize;?></th>
        <td><?php echo html::select('diskSize', $config->vm->os->disk, '', "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th></th>
        <td class='text-center form-actions'>
          <?php echo html::submitButton();?>
          <?php echo html::backButton();?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>


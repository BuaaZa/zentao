<?php
/**
 * The edit template view file of vm module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2022 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Liyuchun <liyuchun@easycorp.ltd>
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
    <h2><?php echo $lang->vm->editTemplate;?></h2>
  </div>
  <form  class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data'>
    <table class='table table-form'>
      <tr>
        <th class='w-150px'><?php echo $lang->vmtemplate->name;?></th>
        <td><?php echo html::input('name', $template->name, "class='form-control'");?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->hostID;?></th>
        <td><?php echo html::select('hostID', $hosts, $template->hostID, "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->templateName;?></th>
        <td id="template"><?php echo html::select('templateName', $templatePairs, $template->templateName, "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osCategory;?></th>
        <td><?php echo html::select('osCategory', $config->vm->os->list, $template->osCategory, "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osType;?></th>
        <td><?php echo html::select('osType', $config->vm->os->type[$template->osCategory], $template->osType, "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osVersion;?></th>
        <td><?php echo html::select('osVersion', $lang->vm->versionList[$template->osType], $template->osVersion, "class='form-control chosen' required")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->osLang;?></th>
        <td><?php echo html::select('osLang', $lang->vm->langList, $template->osLang, "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->cpuCoreNum;?></th>
        <td><?php echo html::select('cpuCoreNum', $config->vm->os->cpu, $template->cpuCoreNum, "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->memorySize;?></th>
        <td><?php echo html::select('memorySize', $config->vm->os->memory, $template->memorySize, "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->vmtemplate->diskSize;?></th>
        <td><?php echo html::select('diskSize', $config->vm->os->disk, $template->diskSize, "class='form-control chosen'")?></td>
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


<?php
/**
 * The create view file of host module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jiangxiu Peng <pengjiangxiu@cnezsoft.com>
 * @package     host
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2><?php echo $lang->host->editAction;?></h2>
  </div>
  <form method='post' target='hiddenwin' id='ajaxForm'>
    <table class='table table-form'>
      <tr>
        <th class='w-100px'><?php echo $lang->host->name;?></th>
        <td><?php echo html::input('name', $host->name, "class='form-control'");?></td>
        <th><?php echo $lang->host->admin;?></th>
        <td><?php echo html::select('admin', $accounts, $host->admin, "class='form-control chosen'");?></td>
        <td></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->cpuBrand;?></th>
        <td><?php echo html::select('cpuBrand', $lang->host->cpuBrandList, $host->cpuBrand, "class='form-control chosen'");?></td>
        <th><?php echo $lang->host->cpuModel;?></th>
        <td><?php echo html::input('cpuModel', $host->cpuModel, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->cpuNumber;?></th>
        <td><?php echo html::input('cpuNumber', $host->cpuNumber, "class='form-control'");?></td>
        <th><?php echo $lang->host->cpuCores;?></th>
        <td><?php echo html::input('cpuCores', $host->cpuCores, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->memory;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('memory', $host->memory, "class='form-control'");?>
            <span class="input-group-addon"><?php echo $lang->host->unitList['GB'];?></span>
          </div>
        </td>
        <th><?php echo $lang->host->diskSize;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('diskSize', $host->diskSize, "class='form-control'");?>
            <span class='input-group-addon fix-border fix-padding' id='unit'></span>
            <?php echo html::select('unit', $lang->host->unitList, $host->unit, "class='form-control'");?>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->host->group;?></th>
        <td><?php echo html::select('group', $optionMenu, $host->group, "class='form-control chosen'");?></td>
        <th class='w-90px'><?php echo $lang->host->serverRoom;?></th>
        <td><?php echo html::select('serverRoom', $rooms, $host->serverRoom, 'class="form-control chosen" data-max_drop_width="150"');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->serverModel;?></th>
        <td><?php echo html::input('serverModel', $host->serverModel, "class='form-control'");?></td>
        <th><?php echo $lang->host->hostType;?></th>
        <td><?php echo html::select('hostType', $lang->host->hostTypeList, $host->hostType, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->osName;?></th>
        <td><?php echo html::select('osName', $lang->host->osNameList, $host->osName, "class='form-control chosen'");?></td>
        <th><?php echo $lang->host->osVersion;?></th>
        <td><?php echo html::select('osVersion', $lang->host->{$host->osName . 'List'}, $host->osVersion, "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->agentPort?></th>
        <td><?php echo html::input('agentPort', $host->agentPort, "class='form-control'");?></td>
        <th><?php echo $lang->host->instanceNum?></th>
        <td><?php echo html::input('instanceNum', $host->instanceNum, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->pri?></th>
        <td><?php echo html::input('pri', $host->pri, "class='form-control'");?></td>
        <th><?php echo $lang->host->tags?></th>
        <td><?php echo html::select('tags', $lang->host->tagsList, $host->tags, "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->provider?></th>
        <td><?php echo html::select('provider', $lang->host->providerList, $host->provider, "class='form-control chosen'");?></td>
        <th><?php echo $lang->host->bridgeID?></th>
        <td><?php echo html::input('bridgeID', $host->bridgeID, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->privateIP;?></th>
        <td><?php echo html::input('privateIP', $host->privateIP, "class='form-control'");?></td>
        <th><?php echo $lang->host->publicIP;?></th>
        <td><?php echo html::input('publicIP', $host->publicIP, "class='form-control'");?></td>
      </tr>
      <tr>
        <th></th>
        <td colspan='3' class='text-center form-actions'>
          <?php echo html::hidden('status', $host->status);?>
          <?php echo html::submitButton();?>
          <?php echo html::backButton();?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

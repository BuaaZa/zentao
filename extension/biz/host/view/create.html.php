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
    <h2><?php echo $lang->host->create?></h2>
  </div>
  <form method='post' target='hiddenwin' id='ajaxForm'>
    <table class='table table-form'>
      <tr>
        <th class='w-100px'><?php echo $lang->host->name;?></th>
        <td><?php echo html::input('name', '', "class='form-control'");?></td>
        <th class='w-150px'><?php echo $lang->host->admin;?></th>
        <td><?php echo html::select('admin', $accounts, '', "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->cpuBrand;?></th>
        <td><?php echo html::select('cpuBrand', $lang->host->cpuBrandList, '', "class='form-control chosen'");?></td>
        <th><?php echo $lang->host->cpuModel;?></th>
        <td><?php echo html::input('cpuModel', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->cpuNumber;?></th>
        <td><?php echo html::input('cpuNumber', '', "class='form-control'");?></td>
        <th><?php echo $lang->host->cpuCores;?></th>
        <td><?php echo html::input('cpuCores', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->memory;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('memory', '', "class='form-control'");?>
            <span class="input-group-addon"><?php echo $lang->host->unitList['GB'];?></span>
          </div>
        </td>
        <th><?php echo $lang->host->diskSize;?></th>
        <td>
          <div class='input-group'>
            <?php echo html::input('diskSize', '', "class='form-control'");?>
            <span class='input-group-addon fix-border fix-padding' id='unit'>
              <?php echo html::select('unit', $lang->host->unitList, 'GB', "class='form-control chosen w-50px'");?>
            </span>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->host->group;?></th>
        <td><?php echo html::select('group', $optionMenu, '', "class='form-control chosen'");?></td>
        <th class='w-90px'><?php echo $lang->host->serverRoom;?></th>
        <td><?php echo html::select('serverRoom', $rooms, '', "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->serverModel;?></th>
        <td><?php echo html::input('serverModel', '', "class='form-control'");?></td>
        <th><?php echo $lang->host->hostType;?></th>
        <td><?php echo html::select('hostType', $lang->host->hostTypeList, 'virtual', "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->osName;?></th>
        <td><?php echo html::select('osName', $lang->host->osNameList, 'linux', "class='form-control chosen'");?></td>
        <th><?php echo $lang->host->osVersion;?></th>
        <td><?php echo html::select('osVersion', $lang->host->linuxList, '', "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->agentPort?></th>
        <td><?php echo html::input('agentPort', '8086', "class='form-control'");?></td>
        <th><?php echo $lang->host->instanceNum?></th>
        <td><?php echo html::input('instanceNum', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->pri?></th>
        <td><?php echo html::input('pri', '100', "class='form-control'");?></td>
        <th><?php echo $lang->host->tags?></th>
        <td><?php echo html::select('tags', $lang->host->tagsList, '', "class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->privateIP;?></th>
        <td><?php echo html::input('privateIP', '', "class='form-control'");?></td>
        <th><?php echo $lang->host->publicIP;?></th>
        <td><?php echo html::input('publicIP', '', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->provider?></th>
        <td><?php echo html::select('provider', $lang->host->providerList, '', "class='form-control chosen'");?></td>
        <th><?php echo $lang->host->bridgeID?></th>
        <td><?php echo html::input('bridgeID', 'br0', "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->host->status;?></th>
        <td colspan='3'><?php echo html::radio('status', $lang->host->statusList, 'online');?></td>
      </tr>
      <tr>
        <td colspan='4' class='text-center form-actions'>
          <?php echo html::submitButton();?>
          <?php echo html::backButton();?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

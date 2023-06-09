<?php
/**
 * The edit view file of feedback module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/chosen.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/kindeditor.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/datepicker.html.php';?>
<?php js::set('browseType', $browseType);?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2>
      <span class='label label-id'><?php echo $feedback->id;?></span>
      <?php echo html::a(inlink('view', "id=$feedback->id"), $feedback->title);?>
      <small><?php echo html::icon($lang->icons['edit']) . ' ' . $lang->edit;?></small>
    </h2>
  </div>
  <form class='main-form form-ajax' method='post' enctype='multipart/form-data'>
    <table class='table table-form'>
      <tr>
        <th class='w-120px'><?php echo $lang->feedback->product?></th>
        <td><?php echo html::select('product', $products, $feedback->product, "class='form-control chosen'")?></td>
        <td></td>
      </tr>
      <tr>
        <th class='w-120px'><?php echo $lang->feedback->module?></th>
        <td>
          <?php echo html::select('module', $modules ? $modules : array(), $feedback->module, "class='form-control chosen'")?>
        </td>
        <td></td>
      </tr>
      <tr>
        <th class='w-120px'><?php echo $lang->feedback->type;?></th>
        <td><?php echo html::select('type', $lang->feedback->typeList, $feedback->type, "class='form-control chosen'")?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->title?></th>
        <td colspan='2'>
          <div class='input-group'>
            <?php echo html::input('title', $feedback->title, "class='form-control'")?>
            <span class='input-group-addon'>
              <div class='checkbox-primary'>
                <input type='checkbox' id='public' name='public' value='1' <?php if($feedback->public) echo 'checked'?> />
                <label for='notify'><?php echo $lang->feedback->public?></label>
              </div>
            </span>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->desc?></th>
        <td colspan='2'><?php echo html::textarea('desc', $feedback->desc, "class='form-control'")?></td>
      </tr>
      <tr class='hide'>
        <th><?php echo $lang->feedback->status;?></th>
        <td><?php echo html::hidden('status', $feedback->status);?></td>
      </tr>
      <?php $this->printExtendFields($feedback, 'table');?>
      <tr>
        <th><?php echo $lang->feedback->feedbackBy;?></th>
        <td><?php echo html::input('feedbackBy', $feedback->feedbackBy, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->notifyEmail;?></th>
        <td><?php echo html::input('notifyEmail', $feedback->notifyEmail, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->files;?></th>
        <td><?php echo $this->fetch('file', 'buildform');?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->notify;?></th>
        <td>
          <div class='checkbox-primary'>
            <input type='checkbox' id='notify' name='notify' value='1' <?php if($feedback->notify) echo 'checked'?> />
            <label for='notify'><?php echo $lang->feedback->mailNotify?></label>
          </div>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->productVersion;?></th>
        <td><?php echo html::input('productVersion', $feedback->productVersion, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->usedProject;?></th>
        <td><?php echo html::input('usedProject', $feedback->usedProject, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->expectDate;?></th>
        <td id='expectDateTd'>
            <span><?php echo html::input('expectDate', helper::isZeroDate($feedback->expectDate) ? '' : $feedback->expectDate, "class='form-control form-datetimes'");?></span>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->contactWay;?></th>
        <td><?php echo html::input('contactWay', $feedback->contactWay, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['serverOS'];?></th>
        <td><?php echo html::input('serverOS', $feedback->projectUseInfo->serverOS, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['serverCPU'];?></th>
        <td><?php echo html::input('serverCPU', $feedback->projectUseInfo->serverCPU, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['middleware'];?></th>
        <td><?php echo html::input('middleware', $feedback->projectUseInfo->middleware, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['database'];?></th>
        <td><?php echo html::input('database', $feedback->projectUseInfo->database, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['terminalOS'];?></th>
        <td><?php echo html::input('terminalOS', $feedback->projectUseInfo->terminalOS, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['terminalCPU'];?></th>
        <td><?php echo html::input('terminalCPU', $feedback->projectUseInfo->terminalCPU, "class='form-control'");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->feedback->projectUseInfoList['browser'];?></th>
        <td><?php echo html::input('browser', $feedback->projectUseInfo->browser, "class='form-control'");?></td>
      </tr>
      <tr>
        <td colspan='3' class='text-center form-actions'>
          <?php echo html::submitButton();?>
          <?php echo html::backButton();?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>
<script>
// 修改日期控件使之支持秒 chenjj 230117
$(function()
{
    var options = 
    {
        language: '<?php echo $this->app->getClientLang(); ?>',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        format: 'yyyy-mm-dd hh:ii:ss'
    }

    $('.form-datetimes').datetimepicker(options);
});
</script>

<?php
/**
 * The edit file of case module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     case
 * @version     $Id: edit.html.php 5000 2013-07-03 08:20:57Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('page', 'send');?>
<?php js::set('interfaceID', $interface->id);?>
<?php js::set('tab', $this->app->tab);?>
<?php js::set('confirmUnlinkTesttask', $lang->testcase->confirmUnlinkTesttask);?>
<style>
  th {
  text-align: center;
}
</style>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2>
      <?php echo "<b style=\"margin-right: 10px;font-size: 1.3em;color:{$this->lang->ztinterface->methodColor[$interface->method]};\">$interface->method</b>";?>
      <?php echo "<b style=\"font-size: 1.3em;\">$interface->name</b>";?>
    </h2>
  </div>
  <form method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
    <div class='main-row'>
      <div class='main-col col-7'>
        <div class='cell'>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->url;?></div>
            <div class="detail-content">
              <div class="input-control" style="display: flex; align-items: center;">
                <?php #echo '<span style="font-size: 1.3rem; letter-spacing: 0.05em;">' . $interface->url . '</span>';?>
                <?php echo html::input('baseURL', '', 'class="form-control" style="width: 60%;" list="baseUrlList" placeholder="' . $lang->ztinterface->baseUrl . '"');?>
                <?php echo html::input('URL', $interface->url, 'class="form-control" style="width: 40%;" disabled title="接口文档中指定"');?>
                <?php echo $baseURLList;?>
              </div>
            </div>
          </div>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->head;?></div>
            <div class='detail-content'>
              <table class='table table-form table-bordered'>
                <thead>
                  <tr>
                    <th width="40%"><?php echo $lang->ztinterface->key?></th>
                      <th width="70px"><?php echo $lang->ztinterface->type;?></th>
                      <th width="50px"><?php echo $lang->ztinterface->canNull;?></th>
                      <th width="15%"><?php echo $lang->ztinterface->mock;?></th>
                      <th><?php echo $lang->ztinterface->value;?></th>
                  </tr>
                </thead>
                <tbody id='steps' class='table table-form' data-group-name='<?php echo $lang->testcase->groupName ?>'>
                  <tr class='template step' id='stepTemplate'>
                    <td class='step-id'></td>
                    <td>
                      <div class='input-group'>
                          <!-- <span class='input-group-addon step-item-id'></span> -->
                        <textarea rows='1' class='form-control autosize step-steps' name='steps[]'></textarea>
                        <span class="input-group-addon step-type-toggle">
                          <input type='hidden' name='stepType[]' value='item' class='step-type'>
                          <div class='checkbox-primary'>
                            <input tabindex='-1' type="checkbox" class='step-group-toggle'>
                            <label><?php echo $lang->testcase->group ?></label>
                          </div>
                        </span>
                          <span class="input-group-addon step-type-toggle2">
                              <input type='hidden' name='stepIoType[]' value='0' class='step-iotype'>
                          <div class='checkbox-primary'>
                            <input tabindex='-1' type="checkbox" class='step-group-toggle2'>
                            <label class="checkbox-inline"><?php echo "勾选为输出项" ?></label>
                          </div>
                        </span>
                      </div>
                    </td>
                      <td><textarea rows='1' class='form-control autosize step-expects' name='inputs[]'></textarea></td>
                      <td><textarea rows='1' class='form-control autosize step-expects' name='goal_actions[]'></textarea></td>
                      <td><textarea rows='1' class='form-control autosize step-expects' name='expects[]'></textarea></td>
                      <td><textarea rows='1' class='form-control autosize step-expects' name='eval_criterias[]'></textarea></td>
                    <td class='step-actions'>
                      <div class='btn-group'>
                        <button type='button' class='btn btn-step-add' tabindex='-1'><i class='icon icon-plus'></i></button>
                        <button type='button' class='btn btn-step-move' tabindex='-1'><i class='icon icon-move'></i></button>
                        <button type='button' class='btn btn-step-delete' tabindex='-1'><i class='icon icon-close'></i></button>
                      </div>
                    </td>
                  </tr>
                  <?php foreach($case->steps as $stepID => $step):?>
                  <tr class='step'>
                    <td class='step-id'></td>
                    <td>
                      <div class='input-group'>
                          <!-- <span class='input-group-addon step-item-id'></span> -->
                        <?php echo html::textarea('steps[]', $step->desc, "rows='1' class='form-control autosize step-steps'") ?>
                        <span class='input-group-addon step-type-toggle'>
                          <?php if(!isset($step->type)) $step->type = 'step';?>
                          <input type='hidden' name='stepType[]' value='<?php echo $step->type;?>' class='step-type'>
                          <div class='checkbox-primary'>
                            <input tabindex='-1' tabindex='-1' type="checkbox" class='step-group-toggle'<?php if($step->type === 'group') echo ' checked' ?> />
                            <label><?php echo $lang->testcase->group ?></label>
                          </div>
                        </span>
                          <span class='input-group-addon step-type-toggle2'>
                          <?php if(!isset($step->iotype)) $step->iotype = '0';?>
                          <input type='hidden' name='stepIoType[]' value='<?php echo $step->iotype;?>' class='step-iotype'>
                          <div class='checkbox-primary'>
                            <input tabindex='-1' type="checkbox" class='step-group-toggle2'<?php if($step->iotype === '1') echo ' checked' ?>>
                            <label><?php echo "勾选为输出项" ?></label>
                          </div>
                        </span>
                      </div>
                    </td>
                      <td><?php echo html::textarea('inputs[]', $step->input, "rows='1' class='form-control autosize step-expects'") ?></td>
                      <td><?php echo html::textarea('goal_actions[]', $step->goal_action, "rows='1' class='form-control autosize step-expects'") ?></td>
                      <td><?php echo html::textarea('expects[]', $step->expect, "rows='1' class='form-control autosize step-expects'") ?></td>
                      <td><?php echo html::textarea('eval_criterias[]', $step->eval_criteria, "rows='1' class='form-control autosize step-expects'") ?></td>
                    <td class='step-actions'>
                      <div class='btn-group'>
                        <button type='button' class='btn btn-step-add' tabindex='-1'><i class='icon icon-plus'></i></button>
                        <button type='button' class='btn btn-step-move' tabindex='-1'><i class='icon icon-move'></i></button>
                        <button type='button' class='btn btn-step-delete' tabindex='-1'><i class='icon icon-close'></i></button>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php $this->printExtendFields($case, 'div', 'position=left');?>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->testcase->legendComment;?></div>
            <div class='detail-content'><?php echo html::textarea('comment', '',  "rows='5' class='form-control'");?></div>
          </div>
          <div class="detail">
            <div class="detail-title"><?php echo $lang->files;?></div>
            <div class='detail-content'>
              <?php echo $this->fetch('file', 'printFiles', array('files' => $case->files, 'fieldset' => 'false', 'object' => $case, 'method' => 'edit'));?>
              <?php echo $this->fetch('file', 'buildform');?>
            </div>
          </div>
          <div class='text-center detail form-actions'>
            <?php echo html::hidden('lastEditedDate', $case->lastEditedDate);?>
            <?php echo html::submitButton(). html::backButton();;?>
          </div>
          <?php include '../../common/view/action.html.php';?>
        </div>
      </div>
      <div class='side-col col-4'>
        <div class='cell'>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->messageView;?></div>
            <div class='detail-content'><?php echo html::textarea('messageView', '', "rows='20' class='form-control'");?></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
$(function()
{
    $('#subNavbar [data-id=testcase]').addClass('active');
    $('#navbar [data-id=testcase]').addClass('active');
})
</script>
<?php include '../../common/view/footer.html.php';?>

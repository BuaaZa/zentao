<?php
/**
 * The batch create view of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     story
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<?php js::set('showFields', $showFields);?>
<?php js::set('requiredFields', $config->qastory->create->requiredFields);?>
<?php js::set('oldAccountList', array_keys($currentTaskPoints));?>
<div id="mainContent" class="main-content">
  <div class="main-header">
    <h2><?php echo $storyTitle . ' - ' . $this->lang->qastory->subdivide; ?></h2>
    <div class="pull-right btn-toolbar">
      <?php if(isonlybody()):?>
      <div class="divider"></div>
      <button id="closeModal" type="button" class="btn btn-link" data-dismiss="modal"><i class="icon icon-close"></i></button>
      <?php endif;?>
    </div>
  </div>
  <form method='post' class='load-indicator main-form' enctype='multipart/form-data' target='hiddenwin' id="batchCreateForm">
    <div class="table-responsive">
      <table class="table table-form">
        <thead>
          <tr>
            <th class='c-name required has-btn'><?php echo $lang->qastory->title;?></th>
            <th class='c-spec specBox'><?php echo $lang->qastory->spec;?></th>
            <th class='c-verify verifyBox'><?php echo $lang->qastory->verify;?></th>
            <th class='c-actions'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 0;?>
          <?php foreach($currentTaskPoints as $taskPoint):?>
          <tr>
            <td><input type="text" name="title[<?php echo 'old' . $i;?>]" id="title<?php echo 'old' . $i;?>" value='<?php echo $taskPoint->title;?>' class="form-control title-import input-story-title" readonly></td>
            <td><input type="text" name="spec[<?php echo 'old' . $i;?>]" id="spec<?php echo 'old' . $i;?>" value='<?php echo $taskPoint->spec;?>' class="form-control title-import input-story-title" readonly></td>
            <td><input type="text" name="verify[<?php echo 'old' . $i;?>]" id="verify<?php echo 'old' . $i;?>" value='<?php echo $taskPoint->verify;?>' class="form-control title-import input-story-title" readonly></td>
          </tr>
          <?php $i ++;?>
          <?php endforeach;?>
          <tr class="template">
            <td style='overflow:visible'>
              <div class="input-group">
                <div class="input-control has-icon-right">
                  <input type="text" name="title[$id]" id="title$id" value="" class="form-control title-import input-story-title" autocomplete="off">
                  <div class="colorpicker">
                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><span class="cp-title"></span><span class="color-bar"></span><i class="ic"></i></button>
                    <ul class="dropdown-menu clearfix">
                      <li class="heading"><?php echo $lang->story->colorTag;?><i class="icon icon-close"></i></li>
                    </ul>
                    <input type="hidden" class="colorpicker" id="color$id" name="color[$id]" value="" data-icon="color" data-wrapper="input-control-icon-right" data-update-color="#title$id">
                  </div>
                </div>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-link btn-icon btn-copy" data-copy-from="#title$id" data-copy-to="#spec$id" title="<?php echo $lang->qastory->copyTitle ;?>"><i class="icon icon-arrow-right"></i></button>
                </span>
              </div>
            </td>
            <td class='spec specBox'><textarea name="spec[$id]" id="spec$id" rows="1" class="form-control autosize"></textarea></td>
            <td class='verify verifyBox'><textarea name="verify[$id]" id="verify$id" rows="1" class="form-control autosize"></textarea></td>
            <td class='c-actions text-left'>
              <a href='javascript:;' onclick='addRow(this)' class='btn btn-link'><i class='icon-plus'></i></a>
              <a href='javascript:;' onclick='deleteRow(this)' class='btn btn-link'><i class='icon icon-close'></i></a>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" class="text-center form-actions">
              <?php echo html::commonButton($lang->save, "id='saveButton'", 'btn btn-primary btn-wide');?>
              <?php echo html::backButton();?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
</div>
<div>
  <?php $i = '%i%';?>
  <table class='hidden'>
    <tr id='addRow' class='hidden'>
      <td style='overflow:visible'>
        <div class="input-group">
          <div class="input-control has-icon-right">
            <input type="text" name="title[<?php echo $i?>]" id="title<?php echo $i?>" value="" class="form-control title-import input-story-title" autocomplete="off">
            <div class="colorpicker">
              <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><span class="cp-title"></span><span class="color-bar"></span><i class="ic"></i></button>
              <ul class="dropdown-menu clearfix">
                <li class="heading"><?php echo $lang->story->colorTag;?><i class="icon icon-close"></i></li>
              </ul>
              <input type="hidden" class="colorpicker" id="color<?php echo $i?>" name="color[<?php echo $i?>]" value="" data-icon="color" data-wrapper="input-control-icon-right" data-update-color="#title<?php echo $i?>">
            </div>
          </div>
          <span class="input-group-btn">
            <button type="button" class="btn btn-link btn-icon btn-copy" data-copy-from="#title<?php echo $i?>" data-copy-to="#spec<?php echo $i?>" title="<?php echo $lang->story->copyTaskPointTitle ;?>"><i class="icon icon-arrow-right"></i></button>
          </span>
        </div>
      </td>
      <td class='spec specBox'><textarea name="spec[<?php echo $i?>]" id="spec<?php echo $i;?>" rows="1" class="form-control autosize"></textarea></td>
      <td class='verify verifyBox'><textarea name="verify[<?php echo $i?>]" id="verify<?php echo $i;?>" rows="1" class="form-control autosize"></textarea></td>
      <td class='c-actions text-left'>
        <a href='javascript:;' onclick='addRow(this)' class='btn btn-link'><i class='icon-plus'></i></a>
        <a href='javascript:;' onclick='deleteRow(this)' class='btn btn-link'><i class='icon icon-close'></i></a>
      </td>
    </tr>
  </table>
</div>
<script>
$(function()
{
    var imageTitles = <?php echo empty($titles) ? '""' : json_encode($titles);?>;
    var storyTitles = <?php echo empty($titles) ? '""' : json_encode(array_keys($titles));?>;

    $('#batchCreateForm').batchActionForm(
    {
        idStart: 1,
        idEnd: <?php echo max((empty($titles) ? 1 : count($titles)), 1)?>,
        rowCreator: function($row, index)
        {
            rowIndex = index; // Set the index for the add element operation
            $row.find('select.chosen,select.picker-select').each(function()
            {
                var $select = $(this);
                if($select.hasClass('picker-select')) $select.parent().find('.picker').remove();
                if(index == 1) $select.find("option[value='ditto']").remove();
                if(index > 1 && $select.find('option[value="ditto"]').length > 0) $select.val('ditto');
                if($select.attr('id').indexOf('branch') >= 0) $select.val('<?php echo $branch;?>')
                $select.chosen();
                setTimeout(function()
                {
                    $select.next('.chosen-container').find('.chosen-drop').width($select.closest('td').width() + 50);
                }, 200);
            });

            var storyTitle = storyTitles && storyTitles[index - 1];
            if (storyTitle !== undefined && storyTitle !== null)
            {
                $row.find('.input-story-title').val(storyTitle).after('<input type="hidden" name="uploadImage[' + index + ']" id="uploadImage[' + index + ']" value="' + imageTitles[storyTitle] + '">');
            }

            if(index == 1) $row.find('td.c-actions > a:last').remove();

            /* Implement a custom form without feeling refresh. */
            var fieldList = ',' + showFields + ',';
            $('#formSettingForm > .checkboxes > .checkbox-primary > input').each(function()
            {
                var field     = ',' + $(this).val() + ',';
                var $field    = $row.find('[name^=' + $(this).val() + ']');
                var required  = ',' + requiredFields + ',';
                var $fieldBox = $row.find('.' + $(this).val() + 'Box' );
                if(fieldList.indexOf(field) >= 0 || required.indexOf(field) >= 0)
                {
                    $fieldBox.removeClass('hidden');
                    $field.removeAttr('disabled');
                }
                else if(!$fieldBox.hasClass('hidden'))
                {
                    $fieldBox.addClass('hidden');
                    $field.attr('disabled', true);
                }
            })
        }
    });

    $(document).on('change', "#mainContent select[name^=needReview]", function()
    {
        select = $(this).parent('td').next('td').children("select[name^=reviewer]");
        $(select).removeAttr('disabled');
        if($(this).val() == 0) $(select).attr('disabled', 'disabled');
        $(select).trigger("chosen:updated");
    })

    $('.reviewerDitto:first').remove();
});

</script>
<?php if(isset($execution)) js::set('execution', $execution);?>
<?php js::set('storyType', $type);?>
<?php if(isonlybody()):?>
<style>
.body-modal .main-header {padding-right: 0px;}
.btn-toolbar > .dropdown {margin: 0px;}
</style>
<script>
$(function()
{
    parent.$('#triggerModal .modal-content .modal-header .close').hide();
})
</script>
<?php endif;?>
<?php include '../../common/view/pastetext.html.php';?>
<?php include '../../common/view/footer.html.php';?>

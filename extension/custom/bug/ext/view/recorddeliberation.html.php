<?php
/**
 * The create view of bug module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     bug
 * @version     $Id: create.html.php 4903 2013-06-26 05:32:59Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
include '../../../../../module/common/view/header.html.php';
include '../../../../../module/common/view/kindeditor.html.php';
include '../../../../../module/common/view/datepicker.html.php';


?>
<div id="mainContent" class="main-content fade">
    <div class="center-block">
        <div class='main-header'>
            <h2>
                <span class='label label-id'><?php echo $bug->id;?></span>
                <?php echo isonlybody() ? ('<span title="' . $bug->title . '">' . $bug->title . '</span>') : html::a($this->createLink('bug', 'view', 'bug=' . $bug->id), $bug->title);?>

                <?php if(!isonlybody()):?>
                    <small><?php echo $lang->arrow . $lang->bug->recorddeliberation;?></small>
                <?php endif;?>
            </h2>
        </div>
        <?php
        foreach(explode(',',$config->deliberation->record->requiredFields) as $field)
        {
            if($field and strpos($showFields, $field) === false) $showFields .= ',' . $field;
        }
        ?>
        <form method='post' enctype='multipart/form-data' id='dataform'  target='hiddenwin'>
            <table class="table table-form">


                <tr>
                    <?php $showDeadline = strpos(",$showFields,", ',deliberateddate,') !== false;?>
                    <?php if($showDeadline):?>
                    <th></th>
                    <td id='deadlineTd'>
                        <div class='input-group'>
                            <span class='input-group-addon fix-border'><?php echo $lang->bug->deliberateddate?></span>
                            <?php echo html::input('deliberateddate', $deadline, "class='form-control form-date'");#设置默认日期?>
                        </div>
                    </td>
                    <?php endif;?>
                </tr>
                <tr>
                    <th></th>
                    <td  id='statusBox'>
                    <div class='input-group'>
                        <span class='input-group-addon fix-border'><?php echo $lang->bug->tostatus;?></span>
                        <?php echo html::select('tostatus', $lang->bug->tostatuslist, $tostatus, "class='form-control chosen' ");?>
                    </div>
                    </td>
                </tr>

                <tr>
                    <th><?php echo $lang->bug->deliberationdescription;?></th>
                    <td colspan='2'>
                        <?php echo html::textarea('comment', '', "rows='6' class='form-control'");?>
                    </td>
                </tr>

                <?php $this->printExtendFields('', 'table');?>
                <tr>
                    <th><?php echo $lang->bug->deliberationfile;?></th>
                    <td colspan='2'><?php echo $this->fetch('file', 'buildform', 'fileCount=1&percent=0.85');?></td>
                </tr>


                <tr>
                    <td colspan="3" class="text-center">
                        <?php echo html::submitButton() . html::linkButton($lang->goback, $this->session->bugList, 'self', '', 'btn btn-wide');?>
                    </td>
                </tr>

            </table>
        </form>
        <hr class='small' />
        <div class='main'><?php include '../../../../../module/common/view/action.html.php';?></div>
    </div>
</div>
<?php include '../../../../../module/common/view/footer.html.php';?>

<?php
/**
 * The view file of case module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     case
 * @version     $Id: view.html.php 594 2010-03-27 13:44:07Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/datatable.fix.html.php';?>
<div id='mainMenu' class='clearfix'>
  <div id="sidebarHeader">
    <div class="title" title="<?php echo $moduleName;?>">
      <?php
        echo $task->name;
      ?>
    </div>
  </div>
  <div class='btn-toolbar pull-left'>
    <?php
    $hasCasesPriv = common::hasPriv('testtask', 'cases');
    $hasGroupPriv = common::hasPriv('testtask', 'groupcase');
    ?>
    <?php
    if($hasCasesPriv) echo html::a($this->inlink('cases', "taskID=$taskID&browseType=all&param=0"), "<span class='text'>{$lang->testtask->allCases}</span>", '', "id='allTab' class='btn btn-link' data-app='{$app->tab}'");
    if($hasCasesPriv) echo html::a($this->inlink('cases', "taskID=$taskID&browseType=assignedtome&param=0"), "<span class='text'>{$lang->testtask->assignedToMe}</span>", '', "id='assignedtomeTab' class='btn btn-link' data-app='{$app->tab}'");

    if($hasGroupPriv)
    {
        $groupBy  = isset($groupBy)  ? $groupBy : '';
        $active   = !empty($groupBy) ? 'btn-active-text' : '';

        echo "<div id='groupTab' class='btn-group'>";
        echo html::a($this->createLink('testtask', 'groupCase', "taskID=$taskID&groupBy=story"), "<span class='text'>{$lang->testcase->groupByStories}</span>", '', "class='btn btn-link $active' data-app='{$app->tab}'");
        echo '</div>';
    }
    ?>

    <?php if($this->methodName == 'cases'):?>
    <div class='btn-group'>
      <?php $active = $suiteName == $lang->testtask->browseBySuite ? '' : 'btn-active-text';?>
      <a href='javascript:;' class='btn btn-link btn-limit <?php echo $active;?>' data-toggle='dropdown'><span class='text' title='<?php echo $suiteName;?>'><?php echo $suiteName;?></span> <span class='caret'></span></a>
      <ul class='dropdown-menu' style='max-height:240px; max-width: 300px; overflow-y:auto'>
        <?php
          foreach($suites as $key => $name) echo "<li>" . html::a(inlink('cases', "taskID=$taskID&browseType=bysuite&param=$key"), $name) . "</li>";
        ?>
      </ul>
    </div>
    <?php echo "<a class='btn btn-link querybox-toggle' id='bysearchTab'><i class='icon icon-search muted'></i> {$lang->testcase->bySearch}</a>";?>
    <?php endif;?>
  </div>
  <div class='btn-toolbar pull-right'>
    <?php

    common::printLink('testtask', 'create',
        "product=$productID", "<i class='icon icon-plus'></i> " . $lang->testtask->create,
        '', "class='btn btn-primary'");

    if(!$task->isParent){
      common::printIcon('testtask', 'linkCase',
          "taskID=$task->id", $task, 'button', 'link');
    }
    common::printIcon('testcase', 'export', "productID=$productID&orderBy=case_desc&taskID=$task->id", '', 'button', '', '', 'export');
    common::printIcon('testtask', 'report', "productID=$productID&taskID=$task->id&browseType=$browseType&branchID=$task->branch&moduleID=" . (empty($moduleID) ? '' : $moduleID));
    common::printIcon('testtask',   'view',     "taskID=$task->id", '', 'button', 'list-alt');
    common::printBack($this->session->testtaskList, 'btn btn-link');
    ?>
  </div>
</div>
<?php
$headerHooks = glob(dirname(dirname(__FILE__)) . "/ext/view/featurebar.*.html.hook.php");
if(!empty($headerHooks))
{
    foreach($headerHooks as $fileName) include($fileName);
}
?>
<?php js::set('confirmUnlink', $lang->testtask->confirmUnlinkCase)?>
<?php js::set('taskCaseBrowseType', ($browseType == 'bymodule' and $this->session->taskCaseBrowseType == 'bysearch') ? 'all' : $this->session->taskCaseBrowseType);?>
<?php js::set('browseType', $browseType);?>
<?php js::set('moduleID', $moduleID);?>
<div id='mainContent' class='main-row fade'>
  <div class='side-col' id='sidebar'>
    <div class="sidebar-toggle"><i class="icon icon-angle-left"></i></div>
    <div class='cell'><?php echo $taskTree;?></div>
  </div>
  <div class='main-col'>
    <div class="cell" id="queryBox" data-module='testtask'></div>
    <?php
    $datatableId  = $this->moduleName . ucfirst($this->methodName);
    $useDatatable = (isset($config->datatable->$datatableId->mode) and $config->datatable->$datatableId->mode == 'datatable');
    ?>
    <form class='main-table table-cases'
          data-hot='true' method='post'
          name='casesform' id='casesForm'
        <?php if(!$useDatatable) echo "data-ride='table'";?>>
      <div class="table-header fixed-right">
        <nav class="btn-toolbar pull-right"></nav>
      </div>
      <?php
      $vars = "taskID=$task->id&browseType=$browseType&param=$param&orderBy=%s&recToal={$pager->recTotal}&recPerPage={$pager->recPerPage}";

      $canBatchEdit   = common::hasPriv('testcase', 'batchEdit');
      $canBatchUnlink = common::hasPriv('testtask', 'batchUnlinkCases');
      $canBatchAssign = common::hasPriv('testtask', 'batchAssign');
//      ChromePhp::log($task->isParent);
//      ChromePhp::log($this->app->user->rights);
      $canBatchMove   = common::hasPriv('testtask', 'batchMove');
      $canBatchRun    = common::hasPriv('testtask', 'batchRun');

      $canBatchAction = ($canBeChanged and ($canBatchEdit or $canBatchUnlink or $canBatchAssign or $canBatchMove or $canBatchRun));

      if($useDatatable) include '../../common/view/datatable.html.php';
      if(!$useDatatable) include '../../common/view/tablesorter.html.php';

      $config->testcase->datatable->defaultField = $config->testtask->datatable->defaultField;
      $config->testcase->datatable->fieldList['actions']['width'] = '120';

      $setting = $this->datatable->getSetting('testtask');
      $widths  = $this->datatable->setFixedFieldWidth($setting);
      $columns = 0;
      ?>

      <?php if(!$useDatatable) echo '<div class="table-responsive">';?>
        <table class='table has-sort-head
            <?php if($useDatatable) echo ' datatable';?>'
               id='caseList'
               data-fixed-left-width='<?php echo $widths['leftWidth']?>'
               data-fixed-right-width='<?php echo $widths['rightWidth']?>'
               data-checkbox-name='caseIDList[]'>
          <thead>
            <tr>
            <?php
            foreach($setting as $key => $value)
            {
                if($value->show)
                {
                    $this->datatable->printHead($value, $orderBy, $vars, $canBatchAction);
                    $columns ++;
                }
            }
            ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach($runs as $run):?>
            <tr data-id='<?php echo $run->id?>'>
              <?php foreach($setting as $key => $value) $this->testtask->printCell($value, $run, $users, $task, $branches, $useDatatable ? 'datatable' : 'table');?>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      <?php if(!$useDatatable) echo '</div>';?>
      <?php if($runs):?>
      <div class='table-footer'>
        <?php if($canBatchAction):?>
        <div class="checkbox-primary check-all"><label><?php echo $lang->selectAll?></label></div>
        <div class='table-actions btn-toolbar'>
<!--            批量编辑/移除-->
          <div class='btn-group '>
            <?php
                $actionLink = $this->createLink('testcase', 'batchEdit', "productID=$productID&branch=all");
                $misc       = $canBatchEdit ? "onclick=\"setFormAction('$actionLink')\"" : "disabled='disabled'";
                echo html::commonButton($lang->edit, $misc);
            ?>

            <?php if($canBatchUnlink):?>
            <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'>
                <span class='caret'></span>
            </button>

            <ul class='dropdown-menu'>
              <?php
              $actionLink = $this->createLink('testtask', 'batchUnlinkCases', "taskID=$task->id");
              $misc       = "onclick=\"setFormAction('$actionLink')\"";
              echo "<li>" . html::a('javascript:;', $lang->testtask->unlinkCase, '', $misc) . "</li>";
              ?>
            </ul>
            <?php endif;?>

          </div>
<!--            批量指派-->
          <?php if($canBatchAssign && !$task->isParent):?>
          <div class="btn-group ">

            <button data-toggle="dropdown" type="button" class="btn">
                <?php echo $lang->testtask->assign;?>
                <span class="caret"></span>
            </button>

            <?php
                $withSearch = count($assignedToList) > 10;
                echo html::select('assignedTo', $assignedToList, '', 'class="hidden"');
            ?>

            <div class="dropdown-menu search-list
                <?php if($withSearch) echo ' search-box-sink';?>"
                 data-ride="searchList">

              <?php if($withSearch):?>
              <?php
                  $membersPinYin = common::convert2Pinyin($assignedToList);
              ?>
              <div class="input-control search-box has-icon-left has-icon-right search-example">
                <input id="userSearchBox" type="search" autocomplete="off" class="form-control search-input">
                <label for="userSearchBox" class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label>
                <a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a>
              </div>
              <?php endif;?>

              <div class="list-group">
              <?php foreach ($assignedToList as $key => $value):?>
                  <?php
                  if(empty($key) or $key == 'closed') continue;
                  $searchKey = $withSearch ? ('data-key="' . zget($membersPinYin, $value, '') . " @$key\"") : "data-key='@$key'";
//                  echo html::a("javascript:$(\"#assignedTo\").val(\"$key\");
//                                    setFormAction(\"$actionLink\", \"hiddenwin\")",
//                                    $value, '', $searchKey);

                  $actionLink = inLink('batchAssign', "taskID=$task->id");
                  echo html::a('#', $value, '',
                      "$searchKey onclick=\"$('#assignedTo').val('$key');setFormAction('$actionLink', 'hiddenwin')\" ",);
                  ?>
              <?php endforeach;?>
              </div>

            </div>
          </div>
          <?php endif;?>

<!--        todo: 批量移动-->
          <?php if($canBatchMove && !$task->isParent):?>
          <div class="btn-group ">
            <button data-toggle="dropdown" type="button" class="btn">
                <?php echo $lang->testtask->move;?>
                <span class="caret"></span>
            </button>

            <?php
                $withSearch = count($taskList) > 10;
                echo html::select('moveTo', $taskList, '', 'class="hidden"');
            ?>
            <div class="dropdown-menu search-list
                <?php if($withSearch) echo ' search-box-sink';?>"
                 data-ride="searchList">

                <?php if($withSearch):?>
                    <?php
                        $membersPinYin = common::convert2Pinyin($taskList);
                    ?>
                    <div class="input-control search-box has-icon-left has-icon-right search-example">
                        <input id="userSearchBox" type="search" autocomplete="off" class="form-control search-input">
                        <label for="userSearchBox" class="input-control-icon-left search-icon"><i class="icon icon-search"></i></label>
                        <a class="input-control-icon-right search-clear-btn"><i class="icon icon-close icon-sm"></i></a>
                    </div>
                <?php endif;?>

                <div class="list-group">
                    <?php foreach ($taskList as $key => $value):?>
                        <?php
                        if(empty($key) or $key == 'closed') continue;
                        $searchKey = $withSearch ? ('data-key="' . zget($membersPinYin, $value, '') . " @$key\"") : "data-key='@$key'";

                        $actionLink = inLink('batchMove', "taskID=$task->id");
                        echo html::a('#', $value, '',
                            "$searchKey onclick=\"$('#moveTo').val('$key');setFormAction('$actionLink', 'hiddenwin')\" ",);
                        ?>
                    <?php endforeach;?>
                </div>

            </div>
          </div>
          <?php endif;?>

<!--            批量执行-->
          <?php
          if($canBatchRun)
          {
              $actionLink = inLink('batchRun', "productID=$productID&orderBy=id_desc&from=testtask&taskID=$taskID");
              echo html::commonButton($lang->testtask->runCase, "onclick=\"setFormAction('$actionLink')\"");
          }
          ?>

        </div>
        <?php endif;?>
        <?php $pager->show('right', 'pagerjs');?>
      </div>
      <?php else:?>
      <div class="table-empty-tip">
        <?php if(!$task->isParent):?>
          <p><span class="text-muted"><?php echo $lang->testcase->noCase;?></span> <?php if($canBeChanged) common::printLink('testtask', 'linkCase', "taskID={$taskID}", "<i class='icon icon-link'></i> " . $lang->testtask->linkCase, '', "class='btn btn-info'");?></p>
        <?php else:?>
          <p><span class="text-muted"><?php echo $lang->testtask->parentNoCase;
            // echo empty($runs);
          ?></span></p>
        <?php endif;?>
      </div>
      <?php endif;?>
    </form> 
  </div>
</div>
<script>
$('#module' + moduleID).addClass('active');
$('#' + taskCaseBrowseType + 'Tab').addClass('btn-active-text');
<?php if($browseType == 'bysearch'):?>
$shortcut = $('#QUERY<?php echo (int)$param;?>Tab');
if($shortcut.size() > 0)
{
    $shortcut.addClass('active');
    $('#bysearchTab').removeClass('active');
    $('#querybox').removeClass('show');
}
<?php endif;?>
<?php if($useDatatable):?>
$(function(){$('#casesForm').table();})
<?php endif;?>
$("thead").find('.c-assignedTo').attr('class', '');
</script>
<?php include '../../common/view/footer.html.php';?>

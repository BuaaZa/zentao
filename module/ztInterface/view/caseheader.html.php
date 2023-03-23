<?php js::set('flow', $config->global->flow);?>
<?php $isProjectApp  = $this->app->tab == 'project'?>
<?php $currentModule = 'ztinterface';?>
<?php $currentMethod = 'browse';?>
<?php if(common::checkNotCN()):?>
<style> .btn-toolbar>.btn {margin-right: 3px !important;}</style>
<?php endif;?>
<?php if(!isset($branch)) $branch = 0;?>
<?php if($config->global->flow == 'full'):?>
<style>
.btn-group a i.icon-plus {font-size: 16px;}
.btn-group a.btn-primary {border-right: 1px solid rgba(255,255,255,0.2);}
.btn-group button.dropdown-toggle.btn-primary {padding:6px;}
.body-modal #mainMenu>.btn-toolbar {width: auto;}
#mainMenu .dividing-line {width: 1px; height: 16px; display: inline-block; background: #D8DBDE; margin: 7px 8px 0 0; float: left;}
</style>
<div id='mainMenu' class='clearfix'>
  <?php if(!($this->app->rawMethod == 'groupcase')):?>
  <div id="sidebarHeader">
    <div class="title">
      <?php
      if($this->app->rawMethod == 'browseunits')
      {
          echo $lang->testtask->unitTag[$browseType];
      }
      else
      {
          echo !empty($moduleID) ? $moduleName : $this->lang->tree->all;
          if(!empty($moduleID))
          {
              $removeLink = $browseType == 'bymodule' ? $this->createLink($currentModule, $currentMethod, $projectParam . "productID=$productID&branch=$branch&browseType=$browseType&param=0&orderBy=$orderBy&recTotal=0&recPerPage={$pager->recPerPage}") : 'javascript:removeCookieByKey("caseModule")';
              echo html::a($removeLink, "<i class='icon icon-sm icon-close'></i>", '', "class='text-muted' data-app='{$this->app->tab}'");
          }
      }
      ?>
    </div>
  </div>
  <?php endif;?>
  <div class='btn-toolbar pull-left'>
    <?php
    $hasBrowsePriv = $isProjectApp ? common::hasPriv('project', 'testcase') : common::hasPriv('testcase', 'browse');
    $hasGroupPriv  = common::hasPriv('testcase', 'groupcase');
    $hasZeroPriv   = common::hasPriv('testcase', 'zerocase');
    $hasUnitPriv   = common::hasPriv('testtask', 'browseunits');
    ?>
    <?php foreach(customModel::getFeatureMenu('testcase', 'browse') as $menuItem):?>
    <?php
    if(isset($menuItem->hidden)) continue;
    $menuType = $menuItem->name;
    if(!$config->testcase->needReview and empty($config->testcase->forceReview) and $menuType == 'wait') continue;
    if($hasBrowsePriv and ($menuType == 'all' or $menuType == 'wait'))
    {
        echo html::a($this->createLink($currentModule, $currentMethod, "productID=$productID&branch=$branch&browseType=$menuType"), "<span class='text'>{$menuItem->text}</span>", '', "class='btn btn-link' id='{$menuType}Tab' data-app='{$this->app->tab}'");
    }
    ?>
    <?php endforeach;?>
    <?php
    if($this->methodName == 'browse') echo "<a id='bysearchTab' class='btn btn-link querybox-toggle'><i class='icon-search icon'></i> {$lang->testcase->bySearch}</a>";
    ?>
  </div>
  <?php if(!isonlybody()):?>
  <div class='btn-toolbar pull-right'>
    <?php if(!empty($productID)): ?>
    <!-- <div class='btn-group'>
      <button type='button' class='btn btn-link dropdown-toggle' data-toggle='dropdown'>
        <i class='icon icon-export muted'></i> <?php echo $lang->export ?>
        <span class='caret'></span>
      </button>
      <ul class='dropdown-menu pull-right' id='exportActionMenu'>
      <?php
      $class = common::hasPriv('testcase', 'export') ? '' : "class=disabled";
      $misc  = common::hasPriv('testcase', 'export') ? "class='export'" : "class=disabled";
      $link  = common::hasPriv('testcase', 'export') ?  $this->createLink('testcase', 'export', "productID=$productID&orderBy=$orderBy&taskID=0&browseType=$browseType") : '#';
      echo "<li $class>" . html::a($link, $lang->testcase->export, '', $misc . "data-app={$this->app->tab}") . "</li>";

      $class = common::hasPriv('testcase', 'exportTemplate') ? '' : "class=disabled";
      $misc  = common::hasPriv('testcase', 'exportTemplate') ? "class='export'" : "class=disabled";
      $link  = common::hasPriv('testcase', 'exportTemplate') ?  $this->createLink('testcase', 'exportTemplate', "productID=$productID") : '#';
      echo "<li $class>" . html::a($link, $lang->testcase->exportTemplate, '', $misc . "data-app={$this->app->tab} data-width='65%'") . "</li>";
      ?>
      </ul>
    </div> -->
    <?php endif;?>
    <?php if(empty($productID) or common::canModify('product', $product)):?>
    <?php if(!empty($productID) and (common::hasPriv('testcase', 'import') or common::hasPriv('testcase', 'importFromLib'))): ?>
    <div class='btn-group'>
      <button type='button' class='btn btn-link dropdown-toggle' data-toggle='dropdown' id='importAction'><i class='icon icon-import muted'></i> <?php echo $lang->import ?><span class='caret'></span></button>
      <ul class='dropdown-menu pull-right' id='importActionMenu'>
      <?php
        echo "<li>" . html::a($this->createlink('ztinterface', 'import', "productID=$productID&branch=$branch"), $lang->ztinterface->jsonImport, '', "class='export' data-app={$app->tab}") . "</li>";?>
      </ul>
    </div>
    <?php endif;?>
    <?php $initModule = isset($moduleID) ? (int)$moduleID : 0;?>
    <div class='btn-group dropdown'>
      <?php
      $createTestcaseLink = $this->createLink('ztinterface', 'create', "productID=$productID&branch=$branch&moduleID=$initModule");
      $buttonLink  = $createTestcaseLink;
      $buttonTitle = $lang->ztinterface->create;
      echo html::a($buttonLink, "<i class='icon-plus'></i> " . $buttonTitle, '', "class='btn btn-primary $hidden' data-app='{$this->app->tab}'");
      ?>
    </div>
    <?php endif;?>
  </div>
  <?php endif;?>
</div>
<?php endif;?>

<?php
$headerHooks = glob(dirname(dirname(__FILE__)) . "/ext/view/featurebar.*.html.hook.php");
if(!empty($headerHooks))
{
    foreach($headerHooks as $fileName) include($fileName);
}
?>
<script>
$(function()
{
    var $allTab           = $('#allTab');
    var $waitTab          = $('#waitTab');
    var $needconfirmTab   = $('#needconfirmTab');
    var $groupTab         = $('#groupTab');
    var $zerocaseTab      = $('#zerocaseTab');
    var $bysuiteTab       = $('#bysuiteTab');
    var $browseunitsTab   = $('#browseunitsTab');
    var hasAllTab         = $allTab.length > 0;
    var hasWaitTab        = $waitTab.length > 0;
    var hasNeedconfirmTab = $needconfirmTab.length > 0;
    var hasGroupTab       = $groupTab.length > 0;
    var hasZerocaseTab    = $zerocaseTab.length > 0;
    var hasbysuiteTab     = $bysuiteTab.length > 0;
    var hasBrowseunitsTab = $browseunitsTab.length > 0;
});
</script>

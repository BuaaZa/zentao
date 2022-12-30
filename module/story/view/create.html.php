<?php
/**
 * The create view of story module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     story
 * @version     $Id: create.html.php 4902 2013-06-26 05:25:58Z wyd621@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include './header.html.php';?>
<?php js::set('page', 'create');?>
<?php js::set('holders', $lang->story->placeholder); ?>
<?php js::set('blockID', $blockID); ?>
<?php js::set('feedbackSource', $config->story->feedbackSource); ?>
<?php js::set('storyType', $type);?>
<?php 
  js::set('requiredFields', $config->story->create->requiredFields);
?>
<?php
foreach(explode(',', $config->story->create->requiredFields) as $field)
{
    if($field and strpos($showFields, $field) === false) $showFields .= ',' . $field;
}
?>
<?php js::set('showFields', $showFields);?>
<?php if(common::checkNotCN()):?>
<style> .sourceTd > .input-group > .input-group > .input-group-addon:first-child{padding: 5px 18px} </style>
<?php endif;?>
<div id="mainContent" class="main-content">
  <div class="center-block">
    <div class="main-header">
      <h2><?php echo ($type=='taskPoint')?$lang->story->createTaskPoint:$lang->story->create;?></h2>
      <?php if(!$this->story->checkForceReview()):?>
      <div class="needNotReviewBox">
        <div class='checkbox-primary'>
          <input id='needNotReview' name='needNotReview' value='1' type='checkbox' class='no-margin' <?php echo $needReview;?>/>
          <label for='needNotReview'><?php echo $lang->story->needNotReview;?></label>
        </div>
      </div>
      <?php endif;?>
      <?php if($type != 'taskPoint'):?>
      <div class="pull-right btn-toolbar">
        <?php $customLink = $this->createLink('custom', 'ajaxSaveCustomFields', 'module=story&section=custom&key=createFields')?>
        <?php include '../../common/view/customfield.html.php';?>
      </div>
      <?php endif;?>
    </div>
    <form class="load-indicator main-form form-ajax" method='post' enctype='multipart/form-data' id='dataform'>
      <table class="table table-form">
        <tbody>
          <?php if($type != 'taskPoint'):?>
          <tr>
            <th><?php echo $lang->story->product;?></th>
            <td colspan="2">
              <div class='input-group'>
              <?php
                $products[""] = "";
                echo html::select('product', $products, '', "onchange=\"loadProduct(this.value);$('#parent_select1').load('/www/api.php/v1/getparenthtml/'+this.value+'?execution='+".$fromExecution.");$('#parent_select2').load('/www/api.php/v1/getparenthtml/'+this.value+'?execution='+".$fromExecution.");\" class='form-control chosen control-product' required");?>
              <span class='input-group-addon fix-border fix-padding'></span>
              <?php if($branches) echo html::select('branch', $branches, $branch, "onchange='loadBranch();' class='form-control chosen control-branch'");?>
              </div>
            </td>
            <td colspan="2">
              <div class='input-group' id='moduleIdBox'>
                <div class="input-group-addon"><?php echo $lang->story->module;?></div>
                <?php
                echo html::select('module', $moduleOptionMenu, $moduleID, "class='form-control chosen'");
                if(count($moduleOptionMenu) == 1)
                {
                    echo "<div class='input-group-addon'>";
                    echo html::a($this->createLink('tree', 'browse', "rootID=$productID&view=story&currentModuleID=0&branch=$branch", '', true), $lang->tree->manage, '', "class='text-primary' data-toggle='modal' data-type='iframe' data-width='90%'");
                    echo '&nbsp; ';
                    echo html::a("javascript:void(0)", $lang->refreshIcon, '', "class='refresh' title='refresh' onclick='loadProductModules($productID)'");
                    echo '</div>';
                }
                ?>
              </div>
            </td>
          </tr>
          <?php else:?>
          <tr>
            <th><?php echo $lang->story->product;?></th>
            <td colspan="4">
              <div class='input-group'>
              <?php
                $products[""] = "";
                echo html::select('product', $products, $productID, "onchange=\"loadProduct(this.value);\" class='form-control chosen control-product' required");?>
              <span class='input-group-addon fix-border fix-padding'></span>
              <?php if($branches) echo html::select('branch', $branches, $branch, "onchange='loadBranch();' class='form-control chosen control-branch'");?>
              </div>
            </td>
          </tr>
          <?php endif;?>
          <?php $hiddenSource = strpos(",$showFields,", ',source,') !== false ? '' : 'hidden';?>
          <?php if($type != 'taskPoint'):?>
          <?php if($type == 'story'):?>
          <tr>
            <th class='planTh'><?php echo $lang->story->planAB;?></th>
            <td colspan="2">
              <div class='input-group' id='planIdBox'>
                <?php
                echo html::select('plan', $plans, $planID, "class='form-control chosen'");
                if(count($plans) == 1)
                {
                    echo "<div class='input-group-btn'>";
                    echo html::a($this->createLink('productplan', 'create', "productID=$productID&branch=$branch", '', true), "<i class='icon icon-plus'></i>", '', "class='btn btn-icon' data-toggle='modal' data-type='iframe' data-width='95%' title='{$lang->productplan->create}'");
                    echo '</div>';
                    echo "<div class='input-group-btn'>";
                    echo html::a("javascript:void(0)", "<i class='icon icon-refresh'></i>", '', "class='btn btn-icon refresh' data-toggle='tooltip' title='{$lang->refresh}' onclick='loadProductPlans($productID)'");
                    echo '</div>';
                }
                ?>
              </div>
            </td>
            <td colspan='<?php echo $type == 'story' ? 2 : 1;?>' id='assignedToBox'>
              <div class='input-group'>
                <div class="input-group-addon assignedTo"><?php echo $lang->story->assignedTo;?></div>
                <?php echo html::select('assignedTo', $users, '', "class='form-control picker-select'");?>
              </div>
            </td>
          </tr>
          <tr class='sourceBox <?php echo $hiddenSource;?>'>
            <th><?php echo $lang->story->source;?></th>
            <td colspan='2'>
              <?php echo html::select('source', $lang->story->sourceList, $source, "class='form-control chosen'");?>
            </td>
            <td colspan="2" class="sourceTd">
              <div class="input-group">
                <div class='input-group-addon' id='sourceNoteBox'><?php echo $lang->story->sourceNote;?></div>
                <?php echo html::input('sourceNote', $sourceNote, "class='form-control'");?>
              </div>
            </td>
            <td colspan="2" id='feedbackBox' class='hidden'>
              <div class="input-group">
                <div class="input-group">
                  <div class="input-group-addon" style="min-width: 77px;"><?php echo $lang->story->feedbackBy;?></div>
                  <?php echo html::input('feedbackBy', '', "class='form-control'");?>
                  <span class='input-group-addon'><?php echo $lang->story->notifyEmail;?></span>
                  <?php echo html::input('notifyEmail', '', "class='form-control'");?>
                </div>
              </div>
            </td>
          </tr>
          <?php else:?>
          <tr>
            <th class='planTh'><?php echo $lang->story->assignedTo;?></th>
            <td colspan='2' id='assignedToBox'>
              <?php echo html::select('assignedTo', $users, '', "class='form-control picker-select'");?>
            </td>
            <td colspan="2" class="sourceTd <?php echo $hiddenSource?> sourceBox">
              <div class="input-group">
                <div class="input-group">
                  <div class="input-group-addon" style="min-width: 77px;"><?php echo $lang->story->source;?></div>
                  <?php echo html::select('source', $lang->story->sourceList, $source, "class='form-control chosen'");?>
                  <span class='input-group-addon' id="sourceNoteBox"><?php echo $lang->story->sourceNote;?></span>
                  <?php echo html::input('sourceNote', $sourceNote, "class='form-control' style='width:140px;'");?>
                </div>
              </div>
            </td>
          </tr>
          <?php endif;?>
          <tr>
            <th><?php echo $lang->story->reviewedBy;?></th>
            <td colspan='2' id='reviewerBox'>
              <div class="table-row">
                <?php $required = $this->story->checkForceReview() ? 'required' : '';?>
                <?php echo $this->story->checkForceReview() ? '' : html::hidden('needNotReview', 1);?>
                <div class="table-col">
                  <?php echo html::select('reviewer[]', $reviewers, empty($needReview) ? $product->PO : '', "class='form-control picker-select' multiple $required");?>
                </div>
              </div>
            </td>
          </tr>
          <?php endif;?>
          <?php
          if($type == 'story' or $type == 'taskPoint'):?>
          <?php if($this->config->URAndSR):?>
          <tr>
            <th><?php echo $lang->story->requirement;?></th>
            <td colspan="2"><?php echo html::select('URS[]', $URS, '', "class='form-control chosen' multiple");?></td>
            <td colspan="2">
              <div class='input-group' id='moduleIdBox'>
                <div class="input-group-addon"><?php echo $lang->story->parent;?></div>
                  <div id='parent_select1'>
                    <?php
                      if($type == 'taskPoint'){ 
                        echo html::select('parent', $stories, $storyID, "class='form-control chosen' required");
                      }else{
                        $stories = array(); 
                        echo html::select('parent', $stories, '', "class='form-control chosen'");
                      }?>
                  </div>
              </div>
            </td>
          </tr>
          <?php else:?>
          <tr>
            <th><?php echo $lang->story->parent;?></th>
            <td colspan="4">
              <div id='parent_select2'>
                <?php
                  if($type == 'taskPoint'){ 
                    echo html::select('parent', $stories, $storyID, "class='form-control chosen' required");
                  }else{
                    $stories = array(); 
                    echo html::select('parent', $stories, '', "class='form-control chosen'");
                  }?>
              </div>
            </td>
          </tr>
          <?php endif;?>
          <?php endif;?>
          <?php if (isset($executionType) and $executionType == 'kanban'):?>
          <tr>
            <th><?php echo $lang->kanbancard->region;?>
            <td colspan="2"><?php echo html::select('region', $regionPairs, $regionID, "onchange='setLane(this.value)' class='form-control chosen'");?></td>
            <td colspan="2">
              <div class='input-group'>
                <div class="input-group-addon"><?php echo $lang->kanbancard->lane;?></div>
                <?php echo html::select('lane', $lanePairs, $laneID, "class='form-control chosen'");?>
              </div>
            </td>
          </tr>
          <?php endif;?>
          <tr>
            <th><?php
              if($type == 'taskPoint'){
                echo $lang->story->taskPointTitle;
              }
              else{
                echo $lang->story->title;
              }
            ?></th>
            <td colspan="4">
              <div class='table-row'>
                <div class='table-col input-size'>
                  <div class="input-control has-icon-right">
                    <?php echo html::input('title', $storyTitle, "class='form-control' required");?>
                    <div class="colorpicker">
                      <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown"><span class="cp-title"></span><span class="color-bar"></span><i class="ic"></i></button>
                      <ul class="dropdown-menu clearfix">
                        <li class="heading"><?php echo $lang->story->colorTag;?><i class="icon icon-close"></i></li>
                      </ul>
                      <input type="hidden" class="colorpicker" id="color" name="color" value="" data-icon="color" data-wrapper="input-control-icon-right" data-update-color="#title"  data-provide="colorpicker">
                    </div>
                  </div>
                </div>
                <?php if($type != 'taskPoint'):?>
                <?php $hiddenPri = strpos(",$showFields,", ',pri,') !== false ? '' : 'hidden';?>
                <div class="table-col categoryBox">
                  <div class="input-group">
                    <span class="input-group-addon fix-border br-0"><?php echo $lang->story->category;?></span>
                    <?php echo html::select('category', $lang->story->categoryList, 'feature', "class='form-control chosen'");?>
                  </div>
                </div>
                <div class="table-col <?php echo $hiddenPri?> priBox">
                  <div class="input-group">
                    <span class="input-group-addon fix-border br-0"><?php echo $lang->story->pri;?></span>
                    <?php
                    $hasCustomPri = false;
                    foreach($lang->story->priList as $priKey => $priValue)
                    {
                        if(!empty($priKey) and (string)$priKey != (string)$priValue)
                        {
                            $hasCustomPri = true;
                            break;
                        }
                    }

                    $priList = $lang->story->priList;
                    if(end($priList)) unset($priList[0]);
                    if(!isset($priList[$pri]))
                    {
                        reset($priList);
                        $pri = key($priList);
                    }
                    ?>
                    <?php if($hasCustomPri):?>
                    <?php echo html::select('pri', (array)$priList, $pri, "class='form-control'");?>
                    <?php else:?>
                    <div class="input-group-btn pri-selector" data-type="pri">
                      <button type="button" class="btn dropdown-toggle br-0" data-toggle="dropdown">
                        <span class="pri-text"><span class="label-pri label-pri-<?php echo empty($pri) ? '0' : $pri?>" title="<?php echo $pri?>"><?php echo $pri?></span></span> &nbsp;<span class="caret"></span>
                      </button>
                      <div class='dropdown-menu pull-right'>
                        <?php echo html::select('pri', (array)$priList, $pri, "class='form-control' data-provide='labelSelector' data-label-class='label-pri'");?>
                      </div>
                    </div>
                    <?php endif;?>
                  </div>
                </div>
                <?php $hiddenEstimate = strpos(",$showFields,", ',estimate,') !== false ? '' : 'hidden';?>
                <div class="table-col <?php echo $hiddenEstimate?> estimateBox">
                  <div class="input-group">
                    <span class="input-group-addon fix-border br-0"><?php echo $lang->story->estimateAB;?></span>
                    <input type="text" name="estimate" id="estimate" value="<?php echo $estimate;?>" class="form-control" autocomplete="off" placeholder='<?php echo $lang->story->hour;?>' />
                  </div>
                </div>
                <?php endif;?>
              </div>
            </td>
          </tr>
          <tr>
            <th><?php echo $lang->story->spec;?></th>
            <td colspan="4">
              <?php echo $this->fetch('user', 'ajaxPrintTemplates', 'type=story&link=spec');?>
              <?php echo html::textarea('spec', $spec, "rows='9' class='form-control kindeditor disabled-ie-placeholder' hidefocus='true' placeholder='" . htmlSpecialString($lang->story->specTemplate . "\n" . $lang->noticePasteImg) . "'");?>
            </td>
          </tr>
          <?php $hiddenVerify = strpos(",$showFields,", ',verify,') !== false ? '' : 'hidden';?>
          <tr class="<?php echo $hiddenVerify;?> verifyBox">
            <th><?php echo $lang->story->verify;?></th>
            <td colspan="4"><?php echo html::textarea('verify', $verify, "rows='6' class='form-control kindeditor' hidefocus='true'");?></td>
          </tr>
          <?php $this->printExtendFields('', 'table', 'columns=4');?>
          <?php if($type != 'taskPoint'):?>
          <tr>
            <th><?php echo $lang->story->legendAttatch;?></th>
            <td colspan='4'><?php echo $this->fetch('file', 'buildform');?></td>
          </tr>
          <?php $hiddenMailto = strpos(",$showFields,", ',mailto,') !== false ? '' : 'hidden';?>
          <tr class="<?php echo $hiddenMailto?> mailtoBox">
            <th><?php echo $lang->story->mailto;?></th>
            <td colspan="4">
              <div class="input-group">
                <?php echo html::select('mailto[]', $users, str_replace(' ' , '', $mailto), "class='form-control picker-select' data-placeholder='{$lang->chooseUsersToMail}' multiple");?>
                <?php echo $this->fetch('my', 'buildContactLists');?>
              </div>
            </td>
          </tr>
          <?php $hiddenKeyWords = strpos(",$showFields,", ',keywords,') !== false ? '' : 'hidden';?>
          <tr class="<?php echo $hiddenKeyWords?> keywordsBox">
            <th><?php echo $lang->story->keywords;?></th>
            <td colspan="4">
              <?php echo html::input('keywords', $keywords, 'class="form-control"');?>
            </td>
          </tr>
          <?php endif;?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="text-center form-actions">
              <?php echo html::hidden('type', $type);?>
              <?php echo html::commonButton($lang->save, "id='saveButton'", 'btn btn-primary btn-wide');?>
              <?php echo $gobackLink ? html::a($gobackLink, $lang->goback, '', 'class="btn btn-wide"') : html::backButton('', $source == 'bug' ? 'data-app=qa' : '');?>
            </td>
          </tr>
        </tfoot>
      </table>
    </form>
  </div>
</div>
<?php js::set('executionID', $objectID);?>
<?php js::set('storyModule', $lang->story->module);?>
<?php js::set('storyType', $type);?>
<script>
$(function(){parent.$('body.hide-modal-close').removeClass('hide-modal-close');})
</script>
<?php include '../../common/view/footer.html.php';?>

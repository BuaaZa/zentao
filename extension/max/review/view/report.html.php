<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php $browseLink = inlink('browse');?>
<div id="mainMenu" class="clearfix">
  <div class="btn-toolbar pull-left">
    <?php echo html::backButton('<i class="icon icon-back icon-sm"></i>' . $lang->goback, '', 'btn btn-secondary')?>
    <div class="divider"></div>
    <div class="page-title">
      <span class="label label-id"><?php echo $review->id?></span>
      <span class="text"><?php echo $review->title . '<i class="icon-angle-right"></i> ' . $lang->review->report->common?></span>
    </div>
    <div class='input-control space w-150px'>
      <?php
      $n = 0;
      foreach($approvalIDList as &$approvalItem)
      {
        $n++;
        $approvalItem = sprintf($lang->review->selectApprovalText, $n);
      }
      ?>
      <?php echo html::select('approval', $approvalIDList, $approvalID, "onchange='changeReview($reviewID, this.value)' class='form-control chosen'");?>
    </div>
  </div>
</div>
<div class='main-row' id='mainContent'>
  <div class='main-col main-table'>
    <div class='cell'>
      <table class='table table-borderless'>
        <tr><th class='text-center' colspan='8' style="font-size:15px;"><?php echo $lang->review->explain;?></th></tr>
        <tr>
          <th colspan='2'><?php echo $lang->review->object;?></th>
          <td colspan='2'><?php echo zget($lang->baseline->objectList, $review->category);?></td>
          <th colspan='2'><?php echo $lang->review->reviewerCount;?></th>
          <td colspan='2'><?php echo $reviewerCount;?></td>
        </tr>
        <tr>
          <th colspan='2'><?php echo $lang->review->reviewedDate;?></th>
          <td colspan='2'><?php echo isset($approvalNode[0]->date) and !helper::isZeroDate($approvalNode[0]->date) ? $approvalNode[0]->date : '';?></td>
          <th colspan='2'><?php echo $lang->review->reviewedHours;?></th>
          <td colspan='2'>
          <?php
          $consumed = 0;
          foreach($approvalNode as $node) $consumed += empty($node->extra) ? 0 : $node->extra;
          echo floor($consumed);
          ?>
          </td>
        </tr>
        <tr>
          <th colspan='2'>
            <?php echo $lang->review->issueCount;?>
            <a data-toggle='tooltip' class='text-help' title='<?php echo $lang->review->issueCountTip;?>'><i class='icon-help'></i></a>
          </th>
          <td colspan='2'><?php echo count($issues);?></td>
          <th colspan='2'>
            <?php echo $lang->review->objectScale;?>
            <a data-toggle='tooltip' class='text-help' title='<?php echo $lang->review->objectScaleTip;?>'><i class='icon-help'></i></a>
          </th>
          <td colspan='2'><?php echo round($objectScale, 2);?></td>
        </tr>
        <tr>
          <th colspan='2'>
            <?php echo $lang->review->issueRate;?>
            <a data-toggle='tooltip' class='text-help' title='<?php echo $lang->review->issueRateTip;?>'><i class='icon-help'></i></a>
          </th>
          <td colspan='2'><?php echo $objectScale == 0 ? 0 : round(count($issues) / $objectScale, 2);?></td>
          <th colspan='2'>
            <?php echo $lang->review->issueFoundRate;?>
            <a data-toggle='tooltip' class='text-help' title='<?php echo $lang->review->issueFoundRateTip;?>'><i class='icon-help'></i></a>
          </th>
          <td colspan='2'><?php echo $consumed == 0 ? 0 : round(count($issues) / $consumed, 2);?></td>
        </tr>
      </table>
    </div>
    <div class='cell'>
    <table class='table table-borderless'>
    <?php if(!empty($issues)):?>
        <tr>
          <th colspan='1'><?php echo $lang->idAB;?></th>
          <th colspan='2'><?php echo $lang->review->issues;?></th>
          <th colspan='2'><?php echo $lang->review->reviewedBy;?></th>
          <th colspan='5'><?php echo $lang->comment;?></th>
        </tr>
        <?php foreach($issues as $issue):?>
        <tr>
          <td colspan='1'><?php echo $issue->id;?></td>
          <td colspan='2'><?php echo $issue->title;?></td>
          <td colspan='2'><?php echo zget($users, $issue->createdBy);?></td>
          <td colspan='5' class="text-ellipsis" title=<?php echo strip_tags($issue->opinion);?>><?php echo $issue->opinion;?></td>
        </tr>
        <?php endforeach;?>
    <?php endif;?>
    <?php if(!empty($approvalNode)):?>
      <table class='table table-borderless'>
        <tr>
          <th colspan='1'><?php echo $lang->review->reviewedDate;?></th>
          <th colspan='2'><?php echo $lang->review->reviewedBy;?></th>
          <th colspan='1'><?php echo $lang->review->reviewResult;?></th>
          <th colspan='1'><?php echo $lang->reviewresult->consumed;?></th>
          <th colspan='5'><?php echo $lang->review->finalOpinion;?></th>
        </tr>
        <?php foreach($approvalNode as $reviewItem):?>
        <tr>
          <td colspan='1'><?php echo !helper::isZeroDate($reviewItem->date) ? $reviewItem->date : '';?></td>
          <td colspan='2'><?php echo zget($users, $reviewItem->reviewedBy);?></td>
          <td colspan='1'><?php echo zget($lang->review->resultList, $reviewItem->result);?></td>
          <td colspan='1'><?php echo $reviewItem->extra;?></td>
          <td colspan='5' class="text-ellipsis" title=<?php echo strip_tags($reviewItem->opinion);?>><?php echo $reviewItem->opinion;?></td>
        </tr>
        <?php endforeach;?>
    <?php endif;?>
        <tr id="resultExplain">
          <th class='text-center' colspan='8'><?php echo $lang->review->resultExplain;?></th>
          <th class='text-center' colspan='2'><?php echo $lang->review->conclusion;?></th>
        </tr>
        <tr>
          <td colspan='8'><?php echo $lang->review->resultExplainList['pass'];?></td>
          <td rowspan='2' colspan='2' class="text-center status-<?php echo $approval->result;?>" style='background: #e3f2fd;'><?php echo zget($lang->review->resultList, $approval->result);?></td>
        </tr>
        <tr>
          <td colspan='8'><?php echo $lang->review->resultExplainList['fail'];?></td>
        </tr>
        <tr>
          <th colspan='2'><?php echo $lang->review->reportCreatedBy;?></th>
          <th colspan='2'><?php echo zget($users, $review->createdBy);?></th>
          <th colspan='2'><?php echo $lang->review->reportApprovedBy;?></th>
          <th colspan='2'>
            <?php
            foreach($reviewer as $account)
            {
                $account = trim($account);
                if(empty($account)) continue;
                echo zget($users, $account) . " &nbsp;";
            }
            ?>
          </th>
        </tr>
      </table>
    </div>
    <!--div class='cell'>
      <table class='table table-borderless'>
        <tr><th class='text-center' colspan='10'><?php echo $lang->review->issue->summary;?></th></tr>
        <tr>
          <th><?php echo $lang->review->issue->id;?></th>
          <th><?php echo $lang->review->issue->desc;?></th>
          <th><?php echo $lang->review->issue->analyse;?></th>
          <th><?php echo $lang->review->issue->introAnalyse;?></th>
          <th><?php echo $lang->review->issue->resolvedBy;?></th>
          <th><?php echo $lang->review->issue->deadline;?></th>
          <th><?php echo $lang->review->issue->resolvedDate;?></th>
          <th><?php echo $lang->review->issue->severity;?></th>
          <th><?php echo $lang->review->issue->verifiedBy;?></th>
          <th><?php echo $lang->review->issue->status;?></th>
        </tr>
      </table>
    </div -->
  </div>
</div>

<script>
function changeReview(reviewID, approvalID)
{
    location.href = createLink('review', 'report', 'reviewID=' + reviewID + '&approvalID=' + approvalID);
}
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

<?php if($module == 'feedback' && $field == 'review'):?>

<?php
$users   = $this->loadModel('user')->getPairs('noclosed|nodeleted');

$this->loadModel('setting');
$configItems  = $this->setting->getItems('owner=system&module=feedback&keys');
foreach($configItems as $configItem)
{
  if($configItem->key == 'forceReview')$forceReview = $configItem->value;
  if($configItem->key == 'needReview')$needReview = $configItem->value;
  if($configItem->key == 'forceNotReview')$forceNotReview = $configItem->value;
  if($configItem->key == 'reviewer')$reviewer = $configItem->value;
}
?>  
<table class='table table-form mw-900px' id='feedbackReview'>
  <tr>
    <th class='thWidth'><?php echo $lang->custom->feedback->fields['review'];?></th>
    <td class='w-350px'><?php echo html::radio('needReview', $lang->custom->reviewList, $needReview);?></td>
    <td></td>
  </tr>
  <tr <?php if($needReview) echo "class='hidden'"?>>
    <th><?php echo $lang->custom->forceReview;?></th>
    <td><?php echo html::select('forceReview[]', $users, $forceReview, "class='form-control chosen' multiple");?></td>
    <td><?php printf($lang->custom->notice->forceReview, $lang->feedback->common);?></td>
  </tr>
  <tr <?php if(!$needReview) echo "class='hidden'"?>>
    <th><?php echo $lang->custom->forceNotReview;?></th>
    <td><?php echo html::select('forceNotReview[]', $users, $forceNotReview, "class='form-control chosen' multiple");?></td>
    <td><?php printf($lang->custom->notice->forceNotReview, $lang->feedback->common);?></td>
  </tr>
  <tr>
    <th><?php echo $lang->feedback->reviewedByAB;?></th>
    <?php $users[''] = $lang->feedback->deptManager;?>
    <td><?php echo html::select('reviewer', $users, $reviewer, "class='form-control chosen'");?></td>
  </tr>
  <tr>
    <td colspan='2' class='text-center'>
      <button id="submit" type="button" class="btn btn-wide btn-primary" data-loading="稍候..."><?php echo $lang->save?></button>
      <!-- <?php echo html::submitButton();?> -->
    </td>
  </tr>
</table>
<?php js::set('saveSetupFlowUrl', $this->createLink('custom', 'ajaxSetupFlow'));?>
<script>
$.fn.serializeObject = function(){
  var obj = new Object();
  var jsonArray = $("form").serializeArray();
  $.each(jsonArray, function() {
      if (obj[this.name] !== undefined) {
          if (!obj[this.name].push) {
              obj[this.name] = [obj[this.name]];
          }
          obj[this.name].push(this.value || '');
      } else {
          obj[this.name] = this.value || '';
      }
  });
  return obj;
}
$(function()
{
    $('.main-form > .main-header ').after($('#feedbackReview'));

    $("input[name='needReview']").change(function()
    {
        if($(this).val() == 0)
        {
            $('#forceReview').closest('tr').removeClass('hidden');
            $('#forceNotReview').closest('tr').addClass('hidden');
        }
        else
        {
            $('#forceReview').closest('tr').addClass('hidden');
            $('#forceNotReview').closest('tr').removeClass('hidden');
        }
    })

    $('#submit').on('click',function(){
      var reqData = $('.main-form').serializeObject();
      $.post(saveSetupFlowUrl,reqData,function(data){
        if(!data){
          alert("返回数据异常");
          return;
        }
        var data = JSON.parse(data);
        if(data && data.result ==='success'){
          alert("保存成功")
        }else{
          alert(data.message)
        }
      });

    })
})
</script>
<?php endif;?>

<?php if($module == 'feedback' && $field == 'closedReasonList'):?>
<script>
$('[name*=systems]').each(function()
{
    if($(this).val() == 1) $(this).closest('tr').find('.icon-close').parent().remove();
})
</script>
<?php endif;?>

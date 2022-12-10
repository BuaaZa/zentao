<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php include $app->getModuleRoot() . 'common/view/datepicker.html.php';?>
<div id="mainContent" class="main-content fade">
  <div class="main-header clearfix">
    <h2 class="pull-left">
      <?php echo $lang->auditplan->batchCreate;?>
    </h2>
  </div>
  <form method='post' class='load-indicator batch-actions-form form-ajax' enctype='multipart/form-data' id="batchCreateForm">
    <div class="table-responsive">
      <table class="table table-form" id="tableBody">
        <thead>
          <tr class='text-center'>
            <th class='w-30px'><?php echo $lang->idAB;?></th>
            <th class='w-150px'><?php echo $lang->auditplan->execution;?></th>
            <th class='w-120px'><?php echo $lang->auditplan->process;?></th>
            <th class='required w-400px' colspan='2'><?php echo $lang->auditplan->objectID;?></span></th>
            <th class='w-200px'><?php echo $lang->auditplan->date;?></th>
            <th class='w-120px'><?php echo $lang->auditplan->assignedTo;?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $executionID = isset($executionID) ? $executionID : '';
          $executions  += array('ditto' => $lang->auditplan->ditto);
          $processes   += array('ditto' => $lang->auditplan->ditto);
          $users       += array('ditto' => $lang->auditplan->ditto);
          ?>
          <?php for($i = 1; $i <= 10; $i++):?>
          <?php
          $executionID = $i == 1 ? $executionID : 'ditto';
          $processesID = $i == 1 ? '' : 'ditto';
          $userID      = $i == 1 ? '' : 'ditto';
          ?>
          <tr>
            <td><?php echo $i;?></td>
            <td><?php echo html::select("execution[$i]", $executions, isset($executionID) ? $executionID : '', "class='form-control chosen'");?></td>
            <td><?php echo html::select("process[$i]", $processes, $processesID, "class='form-control chosen' onchange=changeActivity(this)");?></td>
            <td><?php echo html::select("activity[$i]", '', '', "class='form-control chosen'");?></td>
            <td><?php echo html::select("output[$i]", '', '', "class='form-control chosen'");?></td>
            <td>
              <?php echo html::hidden("dateType[$i]", '1');?>
              <?php echo html::input("checkDate[$i]", '', "class='form-control form-date form-date'");?>
            </td>
            <td><?php echo html::select("assignedTo[$i]", $users, $userID, "class='form-control chosen'");?></td>
          </tr>
          <?php endfor;?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan='7' class='text-center form-actions'>
              <?php echo html::submitButton();?>
              <?php echo html::backButton($lang->goback, "data-app='{$app->tab}'");?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
</div>
<script>
$(function()
{
    removeDitto();
})

function changeActivity(obj)
{
    var i = $(obj).attr('id').replace(/[^0-9]/ig, '');
    var seletedValue = obj.value;

    if(seletedValue === 'ditto')
    {
        for(i; i >= 0; i--)
        {
            var processValue = $('#process' + i +' option:selected').val();
            seletedValue = processValue;
            if(processValue != 'ditto') break;
        }
    }

    for(var n = i; n >= i && n <= 10; n++)
    {
        var processID = $('#process' + n).val();
        if(processID != 'ditto' && n != i) break;

        ((function(n)
        {
            $.get(createLink('auditplan', 'ajaxGetActivity', "projectID=<?php echo $projectID?>&processID=" + seletedValue + '&i=' + n + "&from=<?php echo $from;?>"), function(data){
                $('#activity' + n).replaceWith(data);
                $('#activity' + n + '_chosen').remove();
                $('#activity' + n).chosen();
            })
        }(n)));
    }
}

function getActivity(obj)
{
    var i = $(obj).attr('id').replace(/[^0-9]/ig, '');
    var value = obj.value;
    if(value == 'ditto')
    {
        for(var num = i; num <= i && num > 0; num--)
        {
           var processID = $('#process' + num +' option:selected').val();
           if(processID != 'ditto')
           {
               value = processID;
           }

        }
    }

    var link = createLink('auditplan', 'ajaxGetActivity', "projectID=<?php echo $projectID?>&processID=" + value + '&i=' + i + "&from=<?php echo $from;?>");
    $.get(link, function(data)
    {
        $('#activity' + i).replaceWith(data);
        $('#activity' + i + '_chosen').remove();
        $('#activity' + i).chosen();
    })
}

function getOutput(obj)
{
    var i = $(obj).attr('id').replace(/[^0-9]/ig, '');
    var link = createLink('auditplan', 'ajaxGetOutput', "projectID=<?php echo $projectID?>&activityID=" + obj.value + '&i=' + i);
    $.get(link, function(data)
    {
        $('#output' + i).replaceWith(data);
        $('#output' + i + '_chosen').remove();
        $('#output' + i).chosen();
    })
}

$('select[id^="process"]').each(function()
{
    getActivity(this);
})
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

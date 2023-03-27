<?php echo html::hidden('feedbackID', '');?>
<div class="modal fade" id="toTask">
  <div class="modal-dialog mw-500px">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $lang->feedback->selectProjects;?></h4>
      </div>
      <div class="modal-body">
        <table class='table table-form'>
          <?php if($this->config->systemMode == 'new'):?>
          <tr>
            <th><?php echo $lang->feedback->project;?></th>
            <td><?php echo html::select('taskProjects', $projects ? $projects : array(), '', "class='form-control chosen'");?></td>
          </tr>
          <tr>
            <th id='executionHead'><?php echo $lang->feedback->execution;?></th>
            <td><?php echo html::select('executions', '', '', "class='form-control chosen'");?></td>
          </tr>
          <?php else:?>
          <tr>
            <th><?php echo $lang->execution->common;?></th>
            <td><?php echo html::select('executions', '', '', "class='form-control chosen'");?></td>
          </tr>
          <?php endif;?>
          <tr>
            <td colspan='2' class='text-center'>
              <?php echo html::commonButton($lang->feedback->nextStep, "id='taskProjectButton'", 'btn btn-primary btn-wide');?>
              <?php echo html::commonButton($lang->cancel, "data-dismiss='modal'", 'btn btn-default btn-wide');?>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<?php js::set('systemMode', $this->config->systemMode);?>
<script>

// 清空
function emptySelect(id){
    $(`#${id}`).replaceWith(`<select name='${id}' id='${id}' class='form-control'></select>`);
    $(`#${id}_chosen`).remove();
    $(`#${id}`).chosen();
}

function getFeedbackID(obj)
{
    emptySelect('taskProjects');
    emptySelect('executions');
    var feedbackID = $(obj).attr("data-id");
    $('#feedbackID').val(feedbackID);
    if(systemMode == 'new')
    {
        $('#taskProjects').change();
        getProjects(obj);
        // getExecutions(0);
    }
    else
    {
        var projectID  = $(obj).attr("data-product");
        // getExecutions(projectID);
    }
}

function loadProductExecutions(projectID,value){
        getExecutions(projectID,value);
}

function getProjects(obj)
{
    var productID = $(obj).attr("data-product");
    var link      = createLink('feedback', 'ajaxGetProjects', 'productID=' + productID + '&field=taskProjects');

    $.post(link, function(data)
    {
        $('#taskProjects').replaceWith(data);
        $('#taskProjects_chosen').remove();
        $('#taskProjects').chosen();
    })
}

function getExecutions(projectID,value)
{
    if(systemMode == 'new' && projectID)
    {
        var langLink = createLink('feedback', 'ajaxGetExecutionLang', 'projectID=' + projectID);
        $.post(langLink, function(executionLang)
        {
          if(executionLang){
            $('#executionHead').html(executionLang);
          }
        })
    }

    var link = createLink('feedback', 'ajaxGetExecutions', 'productID=' + projectID+'&projectID='+value);

    $.post(link, function(data)
    {
        $('#executions').replaceWith(data);
        $('#executions_chosen').remove();
        $('#executions').chosen();
    })
}

$('#taskProjectButton').on('click', function()
{
    var projectID   = $('#project').val();
    var executionID = $('#execution').val();
    var feedbackID  = $('#feedbackID').val();
    var executionID = executionID ? parseInt(executionID) : 0;

    if(systemMode == 'new' && projectID && executionID)
    {
        location.href = createLink('feedback', 'toTask', 'executionID=' + executionID + '&storyID=0&moduleID=0&taskID=0&todoID=0&extra=projectID=' + projectID + ',feedbackID=' + feedbackID) + '#app=feedback';
    }
    else if(systemMode == 'classic' && executionID)
    {
        location.href = createLink('feedback', 'toTask', 'executionID=' + executionID + '&storyID=0&moduleID=0&taskID=0&todoID=0&extra=projectID=0,feedbackID=' + feedbackID) + '#app=feedback';
    }
    else if(!executionID)
    {
        alert('<?php echo $lang->feedback->noExecution;?>');
    }
    else
    {
        alert('<?php echo $lang->feedback->noProject;?>');
    }
});
</script>

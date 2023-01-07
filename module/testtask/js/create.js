/**
 * Load execution related builds
 *
 * @access public
 * @return void
 */
function loadProductRelated()
{
    loadExecutions($('#product').val());
    loadTestReports($('#product').val());
    buildData = '<select id="build" name="build" class="form-control"></select>';
    $('#build').replaceWith(buildData);
    $('#build_chosen').remove();
    $("#build").chosen();
    $('#build').trigger("chosen:updated");
}

/**
 * Load executions.
 *
 * @param  int    productID
 * @access public
 * @return void
 */
function loadExecutions(productID)
{
    link = createLink('product', 'ajaxGetExecutions', 'productID=' + productID + '&projectID=' + projectID + '&branch=');
    $.get(link, function(data)
    {
        if(!data) data = '<select id="execution" name="execution" class="form-control"></select>';
        $('#execution').replaceWith(data);
        $('#execution_chosen').remove();
        $("#execution").chosen();
    });
}

function loadTestParent(productID)
{
    link = createLink('testtask', 'ajaxGetTestParent', 'productID=' + productID + '&projectID=' + projectID + '&executionID=' + $('#excution').val());
    $.get(link, function(data)
    {
        if(!data) data = '<select id="execution" name="execution" class="form-control"></select>';
        $('#parent').replaceWith(data);
        $('#parent_chosen').remove();
        $("#parent").chosen();
    });
}

function loadTestEParent(executionID)
{
    link = createLink('testtask', 'ajaxGetTestParent', 'productID=' + $('#product').val() + '&projectID=' + projectID + '&executionID=' + executionID);
    $.get(link, function(data)
    {
        if(!data) data = '<select id="execution" name="execution" class="form-control"></select>';
        $('#parent').replaceWith(data);
        $('#parent_chosen').remove();
        $("#parent").chosen();
    });
}

// function checkUsecase(taskID){
//     link = createLink('testtask', 'ajaxCheckUsecase', 'taskID=' + taskID);
//     $.get(link, function(data)
//     {
//         if(!data || data == "false"){
//             var t = document.getElementById('case_select');
//             t.style.display = 'none';
//         }else{
//             var t = document.getElementById('case_select');
//             t.style.display = 'block';
//         }
//     });
// }

/* If the mouse hover over the manage contacts button, give tip. */
$(function()
{
    adjustPriBoxWidth();
    if($('#execution').val() != 0) loadExecutionBuilds($('#execution').val());
});

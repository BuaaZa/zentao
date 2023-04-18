/**
 * Confirm batch delete cases.
 *
 * @param  string $actionLink
 * @access public
 * @return void
 */
function confirmBatchDelete(actionLink)
{
    if(confirm(batchDelete)) setFormAction(actionLink);
    return false;
}

$(function()
{
    if($('#interfaceList thead th.c-title').width() < 150) $('#interfaceList thead th.c-title').width(150);

    /* The display of the adjusting sidebarHeader is synchronized with the sidebar. */
    $(".sidebar-toggle").click(function()
    {
        $("#sidebarHeader").toggle("fast");
    });
    if($("main").is(".hide-sidebar")) $("#sidebarHeader").hide();

    $('#importToLib').on('click', function()
    {
        var storyIdList = '';
        $("input[name^='caseIDList']:checked").each(function()
        {
            storyIdList += $(this).val() + ',';
            $('#caseIdList').val(storyIdList);
        });
    });
});


$(function()
{
    if($('#bugList thead th.c-title').width() < 150) $('#bugList thead th.c-title').width(150);

    /* The display of the adjusting sidebarHeader is synchronized with the sidebar. */
    $(".sidebar-toggle").click(function()
    {
        $("#sidebarHeader").toggle("fast");
    });
    if($("main").is(".hide-sidebar")) $("#sidebarHeader").hide();

    $('#bugList').on('change', "[name='bugIDList[]']", checkClosed);
});

/**
 * Closed bugs are not assignable.
 *
 * @access public
 * @return void
 */
function checkClosed()
{
    var disabledAssigned = $('#bugList tr.checked .c-assignedTo a').length > 0 ? true : false;
    $('#bugList tr.checked .c-assignedTo a').each(function()
    {
        if(!$(this).hasClass('disabled'))
        {
            disabledAssigned = false;
            return false;
        }
    });

    $('#mulAssigned').prop('disabled', disabledAssigned);
}

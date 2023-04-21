$(document).ready(function()
{
    $.get("pathinfo.php", function(result)
    {
        $('#requestType').val('PATH_INFO');
    });
});

$(function()
{
    $('#installType').change(function()
    {
        if ($(this).val() !== 'install')
            $('#step2_js_clearDB').css("display", "none");
        else
            $('#step2_js_clearDB').css("display", "block");
    });
})

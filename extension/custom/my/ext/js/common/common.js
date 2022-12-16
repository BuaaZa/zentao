$(function()
{
    if(typeof mode === 'string')
    {
        if(typeof rawMethod === 'string' && rawMethod == 'work')
        {
            $("#subNavbar li[data-id='feedback'] a").append('<span class="label label-light label-badge">' + feedbackCount + '</span>');
        }
    }
});
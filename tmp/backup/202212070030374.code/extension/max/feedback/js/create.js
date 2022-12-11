$(function()
{
    $('#navbar ul.nav li[data-id="unclosed"]').addClass('active');

    $.get(createLink('feedback', 'ajaxGetStatus', 'methodName=create'), function(status)
    {
        $('#status').val(status).change();
    });

    /* Init pri. */
    $('#pri').on('change', function()
    {
        var $select = $(this);
        var $selector = $select.closest('.pri-selector');
        var value = $select.val();
        $selector.find('.pri-text').html('<span class="label-pri label-pri-' + value + '" title="' + value + '">' + value + '</span>');
    });
});

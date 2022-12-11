$(function()
{
    /* Set default tab. */
    if($.cookie('recordEstimateType') == 'all')
    {
        $('#createEffort').addClass('hidden');
        $('.my-effort, #legendMyEffort').removeClass('active');
        $('.all-effort, #legendAllEffort').addClass('active');
    }
    else
    {
        $('.my-effort, #legendMyEffort').addClass('active');
        $('#createEffort').removeClass('hidden');
    }
    $.cookie('recordEstimateType', null);

    $('.order-btn').on('click', function()
    {
        $.cookie('recordEstimateType', 'all');
    });

    /* Hide creation logs when displaying team logs. */
    $('#linearefforts .tabs ul > li').click(function()
    {
        var tab = $(this).find('a').attr('href');
        $('#createEffort').toggleClass('hidden', tab == '#legendAllEffort');
    });

    $("#submit").click(function(e, confirmed)
    {
        if(confirmed) return true;

        var $this = $(this);
        var hasZero = false;
        var $left   = $("input[name^='left']");
        $left.each(function()
        {
            if($(this).attr('disabled') != 'disabled' && !$(this).prop('readonly') && parseFloat($(this).val(), 10) === 0) hasZero = true;
        })
        if(hasZero)
        {
            e.preventDefault();
            bootbox.confirm(noticeFinish, function(result)
            {
                if(!result) $this.attr("disabled", false);
                if(result) $this.trigger('click', true);
            });
            return false;
        }
    });

    if(objectType == 'task' || objectType == 'story') $('.form-date').datetimepicker('setEndDate', today);

    $('#objectTable .showinonlybody').each(function()
    {
        $(this).click(function()
        {
            var hasRecord = false;
            $('#objectTable').find('input[name^="consumed"], input[name^="left"], input[name^="work"]').each(function()
            {
                if($(this).val() !== '')
                {
                    hasRecord = true;
                    return false;
                }
            });
            if(hasRecord)
            {
                alert(noticeSaveRecord);
                return false;
            }
        });
    });

    $('.btn-back').click(function()
    {
        $.closeModal();
        return false;
    });

    $('.table-record .date-group .input-group-addon').on('click', function()
    {
        $(this).prev().datetimepicker('show');
    });
})

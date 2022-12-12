$(function()
{
    if(window.self == window)
    {
        $("a[data-dismiss='modal']").addClass('hidden');
    }    

    $(document).off('click', '.deleteLeave');
    $(document).off('click', '.reviewPass');

    href = $('a.deleteLeave').attr('href');
    $('a.deleteLeave').attr('href', '###').attr('data-href', href);
    $(document).on('click', '.deleteLeave', function()
    {
        if(confirm(lang.confirmDelete))
        {
            $(this).text(lang.deleting);
            $.getJSON($(this).attr('data-href'), function(data)
            {
                if(data.result == 'success')
                {
                    if(data.locate) return location.href = data.locate + (data.locate.indexOf('?') > 0 ? '&' : '?') + 'onlybody=yes';
                    return location.reload();
                }
                else
                {
                    alert(data.message);
                    if(selecter.parents('#ajaxModal').size()) return $.reloadAjaxModal(1200);
                    return location.reload();
                }
            });
        }
        return false;
    });

    href = $('a.reviewPass').attr('href');
    $('a.reviewPass').attr('href', '###').attr('data-href', href);
    $(document).on('click', '.reviewPass', function()
    {
        if(confirm(confirmReview.pass))
        {
            var selecter = $(this);

            $.getJSON(selecter.attr('data-href'), function(data)
            {
                if(data.result == 'success')
                {
                    if(data.locate) return location.href = data.locate;
                    return location.reload();
                }
                else
                {
                    alert(data.message);
                    return location.reload();
                }
            });
        }
        return false;
    });
})

$(function()
{
    var editURL = $('.modal-body .page-actions > .btn-group > .loadInModal').attr('href');
    if(editURL) $('.modal-body .page-actions > .btn-group > .loadInModal').attr('href', editURL + (editURL.indexOf('?') > 0 ? '&' : '?') + 'onlybody=yes');

    var rejectURL = $('.modal-body .page-actions > .loadInModal').attr('href');
    if(rejectURL) $('.modal-body .page-actions > .loadInModal').attr('href', rejectURL + (rejectURL.indexOf('?') > 0 ? '&' : '?') + 'onlybody=yes');

    $(document).off('click', '.deleteOvertime');
    $(document).off('click', '.reviewPass');

    href = $('a.deleteOvertime').attr('href');
    $('a.deleteOvertime').attr('href', '###').attr('data-href', href);
    $(document).on('click', '.deleteOvertime', function()
    {
        if(confirm(lang.confirmDelete))
        {
            $(this).text(lang.deleting);
            $.getJSON($(this).attr('data-href'), function(data)
            {
                if(data.result == 'success')
                {
                    if(data.locate) return location.href = data.locate;
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

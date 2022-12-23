$(function()
{
    $('#hostID').change(function()
    {
        var hostID = $('#hostID').val();
        var link   = createLink('vm', 'ajaxGetTemplatesByApi', 'hostID=' + hostID);
        $.get(link, function(data)
        {
            $('#template').html('').append(data);
            $('#templateName').chosen().trigger("chosen:updated");
        });
    });

    $('#osCategory').change(function()
    {
        var os = $('#osCategory').val();
        $('#osType').empty();
        var types = vmConfig.os.type[os];
        for(code in types) $('#osType').append('<option value="' + code + '">' + types[code] + '</option>');
        if(template) $('#osType').val(template.osType);
        $('#osType').chosen().trigger('chosen:updated');
        $('#osType').change();
    });

    $('#osType').change(function()
    {
        var type = $('#osType').val();
        $('#osVersion').empty();
        var versions = vmLang.versionList[type];
        for(code in versions) $('#osVersion').append('<option value="' + code + '">' + versions[code] + '</option>');
        if(template) $('#osVersion').val(template.osVersion);
        $('#osVersion').chosen().trigger('chosen:updated');
        $('#osVersion').change();
    });

    $('#osVersion').change(function()
    {
        if(config.currentMethod != 'create') return;

        var os      = $('#osCategory').val();
        var type    = $('#osType').val();
        var version = $('#osVersion').val();
        var link    = createLink('vm', 'ajaxGetVmTemplateList', 'osCategory=' + os + '&osType=' + type + '&osVersion=' + version);
        $.get(link, function(data)
        {
            $('#template').html('').append(data);
            if(template) $('#vmTemplate').val(template.id);
            $('#vmTemplate').chosen().trigger("chosen:updated");
        });
    });

    if(typeof templateID == 'undefined' || !templateID) $('#osCategory').change();
})

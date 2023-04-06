$(function()
{
    var presetObjectType = ['testtask',  'execution',  'project'];

    $('#mainContent .main-header h2 #selectObjectType').change(function()
    {
        var typeID = $(this).prop('selectedIndex');
        if(typeID>=0 && typeID<=2){
            location.href = createLink('testreport', 'create', 'objectID=0&objectType=' + presetObjectType[typeID] +'&productID=' + extra);
            return false;
        }
    });

    $('#mainContent .main-header h2 #selectTask').change(function()
    {
        var taskID = $(this).val();
        var typeID = $('#mainContent .main-header h2 #selectObjectType').prop('selectedIndex');
        if(typeID<0 && typeID>2){
            typeID = 0;
        }
        if(taskID)
        {
            location.href = createLink('testreport', 'create', 'objectID=' + taskID + '&objectType=' + presetObjectType[typeID] + '&productID=' + extra);
            return false;
        }
    });
})

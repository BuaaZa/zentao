function changeDate(executionID, date)
{
    if(date.indexOf('-') != -1)
    {
        var datearray = date.split("-");
        var date = '';
        for(i=0 ; i<datearray.length ; i++)
        {
            date = date + datearray[i];
        }
    }
    link = createLink('execution', 'effort', 'executionID=' + executionID + '&date=' + date);
    location.href=link;
}

function changeUser(executionID, date, userID)
{
    if(date.indexOf('-') != -1)
    {
        var datearray = date.split("-");
        var date = '';
        for(i=0 ; i<datearray.length ; i++)
        {
            date = date + datearray[i];
        }
    }
    link = createLink('execution', 'effort', 'executionID=' + executionID + '&date=' + date + '&userID=' + userID);
    location.href = link;
}

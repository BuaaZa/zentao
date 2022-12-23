<?php
$feedbackPairs = array();
foreach($users as $user) $feedbackPairs[] = !empty($user->feedback);
js::set('feedbackPairs', $feedbackPairs);
?>
<script>
<?php if(!empty($_SESSION['user']->feedback) or !empty($_COOKIE['feedbackView'])):?>
$('#sidebar').remove();
$('#sidebarHeader').remove();
<?php endif;?>
$(function()
{
    $('#userListForm table tbody tr').each(function(i)
    {
        var $account = $(this).find('td.cell-id').next();
        if($account.size() > 0)
        {
            isFeedback = feedbackPairs[i];
            if(isFeedback) $account.append("<span class='label label-info'><?php echo $lang->user->feedbackAB?></span>");
        }
    })
});
</script>

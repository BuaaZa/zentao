<?php if($config->systemMode == 'classic' and strpos(',testtask,testcase,task,bug,build,', ",{$action->module},") !== false and $action->buildin == 0 && $mode == 'edit'):?>
<style>
tr[data-field=project] {display:none;}
</style>
<?php endif;?>
<?php if(isset($action) && $action->buildin && $action->method == 'view'):?>
<script>
$(function()
{
    $('.form-actions a[href*=block]').remove();
})
</script>
<?php endif;?>

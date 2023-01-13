<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/datepicker.html.php'; ?>
<?php //js::set('noTodo', $lang->todo->noTodo); ?>
<?php //js::set('moduleList', $config->todo->moduleList) ?>
<?php //js::set('objectsMethod', $config->todo->getUserObjectsMethod) ?>
<?php //js::set('nameBoxLabel', array('custom' => $lang->todo->name, 'idvalue' => $lang->todo->idvalue)); ?>
<?php //js::set('vision', $config->vision); ?>
<?php //js::set('noOptions', $lang->todo->noOptions); ?>
<?php //js::set('chosenType', $lang->todo->typeList); ?>
<div id='mainContent' class='main-content'>
    <div class='center-block'>
        <div class='main-header'>
            <h2><?php echo $lang->company->archiveaction; ?></h2>
        </div>
        <form method='post' target='hiddenwin' id='dataform'>
            <table class='table table-form'>
                <tr>
                    <th class='c-name'><?php echo $lang->company->beginDay;?></th>
                    <td class='c-fileName'>
                        <div class='input-group'>
                            <?php echo html::input('beginDate',helper::today(), "class='form-control text-center form-date'");?>
                            <span class='input-group-addon'><i class='icon icon-calendar'></i></span>
                        </div>
                    </td><td></td>
                    <th class='c-name'><?php echo $lang->company->endDay;?></th>
                    <td class='c-fileName'>
                        <div class='input-group'>
                            <?php echo html::input('endDate',helper::today(), "class='form-control text-center form-date'");?>
                            <span class='input-group-addon'><i class='icon icon-calendar'></i></span>
                        </div>
                    </td><td></td>
                </tr>

            </table>
            <br><br><br>
            <div class='table-footer text-center form-actions'>
                <?php echo html::submitButton() ; ?>
                <?php echo html::backButton('', '', 'btn btn-wide') ; ?>
            </div>
            <br><br><br><br><br>
        </form>
    </div>
</div>

<script>
    var today = '<?php echo date('Y-m-d')?>';
</script>
<?php include '../../common/view/footer.lite.html.php'; ?>

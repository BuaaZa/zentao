<?php include '../../common/view/header.html.php'; ?>
<?php include '../../common/view/datepicker.html.php'; ?>
<div id='mainContent' class='main-content'>
    <div class='center-block'>
        <div class='main-header'>
            <h2><?php echo $lang->company->recoveraction; ?></h2>
        </div>
        <h4><?php echo $lang->company->archivedDays; ?></h4>
        <form method='post' target='hiddenwin' id='dataform'>
            <table class='table table-form' border = '1'>
                <tr>
                    <td><?php echo $lang->company->beginDay; ?></td>
                    <td><?php echo $lang->company->endDay; ?></td>
                </tr>
<!--                <tr>--><?php //print_r($ranges); ?><!--</tr>-->
                <?php foreach ($ranges as $range): ?>
                <tr>
                <td><?php echo $range->start; ?></td>
                <td><?php echo $range->end; ?></td>
                </tr>
                <?php endforeach; ?>
            </table><br><br><br>
            <h4><?php echo $lang->company->recoverRange; ?></h4>
            <div class='input-group'>
                <?php echo html::input('beginDate',helper::today(), "class='form-control text-center form-date'");?>
                <span class='input-group-addon'><i class='icon icon-calendar'></i></span>
            </div>
            <br>
            <div class='input-group'>
                <?php echo html::input('endDate',helper::today(), "class='form-control text-center form-date'");?>
                <span class='input-group-addon'><i class='icon icon-calendar'></i></span>
            </div>
            <div class='table-footer text-center form-actions'>
                <?php echo html::submitButton('恢复') ; ?>
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


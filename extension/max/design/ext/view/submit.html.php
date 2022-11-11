<?php include $app->getModuleRoot() . 'common/view/header.lite.html.php';?>
<main id="main">
  <div class="container">
    <div id="mainContent" class='main-content load-indicator'>
      <div class='main-header'>
        <h2><?php echo $lang->design->submit;?></h2>
      </div>
      <form class='main-form' method='post' target='hiddenwin'>
        <table class="table table-form">
          <tr>
            <th class='text-nowrap'><?php echo $lang->design->reviewObject;?></th>
            <td colspan="2">
              <?php echo html::select('object', array_filter($lang->design->typeList), '', "class='form-control chosen'");?>
            </td>
            <td></td>
          </tr>
          <tr>
            <th class='text-nowrap'><?php echo $lang->design->reviewRange;?></th>
            <td colspan="2">
              <?php echo html::select('range', $lang->exportTypeList, '', "class='form-control chosen'");?>
            </td>
            <td></td>
          </tr>
          <tr>
            <th></th>
            <td><?php echo html::submitButton('', '', 'btn btn-primary');?></td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</main>
<?php include $app->getModuleRoot() . 'common/view/footer.lite.html.php';?>

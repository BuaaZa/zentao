<?php
/**
 * The suspend file of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang<wwccss@gmail.com>
 * @package     project
 * @version     $Id: suspend.html.php 935 2013-01-16 07:49:24Z wwccss@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('urls', $baseURLList);?>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2>
      <?php echo "<span title='$product->name'>" . $product->name . '-基地址</span>'; ?>
    </h2>
  </div>
  <form class='load-indicator main-form' method='post' target='hiddenwin'>
    <table class='table table-form'>
      <tr>
        <th class='w-120px'><?php echo "新建/修改"?></th>
        <td colspan='7'><?php echo html::select('method', $baseURLPairs, 0,"class='form-control chosen'");?></td>
      </tr>
      <tr>
        <th class='w-120px'><?php echo "名称"?></th>
        <td colspan='6'>
            <?php echo html::input('name', "", "class='form-control'");?>
        </td>
        <td><input tabindex='-1' id="delete" name="delete" disabled type="checkbox" class='notNull'>删除该条目</input></td>
      </tr>
      <tr>
        <th class='w-120px'><?php echo "基地址"?></th>
        <td colspan='7'><?php echo html::input('url', "", "class='form-control'");?></td>
      </tr>
      <tr>
        <td colspan='8' class='text-center form-actions'>
          <?php echo html::submitButton();?>
        </td>
      </tr>
    </table>
  </form>
</div>
<?php include '../../common/view/footer.html.php';?>

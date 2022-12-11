<?php
/**
 * The admin view file of feedback module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     feedback
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include $app->getModuleRoot() . 'common/view/header.html.php';?>
<div id="mainMenu" class="clearfix">
  <span class='label label-info'><?php echo $lang->feedback->hasPrivUser;?></span>
</div>
<div id='mainContent' class='main-table'>
  <table class='table table-fixed tablesorter table-datatable'>
    <thead>
      <tr>
        <th class='w-160px'>
          <?php echo $lang->productCommon;?>
        </th>
        <th><?php echo $lang->user->common;?></th>
        <th class='w-60px c-actions text-left'><?php echo $lang->actions?></th>
      </tr>
    </thead>
    <?php if($products):?>
    <tbody>
      <?php foreach($products as $productID => $productName):?>
      <tr class='text-left'>
        <td title='<?php echo $productName;?>' class='c-name'><?php echo $productName;?></td>
        <?php
        $authorizedUser = '';
        if(isset($feedbackView[$productID]))
        {
            foreach($feedbackView[$productID] as $account => $view)
            {
                if(!isset($users[$account])) continue;
                $user = $users[$account];
                $authorizedUser .= empty($user->realname) ? ',' . $account : ',' . $user->realname;
            }
            $authorizedUser = substr($authorizedUser, 1);
        }
        ?>
        <td class='text-left text-ellipsis' title='<?php echo $authorizedUser;?>'>
        <?php echo $authorizedUser;?>
        </td>
        <td class='c-actions'>
          <?php common::printLink('feedback', 'manageProduct', "product=$productID", "<i class='icon-group-managepriv icon-lock'></i>", '', "class='iframe btn' title='{$lang->feedback->manageProduct}'", '', true);?>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <?php endif;?>
  </table>
  <div class='table-footer'><?php $pager->show('right', 'pagerjs');?></div>
</div>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php';?>

<?php
/**
 * The runrun view file of testtask of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     testtask
 * @version     $Id: runcase.html.php 4723 2013-05-03 05:19:29Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<?php //js::set('caseResultSave', $lang->save);?>
<?php //js::set('tab', $app->tab);?>
<div id='mainContent' class='main-content'>
    <div class='main-header'>
        <h2>
            <span class='label label-id'><?php echo $case->id;?></span>
            <span title='<?php echo $case->title?>'>
                <?php echo $case->title;?>数据样本#步骤<?php echo $sample->casestep_level?>
            </span>
        </h2>
    </div>
    <table id="testTable" class='table table-form mg-0 table-bordered' style='border: 1px solid #ddd'>
        <tr>
            <td><b>数据输入项名称</b></td>
            <td><b>MOCK规则</b></td>
            <td><b>是否必填</b></td>
            <?php
                //for ($i = 1; $i < count($table[0]); $i++)
                  //  echo "<td><b>样本" . $i . "</b></td>"
            ?>
        </tr>
        <?php foreach ($table as $row):?>
        <tr>
            <?php foreach ($row as $item):?>
            <td>
                <?php echo $item; ?>
            </td>
            <?php endforeach;?>
        </tr>
        <?php endforeach;?>
    </table>
    <div class='main' id='resultsContainer'></div>
</div>
<?php include '../../common/view/footer.lite.html.php';?>

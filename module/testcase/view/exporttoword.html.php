<?php
/**
 * The importfromlib view file of testcase module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     testcase
 * @version     $Id
 * @link        http://www.zentao.net
 */
?>

<?php include '../../common/view/header.lite.html.php';?>
<script>
    function setDownloading()
    {
        if(navigator.userAgent.toLowerCase().indexOf("opera") > -1) return true;   // Opera don't support, omit it.

        $.cookie('downloading', 1);
        time = setInterval("closeWindow()", 300);
        return true;
    }

    function closeWindow()
    {
        if($.cookie('downloading') == 1)
        {
            parent.$.closeModal();
            $.cookie('downloading', null);
            clearInterval(time);
        }
    }
</script>
<div id='mainContent' class='main-content'>
    <div class='main-header'>
        <h2>导出用例</h2>
    </div>

    <form method='post' target='hiddenwin' onsubmit='setDownloading();' style='padding: 40px 25%'>
        <table class='w-p100'>
            <tr>
                <td class='w-100px'>
                    <?php echo html::select('', $lang->testcase->exportCaseTypetList, 'word', "class='form-control'");?>
                </td>
                <td>
                    <?php echo html::submitButton();?>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include '../../common/view/footer.lite.html.php';?>

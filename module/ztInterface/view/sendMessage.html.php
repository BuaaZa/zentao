<?php
/**
 * The edit file of case module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     case
 * @version     $Id: edit.html.php 5000 2013-07-03 08:20:57Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::set('page', 'send');?>
<?php js::set('interfaceID', $interface->id);?>
<?php js::set('tab', $this->app->tab);?>
<?php js::set('confirmUnlinkTesttask', $lang->testcase->confirmUnlinkTesttask);?>
<style>
  th {
  text-align: center;
}
.no-data-message {
  text-align: center;
  background-color: #f5f5f5;
  color: #7f8c8d;
  font-size: 0.8em;
  padding: 5px;
}
.header-value {
  resize:none;
}
.notNull {
  width: 20px;
  height: 20px;
  margin: auto;
  padding: 0;
  display: inline-block;
  vertical-align: middle;
}
.icon-angle-right{
  background-color: transparent;
  border: none;
  outline: none;
}
.icon-angle-down{
  background-color: transparent;
  border: none;
  outline: none;
}
.innerbtn{
  width:20px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.generate-button {
  padding: 10px 20px;
  border: none;
  background-color: #0077ff;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
}

</style>
<div id='mainContent' class='main-content'>
  <div class='main-header'>
    <h2>
      <?php echo "<b style=\"margin-right: 10px;font-size: 1.3em;color:{$this->lang->ztinterface->methodColor[$interface->method]};\">$interface->method</b>";?>
      <?php echo "<b style=\"font-size: 1.3em;\">$interface->name</b>";?>
    </h2>
  </div>
  <form method='post' enctype='multipart/form-data' target='hiddenwin' id='dataform'>
    <div class='main-row'>
      <div class='main-col col-7'>
        <div class='cell'>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->url;?></div>
            <div class="detail-content">
              <div class="input-control" style="display: flex; align-items: center;">
                <?php #echo '<span style="font-size: 1.3rem; letter-spacing: 0.05em;">' . $interface->url . '</span>';?>
                <?php echo html::input('baseURL', '', 'class="form-control" style="width: 60%;" list="baseUrlList" placeholder="' . $lang->ztinterface->baseUrl . '"');?>
                <?php echo html::input('URL', $interface->url, 'class="form-control" style="width: 40%;" disabled title="接口文档中指定"');?>
                <?php echo $baseURLList;?>
              </div>
            </div>
          </div>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->head;?></div>
            <div class='detail-content'>
              <table class='table table-form table-bordered'>
                <thead>
                  <tr>
                    <th width="40%"><?php echo $lang->ztinterface->key?></th>
                      <th width="100px"><?php echo $lang->ztinterface->type;?></th>
                      <!-- <th width="50px"><?php echo $lang->ztinterface->canNull;?></th> -->
                      <!-- <th width="15%"><?php echo $lang->ztinterface->mock;?></th> -->
                      <th><?php echo $lang->ztinterface->value;?></th>
                  </tr>
                </thead>
                <tbody id='headers' class='table table-form' data-group-name='<?php echo $lang->testcase->groupName ?>'>
                  <?php if(empty($header["content"])):?>
                    <tr>
                      <td colspan="3" class="no-data-message"><?php echo $lang->ztinterface->noHeaders?></td>
                    </tr>
                  <?php else:?>
                    <?php foreach($header["content"] as $id => $message):?>
                    <tr class='header-key'>
                      <td>
                        <b><?php echo $message["name"];?></b>
                        <?php if(!empty($message["description"])){
                            echo "<span style=\"color: #888888;\">({$message["description"]})</span>";
                          }
                        ?>
                      </td>
                      <td style="text-align: center;"><?php echo $message["type"];?></td>
                      <td><?php
                        $valueExample = '';
                        if(!empty($message["example"])){
                          $valueExample = "示例:".$message["example"];
                        }
                        echo html::textarea('header_value[]', '', "rows='1' class='form-control autosize header-value' placeholder=\"$valueExample\""); ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php endif;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->body;?></div>
            <div class='detail-content'>
              <table class='table table-form table-bordered'>
                <thead>
                  <tr>
                    <th width="35%"><?php echo $lang->ztinterface->key?></th>
                      <th width="70px"><?php echo $lang->ztinterface->type;?></th>
                      <th width="50px"><?php echo $lang->ztinterface->notNull;?></th>
                      <th width="15%"><?php echo $lang->ztinterface->mock;?></th>
                      <th><?php echo $lang->ztinterface->value;?></th>
                      <?php ChromePhp::log($data);?>
                  </tr>
                </thead>
                <tbody id='headers' class='table table-form' data-group-name='<?php echo $lang->testcase->groupName ?>'>
                  <?php if(empty($header["content"])):?>
                    <tr>
                      <td colspan="5" class="no-data-message"><?php echo $lang->ztinterface->noBody;?></td>
                    </tr>
                  <?php else:?>
                    <?php echo $bodyHtml;?>
                  <?php endif;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class='text-center detail form-actions'>
            <?php echo html::submitButton(). html::backButton();;?>
          </div>
        </div>
      </div>
      <div class='side-col innerbtn'>
        
      </div>
        <div class='side-col col-3'>
        <div class='cell'>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->messageView;?></div>
            <div class='detail-content'><?php echo html::textarea('messageView', '', "rows='20' class='form-control'");?></div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script>
$(function()
{
    $('#subNavbar [data-id=testcase]').addClass('active');
    $('#navbar [data-id=testcase]').addClass('active');
})
</script>
<?php include '../../common/view/footer.html.php';?>

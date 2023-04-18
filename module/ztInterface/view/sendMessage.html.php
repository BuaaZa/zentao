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
            <div class='detail-title' style="display: flex; justify-content: space-between;">
              <?php echo $lang->ztinterface->url;?>
              <button id="tableCustomBtn" type="button" class="btn btn-link" style="float: right;">
                <i class="icon-cog-outline"></i>
              </button>
            </div>
            <div class="detail-content">
              <div class="input-control" style="display: flex; align-items: center;">
                <?php #echo '<span style="font-size: 1.3rem; letter-spacing: 0.05em;">' . $interface->url . '</span>';?>
                <?php echo html::input('baseURL', '', 'class="form-control" style="width: 60%;" list="baseUrlList" placeholder="' . $lang->ztinterface->baseUrl . '"');?>
                <?php echo html::input('URL', $interface->url, 'class="form-control" style="width: 40%;" disabled title="接口文档中指定"');?>
                <?php echo $baseURLList;?>
              </div>
              <div id="urlError">
                <span id="error" style="font-size:4px;color:red;display:none;">Mock函数不存在</span>
              </div>
            </div>
          </div>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->head;?></div>
            <div class='detail-content'>
              <table class='table table-form table-bordered'>
                <thead>
                  <tr>
                    <th width="30%"><?php echo $lang->ztinterface->key?></th>
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
                      <td id='name'>
                        <b><?php echo $message["name"];?></b>
                        <?php if(!empty($message["description"])){
                            echo "<span style=\"color: #888888;\">({$message["description"]})</span>";
                          }
                        ?>
                      </td>
                      <td id='type' style="text-align: center;"><?php echo $message["type"];?></td>
                      <td id='value'><?php
                          $valueExample = '';
                          if(!empty($message["example"])){
                            $valueExample = "示例:".$message["example"];
                          }
                          echo html::input('header_value[]', '', "rows='1' class='form-control header-value' placeholder=\"$valueExample\""); ?>
                        <span id="error" style="font-size:4px;color:red;display:none;">类型不符</span>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php endif;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class='detail'>
            <div class='detail-title'>
              <span style="display: inline;"><?php echo $lang->ztinterface->body;?></span>
              <div style="text-align: right;display: inline;">
                <button type="button" class="btn iframe fill-in" style="float: right;">
                  <i class="icon-import" title="填充空白项" data-app="ztinterface"></i>
                </button>
                <button type="button" class="btn iframe all-refresh" style="float: right;">
                  <i class="icon-refresh" title="全部随机" data-app="ztinterface"></i>
                </button>
              </div>
            </div>
            <div class='detail-content'>
              <table class='table table-form table-bordered'>
                <thead>
                  <tr>
                    <th width="30%"><?php echo $lang->ztinterface->key?></th>
                      <th width="70px"><?php echo $lang->ztinterface->type;?></th>
                      <th width="50px"><?php echo $lang->ztinterface->notNull;?></th>
                      <th width="25%"><?php echo $lang->ztinterface->mock;?></th>
                      <th><?php echo $lang->ztinterface->value;?></th>
                  </tr>
                </thead>
                <tbody id='bodys' class='table table-form' data-group-name='<?php echo $lang->testcase->groupName ?>'>
                  <?php if(empty($header["content"])):?>
                    <tr>
                      <td colspan="5" class="no-data-message"><?php echo $lang->ztinterface->noBody;?></td>
                    </tr>
                  <?php else:?>
                    <?php echo $bodyHtml;?>
                  <?php endif;?>
                </tbody>
              </table>
              <?php echo $mocklist;?>
            </div>
          </div>
          <div class='text-center detail form-actions'>
            <button type="button" id="saveMock" class="btn btn-wide btn-primary">保存Mock设置</button>
          </div>
        </div>
      </div>
        <div class='side-col col-4'>
        <div class='cell'>
          <div class='detail'>
            <div class='detail-title'><?php echo $lang->ztinterface->messageView;?></div>
            <div class='detail-content'>
              <?php echo html::textarea('messageHeadView', '', "disabled rows='6' class=' form-control'");?>
              <?php echo html::textarea('messageBodyView', '', "spellcheck=\"false\" style=\"font-size: 14px; letter-spacing: 0.1em; line-height: 1.5em;\" rows='14' class='form-control'");?>
            </div>
          </div>
          <div class='text-center form-actions'>
            <button type="button" id="genMessage" class="btn btn-wide btn-primary" data-type='gen'>
              <i class=" icon-refresh" title="生成报文" data-app="ztinterface"></i>
              <span>生成报文</span>
            </button>
            <button type="button" id="sendMessage" class="btn btn-wide btn-primary">
              <i class=" icon-run" title="全部随机" data-app="ztinterface"></i>
              <span>发送报文</span>
            </button>
          </div>
          <div id='response' class='detail'>
            <div class='detail-title'>
              <?php echo $lang->ztinterface->response;?>
              <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <span id='code' style="color: #777777;display: none;">200</span>
              <span>&nbsp;</span>
              <span id='status' style="color: #777777;display: none;">OK</span>
            </div>
            <div class='detail-content'>
              <?php echo html::textarea('responseView', '', "disabled rows='8' class=' form-control'");?>
            </div>
          </div>
          <div id='messageWrong' class='detail'>
            <div class='detail-title'>
              <?php echo $lang->ztinterface->messageWrong;?>
            </div>
            <div class='detail-content'>
              <?php echo html::textarea('wrongView', '', "disabled rows='8' class=' form-control'");?>
            </div>
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

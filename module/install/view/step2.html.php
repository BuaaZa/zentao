<?php
/**
 * The html template file of step2 method of install module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ZenTaoPMS
 * @version     $Id: step2.html.php 4972 2013-07-02 06:50:10Z zhujinyonging@gmail.com $
 */

include '../../common/view/header.lite.html.php'; ?>
<div class='container'>
    <div class='modal-dialog'>
        <form method='post' action='<?php echo $this->createLink('install', 'step3'); ?>'>
            <div class='modal-header'><strong><?php echo $lang->install->setConfig; ?></strong></div>
            <div class='modal-body'>
                <table align='center' class='table table-bordered table-form'>
                    <thead>
                    <tr>
                        <th class='w-p20 text-right'><?php echo $lang->install->key; ?></th>
                        <th style="text-align: center"><?php echo $lang->install->value ?></th>
                        <th style="text-align: center">备注</th>
                    </tr>
                    </thead>
                    <tr>
                        <?php include $this->app->getConfigRoot() . 'timezones.php'; ?>
                        <th><?php echo $lang->install->timezone; ?></th>
                        <td><?php echo html::select('timezone', $timezoneList, $config->timezone, "class='form-control'"); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->defaultLang; ?></th>
                        <td><?php echo html::select('defaultLang', $config->langs, $app->getClientLang(), "class='form-control'"); ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbHost; ?></th>
                        <td>
                            <?php echo html::input('dbHost', $dbHost, "class='form-control'"); ?>
                        </td>
                        <td><?php echo $lang->install->dbHostNote; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbPort; ?></th>
                        <td>
                            <?php echo html::input('dbPort', $dbPort, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbEncoding; ?></th>
                        <td>
                            <?php echo html::input('dbEncoding', $this->config->db->encoding, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbUser; ?></th>
                        <td>
                            <?php echo html::input('dbUser', $dbUser, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbPassword; ?></th>
                        <td>
                            <?php echo html::input('dbPassword', $dbPassword, "class='form-control'", false, 'password'); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbName; ?></th>
                        <td>
                            <?php echo html::input('dbName', $dbName, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->dbPrefix; ?></th>
                        <td>
                            <?php echo html::input('dbPrefix', 'zt_', "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->installType; ?></th>
                        <td>
                            <?php echo html::select('installType', $lang->install->installTypes, 'install', "class='form-control'"); ?>
                        </td>
                        <td>
                            <div id="step2_js_clearDB">
                                <?php echo html::checkBox('clearDB', $lang->install->clearDB); ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->sync2wbsApi; ?></th>
                        <td>
                            <?php echo html::input('sync2wbsApi', $sync2wbsApi, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->getCodeLineApi; ?></th>
                        <td>
                            <?php echo html::input('getCodeLineApi', $getCodeLineApi, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <th><?php echo $lang->install->syncWorkCodeLine2WbsApi; ?></th>
                        <td>
                            <?php echo html::input('syncWorkCodeLine2WbsApi', $syncWorkCodeLine2WbsApi, "class='form-control'"); ?>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class='modal-footer'>
                <?php echo html::submitButton() . html::hidden('requestType', 'GET'); ?>
            </div>
        </form>
    </div>
</div>
<?php include '../../common/view/footer.lite.html.php'; ?>

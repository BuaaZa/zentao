<?php
/**
 * The testcase module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     testcase
 * @version     $Id: zh-cn.php 4764 2013-05-05 04:07:04Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
$lang->testcase->id               = '用例编号';
$lang->testcase->product          = "所属{$lang->productCommon}";
$lang->testcase->project          = '所属项目';
$lang->testcase->execution        = '所属执行';
$lang->testcase->module           = '所属模块';
$lang->testcase->auto             = '自动化测试用例';
$lang->testcase->frame            = '自动化测试框架';
$lang->testcase->howRun           = '测试方式';
$lang->testcase->frequency        = '使用频率';
$lang->testcase->path             = '路径';
$lang->testcase->lib              = "所属库";
$lang->testcase->branch           = "分支/平台";
$lang->testcase->moduleAB         = '模块';
$lang->testcase->story            = "相关{$lang->SRCommon}";
$lang->testcase->storyVersion     = "{$lang->SRCommon}版本";
$lang->testcase->color            = '标题颜色';
$lang->testcase->order            = '排序';
$lang->testcase->title            = '用例标题';
$lang->testcase->precondition     = '前置条件';
$lang->testcase->pri              = '优先级';
$lang->testcase->type             = '用例类型';
$lang->testcase->status           = '用例状态';
$lang->testcase->statusAB         = '状态';
$lang->testcase->subStatus        = '子状态';
$lang->testcase->steps            = '用例步骤';
$lang->testcase->openedBy         = '由谁创建';
$lang->testcase->openedByAB       = '创建者';
$lang->testcase->openedDate       = '创建日期';
$lang->testcase->lastEditedBy     = '最后修改者';
$lang->testcase->result           = '测试结果';
$lang->testcase->real             = '实际情况';
$lang->testcase->keywords         = '关键词';
$lang->testcase->files            = '附件';
$lang->testcase->linkCase         = '相关用例';
$lang->testcase->linkCases        = '关联相关用例';
$lang->testcase->unlinkCase       = '移除相关用例';
$lang->testcase->linkBug          = '相关缺陷';
$lang->testcase->linkBugs         = '关联相关缺陷';
$lang->testcase->unlinkBug        = '移除相关缺陷';
$lang->testcase->stage            = '适用阶段';
$lang->testcase->scriptedBy       = '脚本由谁创建';
$lang->testcase->scriptedDate     = '脚本创建日期';
$lang->testcase->scriptStatus     = '脚本状态';
$lang->testcase->scriptLocation   = '脚本地址';
$lang->testcase->reviewedBy       = '由谁评审';
$lang->testcase->reviewedDate     = '评审时间';
$lang->testcase->reviewResult     = '评审结果';
$lang->testcase->reviewedByAB     = '评审人';
$lang->testcase->reviewedDateAB   = '日期';
$lang->testcase->reviewResultAB   = '结果';
$lang->testcase->forceNotReview   = '不需要评审';
$lang->testcase->lastEditedByAB   = '修改者';
$lang->testcase->lastEditedDateAB = '修改日期';
$lang->testcase->lastEditedDate   = '修改日期';
$lang->testcase->version          = '用例版本';
$lang->testcase->lastRunner       = '执行人';
$lang->testcase->lastRunDate      = '执行时间';
$lang->testcase->assignedTo       = '指派给';
$lang->testcase->colorTag         = '颜色标签';
$lang->testcase->lastRunResult    = '结果';
$lang->testcase->desc             = '步骤';
$lang->testcase->parent           = '上级步骤';
$lang->testcase->xml              = 'XML';
$lang->testcase->expect           = '预期';
$lang->testcase->allProduct       = "所有{$lang->productCommon}";
$lang->testcase->fromBug          = '来源缺陷';
$lang->testcase->toBug            = '生成缺陷';
$lang->testcase->changed          = '原用例更新';
$lang->testcase->bugs             = '产生缺陷数';
$lang->testcase->bugsAB           = 'B';
$lang->testcase->results          = '执行结果数';
$lang->testcase->resultsAB        = 'R';
$lang->testcase->stepNumber       = '用例步骤数';
$lang->testcase->stepNumberAB     = 'S';
$lang->testcase->createBug        = '转缺陷';
$lang->testcase->fromModule       = '来源模块';
$lang->testcase->fromCase         = '来源用例';
$lang->testcase->sync             = '同步';
$lang->testcase->ignore           = '忽略';
$lang->testcase->fromTesttask     = '来自测试集用例';
$lang->testcase->fromCaselib      = '来自用例库用例';
$lang->testcase->fromCaseID       = '用例来源ID';
$lang->testcase->fromCaseVersion  = '用例来源版本';
$lang->testcase->mailto           = '抄送给';
$lang->testcase->deleted          = '是否删除';
$lang->testcase->browseUnits      = '单元测试';
$lang->testcase->suite            = '套件';
$lang->testcase->executionStatus  = '执行状态';

$lang->case = $lang->testcase;  // 用于DAO检查时使用。因为case是系统关键字，所以无法定义该模块为case，只能使用testcase，但表还是使用的case。

$lang->testcase->stepID      = '编号';
$lang->testcase->stepDesc    = '步骤';
$lang->testcase->stepinput  = '输入';
$lang->testcase->step_goal_action  = '目的和动作';
$lang->testcase->stepExpect  = '预期结果';
$lang->testcase->step_eval_criteria  = '评价准则';
$lang->testcase->stepVersion = '版本';
$lang->testcase->noticegroupnum = '最多使一个步骤绑定输入输出项！';
$lang->testcase->sample_in     = "样本输入";
$lang->testcase->sample_out    = "样本输出";
$lang->testcase->sample_result = "样本结果";


$lang->testcase->common                  = '用例';
$lang->testcase->index                   = "用例管理首页";
$lang->testcase->create                  = "建用例";
$lang->testcase->batchCreate             = "批量建用例";
$lang->testcase->delete                  = "删除";
$lang->testcase->deleteAction            = "删除用例";
$lang->testcase->view                    = "用例详情";
$lang->testcase->review                  = "评审";
$lang->testcase->reviewAB                = "评审";
$lang->testcase->batchReview             = "批量评审";
$lang->testcase->edit                    = "编辑用例";
$lang->testcase->batchEdit               = "批量编辑 ";
$lang->testcase->batchChangeModule       = "批量修改模块";
$lang->testcase->confirmLibcaseChange    = "同步用例库用例修改";
$lang->testcase->ignoreLibcaseChange     = "忽略用例库用例修改";
$lang->testcase->batchChangeBranch       = "批量修改分支";
$lang->testcase->groupByStories          = "{$lang->SRCommon}分组";
$lang->testcase->batchDelete             = "批量删除 ";
$lang->testcase->batchConfirmStoryChange = "批量确认变更";
$lang->testcase->batchCaseTypeChange     = "批量修改类型";
$lang->testcase->browse                  = "用例列表";
$lang->testcase->groupCase               = "分组浏览用例";
$lang->testcase->zeroCase                = "零用例{$lang->SRCommon}";
$lang->testcase->import                  = "导入";
$lang->testcase->importAction            = "导入用例";
$lang->testcase->fileImport              = "导入CSV";
$lang->testcase->importFromLib           = "从用例库中导入";
$lang->testcase->showImport              = "显示导入内容";
$lang->testcase->exportTemplate          = "导出模板";
$lang->testcase->export                  = "导出数据";
$lang->testcase->exportAction            = "导出用例";
$lang->testcase->reportChart             = '报表统计';
$lang->testcase->reportAction            = '用例报表统计';
$lang->testcase->confirmChange           = '确认用例变动';
$lang->testcase->confirmStoryChange      = "确认{$lang->SRCommon}变动";
$lang->testcase->copy                    = '复制用例';
$lang->testcase->group                   = '分组';
$lang->testcase->groupName               = '分组名称';
$lang->testcase->step                    = '步骤';
$lang->testcase->stepChild               = '子步骤';
$lang->testcase->viewAll                 = '查看所有';
$lang->testcase->importToLib             = "导入用例库";
$lang->testcase->exportToWord             = "导出用例";

$lang->testcase->new = '新增';

$lang->testcase->num = '用例记录数：';

$lang->testcase->deleteStep   = '删除';
$lang->testcase->insertBefore = '之前添加';
$lang->testcase->insertAfter  = '之后添加';

$lang->testcase->assignToMe   = '指派给我的用例';
$lang->testcase->openedByMe   = '我建的用例';
$lang->testcase->allCases     = '所有';
$lang->testcase->allTestcases = '所有用例';
$lang->testcase->needConfirm  = "{$lang->SRCommon}变动";
$lang->testcase->bySearch     = '搜索';
$lang->testcase->unexecuted   = '未执行';

$lang->testcase->lblStory       = "相关{$lang->SRCommon}";
$lang->testcase->lblLastEdited  = '最后编辑';
$lang->testcase->lblTypeValue   = '类型可选值列表';
$lang->testcase->lblStageValue  = '阶段可选值列表';
$lang->testcase->lblStatusValue = '状态可选值列表';

$lang->testcase->legendBasicInfo   = '基本信息';
$lang->testcase->legendAttatch     = '附件';
$lang->testcase->legendLinkBugs    = '相关缺陷';
$lang->testcase->legendOpenAndEdit = '创建编辑';
$lang->testcase->legendComment     = '备注';

$lang->testcase->summary               = "本页共 <strong>%s</strong> 个用例，已执行<strong>%s</strong>个。";
$lang->testcase->confirmBatchDelete    = '您确认要批量删除这些测试用例吗？';
$lang->testcase->ditto                 = '同上';
$lang->testcase->dittoNotice           = '该用例与上一用例不属于同一产品！';
$lang->testcase->confirmUnlinkTesttask = '用例[%s]已关联在之前所属分支/平台的测试集中，调整分支/平台后，将从之前所属分支/平台的测试集中移除，请确认是否继续修改。';

$lang->testcase->reviewList[0] = '否';
$lang->testcase->reviewList[1] = '是';

$lang->testcase->priList[0] = '';
$lang->testcase->priList[3] = 3;
$lang->testcase->priList[1] = 1;
$lang->testcase->priList[2] = 2;
$lang->testcase->priList[4] = 4;

/* Define the types. */
$lang->testcase->typeList['']            = '';
$lang->testcase->typeList['feature']     = '功能测试';
$lang->testcase->typeList['performance'] = '性能测试';
$lang->testcase->typeList['config']      = '配置相关';
$lang->testcase->typeList['install']     = '安装部署';
$lang->testcase->typeList['security']    = '安全相关';
$lang->testcase->typeList['interface']   = '接口测试';
$lang->testcase->typeList['unit']        = '单元测试';
$lang->testcase->typeList['other']       = '其他';

$lang->testcase->stageList['']           = '';
$lang->testcase->stageList['unittest']   = '单元测试阶段';
$lang->testcase->stageList['feature']    = '功能测试阶段';
$lang->testcase->stageList['intergrate'] = '集成测试阶段';
$lang->testcase->stageList['system']     = '系统测试阶段';
$lang->testcase->stageList['smoke']      = '冒烟测试阶段';
$lang->testcase->stageList['bvt']        = '版本验证阶段';

$lang->testcase->reviewResultList['']        = '';
$lang->testcase->reviewResultList['pass']    = '确认通过';
$lang->testcase->reviewResultList['clarify'] = '继续完善';

$lang->testcase->statusList['']            = '';
$lang->testcase->statusList['wait']        = '待评审';
$lang->testcase->statusList['normal']      = '正常';
$lang->testcase->statusList['blocked']     = '被阻塞';
$lang->testcase->statusList['investigate'] = '研究中';

$lang->testcase->resultList['n/a']     = '忽略';
$lang->testcase->resultList['pass']    = '通过';
$lang->testcase->resultList['fail']    = '失败';
$lang->testcase->resultList['blocked'] = '阻塞';

$lang->testcase->exportCaseTypetList['word'] = 'Word';

$lang->testcase->buttonToList = '返回';

$lang->testcase->whichLine        = '第%s行';
$lang->testcase->stepsEmpty       = '步骤%s不能为空';
$lang->testcase->errorEncode      = '无数据，请选择正确的编码重新上传！';
$lang->testcase->noFunction       = '不存在iconv和mb_convert_encoding转码方法，不能将数据转成想要的编码！';
$lang->testcase->noRequire        = "%s行的“%s”是必填字段，不能为空";
$lang->testcase->noRequireTip     = "“%s”是必填字段，不能为空";
$lang->testcase->noLibrary        = "现在还没有用例库，请先创建！";
$lang->testcase->mustChooseResult = '必须选择评审结果';
$lang->testcase->noModule         = '<div>您现在还没有模块信息</div><div>请维护测试模块</div>';
$lang->testcase->noCase           = '暂时没有用例。';
$lang->testcase->importedCases    = 'ID为 %s 的用例在相同模块已经导入，已忽略。';

$lang->testcase->searchStories = "键入来搜索{$lang->SRCommon}";
$lang->testcase->selectLib     = '请选择库';
$lang->testcase->selectLibAB   = '选择用例库';

$lang->testcase->action = new stdclass();
$lang->testcase->action->fromlib               = array('main' => '$date, 由 <strong>$actor</strong> 从用例库 <strong>$extra</strong>导入。');
$lang->testcase->action->reviewed              = array('main' => '$date, 由 <strong>$actor</strong> 记录评审结果，结果为 <strong>$extra</strong>。', 'extra' => 'reviewResultList');
$lang->testcase->action->linked2project        = array('main' => '$date, 由 <strong>$actor</strong> 关联到项目 <strong>$extra</strong>。');
$lang->testcase->action->unlinkedfromproject   = array('main' => '$date, 由 <strong>$actor</strong> 从项目 <strong>$extra</strong> 移除。');
$lang->testcase->action->linked2execution      = array('main' => '$date, 由 <strong>$actor</strong> 关联到' . $lang->executionCommon . ' <strong>$extra</strong>。');
$lang->testcase->action->unlinkedfromexecution = array('main' => '$date, 由 <strong>$actor</strong> 从' . $lang->executionCommon . ' <strong>$extra</strong> 移除。');

$lang->testcase->featureBar['browse']['all']         = '全部';
$lang->testcase->featureBar['browse']['wait']        = '待评审';
$lang->testcase->featureBar['browse']['needconfirm'] = $lang->testcase->needConfirm;
$lang->testcase->featureBar['browse']['group']       = '分组查看';
$lang->testcase->featureBar['browse']['zerocase']    = "零用例{$lang->SRCommon}";
$lang->testcase->featureBar['browse']['browseunits'] = '单元测试';
$lang->testcase->featureBar['browse']['suite']       = '套件';
$lang->testcase->featureBar['groupcase']             = $lang->testcase->featureBar['browse'];

$lang->ztinterface->common = "接口";
$lang->testcase->view      = "接口详情";
$lang->ztinterface->summary   = "本页共 <strong>%s</strong> 个接口。";
$lang->ztinterface->noModule = '<div>您现在还没有模块信息</div><div>请维护接口模块</div>';
$lang->ztinterface->noInterface = "暂时没有接口。";
$lang->ztinterface->create = "创建接口";
$lang->ztinterface->jsonImport = "从json导入";
$lang->ztinterface->name       = '接口名';
$lang->ztinterface->method       = '请求方法';
$lang->ztinterface->url       = 'URL';
$lang->ztinterface->delete       = '删除接口';
$lang->ztinterface->sendMessage       = '发送报文';
$lang->ztinterface->message       = '历史报文';
$lang->ztinterface->edit       = '编辑';
$lang->ztinterface->confirmDelete     = '您确认要删除该接口吗？';
$lang->ztinterface->baseUrl = '基地址';
$lang->ztinterface->head = '请求头';
$lang->ztinterface->key = '参数名';
$lang->ztinterface->description = '描述';
$lang->ztinterface->type = '类型';
$lang->ztinterface->notNull = '非空';
$lang->ztinterface->value = '值';
$lang->ztinterface->messageView = '报文';
$lang->ztinterface->messageWrong = '错误信息';
$lang->ztinterface->response = '响应';
$lang->ztinterface->mock = 'MOCK';
$lang->ztinterface->noHeaders = '请求头内未设置可配置字段';
$lang->ztinterface->body = '请求体';
$lang->ztinterface->noBody = '请求体内未设置可配置字段';
$lang->ztinterface->fakerOptions = array(
    'userName',
    'streetName',
    'firstName',
    'lastName',
    'sentence',
    'paragraph',
    'word',
    'streetAddress',
    'address',
    'country',
    'city',
    'state',
    'company',
    'email',
    'password',
    'url',
    'macAddress',
    'ipv4',
    'ipv6',
    'ip',
    'userAgent',
    'color',
    'dateTime',
    'date',
    'time',
    'monthName',
    'month',
    'year',
    'timezone',
    'phonenumber',
    'name'    
);
$lang->ztinterface->funcTable = array(
    'streetname',
    'streetaddress',
    'address',
    'country',
    'state',
    'city',

    'sentence',
    'paragraph',
    'word',

    'hexcolor',
    'rgbcolor',
    'rgbcsscolor',
    'colorname',

    'monthname',
    'month',
    'year',
    'timezone',

    'email',
    'phonenumber',
    'url',
    'ipv4',
    'ipv6',
    'macaddress',

    'useragent',
    'username',
    'password',

    'firstname',
    'lastname',
    'company',
    'name'   
);
$lang->ztinterface->fakerCN = array(
    'firstname',
    'state',
    'lastname',
    'address',
    'country',
    'streetname',
    'streetaddress',
    'state',
    'city',
    'company',
    'phonenumber',
    'name'    
);

$lang->ztinterface->charType = array("string","integer","array","float");
$lang->ztinterface->stringMock = array();
$lang->ztinterface->stringMock[0]['example'] = "\$keyword";
$lang->ztinterface->stringMock[0]['description'] = "尝试根据参数名含义生成,失败则返回随机字符串(Mock为空时默认采用此模式)";
$lang->ztinterface->stringMock[1]['example'] = "\$String";
$lang->ztinterface->stringMock[1]['description'] = "获取随机字符串,以大小写字母,数字,下划线组成";
$lang->ztinterface->stringMock[2]['example'] = "\$String(@upper)";
$lang->ztinterface->stringMock[2]['description'] = "指定可用字符(@upper:大写字母, @lower: 小写字母)";
$lang->ztinterface->stringMock[3]['example'] = "\$String([@digit,@a-d,@under])";
$lang->ztinterface->stringMock[3]['description'] = "指定多种可用字符(@digit: 数字, @a-d: 等价于abcd, @under: 下划线)";
$lang->ztinterface->stringMock[4]['example'] = "\$String(@all,3,10)";
$lang->ztinterface->stringMock[4]['description'] = "@all: 全部字符; 3: 最小长度, 10: 最大长度";
$lang->ztinterface->stringMock[5]['example'] = "\$Regex([0-9]{7,11}@(qq|163)\.(com|cn))";
$lang->ztinterface->stringMock[5]['description'] = "按正则表达式生成字符串";
$lang->ztinterface->stringMock[6]['example'] = "\$name(zh_CN)";
$lang->ztinterface->stringMock[6]['description'] = "生成一个指定语言的名字,默认为中文";

$lang->ztinterface->stringMock[7]['example'] = "\$country(zh_CN)";
$lang->ztinterface->stringMock[7]['description'] = "生成一个指定语言的国家名称,默认为中文。";
$lang->ztinterface->stringMock[8]['example'] = "\$state(zh_CN)";
$lang->ztinterface->stringMock[8]['description'] = "生成一个指定语言的省/州名称,默认为中文。";
$lang->ztinterface->stringMock[9]['example'] = "\$city(zh_CN)";
$lang->ztinterface->stringMock[9]['description'] = "生成一个指定语言的城市名称,默认为中文。";
$lang->ztinterface->stringMock[10]['example'] = "\$address(zh_CN)";
$lang->ztinterface->stringMock[10]['description'] = "生成一个指定语言的地址,默认为中文。";
$lang->ztinterface->stringMock[11]['example'] = "\$streetName(zh_CN)";
$lang->ztinterface->stringMock[11]['description'] = "生成一个指定语言的街道名,默认为中文。";
$lang->ztinterface->stringMock[12]['example'] = "\$streetAddress(zh_CN)";
$lang->ztinterface->stringMock[12]['description'] = "生成一个指定语言的街道地址,默认为中文。";

$lang->ztinterface->stringMock[13]['example'] = "\$sentence(en_US)";
$lang->ztinterface->stringMock[13]['description'] = "生成一个指定语言的句子,默认为英文。";

$lang->ztinterface->stringMock[14]['example'] = "\$paragraph(en_US)";
$lang->ztinterface->stringMock[14]['description'] = "生成一个指定语言的段落,默认为英文。";

$lang->ztinterface->stringMock[15]['example'] = "\$word(en_US)";
$lang->ztinterface->stringMock[15]['description'] = "生成一个指定语言的单词,默认为英文。";

$lang->ztinterface->stringMock[16]['example'] = "\$hexColor";
$lang->ztinterface->stringMock[16]['description'] = "生成一个十六进制颜色值。";

$lang->ztinterface->stringMock[17]['example'] = "\$rgbColor";
$lang->ztinterface->stringMock[17]['description'] = "生成一个RGB颜色值。";

$lang->ztinterface->stringMock[18]['example'] = "\$rgbCssColor";
$lang->ztinterface->stringMock[18]['description'] = "生成一个CSS RGB颜色值。";

$lang->ztinterface->stringMock[19]['example'] = "\$colorName(en_US)";
$lang->ztinterface->stringMock[19]['description'] = "生成一个指定语言的颜色名称,默认为英文。";

$lang->ztinterface->stringMock[20]['example'] = "\$monthName(en_US)";
$lang->ztinterface->stringMock[20]['description'] = "生成一个指定语言的月份名称,默认为英文。";

$lang->ztinterface->stringMock[23]['example'] = "\$timezone";
$lang->ztinterface->stringMock[23]['description'] = "生成一个时区名称。";

$lang->ztinterface->stringMock[24]['example'] = "\$email";
$lang->ztinterface->stringMock[24]['description'] = "生成一个邮箱地址。";

$lang->ztinterface->stringMock[25]['example'] = "\$url";
$lang->ztinterface->stringMock[25]['description'] = "生成一个URL地址。";

$lang->ztinterface->stringMock[26]['example'] = "\$ipv4";
$lang->ztinterface->stringMock[26]['description'] = "生成一个IPv4地址。";

$lang->ztinterface->stringMock[27]['example'] = "\$ipv6";
$lang->ztinterface->stringMock[27]['description'] = "生成一个IPv6地址。";

$lang->ztinterface->stringMock[28]['example'] = "\$macAddress";
$lang->ztinterface->stringMock[28]['description'] = "生成一个MAC地址。";

$lang->ztinterface->stringMock[29]['example'] = "\$userAgent";
$lang->ztinterface->stringMock[29]['description'] = "生成一个用户代理信息。";

$lang->ztinterface->stringMock[30]['example'] = "\$userName(en_US)";
$lang->ztinterface->stringMock[30]['description'] = "生成一个指定语言的用户名,默认为英文。";

$lang->ztinterface->stringMock[31]['example'] = "\$password";
$lang->ztinterface->stringMock[31]['description'] = "生成一个密码。";

$lang->ztinterface->stringMock[32]['example'] = "\$firstName(zh_CN)";
$lang->ztinterface->stringMock[32]['description'] = "生成一个指定语言的名字（不含姓氏）,默认为中文。";

$lang->ztinterface->stringMock[33]['example'] = "\$lastName(zh_CN)";
$lang->ztinterface->stringMock[33]['description'] = "生成一个指定语言的姓氏, 默认为中文。";

$lang->ztinterface->stringMock[34]['example'] = "\$company(zh_CN)";
$lang->ztinterface->stringMock[34]['description'] = "生成一个指定语言的公司名称,默认为中文。";

$lang->ztinterface->stringMock[35]['example'] = "\$month";
$lang->ztinterface->stringMock[35]['description'] = "生成一个月份。";

$lang->ztinterface->stringMock[36]['example'] = "\$datetime(Y-m-d H:i:s)";
$lang->ztinterface->stringMock[36]['description'] = "按格式生成一个日期/时间/日期+时间,通过Y/y/M/m/D/d/H/h/I/i/S/s进行控制。";

$lang->ztinterface->stringMock[37]['example'] = "\$phoneNumber";
$lang->ztinterface->stringMock[37]['description'] = "生成一个手机号码";


$lang->ztinterface->integerMock = array();
$lang->ztinterface->integerMock[0]['example'] = "\$integer(-10,10)";
$lang->ztinterface->integerMock[0]['description'] = "生成一个处于给定范围中的整数";
$lang->ztinterface->integerMock[1]['example'] = "\$regexnum(1[2-7]{0,2})";
$lang->ztinterface->integerMock[1]['description'] = "生成一个符合正则表达式的整数";

$lang->ztinterface->floatMock = array();
$lang->ztinterface->floatMock[0]['example'] = "\$float(-10,10)";
$lang->ztinterface->floatMock[0]['description'] = "生成一个处于给定范围中的浮点数";
$lang->ztinterface->floatMock[1]['example'] = "\$regexnum(1[2-7]{0,1}\.[0-9]{1,2})";
$lang->ztinterface->floatMock[1]['description'] = "生成一个符合正则表达式的浮点数";

$lang->ztinterface->arrayMock = array();
$lang->ztinterface->arrayMock[0]['example'] = "\$array(1,4)";
$lang->ztinterface->arrayMock[0]['description'] = "生成一个长度在给定范围内的列表";


$lang->ztinterface->methodColor = array(
    'GET' => '#7FFF7F',
    'POST' => '#7FBFFF',
    'PUT' => '#FFBF7F',
    'DELETE' => '#FF7F7F',
    'HEAD' => '#D8BFD8',
    'OPTIONS' => '#008080',
    'CONNECT' => '#800000',
    'TRACE' => '#556B2F',
    'PATCH' => '#000080'
);


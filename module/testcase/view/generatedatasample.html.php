<?php include '../../common/view/header.lite.html.php'; ?>
<div id='mainContent' class='main-content'>

    <div class='main-header'>
        <h2>填写数据样本</h2>
    </div>
    <div style="text-align:center">
        <form class='load-indicator main-form form-ajax'
              method='post' enctype='multipart/form-data'
              id='dataform' data-type='ajax'>
            <table id="testTable"
                   class='table table-form mg-0 table-bordered'>
                <thead>
                    <tr class="text-center">
                    </tr>
                </thead>

                <tbody id='steps' class='sortable' data-group-name='<?php echo $lang->testcase->groupName ?>'>

                <?php foreach ($steps as $stepID => $step): ?>
                    <tr class='step '>

                        <td class='step-id'></td>
                        <td>
                            <div class='input-group'>
                                <!-- <span class='input-group-addon step-item-id'></span> -->
                                <?php
                                echo html::textarea('steps[]', $step->desc,
                                    "rows='1' class='form-control autosize step-steps'")
                                ?>
                                <input type='hidden' name='stepType[]' value='step' class='step-type'>
                                <!--<span class='input-group-addon step-type-toggle'>
                          <?php /*if(!isset($step->type)) $step->type = 'step';*/ ?>
                          <input type='hidden' name='stepType[]' value='<?php /*echo $step->type;*/ ?>' class='step-type'>
                               <div class='checkbox-primary'>
                            <input tabindex='-1' type="checkbox" class='step-group-toggle'<?php /*//if($step->type === 'group') echo ' checked' */ ?>>
                            <label><?php /*//echo $lang->testcase->group */ ?></label>
                          </div>
                        </span>
                        <span class='input-group-addon step-type-toggle2'>
                          <?php /*if(!isset($step->iotype)) $step->iotype = '0';*/ ?>
                          <input type='hidden' name='stepIoType[]' value='<?php /*echo $step->iotype;*/ ?>' class='step-iotype'>
                          <div class='checkbox-primary'>
                            <input tabindex='-1' type="checkbox" class='step-group-toggle2'<?php /*if($step->iotype === '1') echo ' checked' */ ?>>
                            <label><?php /*echo "勾选为输出项" */ ?></label>
                          </div>
                        </span>-->
                            </div>
                        </td>
                        <!--                    <td>-->
                        <?php //echo html::textarea('inputs[]', $step->input, "rows='1' class='form-control autosize step-expects'") ?><!--</td>-->
                        <td><?php echo html::textarea('goal_actions[]', $step->goal_action, "rows='1' class='form-control autosize step-expects'") ?></td>
                        <td><?php echo html::textarea('expects[]', $step->expect, "rows='1' class='form-control autosize step-expects'") ?></td>
                        <td><?php echo html::textarea('eval_criterias[]', $step->eval_criteria, "rows='1' class='form-control autosize step-expects'") ?></td>
                        <td class='stepsample-actions'>
                            <input type='hidden' name='datasample[]' id='datasample' value='' class='step-datasample'>
                            <?php
                            common::printIcon('testcase', 'datasample', "", '',
                                'list', 'edit', '', 'showinonlybody iframe btn-datasample',
                                true, '', '填写');
                            common::printIcon('testcase', 'generatedatasample', "", '',
                                'list', 'list', '', 'showinonlybody iframe btn-generatedatasample',
                                true, '', '显示数据样本');
                            //                          echo $this->loadModel('common')->buildMenu('testcase', 'datasample',"", '',
                            //                            'button', 'edit', '', 'showinonlybody iframe',
                            //                            true, '', '填写');
                            ?>
                            <!--                        <button type='button' title="显示数据样本" class='btn datasample-generate ' >-->
                            <!--                          <i class='icon icon-list'></i>-->
                            <!--                        </button>-->
                            <button type='button' title="重置数据样本" class='btn datasample-undo '>
                                <i class='icon icon-undo'></i>
                            </button>
                        </td>

                        <td class='step-actions'>
                            <div class='btn-group'>
                                <button type='button' class='btn btn-step-add' tabindex='-1'>
                                    <i class='icon icon-plus'></i>
                                </button>
                                <button type='button' class='btn btn-step-move' tabindex='-1'>
                                    <i class='icon icon-move'></i>
                                </button>
                                <button type='button' class='btn btn-step-delete' tabindex='-1'>
                                    <i class='icon icon-close'></i>
                                </button>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
            <br><br>
            <!--<button class="btn" type="button" onclick="addRow();">添加输入项</button>
            <button class="btn" type="button" onclick="addCol();">添加测试样本</button>-->
            <button name="generateSampleButton" class="btn btn-wide btn-info"
                    type="button" onclick="generateDataSample();">
                生成示例样本
            </button>
            <button name="saveButton" class="btn btn-wide btn-primary"
                    type="button" onclick="save_in_cookie();">
                保存
            </button>
            <br><br>
        </form>
        <!-- <input type="button" value="保存" onclick="save_in_cookie();"/> -->
    </div>
</div>
<script type="text/javascript">
    let rowCount = 1;
    let colCount = 2;

    //  规则数量
    let ruleCountMax = 0;
    let stepID;
    //  从隐藏input获得的json序列化的rule
    let dataSampleRuleFromInput;
    //  ajax请求得到的样本示例
    let dataSampleItemJson;

    $(function () {
        stepID = $.cookie('curStepID');
        let nameStr = 'datasample[' + stepID + ']';
        let selector = parent.document.getElementsByName(nameStr);
        let element = $(selector);
        dataSampleRuleFromInput = element.attr("value");

        // TODO: MOCK
        let jsonRule = [
            ['密码', 'int'],
            ['用户名', 'string'],
            ['邮箱', 'string'],
            ['电话', 'string'],
            // ['邮箱', 'int'],
        ];
        dataSampleRuleFromInput = JSON.stringify(jsonRule);

        if (dataSampleRuleFromInput.length > 0) {
            dataSampleRuleFromInput = JSON.parse(dataSampleRuleFromInput);
            ruleCountMax = dataSampleRuleFromInput.length;

            addHead();

            generateTemplate();

            generateDataSample();
        }

        initStepsForDataSample();

        // 根据历史填写 显示样本
        /*if (curDataSample.length > 0) {
            curDataSample = JSON.parse(curDataSample);
            let rowCountMax = curDataSample.length;
            let colCountMax = curDataSample[0].length;
            while (rowCount < rowCountMax) {
                addRow();
            }
            while (colCount < colCountMax) {
                addCol();
            }
            for (i = 0; i < rowCountMax; i += 1) {
                for (j = 0; j < colCountMax; j += 1) {
                    let textName = 'datasample[' + i + '][' + j + ']';
                    selector = document.getElementsByName(textName);
                    element = $(selector);
                    element.text(curDataSample[i][j]);
                }
            }
        }*/
    })

    function addHead() {
        let testTableHead = $('#testTable thead tr');
        // let rowTemplate = "<th class='step-id'> <b>样本编号</b> </th>"

        let rowTemplate = "<th class='sample-id'> <b>样本编号</b> </th>"

        for (let i = 0; i < ruleCountMax; i++) {
            rowTemplate += "<th> <b>" + dataSampleRuleFromInput[i][0] + "</b></th>"
        }
        // rowTemplate += "<th class='step-actions'> <b>操作</b> </th>";
        rowTemplate += "<th class='sample-actions'> <b>操作</b> </th>";

        testTableHead.append(rowTemplate);
    }

    function generateTemplate(){
        let testTableBody = $('#testTable tbody');

        let sampleTemplate = "<tr class='sample step template' id='stepTemplate'>"
        sampleTemplate += "<td class='sample-id step-id'></td>";

        for (let i = 0; i < ruleCountMax; i++) {
            sampleTemplate += `<td>
                                    <textarea rows='1' class='form-control autosize step-expects'>
                                    </textarea>
                                </td>`
        }
        sampleTemplate += `
                <td class='sample-actions'>
                    <div class='btn-group'>
                        <button type='button' class='btn btn-step-add' tabindex='-1'>
                            <i class='icon icon-plus'></i>
                        </button>
                        <button type='button' class='btn btn-step-move' tabindex='-1'>
                            <i class='icon icon-move'></i>
                        </button>
                        <button type='button' class='btn btn-step-delete' tabindex='-1'>
                            <i class='icon icon-close'></i>
                        </button>
                    </div>
                </td>`

        sampleTemplate += "</tr>"

        testTableBody.append(sampleTemplate);
    }

    function generateDataSample() {
        // TODO: ajax请求获取数据样本
        $.ajaxSettings.async = false;
        // url: /module=datasample&method=batchGenerate
        let ajaxGenerateDataSampleLink = createLink('datasample', 'batchGenerate');
        let ruleList =[];
        for (let i = 0; i < ruleCountMax; i++) {
            ruleList.push({
                id: i,
                mock: dataSampleRuleFromInput[i][1]
            })
        }

        $.ajax(
            {
                method: "POST",
                dataType: 'json',
                url: ajaxGenerateDataSampleLink,
                data:
                    {
                        "account": account,
                        "list":ruleList
                    },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response == null ) {
                        new $.zui.Messager('返回数据为空', {
                            type: 'danger',
                            close: true,
                            time: 900 // 不进行自动隐藏
                        }).show();
                    } else if (response.error.length > 0) {
                        new $.zui.Messager('数据规则错误', {
                            type: 'danger',
                            close: true,
                            time: 900 // 不进行自动隐藏
                        }).show();
                    }else{
                        dataSampleItemJson = response
                    }
                },
                error: function () {
                    // changeTableEngine();
                }
            }
        )
        $.ajaxSettings.async = true;


        dataSampleItemJson = {
            error: [
                {
                    id: '0',
                    message: 'error'
                }
            ],
            samples: [
                [
                    {
                        id: '0',
                        value: '123456'
                    },
                    {
                        id: '1',
                        value: 'za'
                    }
                ],
                [
                    {
                        id: '0',
                        value: '123456'
                    },
                    {
                        id: '1',
                        value: 'za'
                    }
                ]
            ]
        }

        let sampleNum = dataSampleItemJson.samples.length;

        let testTableBody = $('#testTable tbody');

        testTableBody.find('tr:not(.template)').remove()

        for (let i = 0; i < sampleNum; i++) {
            let curSample = dataSampleItemJson.samples[i];
            // let sampleTemplate = "<tr class='step '>"
            let sampleTemplate = "<tr class='sample step'>"
            sampleTemplate += "<td class='sample-id step-id'>"+(i+1)+"</td>";

            for (let j = 0; j < ruleCountMax; j++) {
                sampleTemplate += "<td><textarea rows='1' class='form-control autosize step-expects' " +
                    "name='datasampleitem[" + i + "][" + j + "]'>" +
                    (parseInt(curSample.id)  == j ? curSample.value : '') +
                    "</textarea></td>"
            }
            sampleTemplate += `
                <td class='sample-actions'>
                    <div class='btn-group'>
                        <button type='button' class='btn btn-step-add' tabindex='-1'>
                            <i class='icon icon-plus'></i>
                        </button>
                        <button type='button' class='btn btn-step-move' tabindex='-1'>
                            <i class='icon icon-move'></i>
                        </button>
                        <button type='button' class='btn btn-step-delete' tabindex='-1'>
                            <i class='icon icon-close'></i>
                        </button>
                    </div>
                </td>`

            sampleTemplate += "</tr>"

            testTableBody.append(sampleTemplate);
        }
    }

    function addRow(index) {
        //$('#submit').attr("disabled",false);
        let testtable = $("#testTable");
        let lastRow = testtable.find("tr:last");
        let lastRowTexts = lastRow.find("textarea");
        lastRowTexts.each(function () {
            let indices = $(this).attr('name').match(/\d+/g);
            let row = parseInt(indices[0]); // get row index as number
            let col = parseInt(indices[1]); // get column index as number
            row += 1;
            $(this).attr('name', 'datasample[' + row + '][' + col + ']');
        });

        rowCount++;
        let rowTemplate_1 = "<tr><td><textarea rows='1' class='form-control autosize step-expects' name='datasample[" + (rowCount - 2) + "][0]' placeholder='输入项'></textarea></td>";
        let rowTemplate_2 = '';
        for (i = 1; i < colCount; i++) {
            let tmp_template = "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample[" + (rowCount - 2) + "][" + i + "]'></textarea></td>";
            rowTemplate_2 += tmp_template;
        }
        let rowTemplate_3 = '</tr>';
        let rowTemplate = rowTemplate_1 + rowTemplate_2 + rowTemplate_3;

        if (lastRow.length) {
            lastRow.before(rowTemplate);
        } else {
            testtable.append(rowTemplate);
        }

    }

    function delRow(_id) {
        $("#testTable .tr_" + _id).hide();
        rowCount--;
    }

    function addCol() {
        colCount++;
        let i = 1;
        $("#testTable tr").each(function () {
            let trHtml = '';
            if (i === 1) {
                trHtml = '<td><b>样本' + (colCount - 1) + '</b></td>';
            } else {
                trHtml = "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample[" + (i - 2) + "][" + (colCount - 1) + "]'></textarea></td>";
            }

            $(this).append(trHtml);
            i++;
        });
    }

    function delCol(_id) {
        $("#testTable tr").each(function () {
            $("td:eq(" + _id + ")", this).hide();
        });
        colCount--;
    }

    function mover(_id) {
        $("#testTable tr:not(:first)").each(function () {
            $("td:eq(" + _id + ")", this).removeClass("cl1");
            $("td:eq(" + _id + ")", this).addClass("cl2");
        });
    }

    function mout(_id) {
        $("#testTable tr:not(:first)").each(function () {
            $("td:eq(" + _id + ")", this).removeClass("cl2");
            $("td:eq(" + _id + ")", this).addClass("cl1");
        });
    }

    function save_in_cookie() {
        //history.go(-1)
        //console.log("1");
        //此处将表单数据存到cookie中
        let form = document.getElementById("dataform"); // get form element
        let matrix = []; // initialize empty array
        let isEmpty = true;
        for (let i = 0; i < form.elements.length; i++) { // loop through each form element
            let element = form.elements[i]; // get current element
            if (element.name.startsWith("datasample")) { // if element name starts with matrix
                let indices = element.name.match(/\d+/g); // get row and column indices from name
                let row = parseInt(indices[0]); // get row index as number
                let col = parseInt(indices[1]); // get column index as number
                if (!matrix[row]) { // if row does not exist in array yet
                    matrix[row] = []; // create empty row array
                }
                matrix[row][col] = element.value; // assign element value to array position
                if (isEmpty && element.value != '')
                    isEmpty = false;
            }
        }
        let matrixString = JSON.stringify(matrix); // convert array to string using JSON.stringify()
        //document.cookie = "datasam="+matrixString;
        // $.cookie("datasample["+$.cookie('curStepID')+"]", matrixString);
        //alert($.cookie('datasample'));
        //alert(matrixString);
        let stepID = $.cookie('curStepID');
        let nameStr = 'datasample[' + stepID + ']';
        selector = parent.document.getElementsByName(nameStr);
        element = $(selector);
        element.attr("value", matrixString);

        let nameStr2 = 'is_updated[' + stepID + ']';
        selector2 = parent.document.getElementsByName(nameStr2);
        element2 = $(selector2);
        element2.attr("value", '1');

        // console.log(isEmpty);
        // console.log(parent.$('#steps tr[data-index!="'+ stepID +'"] td.stepsample-actions').find('a'));

        let $otherDatasampleActions = parent.$('#steps tr[data-index!="' + stepID + '"] td.stepsample-actions');

        if (!isEmpty) {
            // console.log(parent.$('#steps tr[data-index!="'+ stepID +'"] td.stepsample-actions'));
            $otherDatasampleActions.find('a').attr("disabled", true).css("pointer-events", "none");
            $otherDatasampleActions.find('button').attr("disabled", true);
            $.cookie("isSampleEmpty", 0);
        } else {
            $otherDatasampleActions.find('a').removeAttr("disabled").css("pointer-events", "");
            $otherDatasampleActions.find('button').removeAttr("disabled");
            $.cookie("isSampleEmpty", 1);
        }


        submitButton = $(document.getElementsByName("saveButton"));
        let placement = 'right';
        submitButton.popover({trigger: 'manual', content: "保存成功", placement: placement}).popover('show');
        submitButton.next('.popover').addClass('popover-success');

        function distroy() {
            submitButton.popover('destroy')
        }

        setTimeout(distroy, 500);
        setTimeout($.zui.closeModal, 500);
    }
</script>


<style type="text/css">
    #testTable {
        border: 1px solid #ddd;
    }

    .cl1 {
        background-color: #FFFFFF;
    }

    .cl2 {
        background-color: #FFFF99;
    }
</style>


<?php include '../../common/view/footer.lite.html.php'; ?>


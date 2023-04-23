<?php include '../../common/view/header.lite.html.php'; ?>
<div id='mainContent' class='main-content'>
    <div class='main-header'>
        <h2>填写数据样本</h2>
    </div>

    <div style="text-align:center">
        <form class='load-indicator main-form form-ajax'
              method='post' enctype='multipart/form-data'
              id='dataform' data-type='ajax'>
            <div class='alert with-icon alert-pure' id="datasamplealert">
                <i class='icon-exclamation-sign'></i>
                <div class='content'>
                    <b>请先填写数据规则</b>
                </div>
            </div>
            <table id="sampleTable"
                   class='table table-form mg-0 table-bordered'>
                <thead>
                    <tr class="text-center">
                    </tr>
                </thead>

                <tbody id='steps' class='sortable'>
                </tbody>

            </table>
            <br><br>
            <!--<button class="btn" type="button" onclick="addRow();">添加输入项</button>
            <button class="btn" type="button" onclick="addCol();">添加测试样本</button>-->
            <div id="modalAction">
                <button name="generateSampleButton" class="btn btn-wide btn-info"
                        type="button" onclick="regenerateDataSample();">
                    生成示例样本
                </button>
                <button name="saveButton" class="btn btn-wide btn-primary"
                        type="button" onclick="save_in_cookie();">
                    保存
                </button>
            </div>
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
    //  当前数据样本，二维数组，内容是string
    let curDataSample

    $(function () {
        stepID = $.cookie('curStepID');
        // 获得数据输入项及规则
        let nameStr = 'inputs_rules[' + stepID + ']';
        let selector = parent.document.getElementsByName(nameStr);
        let element = $(selector);
        dataSampleRuleFromInput = element.attr("value");
        // console.log(dataSampleRuleFromInput)

        // 获得已填数据样本
        let nameStr2 = 'datasample[' + stepID + ']';
        let selector2 = parent.document.getElementsByName(nameStr2);
        let element2 = $(selector2);
        curDataSample = element2.attr("value");
        // console.log(curDataSample)

        if (dataSampleRuleFromInput.length > 0) {
            dataSampleRuleFromInput = JSON.parse(dataSampleRuleFromInput);
            // console.log(dataSampleRuleFromInput)
            ruleCountMax = dataSampleRuleFromInput.length;

            addHead();
            generateTemplate();

            if (curDataSample.length > 0) {
                curDataSample = JSON.parse(curDataSample)
            } else {
                // dataSampleItemJson = ajaxGetDataSampleJson()
                curDataSample = []
                curDataSample.push([]);
                for (let i = 0; i < ruleCountMax; i++) {
                    curDataSample[0].push('')
                }
            }

            generateDataSample()
        }else{
            $('#datasamplealert').css('display',"table")
            $("button").css('display',"none")
            $('br').remove()
        }
        initSteps();

    })

    function addHead() {
        let testTableHead = $('#sampleTable thead tr');
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
        let testTableBody = $('#sampleTable tbody');

        let sampleTemplate = "<tr class='step template' data-type='sample' id='stepTemplate'>"
        sampleTemplate += "<td class='sample-id step-id'></td>";
        sampleTemplate += "<input type='hidden' name='stepType[]' value='sample' class='step-type'>"

        //  列从 0 开始
        for (let i = 0; i < ruleCountMax; i++) {
            sampleTemplate += `<td>
                                <textarea rows='1' class='form-control autosize step-expects input_value'
                                          name='datasampleitem[][]' data-rule=` +
                                 i +
                                ">"+
                                `</textarea>
                                </td>`
        }
        sampleTemplate += `
                <td class='sample-actions step-actions'>
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

    function ajaxGetDataSampleJson(){
        // TODO: ajax请求获取数据样本
        $.ajaxSettings.async = false;
        // url: /module=datasample&method=batchGenerate
        let ajaxGenerateDataSampleLink = createLink('datasample', 'batchGenerate');
        // 准备数据
        let ruleList =[];
        for (let i = 0; i < ruleCountMax; i++) {
            ruleList.push({
                id: i,
                mock: dataSampleRuleFromInput[i][1]
            })
        }

        let ret;

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
                        // dataSampleItemJson = response
                        ret = response
                    }
                },
                error: function () {
                    // changeTableEngine();
                }
            }
        )
        $.ajaxSettings.async = true;

        return ret
    }

    // 根据curDataSample 重新生成数据样本
    /**
     * @param {boolean} clear 是否清空已有填写
     */
    function generateDataSample(clear = false){
        let testTableBody = $('#sampleTable tbody');
        if(clear){
            testTableBody.find('tr:not(.template)').remove()
        }

        let sampleNum = curDataSample.length;

        for (let i = 1; i <= sampleNum; i++) {
            let curSample = curDataSample[i-1];
            // let sampleTemplate = "<tr class='step '>"
            let sampleTemplate = "<tr class='step' data-type='sample'>"
            sampleTemplate += "<td class='sample-id step-id'>"+ i +"</td>";
            sampleTemplate += "<input type='hidden' name='stepType[]' value='sample' class='step-type'>"

            for (let j = 0; j < ruleCountMax; j++) {
                sampleTemplate += "<td><textarea rows='1' class='form-control autosize step-expects' " +
                    "name='datasampleitem[" + i + "][" + j + "]' data-rule="+ j + ">" +
                    ((curSample[j]) ? curSample[j] : '') +
                    "</textarea>" +
                    "</td>"
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
            if(!clear){
                let $steps = $('#steps');
                refreshSteps(true,$steps)
            }
        }

    }

    function regenerateDataSample(){
        bootbox.dialog({
            title: '<b>生成示例样本</b>',
            message: `<p>是否生成示例样本?  注意『<b> 重置生成 </b>』会清空已有填写.</p>`,
            size: 'large',
            buttons: {
                cancel: {
                    label: '<i class="icon icon-close"></i> 取消',
                    className: 'btn-danger',
                    callback: function(){
                    }
                },
                reload: {
                    label: '<i class="icon icon-exchange"></i> 重置生成',
                    className: 'btn-warning',
                    callback: function() {
                        // Todo : ajax
                        // dataSampleItemJson = ajaxGetDataSampleJson()
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
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    },
                                    {
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    }

                                ],
                                [
                                    {
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    },
                                    {
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    }

                                ],
                            ]
                        }
                        curDataSample = sampleJsonConvertToArray(dataSampleItemJson)
                        generateDataSample(true)
                        // 阻止关闭
                        // return false;
                    }
                },
                add: {
                    label: '<i class="icon icon-check"></i> 添加生成',
                    className: 'btn-primary',
                    callback: function() {
                        // Todo : ajax
                        // dataSampleItemJson = ajaxGetDataSampleJson()
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
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    },
                                    {
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    }

                                ],
                                [
                                    {
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    },
                                    {
                                        type: 'int',
                                        content:{
                                            id: '0',
                                            value: '123456'
                                        }
                                    }

                                ],
                            ]
                        }
                        curDataSample = sampleJsonConvertToArray(dataSampleItemJson)
                        generateDataSample()
                    }
                }
            },
            callback: function (result) {
            }
        })
    }

    function sampleJsonConvertToArray(sampleJson){
        let ret = [];
        let samples = sampleJson.samples
        for (let i = 0; i < samples.length ; i++) {
            let sample =[];
            for (let j = 0; j < samples[i].length; j++) {
                sample.push(samples[i][j].content.value)
            }
            ret.push(sample)
        }
        return ret
    }

    function save_in_cookie() {
        let form = document.getElementById("dataform"); // get form element
        let matrix = []; // initialize empty array
        for (let i = 0; i < form.elements.length; i++) { // loop through each form element
            let element = form.elements[i]; // get current element
            if (element.name.startsWith("datasampleitem")) { // if element name starts with matrix
                let indices = element.name.match(/\d+/g); // get row and column indices from name
                let row = parseInt(indices[0])-1; // get row index as number
                let col = parseInt(indices[1]); // get column index as number
                if (!matrix[row]) { // if row does not exist in array yet
                    matrix[row] = []; // create empty row array
                }
                matrix[row][col] = element.value; // assign element value to array position
            }
        }
        let matrixString = JSON.stringify(matrix); // convert array to string using JSON.stringify()

        let stepID = $.cookie('curStepID');
        let nameStr = 'datasample[' + stepID + ']';
        selector = parent.document.getElementsByName(nameStr);
        element = $(selector);
        element.attr("value", matrixString);

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

<?php include '../../common/view/footer.lite.html.php'; ?>


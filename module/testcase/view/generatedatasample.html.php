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
                    <i class="icon icon-lightbulb"></i>
                    &nbsp;生成示例样本
                </button>
                <button name="clearButton" class="btn btn-wide btn-warning"
                        type="button" onclick="clearDataSample();">
                    <i class="icon icon-trash"></i>
                    &nbsp;一键清空
                </button>
                <button name="saveButton" class="btn btn-wide btn-primary"
                        type="button" onclick="save_in_cookie();">
                    <i class="icon icon-save"></i>
                    &nbsp;保存
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
    let inputArray =[]
    let inputArrayWithResult = []
    //  ajax请求得到的样本示例
    let dataSampleItemJson;
    //  当前数据样本，二维数组，内容是string
    let curDataSample;
    //  转置的数据样本二维矩阵，第一列是字段名称，从第二列开始是样本
    let transDataSampleWithHead;

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
        transDataSampleWithHead = element2.attr("value");
        // console.log(curDataSample)

        if (dataSampleRuleFromInput.length > 0) {
            dataSampleRuleFromInput = JSON.parse(dataSampleRuleFromInput);
            // console.log(dataSampleRuleFromInput)
            ruleCountMax = dataSampleRuleFromInput.length;

            addHead();
            generateTemplate();

            if (transDataSampleWithHead.length > 0 && JSON.parse(transDataSampleWithHead)[0].length>1) {
                transDataSampleWithHead = JSON.parse(transDataSampleWithHead);
                curDataSample = transpose(transDataSampleWithHead).slice(1);
                //curDataSample = JSON.parse(curDataSample)
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

    // 转置数据样本矩阵
    /**
     * @param {array(array())} matrix 传入的二维矩阵
     */
    function transpose(matrix){
        let row_len = matrix.length;
        if(row_len === 0){
            return matrix
        }
        let col_len = matrix[0].length;
        if(col_len === 0){
            return matrix;
        }
        let t_matrix = [];
        for(let i = 0; i < col_len; i += 1){
            t_matrix[i] = []
            for(let j = 0; j < row_len; j += 1){
                t_matrix[i][j] = matrix[j][i];
            }
        }
        return t_matrix;
    }

    function addHead() {
        let testTableHead = $('#sampleTable thead tr');
        // let rowTemplate = "<th class='step-id'> <b>样本编号</b> </th>"

        let rowTemplate = "<th class='sample-id w-50px step-id'> <b>编号</b> </th>"

        let i;
        for (i = 0; i < ruleCountMax; i++) {
            rowTemplate += "<th> <b>" + dataSampleRuleFromInput[i][0] + "</b></th>"
            inputArray.push(dataSampleRuleFromInput[i][0])
            inputArrayWithResult.push(dataSampleRuleFromInput[i][0]);
        }
        // rowTemplate += "<th class='step-actions'> <b>操作</b> </th>";
        rowTemplate += "<th> <b> 预期结果 </b> </th>";
        inputArrayWithResult.push("预期结果");
        rowTemplate += "<th class='sample-actions'> <b>操作</b> </th>";

        testTableHead.append(rowTemplate);
    }

    function generateTemplate(){
        let $steps = $('#steps');

        let sampleTemplate = "<tr class='step template' data-type='sample' id='stepTemplate'>"
        sampleTemplate += "<td class='sample-id w-50px step-id'></td>";
        sampleTemplate += "<input type='hidden' name='stepType[]' value='sample' class='step-type'>"

        //  列从 0 开始
        for (let i = 0; i < ruleCountMax; i++) {
            sampleTemplate += `<td>
                                <textarea rows='1' class='form-control autosize step-expects'
                                          name='datasampleitem[][]' data-rule=` + i + ">"+
                                `</textarea></td>`
        }
        sampleTemplate += `<td>
                                <textarea rows='1' class='form-control autosize step-expects'
                                          name='datasampleitem[][]' data-rule=` + ruleCountMax + ">"+
            `</textarea></td>`
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
        $steps.append(sampleTemplate);
    }

    // 根据curDataSample 重新生成数据样本
    /**
     * @param {boolean} clear 是否清空已有填写
     */
    function generateDataSample(clear = false){
        let $steps = $('#steps');
        if(clear){
            $steps.find('tr:not(.template)').remove()
        }

        let sampleNum = curDataSample.length;
        // console.log($('#stepTemplate'))
        let $stepTemplate = $('#stepTemplate').clone(true).removeClass('template')
                                            .attr('id', null);
        let $step;

        for (let i = 1; i <= sampleNum; i++) {
            $step = $stepTemplate.clone(true);
            $steps.append($step);
            $step.addClass('step-new').addClass('text-center').addClass('step-step');
            $step.find('.step-id').text(i);

            let curSample = curDataSample[i-1];

            var lastTD;


            $step.find('[name^="datasampleitem["]').each(function ()
                {
                    lastTD = $(this);
                    let rule = $(this).attr('data-rule');
                    if(rule == (curSample.length-1)){
                        $(this).attr('name',"datasampleitem[" +stepID + ']['+ rule +']')
                            .attr('value','')
                    }else{
                        $(this).attr('name',"datasampleitem[" +stepID + ']['+ rule +']')
                            .attr('value',(curSample[rule]?curSample[rule]:''))
                    }
                    $.autoResizeTextarea(this);
                }

            )

            lastTD.attr('value',(curSample[curSample.length-1]?curSample[curSample.length-1]:''));
        }

        refreshSteps(true,$steps)

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
                        dataSampleItemJson = ajaxGetDataSampleJson()
                        // console.log(dataSampleItemJson)
                        curDataSample = sampleJsonConvertToArray(dataSampleItemJson)
                        // console.log(curDataSample)
                        //生成预期结果默认值
                        for(let key in curDataSample){
                            curDataSample[key].push('');
                        }
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
                        dataSampleItemJson = ajaxGetDataSampleJson()
                        curDataSample = sampleJsonConvertToArray(dataSampleItemJson)
                        //生成预期结果默认值
                        for(let key in curDataSample){
                            curDataSample[key].push('');
                        }
                        generateDataSample()
                    }
                }
            },
            callback: function (result) {
            }
        })
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
                id: dataSampleRuleFromInput[i][0],
                mock: dataSampleRuleFromInput[i][1]
            })
        }

        // console.log("ajax body数据")
        // console.log(ruleList)
        let ret;
        $.ajax(
            {
                method: "POST",
                dataType: 'json',
                url: ajaxGenerateDataSampleLink,
                data:
                    {
                        "list":ruleList
                    },
                success: function (response) {
                    // console.log(response)
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

        // console.log(ret)

        return ret
    }

    function sampleJsonConvertToArray(sampleJson){
        let ret = [];
        let samples = sampleJson.samples
        for (let i = 0; i < samples.length ; i++) {
            let sample =[];
            let curSampleContent = samples[i].content
            curSampleContent.sort(
                (a,b)=>{
                    return inputArray.indexOf(a.id) -  inputArray.indexOf(b.id)
                }
            )
            for (let j = 0; j < curSampleContent.length; j++) {
                sample.push(curSampleContent[j].value)
            }
            ret.push(sample)
        }
        return ret
    }

    function clearDataSample(){
        let $steps = $('#steps');
        $steps.find('tr:not(.template, [data-index="1"])').remove()

    }

    function save_in_cookie() {
        $('#stepTemplate').remove()

        let form = document.getElementById("dataform"); // get form element
        let matrix = []; // initialize empty array
        matrix[0] = [];
        for(let j = 0; j < inputArrayWithResult.length; j += 1){
            matrix[0][j] = inputArrayWithResult[j];
        }
        for (let i = 0; i < form.elements.length; i++) { // loop through each form element
            let element = form.elements[i]; // get current element
            if (element.name.startsWith("datasampleitem")) { // if element name starts with matrix
                let indices = element.name.match(/\d+/g); // get row and column indices from name
                let row = parseInt(indices[0]); // get row index as number
                let col = parseInt(indices[1]); // get column index as number
                if (!matrix[row]) { // if row does not exist in array yet
                    matrix[row] = []; // create empty row array
                }
                matrix[row][col] = element.value; // assign element value to array position
            }
        }
        matrix = transpose(matrix);
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


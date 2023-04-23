

<?php include '../../common/view/header.lite.html.php';?>
<div id='mainContent' class='main-content'>

    <div class='main-header'>
        <h2 id="fromStep"></h2>
    </div>
    <div style="text-align:center">
        <?php echo $this->loadModel('ztinterface')->generateMockListForTestCaseModel('rule_list','rule_list'); ?>
        <form class='load-indicator main-form form-ajax' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
            <table class='table table-form mg-0 table-bordered' id="stepform" style='border: 1px solid #ddd; '>
                <thead>
                <tr class="text-center">
                    <th class='w-40px text-center' hidden>编号</th>
                    <th class='w-60px text-center'>数据输入项</th>
                    <th class='w-100px text-center'>MOCK规则</th>
                    <th class='w-40px text-center'>是否必填</th>
                    <th class='w-80px text-center'>正常示例值</th>
                    <th class='w-80px text-center'>异常示例值</th>
                    <th class='step-actions'><?php echo $lang->actions;?></th>

                </tr>
                </thead>
                <tbody id='steps' class='sortable' data-group-name='<?php echo $lang->testcase->groupName ?>'>
                <tr class='template step' id='stepTemplate'>
                    <td class='step-id' hidden></td>
                    <td>
                        <textarea id="inputs" rows='1' class='form-control autosize step-steps' name='inputs_rules[][]'></textarea>
                        <input type='hidden' name='stepType[]' value='sampleInput' class='step-type'>
                    </td>
                    <td>

                        <?php echo html::input('inputs_rules[][]','', "id='rules' list='rule_list' class='step-rules'");?>
                    </td>
                    <td>
                        <?php $notNullPairs = [0=>"否",1=>"是"]; $selectedID=0;?>
                        <?php echo html::select('inputs_rules[][]', $notNullPairs, $selectedID, "class='form-control chosen' id='notNull'");?>
                    </td>
                    <td><textarea rows='1' class='form-control autosize step-expects' name='normal_examples[]'></textarea></td>
                    <td><textarea rows='1' class='form-control autosize step-expects' name='abnormal_examples[]'></textarea></td>
                    <td class='step-actions'>
                        <div class='btn-group'>
                            <button type='button' title="刷新示例值" class='btn mock-refresh'>
                                <i class='icon icon-undo'></i>
                            </button>
                            <button type='button' class='btn btn-step-add' tabindex='-1'><i class='icon icon-plus'></i></button>
                            <button type='button' class='btn btn-step-move' tabindex='-1'><i class='icon icon-move'></i></button>
                            <button type='button' class='btn btn-step-delete' tabindex='-1'><i class='icon icon-close'></i></button>
                        </div>
                    </td>

                </tr>
                </tbody>
            </table>
        <br><br>
        <button name="saveButton" class="btn btn-wide btn-primary" type="button" onclick="save_in_cookie();">保存</button>
        <br><br>
        </form>
    </div>
</div>

    <script type="text/javascript">

        $(function()
        {
            var stepID = $.cookie('curStepID');
            $("#fromStep").text('数据规则#' + stepID);

            var nameStr = 'inputs_rules['+stepID+']';
            selector = parent.document.getElementsByName(nameStr);
            element = $(selector);
            var curInputsRules = element.attr("value");

            var $steps = $('#steps');
            var $stepTemplate = $('#stepTemplate').clone(true).removeClass('template').attr('id', null);

            if(curInputsRules && curInputsRules.length > 0){

                curInputsRules = JSON.parse(curInputsRules);
                var rowCountMax = curInputsRules.length;

                for(i = 1; i <= rowCountMax; i += 1){
                    $stepTemplate = $('#stepTemplate').clone(true).removeClass('template').attr('id', null);
                    var $step = $stepTemplate.clone(true);
                    $steps.append($step);
                    $step.addClass('step-new').addClass('text-center').addClass('step-step');
                    $step.find('.step-id').text(i);
                    $step.find('[id^="inputs"]').attr('name', "inputs_rules["+i+"][0]").attr('value', curInputsRules[i-1][0]);
                    $step.find('[id^="rules"]').attr('name', "inputs_rules["+i+"][1]").attr('value', curInputsRules[i-1][1]);
                    $step.find('[id^="notNull"]').attr('name', "inputs_rules["+i+"][2]").attr('value', curInputsRules[i-1][2]);
                    $step.find('[name^="normal_examples["]').attr('name', "normal_examples["+i+"]");
                    $step.find('[name^="abnormal_examples["]').attr('name', "abnormal_examples["+i+"]");
                    $step.attr('data-type', 'sampleInput').find('.step-steps').addClass('autosize').attr('placeholder', '输入项名称');
                    $step.attr('data-index', i);
                }

            }else{
                var $step = $stepTemplate.clone(true);
                $steps.append($step);
                $step.addClass('step-new').addClass('text-center').addClass('step-step');
                $step.find('.step-id').text('1');
                $step.find('[id^="inputs"]').attr('name', "inputs_rules[1][0]");
                $step.find('[id^="rules"]').attr('name', "inputs_rules[1][1]");
                $step.find('[id^="notNull"]').attr('name', "inputs_rules[1][2]");
                $step.find('[name^="normal_examples["]').attr('name', "normal_examples[1]");
                $step.find('[name^="abnormal_examples["]').attr('name', "abnormal_examples[1]");
                $step.attr('data-type', 'sampleInput').find('.step-steps').addClass('autosize').attr('placeholder', '输入项名称');
                $step.attr('data-index', 1);
            }
            initSteps();
        })


        function save_in_cookie(){
            $('#stepTemplate').remove()

            var form = document.getElementById("dataform"); // get form element
            var matrix = []; // initialize empty array
            for (var i = 0; i < form.elements.length; i++) { // loop through each form element
                    var element = form.elements[i]; // get current element
                    if (element.name.startsWith("inputs_rules")) { // if element name starts with matrix
                        var indices = element.name.match(/\d+/g); // get row and column indices from name
                        var row = parseInt(indices[0])-1; // get row index as number
                        var col = parseInt(indices[1]); // get column index as number
                        if (!matrix[row]) { // if row does not exist in array yet
                            matrix[row] = []; // create empty row array
                        }
                        matrix[row][col] =element.value; // assign element value to array position
                    }
            }
            var matrixString = JSON.stringify(matrix); // convert array to string using JSON.stringify()

            var stepID = $.cookie('curStepID');
            var nameStr = 'inputs_rules['+stepID+']';
            selector = parent.document.getElementsByName(nameStr);
            element = $(selector);
            element.attr("value", matrixString);



            submitButton = $(document.getElementsByName("saveButton"));
            var placement =  'right';
            submitButton.popover({trigger:'manual', content:"保存成功", placement:placement}).popover('show');
            submitButton.next('.popover').addClass('popover-success');
            function distroy(){submitButton.popover('destroy')}
            setTimeout(distroy,500);
            setTimeout($.zui.closeModal, 500);
        }
    </script>



<?php include '../../common/view/footer.lite.html.php';?>


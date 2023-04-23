$(function()
{
    $('#subNavbar a[data-toggle=dropdown]').parent().addClass('dropdown dropdown-hover');

    if(window.flow != 'full')
    {
        $('.querybox-toggle').click(function()
        {
            $(this).parent().toggleClass('active');
        });
    }
})

var newRowID = 0;
/**
 * Load modules and stories of a product.
 *
 * @param  int     $productID
 * @access public
 * @return void
 */
function loadAll(productID)
{
    loadProductBranches(productID)
}

/**
 * Load by branch.
 *
 * @access public
 * @return void
 */
function loadBranch()
{
    var branch = $('#branch').val();
    if(typeof(branch) == 'undefined') branch = 0;
    loadProductModules($('#product').val(), branch);
    setStories();
}

/**
 * Load product branches.
 *
 * @param  int $productID
 * @access public
 * @return void
 */
function loadProductBranches(productID)
{
    $('#branch').remove();

    var param     = page == 'create' ? 'active' : 'all';
    var oldBranch = page == 'edit' ? caseBranch : 0;
    var param     = "productID=" + productID + "&oldBranch=" + oldBranch + "&param=" + param;
    if(typeof(tab) != 'undefined' && (tab == 'execution' || tab == 'project')) param += "&projectID=" + objectID;
    $.get(createLink('branch', 'ajaxGetBranches', param), function(data)
    {
        if(data)
        {
            $('#product').closest('.input-group').append(data);
            $('#branch').css('width', config.currentMethod == 'create' ? '120px' : '95px');
        }

        loadProductModules(productID);
        setStories();
    })
}

/**
 * Load stories of module.
 *
 * @access public
 * @return void
 */
function loadModuleRelated()
{
    setStories();
}

/**
 * Load module.
 *
 * @param  int    $productID
 * @access public
 * @return void
 */
function loadProductModules(productID, branch)
{
    if(typeof(branch) == 'undefined') branch = $('#branch').val();
    if(!branch) branch = 0;
    var currentModuleID = config.currentMethod == 'edit' ? $('#module').val() : 0;
    link = createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=case&branch=' + branch + '&rootModuleID=0&returnType=html&fieldID=&needManage=true&extra=&currentModuleID=' + currentModuleID);
    $('#moduleIdBox').load(link, function()
    {
        var $inputGroup = $(this);
        $inputGroup.find('select').chosen()
        if(typeof(caseModule) == 'string') $('#moduleIdBox').prepend("<span class='input-group-addon'>" + caseModule + "</span>");
        $inputGroup.fixInputGroup();
    });
    setStories();
}

/**
 * Load module.
 *
 * @param  int    $libID
 * @access public
 * @return void
 */
function loadLibModules(libID, branch)
{
    if(typeof(branch) == 'undefined') branch = 0;
    if(!branch) branch = 0;
    link = createLink('tree', 'ajaxGetOptionMenu', 'rootID=' + libID + '&viewtype=caselib&branch=' + branch + '&rootModuleID=0&returnType=html&fieldID=&needManage=true');
    $('#moduleIdBox').load(link, function()
    {
        $(this).find('select').chosen()
        if(typeof(caseModule) == 'string') $('#moduleIdBox').prepend("<span class='input-group-addon'>" + caseModule + "</span>")
    });
}

/**
 * Set story field.
 *
 * @access public
 * @return void
 */
function setStories()
{
    moduleID  = $('#module').val();
    productID = $('#product').val();
    branch    = $('#branch').val();
    if(typeof(branch) == 'undefined') branch = 0;
    link = createLink('story', 'ajaxGetProductStoriesTestcase', 'productID=' + productID + '&branch=' + branch + '&moduleID=' + moduleID + '&storyID=0&onlyOption=false&status=noclosed&limit=0&type=full&hasParent=1&executionID=' + executionID);

    $.get(link, function(stories)
    {
        var value = $('#story').val();
        if(!stories) stories = '<select id="story" name="story"></select>';
        $('#story').replaceWith(stories);
        $('#story').val(value);
        $('#story_chosen').remove();
        $('#story').next('.picker').remove();
        $("#story").picker();
    });
}

/**
 * Init testcase steps in form
 *
 * @param  string selector
 * @access public
 * @return void
 */
function initSteps(selector)
{
    /* Fix task #4832. Auto adjust textarea height. */
    $('textarea.autosize').each(function()
    {
        $.autoResizeTextarea(this);
    });

    var $steps = $(selector || '#steps');
    var $stepTemplate = $('#stepTemplate').detach().removeClass('template').attr('id', null);
    var groupNameText = $steps.data('groupName');

    $steps.on('click', '.btn-step-add', function()
    {
        var $step = $(this).closest('.step');
        var type = $step.find('.step-type').val();
        if(type === 'group'){
            $step = $stepTemplate.clone();
            $steps.append($step);
            $step.addClass('step-new');
            $step.find('.step-type').val('step');
        }else{
            insertStepRow($step,undefined,undefined,undefined,$steps,$stepTemplate);
        }
        refreshSteps(true,$steps);
    }).on('click', '.btn-step-delete', function()
    {
        if($steps.children('.step').length == 1) return;
        $(this).closest('.step').remove();
        refreshSteps(true,$steps);
    })
       /* .on('change', '.step-group-toggle', function()
    {
        var $checkbox = $(this);
        var $step = $checkbox.closest('.step');
        var isChecked = $checkbox.is(':checked');
        var suggestType = isChecked ? 'group' : 'item';
        if(!isChecked)
        {
            var $prevStep = $step.prev('.step:not(.drag-shadow)');
            var suggestChild = $prevStep.length && $prevStep.is('.step-group') && $step.next('.step:not(.drag-shadow)').length;
            suggestType = suggestChild ? 'item' : 'step';
            $steps.find('.step-group-toggle2').prop("checked",false);
        }
        $step.find('.step-type').val(suggestType);


        /!* Auto insert step to group without any steps *!/
        if(suggestType === 'group')
        {
            var $nextStep = $step.next('.step:not(.drag-shadow)');
            if(!$nextStep.length || $nextStep.find('.step-type').val() !== 'item')
            {
                insertStepRow($step, 1, 'item', true);
            }
        }

        refreshSteps();
    }).on('change', '.step-group-toggle2', function()
    {
        refreshSteps();
    })*/
        .on('change', '.form-control', function()
    {
        var $control = $(this);
        if($control.val())
        {
            var $step = $control.closest('.step');
            if($step.data('index') === getStepsElements($steps).length)
            {
/*                insertStepRow($step, 1, 'step', true);
                if($step.is('.step-item,.step-group')) insertStepRow($step, 1, 'item', true);*/
                refreshSteps(true,$steps);
            }
        }
    }).on('click', '.btn-datasample', function()
    {
        var $step = $(this).closest('.step');
        var stepID = $step.find('.step-id').text();
        $.cookie('curStepID', stepID);
    }).on('click', '.btn-generatedatasample', function()
    {
        var $step = $(this).closest('.step');

        var stepID = $step.find('.step-id').text();
        $.cookie('curStepID', stepID);

    }).on('click', '.datasample-undo', function()
    {
        var $step = $(this).closest('.step');
        var $stepInput = $step.find('#datasample');
        // console.log($stepInput.attr('value'));
        $stepInput.attr('value','');
        // console.log($stepInput.attr('value'));

        $.removeCookie('isSampleEmpty')

        var stepID = $step.find('.step-id').text();

        var $otherDatasampleActions = $('#steps tr[data-index!="'+ stepID +'"] td.stepsample-actions');

        $otherDatasampleActions.find('a').removeAttr("disabled").css("pointer-events","");
        $otherDatasampleActions.find('button').removeAttr("disabled");

        new $.zui.Messager('成功清除数据样本', {
            type: 'success',
            close: true,
            icon: 'exclamation-sign',
            time: 900 // 不进行自动隐藏
        }).show();

    }).on('click', '.mock-refresh', function()
    {
        var $step = $(this).closest('.step');
        var $mockRule = $step.find('#rules').val();
        var $notNull = $step.find('#notNull').val();
        var testUrl = createLink('datasample', 'singleMock');
        $.post(testUrl, {'mock': $mockRule, 'notNull': $notNull}, function(result){
            var resultObject = JSON.parse(result);
            if(resultObject['message'] === 'success'){
                console.log(resultObject);
                $step.find('[name^="normal_examples["]').val(resultObject['value']);

                if(resultObject['exception'] && resultObject['exception'].length>0){
                    var exceptions_len = resultObject['exception'].length;
                    var selected_exception_index = Math.floor(Math.random()*exceptions_len);
                    $step.find('[name^="abnormal_examples["]').val(resultObject['exception'][selected_exception_index]['value']);
                }

                /*var exceptions = "";
                for(let exception of resultObject['exception']){
                    exceptions += ('['+exception['type']+']'+exception['value']+'\n');
                }
                $step.find('[name^="abnormal_examples["]').val(exceptions).autosize();*/
                new $.zui.Messager('成功刷新mock示例值', {
                    type: 'success',
                    close: true,
                    icon: 'exclamation-sign',
                    time: 500 // 不进行自动隐藏
                }).show();
            }else{
                new $.zui.Messager(resultObject['error'], {
                    type: 'warning',
                    close: true,
                    icon: 'exclamation-sign',
                    time: 500 // 不进行自动隐藏
                }).show();
            }

        });

    });
    initSortable($steps);
    refreshSteps(true,$steps);
}

var insertStepRow = function($row, count, type, notFocus,$steps,$stepTemplate)
{
    if(count === undefined) count = 1;
    var $step;
    for(var i = 0; i < count; ++i)
    {
        $step = $stepTemplate.clone(true);
        if($row) $row.after($step);
        else $steps.append($step);
        $step.addClass('step-new').addClass('text-center');

        if($row.find('.step-type').val()=='step' && $.cookie('isSampleEmpty')==0 && $('#steps tr td.stepsample-actions input').val()!=''){
            var $stepSampleActions = $step.find('td.stepsample-actions');
            $stepSampleActions.find('a').attr("disabled",true).css("pointer-events","none");
            $stepSampleActions.find('button').attr("disabled",true);
        }
        if(type) $step.find('.step-type').val(type);
    }

    if(!notFocus && $step) setTimeout(function(){$step.find('.step-steps').focus();}, 10);
};
var updateStepType = function($step, type, defaultText)
{
    $step.attr('data-type', type).find('.step-steps').addClass('autosize').attr('placeholder', defaultText);
};
var getStepsElements = function($steps)
{
    return $steps.children('.step:not(.drag-shadow)');
};
var refreshSteps = function(skipAutoAddStep = true,$steps)
{
    var parentId = 1, childId = 0;

    getStepsElements($steps).each(function(idx)
    {
        var $step = $(this).attr('data-index', idx + 1);
        var type = $step.find('.step-type').val();
        var stepID;
        var defaultText = null;
        if(type == 'group')
        {
            $step.removeClass('step-item').removeClass('step-step').addClass('step-group');
            stepID = parentId++;
            $step.find('.step-id').text(stepID);
            childId = 1;
            defaultText = groupNameText;
        }
        else if(type == 'step')
        {
            $step.removeClass('step-item').removeClass('step-group').addClass('step-step');
            stepID = parentId++;
            $step.find('.step-id').text(stepID);
            childId = 0;
        }else if(type == 'sampleInput'){
            $step.removeClass('step-item').removeClass('step-group').addClass('step-step');
            stepID = parentId++;
            $step.find('.step-id').text(stepID);
            childId = 0;
            defaultText = '输入项名称';
        }else if(type == 'sample'){
            $step.removeClass('step-item').removeClass('step-group').addClass('step-step');
            stepID = parentId++;
            $step.find('.step-id').text(stepID);
            childId = 0;
        }
        else // step type is not set
        {
            if(childId) // type as child
            {
                stepID = (parentId - 1) + '.' + (childId++);
                $step.removeClass('step-step').removeClass('step-group').addClass('step-item').find('.step-item-id').text(stepID);
                defaultText = "输入项名称";
                if($step.find('.step-group-toggle2').is(':checked')){
                    defaultText = "输出项名称";
                }
            }
            else // type as step
            {
                $step.removeClass('step-item').removeClass('step-group').addClass('step-step');
                stepID = parentId++;
                $step.find('.step-id').text(stepID);
            }
        }
        $step.find('[name^="steps["]').attr('name', "steps[" +stepID + ']');
        $step.find('[name^="stepType["]').attr('name', "stepType[" +stepID + ']');
        //从1开始索引
        $step.find('[name^="inputs["]').attr('name', "inputs[" +stepID + ']');
        $step.find('[name^="goal_actions["]').attr('name', "goal_actions[" +stepID + ']');
        $step.find('[name^="expects["]').attr('name', "expects[" +stepID + ']');
        $step.find('[name^="eval_criterias["]').attr('name', "eval_criterias[" +stepID + ']');
        $step.find('[name^="stepIoType["]').attr('name', "stepIoType[" +stepID + ']');
        $step.find('[name^="datasample["]').attr('name', "datasample[" +stepID + ']');
        $step.find('[name^="is_updated["]').attr('name', "is_updated[" +stepID + ']');
        $step.find('[name^="inputs_rules["]').attr('name', "inputs_rules[" +stepID + ']');

        if(type == 'sampleInput'){
            $step.find('[id^="inputs"]').attr('name', "inputs_rules[" +stepID + "][0]");
            $step.find('[id^="rules"]').attr('name', "inputs_rules[" +stepID + "][1]");
            $step.find('[id^="notNull"]').attr('name', "inputs_rules[" +stepID + "][2]");
            $step.find('[name^="normal_examples["]').attr('name', "normal_examples[" +stepID + ']');
            $step.find('[name^="abnormal_examples["]').attr('name', "abnormal_examples[" +stepID + ']');
        }else if(type == 'sample'){
            $step.find('[name^="datasampleitem["]').each(function ()
                {
                    let rule = $(this).attr('data-rule');
                    $(this).attr('name',"datasampleitem[" +stepID + ']['+ rule +']')
                }
            )

        }
        updateStepType($step, type, defaultText);
    });

    /* Auto insert step to group without any steps */
    if(!skipAutoAddStep)
    {
        var needRefresh = false;
        getStepsElements($steps).each(function(idx)
        {
            var $step = $(this).attr('data-index', idx + 1);
            if($step.attr('data-type') !== 'group') return;
            var $nextStep = $step.next('.step:not(.drag-shadow)');
            if(!$nextStep.length || $nextStep.attr('data-type') !== 'item')
            {
                insertStepRow($step, 1, 'item', true,$steps);
                needRefresh = true;
            }
        });

        if(needRefresh) refreshSteps(true,$steps);
    }
};
var initSortable = function($steps)
{
    var isMouseDown = false;
    var $moveStep = null, moveOrder = 0;
    $steps.on('mousedown', '.btn-step-move', function()
    {
        isMouseDown = true;
        $moveStep = $(this).closest('.step').addClass('drag-row');

        $(document).off('.sortable').one('mouseup.sortable', function()
        {
            isMouseDown = false;
            $moveStep.removeClass('drag-row');
            $steps.removeClass('sortable-sorting');
            $moveStep = null;
            refreshSteps(true,$steps);
        });
        $steps.addClass('sortable-sorting');
    }).on('mouseenter', '.step:not(.drag-row)', function()
    {
        if(!isMouseDown) return;
        var $targetStep = $(this);
        getStepsElements($steps).each(function(idx)
        {
            $(this).data('order', idx);
        });
        moveOrder = $moveStep.data('order');
        var targetOrder = $targetStep.data('order');
        if(moveOrder === targetOrder) return;
        else if(targetOrder > moveOrder)
        {
            $targetStep.after($moveStep);
        }
        else if(targetOrder < moveOrder)
        {
            $targetStep.before($moveStep);
        }
    });
}

/**
 * Update the step id.
 *
 * @access public
 * @return void
 */
function updateStepID()
{
    var i = 1;
    $('.stepID').each(function(){$(this).html(i ++)});
}

/**
 * Set stories.
 *
 * @param  int     productID
 * @param  int     moduleID
 * @param  int     num
 * @access public
 * @return void
 */
function loadStories(productID, moduleID, num)
{
    var branchIDName = (config.currentMethod == 'batchcreate' || config.currentMethod == 'showimport') ? '#branch' : '#branches';
    var branchID     = $(branchIDName + num).val();
    var storyLink    = createLink('story', 'ajaxGetProductStories', 'productID=' + productID + '&branch=' + branchID + '&moduleID=' + moduleID + '&storyID=0&onlyOption=false&status=noclosed&limit=0&type=full&hasParent=1&executionID=0&number=' + num);
    $.get(storyLink, function(stories)
    {
        if(!stories) stories = '<select id="story' + num + '" name="story[' + num + ']" class="form-control"></select>';
        if(config.currentMethod == 'batchcreate')
        {
            for(var i = num; i <= rowIndex ; i ++)
            {
                if(i != num && $('#module' + i).val() != 'ditto') break;
                var nowStories = stories.replaceAll('story' + num, 'story' + i);
                $('#story' + i).replaceWith(nowStories);
                $('#story' + i + "_chosen").remove();
                $('#story' + i).next('.picker').remove();
                $('#story' + i).attr('name', 'story[' + i + ']');
                $('#story' + i).picker();
            }
        }
        else
        {
            $('#story' + num).replaceWith(stories);
            $('#story' + num + "_chosen").remove();
            $('#story' + num).next('.picker').remove();
            $('#story' + num).attr('name', 'story[' + num + ']');
            $('#story' + num).picker();
        }
    });
}

/**
 * Set modules.
 *
 * @param  int     $branchID
 * @param  int     $productID
 * @param  int     $num
 * @access public
 * @return void
 */
function setModules(branchID, productID, num)
{
    moduleLink = createLink('tree', 'ajaxGetModules', 'productID=' + productID + '&viewType=case&branch=' + branchID + '&num=' + num);
    $.get(moduleLink, function(modules)
    {
        if(!modules) modules = '<select id="module' + num + '" name="module[' + num + ']" class="form-control"></select>';
        $('#module' + num).replaceWith(modules);
        $("#module" + num + "_chosen").remove();
        $("#module" + num).next('.picker').remove();
        $("#module" + num).attr('onchange', "loadStories("+ productID + ", this.value, " + num + ")").chosen();
    });

    loadStories(productID, 0, num);

    /* If the branch of the current row is inconsistent with the one below, clear the module and story of the nex row. */
    var nextBranchID = $('#branch' + (num + 1)).val();
    if(nextBranchID != branchID)
    {
        $('#module' + (num + 1)).find("option[value='ditto']").remove();
        $('#module' + (num + 1)).trigger("chosen:updated");

        $('#plan' + (num + 1)).find("option[value='ditto']").remove();
        $('#plan' + (num + 1)).trigger("chosen:updated");
    }
}

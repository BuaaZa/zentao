function toggleChildren(btn) {
  var parentRow = btn.parentNode.parentNode.parentNode;
  var parentId = parentRow.getAttribute("id");
  var childRows = document.querySelectorAll("tr[class^='" + parentId + "---child" + "']");
  childRows.forEach(function(childRow) {
    childRow.style.display = childRow.style.display === 'none' ? 'table-row' : 'none';
  });
  btn.classList.toggle("icon-angle-down");
  btn.classList.toggle("icon-angle-right");
}

$('select.object-chosen').change(function() {
  var selectValue = $(this).val();
  $(this).siblings('input.value-input').val(selectValue);
  var parentRow = this.parentNode;
  while(parentRow.nodeName!=="TR"){
    parentRow = parentRow.parentNode;
  }
  $('tr[id^="leader-_-"]').each(function() {
    // 选择当前行中class为value-input的input元素并将其disabled属性设置为true
    const disValue = parseInt($(this).attr('data-dis'));
    if(selectValue === 'null'){
      $(this).attr('data-dis', disValue + 1);
      $(this).find('.value-input').prop('disabled', true);
    }else if(selectValue === 'input'){
      if(disValue>0){
        $(this).attr('data-dis', disValue - 1);
        if(disValue-1 == 0){
          $(this).find('.value-input').prop('disabled', false);
        }
      }
    }
  });
}); 

const funcTable = [
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
];

var alertBox = document.createElement('div');
alertBox.style.position = 'fixed';
alertBox.style.top = '50%';
alertBox.style.left = '50%';
alertBox.style.transform = 'translate(-50%, -50%)';
alertBox.style.padding = '10px';
alertBox.style.borderRadius = '5px';
alertBox.style.backgroundColor = '#1E90FF';
alertBox.style.color = 'white';
alertBox.style.zIndex = '9999';
alertBox.style.fontWeight = 'bold';
document.body.appendChild(alertBox);
alertBox.style.display = 'none';

$('.input-mock').on('input', function() {
  var $span = $(this).siblings('span#error');
  if ($span.css('display') === 'inline') {
    $span.css('display', 'none');
  }
});

$('.value-input').on('input', function() {
  var button = $("button#genMessage")
  button.html('同步报文');
  button.attr('data-type', 'update');
});

$('.header-value').on('input', function() {
  var button = $("button#genMessage")
  button.html('同步报文');
  button.attr('data-type', 'update');
  var $span = $(this).siblings('span#error');
  if ($span.css('display') === 'inline') {
    $span.css('display', 'none');
  }
});

$('button#genMessage').click(function(){
  var button = $(this);
  if(button.attr('data-type') == 'update'){
    button.html('<i class=" icon-refresh" title="生成报文" data-app="ztinterface"></i><span>生成报文</span>');
    button.attr('data-type', 'gen');
  }else{
    const table = $('#bodys');
    var baseUrl = $('input#baseURL').val();
    var list = getTrData(table, 'body-key', true);
    var head = getHeadData();
    var obj = {item:list,type:'object',notNull:'true'};
    var postData = {object:obj, head:head,id:interfaceID,baseUrl:baseUrl};
    var link = createLink('ztinterface', 'genMessage', '');
    $.post(link, postData, function(res) {
      var response = {};
      try {
        response = JSON.parse(res);
      } catch (error) {
        console.log(res);
        return;
      }
      console.log(response);
      response['value']['response'].forEach(function(obj) {
        fillInValueAndError(obj);
      });
      if(response['value']['message']['header']){
        var headText = $('textarea#messageHeadView');
        headText.val(response['value']['message']['header'].trim()); 
        if (!headText.hasClass('autosize')) { 
            headText.addClass('autosize'); 
        }
        headText.trigger('autosize.resize')
      }
      if(response['value']['message']['body']){
        var bodyText = $('textarea#messageBodyView');
        bodyText.val(JSON.stringify(JSON.parse(response['value']['message']['body'].trim()),null,2)); 
        if (!bodyText.hasClass('autosize')) { 
            bodyText.addClass('autosize'); 
        }
        bodyText.trigger('autosize.resize')
      }
    });
  }
});

$('.all-refresh').click(function(){
  fillInTable(true);
});

$('.fill-in').click(function(){
  var button = $("button#genMessage")
  button.html('同步报文');
  button.attr('data-type', 'update');
  fillInTable(false);
});

$("#saveMock").click(function() {
  var data = [];
  $("#bodys tr").each(function() {
    const $row = $(this);
    const id = $row.attr("id");
    const $input = $row.find("#mock input.input-mock");
    if($input && $input.val()){
      data.push({id:id,mock:$input.val()});
    }
  });
  var button = this;
  if(data.length > 0){
    var link = createLink('ztinterface', 'saveMock', 'id='+interfaceID);
    $.post(link, {data:data}, function(res) {
        message = JSON.parse(res).message;
        if(message == 'success'){
          showAlterbox('保存成功', '#1E90FF', button);
        }else{
          showAlterbox(message, '#FF6347', button);
        }
    });
  }
});


$('.refresh-button').click(function() {
  var button = $("button#genMessage")
  button.html('同步报文');
  button.attr('data-type', 'update');

  var parentRow = this.parentNode;
  while(parentRow.nodeName!=="TR"){
    parentRow = parentRow.parentNode;
  }
  const rowData = parseRow(parentRow);
  var span = $(parentRow).find('td#mock span');
  if(!rowData){
    console.log('fail to parse Row');
    return;
  } 
  var postData = getPostData(rowData);
  var itemSpan = $(parentRow).find('td#mock span');
  
  if(rowData['type'] == 'array'){
    var itemRow = parentRow.nextElementSibling;
    var itemRowData = parseRow(itemRow);
    itemSpan = $(itemRow).find('td#mock span');
    postData['item'] = [getPostData(itemRowData)];
  }
  
  if(!rowData['funcName']){
    if(rowData['mock'].val().trim()){
      showError(span, 'Mock格式不合法');
    }

    var link = createLink('ztinterface', 'mockBase', '');
    $.post(link, postData, function(res) {
      var response = {};
      try {
        response = JSON.parse(res);
      } catch (error) {
        console.log(res);
        return;
      }
      if(response['value'] === undefined || response['value'] === null){
        rowData['value'].val('');
      }else{
        if(postData['type'] == 'array'){
          response['value'] = JSON.stringify(JSON.parse(response['value']));
        }
        rowData['value'].val(response['value']);
      }
      if(response['error']){
        showError(span, response['error']);
      }else{
        hideError(span);
      }
      if(postData['type'] == 'array' && response['item'] &&  response['item']['error']){
        showError(itemSpan, response['item']['error']);
      }else{
        hideError(itemSpan);
      }
    });
    return;
  }
  
  if(funcTable.includes(rowData['funcName'].toLowerCase())){
    var link = createLink('ztinterface', 'mockFunc', '');
  }else{
    var link = createLink('ztinterface', 'mock'+rowData['funcName'], '');
  }
  $.post(link,postData)
  .done(function(res) {
    var response = {};
    try {
      response = JSON.parse(res);
    } catch (error) {
      showError(span, "Mock函数不存在");
      rowData['value'].val('');
      console.log(res);
      return;
    }
    if(response['value'] === undefined || response['value'] === null){
      rowData['value'].val('');
    }else{
      if(postData['type'] == 'array'){
        response['value'] = JSON.stringify(JSON.parse(response['value']));
      }
      rowData['value'].val(response['value']);
    }
    if(response['error']){
      showError(span, response['error']);
    }else{
      hideError(span);
    }
    if(postData['type'] == 'array' && response['item'] &&response['item']['error']){
      showError(itemSpan, response['item']['error']);
    }else{
      hideError(itemSpan);
    }
  })
  .fail(function() {
    console.log("fail");
    showError(span, 'Mock函数不存在');
    rowData['value'].val('');
  });
});

function cnToEn(str) {
  // 替换中文括号
  str = str.replace(/[\uff08\uff09]/g, function(match) {
    if (match === '\uff08') return '(';
    if (match === '\uff09') return ')';
  });
  // 替换中括号
  str = str.replace(/[\u3010\u3011]/g, function(match) {
    if (match === '\u3010') return '[';
    if (match === '\u3011') return ']';
  });
  // 替换双引号和单引号
  str = str.replace(/[\u201c\u201d\u2018\u2019]/g, function(match) {
    if (match === '\u201c' || match === '\u201d') return '"';
    if (match === '\u2018' || match === '\u2019') return "'";
  });
  return str;
}

function showAlterbox(text, bgc, button){
  alertBox.innerHTML = text;
  alertBox.style.backgroundColor = bgc;
  alertBox.style.display = 'block';
  alertBox.style.top = (button.offsetTop - 300) + 'px';
  alertBox.style.left = (button.offsetLeft + button.offsetWidth / 2 - alertBox.offsetWidth / 2 +30) + 'px';

  setTimeout(function() {
    alertBox.style.display = 'none';
  }, 1000);
}

function parseRow(parentRow){
  if($(parentRow).prop("nodeName") !== "TR") {
    return null;
  }
  var id = $(parentRow).prop("id");
  var name = $(parentRow).find("td#name b").text();
  var type = $(parentRow).find("td#type").text();
  var notNull = $(parentRow).find("td#notNull input").prop("checked");
  var mockInput = $(parentRow).find("td#mock input");
  var mock = mockInput.val().trim();
  var valueInput = $(parentRow).find("td#value input");
  type = type.toLowerCase();

  mock = cnToEn(mock);
  var funcName = '';
  var jsonData = '';

  var match = mock.match(/^\$(\w+)\(.*\)$/);
  if(match)
    funcName = match[1];

  if(funcName){
    const paramStr = mock.replace(/^\$\w+\(|\)$/g, '');
    const params = paramStr.match(/("[^"]*"|'[^']*'|\{[^}]*\}|\[[^\]]*\]|[^,]+)+/g);
    jsonData = JSON.stringify(params);
  }else{
    match = mock.match(/^\$(\w+)$/);
    if(match)
    funcName = match[1];
  }

  funcName = funcName.toLowerCase().charAt(0).toUpperCase() + funcName.toLowerCase().substring(1);
  var data = {id:id,name:name,type:type,notNull:notNull,mock:mockInput,funcName:funcName,params:jsonData,value:valueInput,nowVal:valueInput.val()};
  
  return data;
}

function getPostData(rowData){
  var postData = {};
  postData['id'] = rowData['id'];
  postData['name'] = rowData['name'];
  postData['type'] = rowData['type'];
  postData['notNull'] = rowData['notNull'];
  postData['funcName'] = rowData['funcName'];
  postData['params'] = rowData['params'];
  postData['value'] = rowData['nowVal'];
  return postData;
}
function showError(span,message){
  span.text(message);
  span.css('display', 'inline');
}

function hideError(span){
  span.css('display', 'none');
}



function fillInTable(replace = false){
  const table = $('#bodys');
  var list = getTrData(table, 'body-key', replace);
  var postData = {item:list,type:'object',notNull:'true'};
  var link = createLink('ztinterface', 'mockObject', '');
    $.post(link, postData, function(res) {
      var response = [];
      try {
        response = JSON.parse(res);
      } catch (error) {
        console.log(res);
        return;
      }
      response.forEach(function(obj) {
        fillInValueAndError(obj);
      });
    });  
}

function fillInValueAndError(obj){
  var table = $('#bodys');
  var row = table.find('tr#'+obj.id);
  var span = row.find('td#mock span');
  var type = row.find('td#type').text();
  var input = row.find('td#value').find('input.value-input');
  if(type == 'object'){
    var select =row.find('td#value').find('select.object-chosen');
    select.val(obj.value);
    select.trigger('change');
    return;
  }
  if(obj.value === undefined || obj.value === null){
    if (input.prop('disabled')) {
      input.prop('disabled', false);
      input.val('');
      input.prop('disabled', true);
    } else {
      input.val('');
    }
  }else{
    if(type == 'array'){
      obj.value = JSON.stringify(JSON.parse(obj.value));
    }
    if (input.prop('disabled')) {
      input.prop('disabled', false);
      input.val(obj.value);
      input.prop('disabled', true);
    } else {
      input.val(obj.value);
    }
  }
  if(obj.error){
    showError(span, obj.error);
  }else{
    hideError(span);
  }
  if(type == 'array'){
    var itemSpan = table.find('tr.'+obj.id+'---child').find('td#mock span');
    if(obj.item && obj.item.error){
      showError(itemSpan, obj.item.error);
    }else{
      hideError(itemSpan);
    }
  }
}

function getTrData(body, trClass, replace = false){
  var data = [];
  body.find('tr.'+ trClass).each(function(){
    if(replace || $(this).find('#value input.value-input').val() === ''||($(this).find('td#type').text() == 'object' && $(this).find('#value input.value-input').val() === 'input')){
      var rowData = parseRow(this);
      var postData = getPostData(rowData);
      if(postData['type'] == 'object' || postData['type'] == 'array'){
        postData['item'] = getTrData(body, postData['id']+'---child', replace);
      }
      data.push(postData);
    }
  })
  return data;
}

function getHeadData(){
  var data = {};
  $("#headers").find('tr').each(function() {
    var typeCell = $(this).find('td#type');
    var nameCell = $(this).find('td#name b');
    var valueInput = $(this).find('td#value input');
    var error = $(this).find('td#value span#error');
    if (nameCell.length > 0 && typeCell.length > 0 && valueInput.length > 0) {
      var type = typeCell.text().trim().toLowerCase();
      var value = valueInput.val().trim();
      if(value == '')
        return;
      var name = nameCell.text().trim();
      if(checkValue(type, value)){
        data[name] = value;
      }else if(['array', 'object', 'string','integer', 'float'].includes(type)){
        console.log(error);
        showError(error,'类型不符');
      }else{
        showError(error,'类型不存在,请联系开发人员检查接口');
      }
    }
  });
  return data;
}

function checkValue(type,value){
  type = type.trim().toLowerCase();
  value = value.trim();
  if (value !== '') {
    if ((type === 'string' && typeof value === 'string') || 
        (type === 'integer' && !isNaN(parseInt(value))) ||
        (type === 'float' && !isNaN(parseFloat(value))) ||
        (type === 'array' && isJsonArray(value)) ||
        (type === 'object' && isJsonObject(value))) {
      return true;
    }
  }
  return false;
}

function isJsonArray(value) {
  try {
    var jsonValue = JSON.parse(value);
    return Array.isArray(jsonValue);
  } catch (e) {
    return false;
  }
}

function isJsonObject(value) {
  try {
    var jsonValue = JSON.parse(value);
    return typeof jsonValue === 'object' && !Array.isArray(jsonValue);
  } catch (e) {
    return false;
  }
}
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

$('.input-mock').on('input', function() {
  var $span = $(this).siblings('span#error');
  if ($span.css('display') === 'inline') {
    $span.css('display', 'none');
  }
});

$('.all-refresh').click(function(){
  fillInTable(true);
});

$('.fill-in').click(function(){
  fillInTable(false);
});


$('.refresh-button').click(function() {
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
    if(rowData['mock'].value.trim()){
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
        rowData['value'].value = '';
      }else{
        if(postData['type'] == 'array'){
          response['value'] = JSON.stringify(JSON.parse(response['value']));
        }
        rowData['value'].value = response['value'];
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
      console.log(response);
    } catch (error) {
      showError(span, "Mock函数不存在");
      rowData['value'].value = '';
      console.log(res);
      return;
    }
    if(response['value'] === undefined || response['value'] === null){
      rowData['value'].value = '';
    }else{
      if(postData['type'] == 'array'){
        response['value'] = JSON.stringify(JSON.parse(response['value']));
      }
      rowData['value'].value = response['value'];
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
    rowData['value'].value = '';
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

function parseRow(parentRow){
  if(parentRow.nodeName!=="TR"){
    return null;
  }
  var id = parentRow.id;
  var name = parentRow.querySelector('td:nth-child(1)').querySelector('b').innerText;
  var type = parentRow.querySelector('td:nth-child(2)').innerText;
  var notNull = parentRow.querySelector('td:nth-child(3) input').checked;
  var mockInput = parentRow.querySelector('td:nth-child(4) input');
  var mock = mockInput.value.trim();
  var valueInput = parentRow.querySelector('td:nth-child(5) input');
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
  var data = {id:id,name:name,type:type,notNull:notNull,mock:mockInput,funcName:funcName,params:jsonData,value:valueInput};
  
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
  return postData;
}
function showError(span,message){
  span.text(message);
  span.css('display', 'none');
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
      console.log(response);
      response.forEach(function(obj) {
        var row = table.find('tr#'+obj.id);
        var span = row.find('td#mock span');
        var type = row.find('td#type').text();
        var input = row.find('td#value').find('input.value-input');
        if(type == 'object'){
          var select =row.find('td#value').find('select.object-chosen');
          select.val(obj.value);
          console.log(select.val())
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
      });
    });  
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
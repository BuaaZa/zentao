function toggleChildren(btn) {
  var parentRow = btn.parentNode.parentNode.parentNode;
  var parentId = parentRow.getAttribute("id");
  var childRows = document.querySelectorAll("tr[class^='" + parentId + "::child" + "']");
  childRows.forEach(function(childRow) {
    childRow.style.display = childRow.style.display === 'none' ? 'table-row' : 'none';
  });
  btn.classList.toggle("icon-angle-down");
  btn.classList.toggle("icon-angle-right");
}

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

$('.refresh-button').click(function() {
  var parentRow = this.parentNode;
  while(parentRow.nodeName!=="TR"){
    parentRow = parentRow.parentNode;
  }
  const rowData = parseRow(parentRow);
  var span = parentRow.querySelector('td:nth-child(4) span');
  if(!rowData){
    console.log('fail to parse Row');
    return;
  } 
  var postData = getPostData(rowData);
  var itemSpan = parentRow.querySelector('td:nth-child(4) span');
  if(rowData['type'] == 'array'){
    var itemRow = parentRow.nextElementSibling;
    var itemRowData = parseRow(itemRow);
    itemSpan = itemRow.querySelector('td:nth-child(4) span')
    postData['item'] = getPostData(itemRowData);
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
      if(response['value']){
        rowData['value'].value = response['value'];
      }else{
        rowData['value'].value = '';
      }
      if(response['error']){
        showError(span, response['error']);
      }else{
        hideError(span);
      }
      if(postData['type'] == 'array' && response['item']['error']){
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
    if(response['value']){
      rowData['value'].value = response['value'];
    }else{
      rowData['value'].value = '';
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
  var data = {name:name,type:type,notNull:notNull,mock:mockInput,funcName:funcName,params:jsonData,value:valueInput};
  
  return data;
}

function getPostData(rowData){
  var postData = {};
  postData['name'] = rowData['name'];
  postData['type'] = rowData['type'];
  postData['notNull'] = rowData['notNull'];
  postData['funcName'] = rowData['funcName'];
  postData['params'] = rowData['params'];
  return postData;
}
function showError(span,message){
  span.innerText = message;
  span.style.display = 'inline';
}

function hideError(span){
  span.style.display = 'none';
}
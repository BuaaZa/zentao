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

$('.input-mock').on('input', function() {
  var $span = $(this).siblings('span#error-404');
  if ($span.css('display') === 'inline') {
    $span.css('display', 'none');
  }
  $span = $(this).siblings('span#error-syntax');
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
  if(!rowData){
    console.log('fail to parse Row');
    return;
  } 
  var postData = getPostData(rowData);
  
  if(!rowData['funcName']){
    if(rowData['mock'].value.trim()){
      var $span = $(rowData['mock']).siblings('span#error-404');
      if ($span.css('display') === 'inline') {
        $span.css('display', 'none');
      }
      $span = $(rowData['mock']).siblings('span#error-syntax');
      if ($span.css('display') === 'none') {
        $span.css('display', 'inline');
      }
    }

    var link = createLink('ztinterface', 'mockBase', '');
    $.post(link, postData, function(response) {
      if(response)
        rowData['value'].value = response;
    });
    return;
  }
    
  if(rowData['type'] == 'array'){
    var itemRow = parentRow.nextElementSibling;
    var itemRowData = parseRow(itemRow);
    postData['item'] = getPostData(itemRowData);
  }

  console.log(postData);
  
  var link = createLink('ztinterface', 'mock'+rowData['funcName'], '');
  $.post(link,postData)
  .done(function(response) {
    if(response)
        rowData['value'].value = response;
  })
  .fail(function() {
    console.log("fail");
    var mockTd = parentRow.querySelector('td:nth-child(4)');
    var $span404 =  $(mockTd).find('#error-404');
    if ($span404.css('display') === 'none') {
      $span404.css('display', 'inline');
    }
    var $spanSyntax =  $(mockTd).find('#error-syntax');
    if ($spanSyntax.css('display') === 'inline') {
      $spanSyntax.css('display', 'none');
    }
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
    const params = paramStr.match(/("[^"]*"|'[^']*'|\[[^\]]*\]|[^,]+)+/g);
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
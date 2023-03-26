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
});

$('.refresh-button').click(function() {
  var parentRow = this.parentNode;
  while(parentRow.nodeName!=="TR"){
    parentRow = parentRow.parentNode;
  }
  var type = parentRow.querySelector('td:nth-child(2)').innerText;
  type = type.toLowerCase();
  var mock = parentRow.querySelector('td:nth-child(4) input').value;
  var valueInput = parentRow.querySelector('td:nth-child(5) input');
  
  if(!mock){
    var link = createLink('ztinterface', 'mockBase', 'type='+type);
    $.get(link, function(data) {
      
    });
    return;
  }

  mock = cnToEn(mock);
  var funcName = mock.match(/^@(\w+)\(/)[1];
  const paramStr = mock.replace(/^@\w+\(|\)$/g, '');
  const params = paramStr.match(/("[^"]*"|'[^']*'|\[[^\]]*\]|[^,]+)+/g);
  var jsonData = JSON.stringify(params);
  var postData = {params: jsonData,type: type};
    
  if(type == 'array'){
    var itemRow = parentRow.nextElementSibling;
    var itemType = itemRow.querySelector('td:nth-child(2)').innerText;
    var itemMock = itemRow.querySelector('td:nth-child(4) input').value;
    
    itemMock = cnToEn(itemMock);
    var itemFunc = itemMock.match(/^@(\w+)\(/)[1];
    const itemStr = itemMock.replace(/^@\w+\(|\)$/g, '');
    const itemParams = itemStr.match(/("[^"]*"|'[^']*'|\[[^\]]*\]|[^,]+)+/g);
    var itemJson = JSON.stringify(itemParams);

    postData['itemFunc'] = itemFunc;
    postData['itemType'] = itemType;
    postData['itemParams'] = itemJson;
  }
  
  funcName = funcName.toLowerCase().charAt(0).toUpperCase() + funcName.toLowerCase().substring(1);
  var link = createLink('ztinterface', 'mock'+funcName, '');
  $.post(link,postData)
  .done(function(response) {
    // 成功获取到响应数据
    console.log(response);
  })
  .fail(function() {
    console.log("fail");
    var mockTd = parentRow.querySelector('td:nth-child(4) input');
    var $span =  $(mockTd).find('#error-404');
    if ($span.css('display') === 'none') {
      $span.css('display', 'inline');
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
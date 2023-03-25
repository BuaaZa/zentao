var textareas = document.querySelectorAll('textarea.autosize');

// 为每个textarea添加input事件监听器
textareas.forEach(function(textarea) {
  textarea.addEventListener('input', function() {
    
    const textheight = this.scrollHeight;

    // 调整textarea所在行的高度
    var row = this.parentNode.parentNode;
    row.style.height = textheight + 'px';
  });
});
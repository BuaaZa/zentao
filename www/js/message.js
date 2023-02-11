function showSuccessMessage(message,targetwin)
{
    let win = (targetwin == 'parent') ? parent : ((targetwin == 'parent.parent') ? parent.parent : window);
    let myMessager = new win.$.zui.Messager(message, {
        type: 'success',
        close: true,
        icon: 'check-circle',
        time: 0 // 不进行自动隐藏
    });
    myMessager.show();

    // 修改样式
    win.$('.messagger-zt').removeClass('messagger-zt');

    // 0.9 秒之后隐藏消息
    setTimeout(function() {
        myMessager.hide();
        win.location.reload(true);
    }, 900);

}

function showFailMessage(message,targetwin)
{
    let win = (targetwin == 'parent') ? parent : ((targetwin == 'parent.parent') ? parent.parent : window);
    let myMessager = new win.$.zui.Messager(message, {
        type: 'danger',
        close: true,
        icon: 'exclamation-sign',
        time: 0 // 不进行自动隐藏
    });
    myMessager.show();

    // 修改样式
    win.$('.messagger-zt').removeClass('messagger-zt');

    // 0.9 秒之后隐藏消息
    setTimeout(function() {
        myMessager.hide();
        win.location.reload(true);
    }, 900);

}
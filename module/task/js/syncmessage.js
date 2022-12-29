/**
 * 在父窗口显示提示消息
 *
 */
function showSuccessMessage()
{
    var myMessager =  new parent.$.zui.Messager('同步成功。', {
        type: 'success',
        close: true,
        icon: 'check-circle',
        time: 0 // 不进行自动隐藏
    });
    myMessager.show();

    // 修改样式
    parent.$('.messagger-zt').removeClass('messagger-zt');

    // 0.9 秒之后隐藏消息
    setTimeout(function() {
        myMessager.hide();
        parent.location.reload(true);
    }, 900);

}

function showFailMessage()
{
    var myMessager =  new parent.$.zui.Messager('同步失败。', {
        type: 'danger',
        close: true,
        icon: 'exclamation-sign',
        time: 0 // 不进行自动隐藏
    });
    myMessager.show();

    // 修改样式
    parent.$('.messagger-zt').removeClass('messagger-zt');

    // 0.9 秒之后隐藏消息
    setTimeout(function() {
        myMessager.hide();
        parent.location.reload(true);
    }, 900);

}
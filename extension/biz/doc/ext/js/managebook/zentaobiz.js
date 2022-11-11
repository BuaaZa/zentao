$(document).ready(function()
{
    function saveOrders(orders)
    {
        $.post(createLink('doc','sortBookOrder'),
            {sort:orders},
            function(data)
            {
                if(data.result != "success")
                {
                    bootbox.alert(data.message);
                }
            },'json');
    }

    function updateOrders(ele, parentOrder, orders)
    {
        var root = false;
        if(typeof ele === 'undefined')
        {
            ele = $('.books > dl, .books > .catalog > dl');
            root = true;
            orders = {};
        }

        if(typeof parentOrder === 'undefined')
        {
            parentOrder = '';
            var $parent = ele.closest('.catalog:not(".catalog-empty, .drag-shadow")');
            if($parent.length)
            {
                parentOrder = $parent.children('strong').find('.order').text();
            }
        }

        var index = 1;
        ele.children('.catalog:not(".catalog-empty, .drag-shadow")').each(function()
        {
            var $this = $(this);
            var order = (parentOrder === '' ? '' : (parentOrder + '.')) + (index++);
            orders[$this.data('id')] = order;
            $this.children('strong').find('.order').text(order);
            var $dl = $this.children('dl');
            if($dl.length)
            {
                updateOrders($dl, order, orders);
            }
        });

        if(root)
        {
            saveOrders(orders);
        }
    };

    $('.books dl').append('<dd class="catalog catalog-empty">&nbsp;</dd>');

    $('.books > .catalog .catalog, .books > dl .catalog').not('.catalog-empty').droppable(
    {
        trigger: function($e){return $e.children('.actions').find('.sort-handle')},
        target: function($e){return $e.siblings('.catalog');},
        container: '.books',
        nested: true,
        flex: true,
        sensorOffsetY: -10,
        start: function()
        {
            $('.books').addClass('show-empty-catalog');
        },
        drag: function(e)
        {
            if(e.target)
            {
                $('.drop-area').removeClass('drop-area');
                e.target.closest('dl').addClass('drop-area');
            }
        },
        drop: function(e)
        {
            e.target.before(e.element);
            updateOrders();
        },
        finish: function()
        {
            $('.drop-area').removeClass('drop-area');
            $('.books').removeClass('show-empty-catalog');
        }
    });
});
window.parent.$('#triggerModal').one('hide.zui.modal', function(){
    window.parent.location.reload();
});

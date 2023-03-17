

<?php include '../../common/view/header.lite.html.php';?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        .cl1{
            background-color:#FFFFFF;
        }
        .cl2{
            background-color:#FFFF99;
        }
    </style>
    <script type="text/javascript">
        var rowCount = 0;
        var colCount = 2;
        function addRow(){

            rowCount++;
            var rowTemplate = '<tr class="tr_'+rowCount+'"><td>'+rowCount+'</td><td class="cl1">内容'+rowCount+'</td><td class="cl1"><a href="#" onclick=delRow('+rowCount+')>删除</a></td></tr>';
            var testtable = $("#testTable").find("tbody");
            var tableHtml = testtable.html();
            tableHtml += rowTemplate;

            testtable.html(tableHtml);
        }
        function delRow(_id){
            $("#testTable .tr_"+_id).hide();
            rowCount--;
        }
        function addCol(){
            colCount++;
            $("#testTable tr").each(function(){
                var trHtml = $(this).html();
                trHtml += '<td onclick="delCol('+colCount+')">增加的td</td>';
                $(this).html(trHtml);
            });
        }
        function delCol(_id){
            $("#testTable tr").each(function(){
                $("td:eq("+_id+")",this).hide();
            });
            colCount--;
        }
        function mover(_id){
            $("#testTable tr:not(:first)").each(function(){
                $("td:eq("+_id+")",this).removeClass("cl1");
                $("td:eq("+_id+")",this).addClass("cl2");
            });
        }
        function mout(_id){
            $("#testTable tr:not(:first)").each(function(){
                $("td:eq("+_id+")",this).removeClass("cl2");
                $("td:eq("+_id+")",this).addClass("cl1");
            });
        }
    </script>
    <title>jquery操作表格测试</title>
</head>
<body>
<table id="testTable" border="1" width="500">
    <tr>
        <td>序号</td>
        <td onmouseover="mover(1);" onmouseout="mout(1);">内容</td>
        <td onmouseover="mover(2);" onmouseout="mout(2);">操作</td>
    </tr>
</table>
<input type="button" value="添加行" onclick="addRow();"/>
<input type="button" value="添加列" onclick="addCol();"/>
</body>



<?php include '../../common/view/footer.lite.html.php';?>


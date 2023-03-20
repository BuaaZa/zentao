

<?php include '../../common/view/header.lite.html.php';?>
<div id='mainContent' class='main-content'>
    <div class='main-header'>
        <h2>填写数据样本</h2>
    </div>
    <div style="text-align:center">
    <table id="testTable" border="1" align="center">
        <tr>
            <td>输入输出项</td>
            <td onmouseover="mover(1);" onmouseout="mout(1);">样本1</td>
        </tr>
    </table>
    <input type="button" value="添加输入项" onclick="addRow();"/>
    <input type="button" value="添加样本" onclick="addCol();"/>
    <!-- <input type="button" value="保存" onclick="save_in_cookie();"/> -->
    </div>
</div>

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
        var colCount = 1;
        function addRow(){

            rowCount++;
            var rowTemplate_1 = '<tr class="tr_'+rowCount+'"><td>'+rowCount+'</td>';
            var rowTemplate_2 = '';
            for(i = 1; i<=colCount; i++){
                var tmp_template = '<td class="cl1">样本'+i+'</td>';
                rowTemplate_2 += tmp_template;
            }
            var rowTemplate_3 = '</tr>';
            var rowTemplate = rowTemplate_1 + rowTemplate_2 + rowTemplate_3;
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
                trHtml += '<td onclick="delCol('+colCount+')">样本'+colCount+'</td>';
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
        function save_in_cookie(){
            history.go(-1)
        }
    </script>



<?php include '../../common/view/footer.lite.html.php';?>


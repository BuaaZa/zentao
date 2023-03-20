

<?php include '../../common/view/header.lite.html.php';?>
<div id='mainContent' class='main-content'>
    <div class='main-header'>
        <h2>填写数据样本</h2>
    </div>
    <div style="text-align:center">
    <table id="testTable" class='table table-form mg-0 table-bordered' style='border: 1px solid #ddd'>
        <tr>
            <td><b>输入输出项名称</b></td>
            <td><b>样本1</b></td>
        </tr>
    </table>
        <button class="btn" type="button"  onclick="addRow();"> 添加输入输出项</button>
        <button class="btn" type="button"  onclick="addCol();"> 添加测试样本</button>
        <button class="btn btn-wide btn-primary" type="button"  onclick="save_in_cookie();"> 保存</button>
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
            var rowTemplate_1 = "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample[][]' placeholder=''></textarea></td>";
            var rowTemplate_2 = '';
            for(i = 1; i<=colCount; i++){
                var tmp_template = "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample[][]'></textarea></td>";
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
            var i = 1;
            $("#testTable tr").each(function(){
                var trHtml = $(this).html();
                if(i === 1){
                    trHtml += '<td onclick="delCol('+colCount+')"><b>样本'+colCount+'</b></td>';
                }else{
                    trHtml += "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample[][]'></textarea></td>";
                }

                $(this).html(trHtml);
                i++;
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
            //history.go(-1)
        }
    </script>



<?php include '../../common/view/footer.lite.html.php';?>


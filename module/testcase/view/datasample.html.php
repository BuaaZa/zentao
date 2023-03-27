

<?php include '../../common/view/header.lite.html.php';?>
<div id='mainContent' class='main-content'>
    <div class='main-header'>
        <h2>填写数据样本</h2>
    </div>
    <div style="text-align:center">
        <form class='load-indicator main-form form-ajax' method='post' enctype='multipart/form-data' id='dataform' data-type='ajax'>
    <table id="testTable" class='table table-form mg-0 table-bordered' style='border: 1px solid #ddd'>
        <tr>
            <td><b>输入-输出项名称</b></td>
            <td><b>样本1</b></td>
        </tr>
    </table>
        <br><br>
        <button class="btn" type="button"  onclick="addRow();"> 添加输入输出项</button>
        <button class="btn" type="button"  onclick="addCol();"> 添加测试样本</button>
        <button disabled="disabled" id='submit' class="btn btn-wide btn-primary " type="submit"  onclick="save_in_cookie();"> 保存</button>
        <br><br>
        </form>
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
            $('#submit').attr("disabled",false);
            rowCount++;
            var rowTemplate_1 = "<tr><td><textarea rows='1' class='form-control autosize step-expects' name='datasample["+(rowCount-1)+"][0]' placeholder=''></textarea></td>";
            var rowTemplate_2 = '';
            for(i = 1; i<=colCount; i++){
                var tmp_template = "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample["+(rowCount-1)+"]["+i+"]'></textarea></td>";
                rowTemplate_2 += tmp_template;
            }
            var rowTemplate_3 = '</tr>';
            var rowTemplate = rowTemplate_1 + rowTemplate_2 + rowTemplate_3;

            var testtable = $("#testTable");
            var lastRow = testtable.find("tr:last");
            if (lastRow.length) {
                lastRow.after(rowTemplate);
            } else {
                testtable.append(rowTemplate);
            }

        }
        function delRow(_id){
            $("#testTable .tr_"+_id).hide();
            rowCount--;
        }
        function addCol(){
            colCount++;
            var i = 1;
            $("#testTable tr").each(function(){
                var trHtml = '';
                if(i === 1){
                    trHtml = '<td><b>样本'+colCount+'</b></td>';
                }else{
                    trHtml = "<td><textarea rows='1' class='form-control autosize step-expects' name='datasample["+(i-2)+"]["+colCount+"]'></textarea></td>";
                }

                $(this).append(trHtml);
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
            //console.log("1");
            //此处将表单数据存到cookie中
            var form = document.getElementById("dataform"); // get form element
            var matrix = []; // initialize empty array
            for (var i = 0; i < form.elements.length; i++) { // loop through each form element
                    var element = form.elements[i]; // get current element
                    if (element.name.startsWith("datasample")) { // if element name starts with matrix
                        var indices = element.name.match(/\d+/g); // get row and column indices from name
                        var row = parseInt(indices[0]); // get row index as number
                        var col = parseInt(indices[1]); // get column index as number
                        if (!matrix[row]) { // if row does not exist in array yet
                            matrix[row] = []; // create empty row array
                        }
                        matrix[row][col] =element.value; // assign element value to array position
                    }
            }
            var matrixString = JSON.stringify(matrix); // convert array to string using JSON.stringify()
            //document.cookie = "datasam="+matrixString;
            $.cookie("datasample", matrixString);
            //alert($.cookie('datasample'));
            //alert(matrixString);
        }
    </script>



<?php include '../../common/view/footer.lite.html.php';?>


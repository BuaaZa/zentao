$("select#method").change(function() {
    var selectValue = $(this).val();
    if(selectValue == 0){
        $("input#name").val("");
        $("input#url").val("");
        $("input#delete").prop('disabled',true);
    }else{
        $("input#name").val(urls[selectValue]['name']);
        $("input#url").val(urls[selectValue]['url']);
        $("input#delete").prop('disabled',false);
    }
  }); 
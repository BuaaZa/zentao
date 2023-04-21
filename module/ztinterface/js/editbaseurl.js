$("select#method").change(function() {
    var selectValue = $(this).val();
    console.log(selectValue);
    if(selectValue == 0){
        $("input#name").val("");
        $("input#URL").val("");
        $("input#delete").prop('disabled',true);
    }else{
        $("input#name").val(urls[selectValue]['name']);
        $("input#URL").val(urls[selectValue]['url']);
        $("input#delete").prop('disabled',false);
    }
  }); 
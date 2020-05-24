
$(document).ready(function(){
    $("#btnResetAddForm").click(function(){
        document.location.href="category";
    });

    $("form").submit(function(e){
        e.preventDefault();
        
        var isSuccess=true;

        if ($("#label").val().trim()=="") {
           $("#msgError").html("empty field");
           isSuccess=false; 
        }else{
            $("#msgError").html("");
        }

        if ($("#id").val().trim()=="") {
            isSuccess=false; 
        }

        if ($("input[type='checkbox']").val().trim()=="") {
            isSuccess=false; 
        }

        if($("input[type='checkbox']").prop("checked") == true){
            var checked = 1;
        }else{
            var checked = 0;
        }

        if (isSuccess== true) {
            var datas={
                "label":$("#label").val(),
                "id":$("#id").val(),
                "checked":checked
            };

            $.post("models/admin/actionAddUpdateCategory.php",datas,function(response){
                if (response.error==false) {
                    alert(response.msg);
                    document.location.href="category";
                }else{
                    alert(response.msg);
                }
            });
                
        }

    });
    
});
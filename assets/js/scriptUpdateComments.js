
$(document).ready(function(){
    $("#btnResetAddForm").click(function(){
        document.location.href="comments";
    });

    $("form").submit(function(e){
        e.preventDefault();
        
        var isSuccess=true;

        if ($("#reply").val().trim()=="") {
           $("#msgError").html("empty field");
           isSuccess=false; 
        }else{
            $("#msgError").html("");
        }

        if ($("#id").val().trim()=="") {
            isSuccess=false; 
        }



        if (isSuccess== true) {
            var datas={
                "reply":$("#reply").val(),
                "id":$("#id").val()
            };

            $.post("models/admin/actionUpdateComments.php",datas,function(response){
                if (response.error==false) {
                    alert(response.msg);
                    document.location.href="comments";
                }else{
                    alert(response.msg);
                }
            });
                
        }

    });
    
});
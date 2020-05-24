
$(document).ready(function(){
       
    $("form").submit(function(e){
        e.preventDefault();
        
        var isSuccess=true;

        if ($("#reply").val().trim()=="") {
            $("#replyMsgError").html("empty field");
            isSuccess=false;
        }else{
            $("#replyMsgError").html("");
        }

        if ($("#user").val().trim()=="" || $("#articleId").val().trim()=="" || $("#categorie").val().trim()=="") {
            isSuccess=false;
        }
        

        /* ENVOIS DU FORM VIA AJAX */
        if (isSuccess == true) {
            var postData = {
                "reply":$("#reply").val(),
                "user":$("#user").val(),
                "articleId":$("#articleId").val(),
                "categorie":$("#categorie").val()
            };

            $.post("models/actionComments.php",postData,function(response){
                alert(response.msg);
                if (response.error==false) {
                    document.location.href=("article&id="+$("#articleId").val()+"");
                }else{
                    alert("no");
                }
            }); 
        } 
    });

    
});
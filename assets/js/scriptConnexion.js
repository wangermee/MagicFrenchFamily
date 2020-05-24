
$(document).ready(function(){

    

    $("#formSign").submit(function(e){
        e.preventDefault();
        
        var isSuccess=true;

        if ($("#email").val().trim()=="") {
            $("#signMsgErrorEmail").html("empty field");
            isSuccess=false;
         }else{
             $("#signMsgErrorEmail").html("");
         }

        if ($("#password").val().trim()=="") {
            $("#signMsgErrorPassword").html("empty field");
            isSuccess=false;
        }else{
            $("#signMsgErrorPassword").html("");
        }
   
        if (isSuccess== true) {

            var datas={
                "email":$("#email").val(),
                "password":$("#password").val(),
                "action":$(this.action).val()   
            };

            $.post("models/actionConnexion.php",datas,function(response){
                if (response.error==false) {
                    alert(response.msg);
                    document.location.href=("home");
                }else{
                    alert(response.msg);
                }
            });

        }

    });

    $("#formRegister").submit(function(e){
        e.preventDefault();

        var isSuccess=true;
        
        if ($("#userName").val().trim()=="") {
            $("#registerMsgErrorUserName").html("empty field");
            isSuccess=false;
        }else{
            $("#registerMsgErrorUserName").html("");
        }

         if ($("#registerEmail").val().trim()=="") {
            $("#registerMsgErrorEmail").html("empty field");
            isSuccess=false;
        }else{
            $("#registerMsgErrorEmail").html("");
        }

        if ($("#registerVerifyEmail").val().trim()=="") {
            $("#registerVerifyEmailMsgError").html("empty field");
            isSuccess=false;
        }else{
            $("#registerVerifyEmailMsgError").html("");
        }

        if ($("#registerEmail").val().trim()!=$("#registerVerifyEmail").val().trim()) {
            $("#matchEmailError").html("emails don't match");
            isSuccess=false;
        }else{
            $("#matchEmailError").html("");
        }
        

        if ($("#registerPassword").val().trim()=="" || $("#registerPassword").val().length<5 ) {
            $("#registerPasswordMsgError").html("need five characters minimum");
            isSuccess=false;
        }else{
            $("#registerPasswordMsgError").html("");
        }

        if ($("#registerVerifyPassword").val().trim()=="" || $("#registerPassword").val().length<5) {
            $("#registerVerifyPasswordMsgError").html("need five characters minimum");
            isSuccess=false;
        }else{
            $("#registerVerifyPasswordMsgError").html("");
        }

        if ($("#registerPassword").val().trim()!=$("#registerVerifyPassword").val().trim()) {
            $("#matchPasswordError").html("password don't match");
            isSuccess=false;
        }else{
            $("#matchPasswordError").html("");
        }
   
        if (isSuccess== true) {

            var datas={
                "userName":$("#userName").val(),
                "registerEmail":$("#registerEmail").val(),
                "registerVerifyEmail":$("#registerVerifyEmail").val(),
                "registerPassword":$("#registerPassword").val(),
                "registerVerifyPassword":$("#registerVerifyPassword").val(),
                "action":$(this.action).val()  
            };
            
            $.post("models/actionConnexion.php",datas,function(response){
                if (response.error==false) {
                    alert(response.msg);
                    document.location.href="home";
                }else{
                    alert(response.msg);
                }
            });

        }

    });



});

$(document).ready(function(){
    
    $("#formContactSubmit").submit(function(e){
        e.preventDefault();
        var isSuccess= true;

        if ($("#firstName").val().trim()=="") {
            $("#firstNameError").html("first name empty");
            isSuccess= false;
        }else{
            $("#firstNameError").html("");
        } 
      
        if ($("#lastName").val().trim()=="") {
            $("#lastNameError").html("last name empty");
            isSuccess= false;
        }else{
            $("#lastNameError").html("");
        }

        if ($("#email").val().trim()=="") {
            $("#emailError").html("email empty");
            isSuccess= false;
        }else{
            $("#emailError").html("");
        }

        if ($("#verifyEmail").val().trim()=="") {
            $("#verifyEmailError").html("email empty");
            isSuccess= false;
        }else{
            $("#verifyEmailError").html("");
        }

        if ($("#email").val().trim() != $("#verifyEmail").val().trim()) {
            $("#Error").html("emails don't match");
            isSuccess= false;
        }else{
            $("#Error").html("");
        }


        if ($("#message").val().trim()=="") {
            $("#messageError").html("message empty");
            isSuccess= false;
        }else{
            $("#messageError").html("");
        }
         
        /* ENVOIS DU FORM VIA AJAX */
        if (isSuccess == true) {
            var postData = {
                "firstName":$("#firstName").val(),
                "lastName":$("#lastName").val(),
                "email":$("#email").val(),
                "verifyEmail":$("#verifyEmail").val(),
                "phoneNumber":$("#phoneNumber").val(),
                "message":$("#message").val()
            };

            $.post("models/actionFormContact.php",postData,function(response){
                alert(response.msg);
                if (response.error==false) {
                    document.location.href=("home");
                }
            }); 
        } 
        
    });
    
});
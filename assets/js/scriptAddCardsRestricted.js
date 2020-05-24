
$(document).ready(function(){
    $("#reset").click(function(){
        document.location.href="restrictedList";
    });
    
    $("form").submit(function (e) {
        e.preventDefault();
        
        var isSuccess=true;

        if ($("#name").val().trim()=="") {
            $("#msgErrorName").html("empty field");
            isSuccess=false;
        }else{
            $("#msgErrorName").html(""); 
        }

        if ($("#categorie").val().trim()=="0") {
            $("#msgErrorCategorie").html("select a category");
            isSuccess=false; 
        }else{
            $("#msgErrorCategorie").html(""); 
        }


        if (isSuccess==true) {
            $.ajax({
                url: "models/admin/actionAddUpdateCardsRestrictedList.php",
                type: "POST",
                data:  new FormData(this),
                contentType:false,
                cache: false,
                processData:false,
                success: function (response) {
                    if (response.error == false) {
                        alert(response.msg);
                        document.location.href="restrictedList";
                    }else{
                        alert(response.msg);
                    }
                }
            });    
            
        }
        
    });
});
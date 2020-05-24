



$(document).ready(function(){
    $("#reset").click(function(){
        document.location.href="articles";
    });
    
    $("form").submit(function (e) {
        e.preventDefault();
        
        var isSuccess=true;

        if ($("#title").val().trim()=="") {
            $("#msgErrorTitle").html("empty field");
            isSuccess=false;
        }else{
            $("#msgErrorTitle").html(""); 
        }

        if ($("#categorie").val().trim()=="0") {
            $("#msgErrorCategorie").html("select a category");
            isSuccess=false; 
        }else{
            $("#msgErrorCategorie").html(""); 
        }

        if ($("#author").val().trim()=="0") {
            $("#msgErrorAuthor").html("select a author");
            isSuccess=false; 
        }else{
            $("#msgErrorAuthor").html(""); 
        }

        if ($("#imageName").val().trim()=="") {
            $("#msgErrorImageName").html("empty field");
            isSuccess=false; 
        }else{
            $("#msgErrorImageName").html(""); 
        }


        if ($("#content").val().trim()=="") {
            $("#msgErrorContent").html("create a content");
            isSuccess=false; 
        }else{
            $("#msgErrorContent").html(""); 
        }

        if (isSuccess==true) {
            $.ajax({
                url: "models/admin/actionAddUpdateArticles.php",
                type: "POST",
                data:  new FormData(this),
                contentType:false,
                cache: false,
                processData:false,
                success: function (response) {
                    if (response.error == false) {
                        alert(response.msg);
                        document.location.href="articles";
                    }else{
                        alert(response.msg);
                    }
                }
            });    
            
        }
        
    });
    
});
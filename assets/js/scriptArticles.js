
$(document).ready(function(){
    $("td a:nth-child(3)").click(function(e){
        e.preventDefault();
        $.get(this.href,"false",function(response){
            if (response.error==false) {
                alert(response.msg);
                document.location.href="articles";
            }else{
                alert(response.msg);
            }
        });
    });

    
});
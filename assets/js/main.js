
$(document).ready(function(){
    $("#btnBurger").click(function(){ //menu burger
        $("#burger").toggle(300);   
    });
    $("a").click(function(){ //menu burger
        $("#burger").hide(300);
    });

    $("#home img").mouseenter(function(){ //zoom image
        $(this).addClass("zoomImg");
    });
    $("#home img").mouseleave(function(){ //zoom image
        $(this).removeClass("zoomImg");
    });

    $("#blog img").mouseenter(function(){ //zoom image
        $(this).addClass("zoomImgBlog");
    });
    $("#blog img").mouseleave(function(){ //zoom image
        $(this).removeClass("zoomImgBlog");
    });

    
});
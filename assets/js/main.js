
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

    if (window.matchMedia("(min-width: 992px)").matches) {//annimation nav user
        $("#navXL").hide(900);
        $("#navXL").show(600);
    
        $("#navXL a:nth-child(2)").click(function(){
            $("#navXL").hide(1000);
            $("#navXL").show(800);
        });
    
        $("#navXL a:nth-child(3)").click(function(){
            $("#navXL").hide(1000);
            $("#navXL").show(800);
        });
        
      }

    
});
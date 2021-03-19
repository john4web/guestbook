"use strict";



$(document).ready(function(){




    $("#postMessageForm").submit(function(event){
        event.preventDefault();



        let request = $.ajax({
            url: "phpFiles/action_postMessageAJAX.php",
            method: "POST",
            data: {
                message: $("#entry-textArea").val()
            }

        });


        request.done(function(response){

            if($("#entry-textArea").val() === ""){
                location.href = "entry.php?noMessage=1";
            }else{

                $('html, body').animate({scrollTop:$(document).height()}, 600); //zum ende scrollen

                $("#entryBox-Parent").append(response);

                $(".c-entryBox:last-child").hide();
                $(".c-entryBox:last-child").fadeIn(2000);
            }


        });


    });



});


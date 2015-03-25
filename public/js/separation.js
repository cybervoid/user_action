// Made by Rafael Gil 2014


$("document").ready(function(){
    $('#newHire').on('submit', function(){


        $.ajax({
            type: "POST",
            url: "add",
            data: $("#newHire").serialize()
        })
            .done(function( msg ) {
                console.log(msg);
                $('#report').html(App.templates.separation(msg));
            });

        return false;
    });

});//end of document ready function
// Made by Rafael Gil 2014

var App = App || {};

(function($){
    "use strict";

    App.separation = App.separation || {};

    function newHireSubmit()
    {
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
    }

    $("document").ready(function()
    {
        $('#newHire').on('submit', newHireSubmit);
    });//end of document ready function
}(jQuery));

/*
(function($){
    "use strict";


}(jQuery));
*/
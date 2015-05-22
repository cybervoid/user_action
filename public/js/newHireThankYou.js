/**
 * Created by rafag on 5/18/15.
 */

$(document).ready(function () {


    activateMenu().on('click', function (e) {
        switch ($(this).attr('id')) {
            case "home":
                window.location.href = '/';
                break;
            case "another":
                window.location.href = '/newHire';
                break;
        }
    });


});
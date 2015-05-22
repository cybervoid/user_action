// Made by Rafael Gil 2014

var App = App || {};

(function ($) {
    "use strict";


// code para validar solo entradas de múmeros en los edits
    var nav4 = window.Event ? true : false;

    function acceptNum(evt) {
        // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
        var key = nav4 ? evt.which : evt.keyCode;	// 57
        //return (key <= 13 || (key >= 48 && key <= 57) || (key==44)|| (key==46));
        return (key <= 13 || (key >= 48 && key <= 57) || (key == 44) || (key == 46));
    }


    App.isEmail = function (email) {
        var regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return regex.test(email);
    };

    var get_hostname = function (url) {
        var location = document.createElement("a");
        location.href = url;
// IE doesn't populate all link properties when setting .href with a relative URL,
// however .href will return an absolute URL which then can be used on itself
// to populate these additional fields.
        if (location.host === "") {
            location.href = location.href;
        }
        return location.hostname;
    };

    $(document).ajaxSend(function (e, xhr, settings) {

        if ($.inArray(settings.type, ['GET', 'HEAD', 'OPTIONS', 'TRACE']) > -1) {
// don't send csrf token for reads
            return;
        }

        if (settings.skip_csrf) {
            return;
        }

        if (!settings.force_csrf && get_hostname(settings.url) != document.location.hostname) {
// don't leak csrf token to outside sites
            return;
        }

        if (settings.contentType.indexOf("application/x-www-form-urlencoded") === -1) {
// we don't know the data type, so don't try to inject
            return;
        }

// if settings.data is undefined, null, [] or {}, jquery
// sends text/plain, which php won't parse into $_POST
// setRequestHeader overrides that
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

        var token_value = $('meta[name="csrf-token"]').attr('content');

        if (token_value === '') {
            return;
        }


// (== also catches undefined)
        if (settings.data == null) {
            settings.data = "_token=" + token_value;
        }
        else {
            settings.data += (settings.data ? '&' : '') + "_token=" + token_value;
        }
    });

}(jQuery));
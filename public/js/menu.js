/**
 * Created by rafag on 11/6/14.
 */


$(document).ready(function () {


    activateMenu().on('click', function (e) {
        switch ($(this).attr('id')) {
            case "home":
                window.location.href = '/';
                break;
            case "newHire":
                window.location.href = 'newHire';
                break;
            case "separation":
                window.location.href = 'separation';
                break;
            case "org_change":
                window.location.href = 'change_org';
                break;
        }
    });


    function activateMenu() {


        var $myNavigation = $('.myNavigation');
        var height = $myNavigation.height();
        var width = $myNavigation.width();


        $myNavigation.on('mouseenter', function (e) {
            if (e.target.tagName.toLowerCase() !== 'li') {
                return false;
            }

            var extraHeight = 20;


            $(this).stop().animate({
                height: height + extraHeight,
                width: width + extraHeight,
                top: -extraHeight / 2
            });
            return true;
        });


        $myNavigation.on('mouseleave', function () {
            $(this).stop().animate({
                height: height,
                width: 100,
                top: 0
            });
        });

        return $myNavigation;
    }

});



/**
 * Created by rafag on 3/20/15.
 */
$(document).ready(function () {


    activateMenu().on('click', function (e) {
        switch ($(this).attr('id')) {
            case "newHire":
                window.location.href = 'newHire';
                break;
            case "separation":
                window.location.href = 'separation';
                break;
            case "org_change":
                //window.location.href='change_org.php';
                alert('Under Construction')
                break;
        }
    });


});
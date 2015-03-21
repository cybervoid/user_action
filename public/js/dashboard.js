/**
 * Created by rafag on 3/20/15.
 */
$(document).ready(function () {


    activateMenu().on('click', function (e) {
        switch ($(this).attr('id')){
            case "newHire":
                window.location.href='newHire';
                break;
            case "termination":
                window.location.href='newHire.php?cmd=end';
                break;
            case "org_change":
                //window.location.href='change_org.php';
                alert('Under Construction')
                break;
        }
    });




});
// Made by Rafael Gil 2014

// code para validar solo entradas de múmeros en los edits
var nav4 = window.Event ? true : false;
function acceptNum(evt){
    // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
    var key = nav4 ? evt.which : evt.keyCode;	// 57
    //return (key <= 13 || (key >= 48 && key <= 57) || (key==44)|| (key==46));
    return (key <= 13 || (key >= 48 && key <= 57) || (key==44)|| (key==46));
}


function IsEmail(email) {
    var regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return regex.test(email);
}
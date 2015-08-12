/**
 * Created by rafag on 6/18/15.
 */

function findGroupMatch(groups) {
    /*
        $('#itChecklist li').each(function (i) {
            console.log('valor de this: ' + $(this).text());
            if('illyusa Sales Team Distribution Group'=== $(this).text()){
    console.log('pepe');
            }
        });
        */
    if (groups != undefined) {
        var index;
        for (index = 0; index < groups.length; ++index) {
            $('#itChecklist li').each(function (i) {
                if ('illyusa Sales Team Distribution Group' === groups[index]) {
                    console.log('aqui');
                }
                //console.log('valor de this: ' + $(this).text() + ' valor del otro: ' + groups[index]);
                if ($(this).text() == groups[index]){
                    $(this).find('input[type="checkbox"]').prop('checked', true)
                }
            });
        }
    }

}


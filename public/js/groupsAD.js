/**
 * Created by rafag on 6/18/15.
 */

function findGroupMatch(groups) {

    if (groups != undefined) {
        var index;
        for (index = 0; index < groups.length; ++index) {
            $('#itChecklist li').each(function (i) {
                if('illyusa Sales Team Distribution Group'=== $(this).text()){
                }
                if ($(this).text() == groups[index]){
                    $(this).find('input[type="checkbox"]').prop('checked', true)
                }
            });
        }
    }

}


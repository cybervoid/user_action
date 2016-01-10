<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'DashboardController@index');
Route::get('login', 'LoginController@index');
Route::post('login', 'LoginController@check_password');

Route::get('newHire', 'newHireController@index');
Route::post('add', 'newHireController@add');
Route::post('chkeml', 'newHireController@checkEmail');
Route::get('autocomplete', 'LdapController@autocomplete');


Route::get('report/{reportType}/{name}', 'ReportsController@getReport')->where('name', '[a-zA-Z0-9 -_]+\.pdf');

Route::get('separation', 'SeparationController@index');
Route::post('separation_search', 'SeparationController@separation_search');
Route::post('separation_add', 'SeparationController@add');


Route::get('change_org', 'Change_OrgController@index');
Route::post('org_change_lookup', 'Change_OrgController@lookup');
Route::post('change_org_verify', 'Change_OrgController@verify');
Route::post('change_org_save', 'Change_OrgController@save');
//Route::get('report/{reportType}/{name}', 'ReportsController@getReport')->where('name', '[a-zA-Z0-9 -]+\.pdf');


/*


// TOTODO

      //probar este

php artisan schdl_batch:check

todo en separation remove the user from the VPN and wifi groups and check if we can first (usa groups)
todo en separation schedule check if disable user is checked then actuall disable it and clean the info from AD
todo en el form de org change al poner un coment no sale el nombre del usuario al que aplicaactivac

todo arreglar en new hire y en change org las notificaciones para los managers en el autocompletar
todo adicionar option para incluir a alguien en las notificaciones
todo adicionar option de poner mas managers
todo para separation el grupo de illyusa Sales no está funcionando para salir autodetectado, problemas con el javascript
todo optimizar los templates a PDF y poner cosas en el main template
todo obtener el formato de direccion que roy quiere y poner el mismo en todos en AD



// STYLES
todo- poner todos los label en negrita y pasar todo a labels
todo- aplicar el estilo de newhire a separation (el required que no funciona en separation)
todo- en los emails templates poner stylo para los nombres en negrita
todo - arreglar que la firma salga siempre en la misma pag https://www.google.com/url?q=https%3A%2F%2Fcss-tricks.com%2Falmanac%2Fproperties%2Fp%2Fpage-break%2F&sa=D&sntz=1&usg=AFQjCNFlpwvW2m4q0_8VGFhbFcSIcO-hXQ



// ORGANIZATION CHANGE
todo effective date prset today's date.
todo revisar que schedule funcione en org change
todo if department is sales notify tracie
todo automatizado para cmabiar la signature y actualizar info en AD


// SEPARATION
todo al quitar info from ad ponerlas en el campo notas


// LDAP_HOST=DCUSA2.ILLY-DOMAIN.COM

 */
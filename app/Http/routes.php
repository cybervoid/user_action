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


Route::get('report/{reportType}/{name}', 'ReportsController@getReport')->where('name', '[a-zA-Z0-9 -]+\.pdf');

Route::get('separation', 'SeparationController@index');
Route::post('separation_search', 'SeparationController@separation_search');
Route::post('separation_add', 'SeparationController@add');


Route::get('change_org', 'Change_OrgController@index');
Route::get('lookup_chng_org', 'ActiveDirectory@lookup_chng_org');
//Route::get('lookup/{uname}', 'Change_OrgController@lookup')->where('name', '[a-zA-Z0-9 -]');
Route::post('lookup', 'Change_OrgController@lookup');












/*
 *
 * todo newhires revisar employee number and nickname estan saliendo vacios en el reporte
todo cuando se llenan todos los campos en new hire el pdf se divide en varias pags, jugar con los settigns de htmltopdf para evitar esto
todo para separation el grupo de illyusa Sales no está funcionando para salir autodetectado, problemas con el javascript
todo- en new hires detectar location y predefinir los grupos a los que pertenece

todo- para los nombres eliminar espacios en los titulos, nombres, etc
todo- poner todos los label en negrita y pasar todo a labels
todo6- aplicar el estilo de newhire a separation (el required que no funciona en separation)

todo8-         REVISAR COMO CAPTURAR LOS ERRORES SI EL EMAIL NO SE PUEDE ENVIAR POR ALGUN MOTIVO

todo9- cuando el nombre del reporte  abajar no es el correcto arroja un error


todo- organizacion change, al cambiar la compania mandar un correo
todo automatizado para cmabiar la signature y actualizar info en AD


todo- si tiene en el nombre un acento, no incluirlo en el nombre de usuario
todo- en los emails templates poner stylo para los nombres en negrita
todo- para el separation detectar si el campo de cellphone tiene algún valor is most likely the user has a cellphone.


 */

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
Route::get('autocomplete', 'ActiveDirectory@autocomplete');


Route::get('report/{reportType}/{name}', 'Reports@getReport')->where('name', '[a-zA-Z0-9 -]+\.pdf');

Route::get('separation', 'SeparationController@index');
Route::post('separation_search', 'SeparationController@separation_search');
Route::post('separation_add', 'SeparationController@add');


Route::get('change_org', 'Change_OrgController@index');
Route::get('lookup_chng_org', 'ActiveDirectory@lookup_chng_org');
//Route::get('lookup/{uname}', 'Change_OrgController@lookup')->where('name', '[a-zA-Z0-9 -]');
Route::post('lookup', 'Change_OrgController@lookup');












/*
1- cuando la cookie está me deja entrar aunque no este en la VPN

- al crear un nuevo usuario enviar un recordatorio al correo  con el start date y con un checklist of TODO like:
        - cnhange the password to Illy2014
        - check the groups were appliend correctly
        -prepare the computer to be ready a week before


- para los nombres eliminar espacios en los titulos, nombres, etc
- poner todos los label en negrita y pasar todo a labels
6- aplicar el estilo de newhire a separation (el required que no funciona en separation)

8-         REVISAR COMO CAPTURAR LOS ERRORES SI EL EMAIL NO SE PUEDE ENVIAR POR ALGUN MOTIVO

9- cuando el nombre del reporte  abajar no es el correcto arroja un error

10- validar todas las pags por si los campos no estan llenos

- organizacion change, al cambiar la compania mandar un correo
automatizado para cmabiar la signature y actualizar info en AD

- remove from gorups no esta funcionando
- verificar si el separation date is antes de la fecha de hoy, ejecutarlo right away
- si tiene en el nombre un acento, no incluirlo en el nombre de usuario
- en los emails templates poner stylo para los nombres en negrita
- enviar a maren los forms samples

//// separation schedule
date
	save samaccountname
	deactivate user
	group separation
	remove title
	remove manager



#######################################################
Desghabilitar en testing
newHireController
    user creation  #75
    Send MAil       #69

 */

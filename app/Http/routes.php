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












/*
1- cuando la cookie está me deja entrar aunque no este en la VPN


6- aplicar el estilo de newhire a separation (el required que no funciona en separation)

8-         REVISAR COMO CAPTURAR LOS ERRORES SI EL EMAIL NO SE PUEDE ENVIAR POR ALGUN MOTIVO

9- cuando el nombre del reporte  abajar no es el correcto arroja un error

10- validar todas las pags por si los campos no estan llenos

#######################################################
Desghabilitar en testing
newHireController
    user creation  #75
    Send MAil       #69

 */

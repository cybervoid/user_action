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
//Route::get('send', 'newHireController@send');


Route::get('report/{name}', 'newHireController@getReport')->where('name', '[a-zA-Z0-9 -]+\.pdf');

Route::get('separation', 'SeparationController@index');
Route::post('separation_search', 'SeparationController@separation_search');
Route::post('separation_add', 'SeparationController@add');












/*
1- cuando la cookie está me deja entrar aunque no este en la VPN


2- HAcer esto para los formularios
 * ul.checkmark li {
    background:url("../checkmark.gif") no-repeat 0 50%;
    padding-left: 20px;
}

ul.checkmark {
    list-style-type: none;
}

3- Para las diferentes companías, en newhire ponber las direcciones diferentes
espressamente illy = > 800 westchester ave, #S438
 *
 4- en separation marcar los grupos a los que el usuario esta suscrito

5- en new hire autocompletar el manager para los new hires

6- aplicar el estilo de newhire a separation (el required que no funciona en separation)
 * */

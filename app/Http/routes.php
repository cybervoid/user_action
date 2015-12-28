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
Route::post('org_change_lookup', 'Change_OrgController@lookup');
Route::post('change_org_verify', 'Change_OrgController@verify');
Route::post('change_org_save', 'Change_OrgController@save');
//Route::get('report/{reportType}/{name}', 'ReportsController@getReport')->where('name', '[a-zA-Z0-9 -]+\.pdf');


/*


// TOTODO

      //probar este


todo en separation remove the user from the VPN and wifi groups and check if we can first (usa groups)
todo en el form de org change al poner un coment no sale el nombre del usuario al que aplicaactivac
todo revisar el cron task no esta funcionando para nada
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
todo- organizacion change, al cambiar la compania mandar un correo
todo automatizado para cmabiar la signature y actualizar info en AD


// SEPARATION
todo al quitar info from ad ponerlas en el campo notas


{"count":1,"0":{"sn":{"count":1,"0":"Gil"},"0":"sn","title":{"count":1,"0":"IT Infrastructure Engineer & Support"},"1":"title","givenname":{"count":1,"0":"Rafael"},"2":"givenname","memberof":{"count":15,"0":"CN=SlideShow_SecurityGrp_NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","1":"CN=HR-Tool,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","2":"CN=Wordpress-editor,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","3":"CN=si_infra_all,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM","4":"CN=RoomUsersUSA,OU=Rooms,OU=New York City,OU=North America,DC=ILLY-DOMAIN,DC=COM","5":"CN=VNC Admin,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM","6":"CN=PC Admins,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM","7":"CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","8":"CN=Report ServiceDesk IC Nord America,CN=Users,DC=ILLY-DOMAIN,DC=COM","9":"CN=Finance NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","10":"CN=VPN illy,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM","11":"CN=Marketing NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","12":"CN=Information Technology NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","13":"CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM","14":"CN=Wifi Employees,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM"},"3":"memberof","department":{"count":1,"0":"IT"},"4":"department","company":{"count":1,"0":"illy caff\u00e8 North America, Inc."},"5":"company","samaccountname":{"count":1,"0":"gilra"},"6":"samaccountname","mail":{"count":1,"0":"Rafael.Gil@illy.com"},"7":"mail","manager":{"count":1,"0":"CN=Roy Forster,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM"},"8":"manager","count":9,"dn":"CN=Rafael Gil,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM"}}


*
 * donetodo add new users to VPN and Wifi by default
 * donetodo hacer el formulario de payroll para los separations
 donetodo newhires revisar employee number and nickname estan saliendo vacios en el reporte
donetodo- en new hires detectar location y predefinir los grupos a los que pertenece
donetodo- para los nombres eliminar espacios en los titulos, nombres, etc
donetodo- si tiene en el nombre un acento, no incluirlo en el nombre de usuario
tododone newhire el form esta saliendo con el campo de comentarios vacios
tododone - buscar por nombre y apellidos al mismo tiempo
donetodo- para el separation detectar si el campo de cellphone tiene algún valor is most likely the user has a cellphone and marcarlo en el listado
donetodo - quitar el enter en el formulario de buscar o decidir que hacer con él
donetodo para los separation listar todos los directorios a los que el usuario está afiliado
donetodo quitar del grupo del departamento como customer care na or finance na
donetodo para los newhires ponerlos en canada, verificar si hay un grupo en AD para ellos


 Array ( [count] => 1 [0] => Array ( [sn] => Array ( [count] => 1 [0] => Forster ) [0] => sn [title] => Array ( [count] => 1 [0] => Director of IT Applications and Process ) [1] => title [givenname] => Array ( [count] => 1 [0] => Roy ) [2] => givenname [memberof] => Array ( [count] => 25 [0] => CN=SlideShow_SecurityGrp_NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [1] => CN=HR-Tool,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [2] => CN=Wordpress-editor,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [3] => CN=DL_ODI_WS_SUPPORT,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [4] => CN=_MAPI_Issue,OU=Engineering,OU=Italy,DC=ILLY-DOMAIN,DC=COM [5] => CN=DL_blackberryusa,OU=Teorema,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [6] => CN=illyusa Managers Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [7] => CN=RMGTEAM,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [8] => CN=PC Admins,OU=Service Groups,DC=ILLY-DOMAIN,DC=COM [9] => CN=illyusa Rye Brook Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [10] => CN=EDI Orders Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [11] => CN=Oracle Super Users,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [12] => CN=Report ServiceDesk IC Nord America,CN=Users,DC=ILLY-DOMAIN,DC=COM [13] => CN=DL_forward_servicedesk,OU=Teorema,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [14] => CN=DL_si_gest,OU=Teorema,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [15] => CN=DL_BOusers,OU=Distribution,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [16] => CN=Finance NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [17] => CN=VPN illy,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [18] => CN=OWA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [19] => CN=Logistics NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [20] => CN=Information Technology NA,OU=Security Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [21] => CN=illyusaTeam Distribution Group,OU=Distribution Groups,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM [22] => CN=Wifi Employees,OU=Security,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [23] => CN=BOusers,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM [24] => CN=Sviluppatori,OU=Groups,OU=HeadQuarter,OU=Italy,DC=ILLY-DOMAIN,DC=COM ) [3] => memberof [department] => Array ( [count] => 1 [0] => IT ) [4] => department [company] => Array ( [count] => 1 [0] => illy caffè North America, Inc. ) [5] => company [samaccountname] => Array ( [count] => 1 [0] => forstro ) [6] => samaccountname [mail] => Array ( [count] => 1 [0] => Roy.Forster@illy.com ) [7] => mail [manager] => Array ( [count] => 1 [0] => CN=Carlo Badioli,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM ) [8] => manager [count] => 9 [dn] => CN=Roy Forster,OU=Users,OU=Rye Brook,OU=North America,DC=ILLY-DOMAIN,DC=COM ) )
Array ( [givenname] => Roy [sn] => Forster [department] => IT [title] => Director of IT Applications and Process [company] => illy caffè North America, Inc. [sAMAccountName] => forstro [manager] => Carlo Badioli [managerEmail] => Carlo.Badioli@illy.com [groups] => Array ( [0] => SlideShow_SecurityGrp_NA [1] => HR-Tool [2] => Wordpress-editor [3] => DL_ODI_WS_SUPPORT [4] => _MAPI_Issue [5] => DL_blackberryusa [6] => illyusa Managers Distribution Group [7] => RMGTEAM [8] => PC Admins [9] => illyusa Rye Brook Distribution Group [10] => EDI Orders Distribution Group [11] => Oracle Super Users [12] => Report ServiceDesk IC Nord America [13] => DL_forward_servicedesk [14] => DL_si_gest [15] => DL_BOusers [16] => Finance NA [17] => VPN illy [18] => OWA [19] => Logistics NA [20] => Information Technology NA [21] => illyusaTeam Distribution Group [22] => Wifi Employees [23] => BOusers [24] => Sviluppatori ) )
 */
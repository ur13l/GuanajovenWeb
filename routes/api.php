<?php

use Illuminate\Http\Request;
use \App\Notifications\ConvocatoriaNotification;
use \App\Convocatoria;
use \App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('/publicidad', 'PublicidadApiController@obtenerPublicidad');
Route::get('/convocatorias', 'ConvocatoriaApiController@obtenerConvocatorias');
Route::get('/promociones', 'PromocionesApiController@obtenerEmpresasPromociones');
Route::get('/regiones', 'RegionApiController@obtenerRegiones');
Route::get('/eventos','EventoApiController@obtenerEventos');
Route::post('/eventos/marcar','EventoApiController@marcarEvento');
Route::post('/eventos/registrar', 'EventoApiController@registrar');
Route::get('/notificacionres', 'NotificacionesApiController@obtenerNotificaciones');


//Autenticación API
Route::group(['prefix' => 'usuarios'], function () {
    Route::post('login', 'Auth\LoginApiController@login');
    Route::post('registrar', 'UserApiController@registrar');
    Route::post('actualizar', 'UserApiController@actualizar');
    Route::post('verificarcorreo', 'UserApiController@verificarEmail');
    Route::post('logingoogle', 'Auth\LoginApiController@loginGoogle');
    Route::post('loginfacebook', 'Auth\LoginApiController@loginFacebook');
    Route::post('login_admin', 'Auth\LoginApiController@loginAdmin');
    Route::post('curp', 'UserApiController@obtenerCurp');
    Route::post('posicion','UserApiController@obtenerPosicion');
    Route::post('actualizar-token-guanajoven', 'UserApiController@actualizarTokenGuanajoven');
});

Route::group(['prefix' => 'profile'], function () {
    Route::post('update', 'ProfileApiController@updateProfile');
    Route::post('get', 'ProfileApiController@getProfile');
});


Route::group(['prefix' => '/notificaciones'], function() {
    Route::post('/enviartoken', 'NotificacionesApiController@registrar');
    Route::post('/cancelartoken', 'NotificacionesApiController@cancelar');
    Route::post('/convocatoria', 'ConvocatoriaNotificacionController@enviarNotificacion');
    Route::post('/evento', 'EventoNotificacionController@enviarNotificacion');
    Route::any('/convocatoria/registrada', 'EnviarCorreosApiController@index')->name('convocatoria.registrada');
    Route::any('/evento/registrado', 'EnviarCorreosApiController@guardarVariablesEvento')->name('evento.registrado');
});


Route::group(['prefix' => '/chat'], function() {
    Route::post('/enviar', 'ChatApiController@enviar');
    Route::post('/mensajes', 'ChatApiController@mensajes');
    Route::post('/mensajesAdmin', 'ChatApiController@mensajesAdmin');
    Route::post('/enviarAdmin', 'ChatApiController@enviarAdmin');
});


Route::group(['prefix' => '/documentos'], function () {
   Route::group(['prefix' => '/pdf'], function() {
      Route::get('idguanajoven', 'PdfController@generarPDF');
   });
});

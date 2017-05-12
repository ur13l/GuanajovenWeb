<?php

use Illuminate\Http\Request;

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
Route::get('/regiones', 'RegionApiController@obtenerRegiones');
Route::get('/eventos','EventoApiController@obtenerEventos');

Route::group(['prefix' => '/notificaciones'], function() {
    Route::post('/enviartoken', 'NotificacionesApiContrroller@registrar');
    Route::post('/cancelartoken', 'NotificacionesApiContrroller@cancelar');
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//Usuarios
Route::post('/usuarios/login', 'Auth\LoginController@login');

//Autenticación API
Route::group(['prefix' => 'api/usuarios'], function () {
    Route::post('login', 'Auth\LoginApiController@login');
    Route::post('registrar', 'Auth\LoginApiController@registrar');
});

//Publicidad
Route::get('/publicidad', 'PublicidadController@index');
//Convocatorias
Route::get('/convocatorias', 'ConvocatoriasController@index');
Route::get('/convocatorias/nueva_convocatoria', 'ConvocatoriasController@nuevaConvocatoria');
//Historial de notificaciones
Route::get('/historial', 'HistorialController@index');
//Reportes
Route::get('/reportes', 'ReportesController@index');
//Usuarios
Route::get('/usuarios', 'UsuariosController@index');
//Notificaciones
Route::get('/notificaciones', 'NotificacionesController@index');
//Eventos
Route::get('/eventos', 'EventosController@index');
Route::get('/eventos/nuevo', 'EventosController@nuevoEvento');
Route::get('/eventos/editar', 'EventosController@editarEvento');
//Video
Route::get('/video', 'VideoController@index');
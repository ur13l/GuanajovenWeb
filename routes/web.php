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
//Route::auth();


Route::get('/', function () {
    return view('index');
});

//Usuarios
Route::post('/usuarios/login', 'Auth\LoginController@login');

Route::get('/usuarios/logout', 'Auth\LoginController@getlogout');



//Publicidad
Route::group(['prefix' => 'publicidad'], function () {
    Route::get('/', 'PublicidadController@index')->name('publicidad');
    Route::post('/eliminar', 'PublicidadController@eliminar');
    Route::post('/crear', 'PublicidadController@crear');
    Route::post('/actualizar', 'PublicidadController@actualizar');
    Route::get('/detalle/{id}', 'PublicidadController@detalle');
});


//Convocatorias
Route::group(['prefix' => 'convocatorias'], function() {
    Route::get('/', 'ConvocatoriasController@index')->name('convocatorias');
    Route::get('/nueva', 'ConvocatoriasController@nueva');
    Route::post('/eliminar', 'ConvocatoriasController@eliminar');
    Route::post('/crear', 'ConvocatoriasController@crear');
    Route::get('/editar/{id_convocatoria}', 'ConvocatoriasController@vistaEditar');
    Route::post('/editar', 'ConvocatoriasController@editar');
});

//Convocatorias
Route::group(['prefix' => 'convocatorias'], function() {
    Route::get('/', 'ConvocatoriasController@index')->name('convocatorias');
    Route::get('/nueva', 'ConvocatoriasController@nueva');
    Route::post('/eliminar', 'ConvocatoriasController@eliminar');
    Route::post('/crear', 'ConvocatoriasController@crear');
    Route::get('/editar/{id_convocatoria}', 'ConvocatoriasController@vistaEditar');
    Route::post('/editar', 'ConvocatoriasController@editar');
});


//Empresas
Route::group(['prefix' => 'empresas'], function() {
    Route::get('/', 'EmpresaController@index')->name('empresas');
    Route::get('/nueva', 'EmpresaController@nueva');
    Route::post('/eliminar', 'EmpresaController@eliminar');
    Route::post('/crear', 'EmpresaController@crear');
    Route::get('/editar/{id_empresa}', 'EmpresaController@vistaEditar');
    Route::post('/editar', 'EmpresaController@editar');
});

//Promoción
Route::group(['prefix' => 'promociones'], function() {
    Route::post('/nueva', 'PromocionesController@crear');
    Route::post('/editar', 'PromocionesController@editar');
    Route::get('/eliminarPromocion/{id_promocion}/{id_empresa}', 'PromocionesController@eliminar');
});

//Chat
Route::group(['prefix' => 'chat'], function() {
      Route::get('/', 'ChatController@index')->name('chat');
});




//Notificaciones
Route::group(['prefix' => 'notificaciones'], function() {
    Route::get('/', 'NotificacionesController@index')->name('notificaciones');
    Route::post('/enviar', 'NotificacionesController@enviar');
    Route::post('/eliminar', 'NotificacionesController@eliminar');
    Route::get('/lista', 'NotificacionesController@lista');
});


//Historial de notificaciones
Route::get('/historial', 'HistorialController@index');
//Reportes
Route::get('/reportes', 'ReportesController@index');
//Usuarios
Route::get('/usuarios', 'UsuariosController@index');
//Eventos
Route::group(['prefix' => 'eventos'], function () {
    Route::get('/inicio', 'EventosController@index');
    Route::get('/nuevo', 'EventosController@nuevoEvento');
    Route::get('/editar', 'EventosController@editarEvento');
    Route::post('/guardar', 'EventosController@guardarEvento');
});
//Video
Route::get('/video', 'VideoController@index');

Auth::routes();

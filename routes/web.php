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

//Publicidad
Route::get('/publicidad', 'PublicidadController@index');
//Convocatorias
Route::get('/convocatorias', 'ConvocatoriasController@index');
Route::get('/convocatorias/nueva_convocatoria', 'ConvocatoriasController@nuevaConvocatoria');
<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Convocatorias.
  Fecha: 31/01/2017.
*/

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ConvocatoriasController {
    public function index(Request $request) {
        return view('convocatorias.index');
    }
}
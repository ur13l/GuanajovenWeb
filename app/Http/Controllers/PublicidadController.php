<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Publicidad.
  Fecha: 27/01/2017.
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicidadController {

    public function index(Request $request) {
        return view('publicidad.index');
    }

}

?>
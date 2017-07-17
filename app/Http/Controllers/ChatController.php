<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Convocatorias.
  Fecha: 31/01/2017.
*/

namespace App\Http\Controllers;


use App\Empresa;
use App\Documento;
use App\Formato;
use App\Utils\FileUtils;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController {
    use ValidatesRequests;

    /**
     * Index [GET]
     * Carga el index de empresa con el listado de estas para revisar detalles, crear y eliminar
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        return view('chat.index');
    }




}

<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 2:45 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class UsuariosController {
    public function index(Request $request) {
        return view('usuarios.index');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 3:19 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class EventosController {
    public function index(Request $request) {
        return view('eventos.index');
    }

    public function nuevoEvento(Request $request) {
        return view('eventos.nuevoEvento');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 1:33 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class HistorialController {
    public function index(Request $request) {
        return view('historial.index');
    }
}
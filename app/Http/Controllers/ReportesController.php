<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 2:31 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class ReportesController {
    public function index(Request $request) {
        return view('reportes.index');
    }
}
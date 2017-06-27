<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 2:31 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\CodigoGuanajoven;
use App\Estado;
use App\DatosUsuario;
use App\Genero;
//use App\Http\Controllers\Auth\ImageController;
use App\Http\Controllers\ImageController;
use App\Municipio;
use App\Soap\ConsultaPorCurp;
use App\Soap\ConsultaPorCurpResponse;
use App\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;

class ReportesController {
    public function index(Request $request) {
        return view('reportes.index');
    }



}

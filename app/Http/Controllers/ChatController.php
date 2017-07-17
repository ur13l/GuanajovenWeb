<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class ChatController extends Controller
{

    public function index() {
        return view('chat');
    }

    public function obtenerMensajes() {

    }

}

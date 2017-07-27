<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificacionEvento extends Model {
    protected $table = 'usuario_evento';

    protected $fillable = [
        'id_evento',
        'id_usuario',
        'le_interesa',
        'asistio',
        'asistira'
    ];

    public $timestamps = false;
}

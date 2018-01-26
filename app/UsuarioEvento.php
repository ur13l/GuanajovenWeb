<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioEvento extends Model {
    protected $table = 'usuario_evento';

    protected $fillable = [
        'id_evento',
        'id_usuario',
        'le_interesa',
        'asistio'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

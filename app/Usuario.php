<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model {
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_usuario',
        'correo',
        'contrasena',
        'admin'
    ];

    public function datosUsuario() {
        return $this->hasOne('App\DatosUsuario', 'id_usuario', 'id_usuario');
    }
}

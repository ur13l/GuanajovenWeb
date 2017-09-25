<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPromocion extends Model
{
    protected $table = 'usuario_promocion';

    //protected $primaryKey = ['id_usuario', 'id_promocion'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_usuario',
        'id_empresa',
        'id_promocion',
        'codigo_promocion',
    ];

}

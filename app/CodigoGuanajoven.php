<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodigoGuanajoven extends Model
{
    use SoftDeletes;
    protected $primaryKey = "id_codigo_guanajoven";
    protected $table = "codigo_guanajoven";

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'fecha_expiracion',
        'fecha_limite'
    ];

    protected $fillable = [
        'id_usuario',
        'token',
        'fecha_expiracion',
        'fecha_limite'
    ];

}

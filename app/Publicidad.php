<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicidad extends Model {
    use SoftDeletes;

    protected $table = 'publicidad';
    protected $primaryKey = 'id_publicidad';

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_publicidad',
        'titulo',
        'descripcion',
        'ruta_imagen',
        'url',
        'fecha_inicio',
        'fecha_fin'
    ];
}

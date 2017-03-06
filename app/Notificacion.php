<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model {
    protected $table = 'notificacion';
    protected $primaryKey = 'id_notificacion';

    protected $dates = [
        'fecha_emision',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_notificacion',
        'titulo',
        'mensaje',
        'fecha_emision',
        'edad_minima',
        'edad_maxima',
        'id_genero',
        'id_region'
    ];

    //Relaciones
}

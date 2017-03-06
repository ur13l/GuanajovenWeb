<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {
    protected $table = 'region';
    protected $primaryKey = 'id_region';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_region',
        'nombre',
        'direccion',
        'responsable',
        'descripcion',
        'latitud',
        'longitud'
    ];

    //Relaciones

}

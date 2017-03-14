<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model {
    use SoftDeletes;

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
}

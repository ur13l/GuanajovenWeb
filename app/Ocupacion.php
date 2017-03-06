<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model {
    protected $table = 'ocupacion';
    protected $primaryKey = 'id_ocupacion';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_ocupacion',
        'nombre'
    ];
}

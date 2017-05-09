<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model {
    use SoftDeletes;

    protected $table = 'municipio';
    protected $primaryKey = 'id_municipio';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_municipio',
        'nombre',
        'id_region'
    ];
}

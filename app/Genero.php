<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genero extends Model {
    use SoftDeletes;

    protected $table = 'genero';
    protected $primaryKey = 'id_genero';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_genero',
        'nombre'
    ];
}

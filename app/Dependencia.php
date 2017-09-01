<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $table = 'dependencia';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'clave'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

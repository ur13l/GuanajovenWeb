<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model {
    use SoftDeletes;

    protected $table = 'estado';
    protected $primaryKey = 'id_estado';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_estado',
        'nombre',
        'abreviatura'
    ];
}

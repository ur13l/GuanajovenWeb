<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEvento extends Model {
    use SoftDeletes;

    protected $table = 'tipo_evento';
    protected $primaryKey = 'id_tipo_evento';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_tipo_evento',
        'nombre'
    ];
}

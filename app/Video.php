<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model {
    use SoftDeletes;

    protected $table = 'video';
    protected $primaryKey = 'id_video';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_video',
        'titulo',
        'descripcion',
        'ruta_video',
        'tamano'
    ];
}

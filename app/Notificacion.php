<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacion extends Model {
    use SoftDeletes;

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
        'url'
    ];

    //Relaciones
    public function genero() {
        return $this->hasMany('App\Genero', 'id_genero');
    }

    public function usuarios() {
        return $this->belongsToMany('App\User', 'usuario_notificacion','id_notificacion', 'id_usuario');
    }
}

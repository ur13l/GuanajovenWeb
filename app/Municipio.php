<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model {
    protected $table = 'municipio';
    protected $primaryKey = 'id_municipio';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_municipio',
        'nombre'
    ];

    //Relaciones
    public function datosUsuario() {
        return $this->hasMany('App\DatosUsuario', 'id_municipio', 'id_municipio');
    }
}

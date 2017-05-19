<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatosUsuario extends Model {
    protected $table = 'datos_usuario';
    protected $primaryKey = 'id_datos_usuario';
    use SoftDeletes;

    protected $dates = [
        'fecha_nacimiento',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_datos_usuario',
        'id_usuario',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'id_genero',
        'id_ocupacion',
        'fecha_nacimiento',
        'id_estado_nacimiento',
        'codigo_postal',
        'telefono',
        'curp',
        'id_estado',
        'id_municipio',
        'ruta_imagen'
    ];

    //Relaciones
    public function usuario() {
        return $this->hasOne('App\User', 'id_usuario', 'id_usuario');
    }

    public function genero() {
        return $this->hasOne('App\Genero', 'id_genero', 'id_genero');
    }

    public function ocupacion() {
        return $this->hasOne('App\Ocupacion', 'id_ocupacion', 'id_ocupacion');
    }

    public function estado() {
        return $this->hasOne('App\Estado', 'id_estado', 'id_estado');
    }

    public function municipio() {
        return $this->hasOne('App\Municipio', 'id_municipio', 'id_municipio');
    }

    public function estadoNacimiento() {
        return $this->hasOne('App\Estado', 'id_estado', 'id_estado_nacimiento');
    }
}

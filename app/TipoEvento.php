<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model {
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

    //Relaciones
    public function evento() {
        return $this->hasOne('App\Evento', 'id_tipo_evento', 'id_tipo_evento');
    }
}

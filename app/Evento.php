<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model {
    public $table = 'evento';
    public $primaryKey = 'id_evento';
    use SoftDeletes;

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_evento',
        'id_tipo_evento',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'latitud',
        'longitud'
    ];

    public function tipoEvento() {
        return $this->hasOne("App\TipoEvento", "id_tipo_evento", "id_tipo_evento");
    }
}

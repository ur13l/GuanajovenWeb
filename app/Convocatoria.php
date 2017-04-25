<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convocatoria extends Model
{
    use SoftDeletes;

    protected $table = "convocatoria";
    protected $primaryKey = "id_convocatoria";
    protected $fillable = [
        "id_convocatoria",
        "titulo",
        "descripcion",
        "ruta_imagen",
        "fecha_inicio",
        "fecha_cierre",
        "estatus"
    ];

    protected $dates = [
        "fecha_inicio",
        "fecha_cierre",
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function documentos(){
        return $this->hasMany('App\Documento', 'id_convocatoria')->with('formato');
    }
}

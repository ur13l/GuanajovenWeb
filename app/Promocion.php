<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Promocion extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = "promocion";
    protected $primaryKey = "id_promocion";
    protected $fillable = [
        "id_empresa",
        "titulo",
        "descripcion",
        "bases",
        "fecha_inicio",
        "fecha_fin",
        "codigo_promocion",
        "url_promocion"
    ];

    protected $dates = [
        "fecha_inicio",
        "fecha_fin",
        'created_at',
        'updated_at',
        'deleted_at'
    ];



}

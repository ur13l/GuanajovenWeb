<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $table = "empresa";
    protected $primaryKey = "id_empresa";
    protected $fillable = [
       "id_empresa",
        "empresa",
        "logo",
        "nombre_comercial",
        "razon_social",
        "convenio",
        "estatus",
        "prioridad",
        "url_empresa"
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];



}

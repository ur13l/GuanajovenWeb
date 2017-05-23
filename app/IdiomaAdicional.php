<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdiomaAdicional extends Model
{
    protected $table = "idioma_adicional";
    protected $primaryKey = "id_idioma_adicional";
    protected $fillable = ["nombre"];
}

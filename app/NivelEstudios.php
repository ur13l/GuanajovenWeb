<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelEstudios extends Model
{
    protected $table = "nivel_estudios";
    protected $primaryKey = "id_nivel_estudios";
    protected $fillable = ["nombre"];
}

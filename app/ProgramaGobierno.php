<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramaGobierno extends Model
{
    protected $table = "programa_gobierno";
    protected $primaryKey = "id_programa_gobierno";
    protected $fillable = ["nombre"];
}

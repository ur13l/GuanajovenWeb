<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CapacidadDiferente extends Model
{
    protected $table = "capacidad_diferente";
    protected $primaryKey = "id_capacidad_diferente";
    protected $fillable = ["nombre"];
}

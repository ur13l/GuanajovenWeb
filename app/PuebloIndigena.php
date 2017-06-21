<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuebloIndigena extends Model
{
    protected $table = "pueblo_indigena";
    protected $primaryKey = "id_pueblo_indigena";
    protected $fillable = ["nombre"];
}

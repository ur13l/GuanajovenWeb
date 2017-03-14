<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Formato extends Model
{
    use SoftDeletes;

    protected $table = "formato";
    protected $primaryKey = "id_formato";
    protected $fillable = [
        "id_formato",
        "nombre"
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function documentos(){
        return $this->hasMany('App\Documento');
    }
}

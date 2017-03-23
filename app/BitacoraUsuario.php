<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BitacoraUsuario extends Model {
    use SoftDeletes;

    protected $table = 'bitacora_usuario';
    protected $primaryKey = 'id_bitacora';

    protected $dates = [
        'fecha',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_bitacora',
        'id_usuario',
        'fecha'
    ];

    //Relaciones
    public function usuario() {
        return $this->hasOne('App\User', 'id');
    }
}

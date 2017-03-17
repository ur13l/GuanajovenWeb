<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginToken extends Model {
    use SoftDeletes;

    protected $table = 'login_token';
    protected $primaryKey = 'id_device_token';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id_device_token',
        'id_usuario',
        'device_token'
    ];

    //Relacione con usuario
    public function usuario() {
        return $this->hasMany('App\Usuario', 'id_usuario');
    }
}

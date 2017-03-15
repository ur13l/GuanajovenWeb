<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable {
    protected $table = 'usuario';
    protected $primaryKey = 'id';
    use SoftDeletes;
    use Notifiable;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'email',
        'password',
        'admin'
    ];

    protected $hidden = [
        'password'

    ];

    public function save(array $options = array())
    {
        if(empty($this->api_token)) {
            $this->api_token = str_random(60);
        }
        return parent::save($options);
    }


    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function datosUsuario(){
        return $this->hasOne('App\DatosUsuario', 'id_usuario');
    }

}

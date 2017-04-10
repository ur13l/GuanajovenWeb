<?php

namespace App;

use App\Notifications\MyResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements CanResetPassword {
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
        'id_google',
        'id_facebook',
        'password',
        'admin'
    ];

    protected $hidden = [
        'password',
        'id_google',
        'id_facebook',
        'remember_token'
    ];


    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }


    public function save(array $options = array())
    {
        if(empty($this->api_token)) {
            $this->api_token = str_random(60);
        }

        if(!empty($this->id_google)){
            $this->id_google = Hash::make($this->id_google);
        }

        if(!empty($this->id_facebook)){
            $this->id_facebook = Hash::make($this->id_facebook);
        }
        return parent::save($options);
    }


    public function datosUsuario(){
        return $this->hasOne('App\DatosUsuario', 'id_usuario');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

}
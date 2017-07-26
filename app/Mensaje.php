<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensaje extends Model
{
    protected $table = 'mensaje';
    protected $primaryKey = 'id_mensaje';

    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
      'id_usuario',
      'mensaje',
      'envia_usuario',
      'visto'
    ];

    public function usuario() {
        return $this->belongsTo(User::class);
    }

}

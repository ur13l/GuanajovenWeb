<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    protected $table = 'rol_permiso';

    protected $primaryKey = ['id_rol', 'id_permiso'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}

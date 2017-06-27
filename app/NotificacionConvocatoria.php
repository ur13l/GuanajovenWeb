<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificacionConvocatoria extends Model
{
    protected $table = 'usuario_convocatoria';
    protected $id_usuario;
    protected $id_convocatoria;
    public $timestamps = false;

}

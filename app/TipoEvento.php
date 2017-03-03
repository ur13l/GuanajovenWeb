<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model {
    protected $table = 'tipo_evento';
    protected $primaryKey = 'id_tipo_evento';

    protected $fillable = ['nombre'];
}

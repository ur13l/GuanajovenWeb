<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mensaje extends Model
{
    protected $table = 'mensaje';
    protected $primaryKey = 'id';

    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = ['mensaje'];

    public function usuario() {
        return $this->belongsTo(User::class);
    }

}

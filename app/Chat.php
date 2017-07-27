<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    protected $table = 'chat';
      protected $primaryKey = 'id_chat';
      use SoftDeletes;
      use Notifiable;


      protected $fillable = [
          'id_usuario'
      ];
      protected $dates = [
          'created_at',
          'updated_at',
          'deleted_at'
      ];

}

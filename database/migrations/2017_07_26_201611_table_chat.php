<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableChat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('chat', function (Blueprint $table) {
         $table->increments('id_chat');
         $table->integer('id_usuario');
         $table->foreign('id_usuario')->references('id')->on('usuario');
         $table->timestamps();
         $table->softDeletes();
     });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

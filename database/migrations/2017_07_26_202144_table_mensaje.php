<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableMensaje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mensaje', function (Blueprint $table) {

         $table->increments('id_mensaje');
         $table->integer('id_chat')->unsigned();
         $table->string('mensaje',2000);
         $table->boolean('envia_usuario');
         $table->boolean('visto');
         $table->timestamps();
         $table->softDeletes();

          });

  Schema::table('mensaje', function (Blueprint $table) {
     $table->foreign('id_chat')->references('id_chat')->on('chat');
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

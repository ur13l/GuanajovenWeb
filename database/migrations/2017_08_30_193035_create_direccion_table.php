<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direccion', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_dependencia')->unsigned();
            $table->string('nombre');
            $table->string('clave');

            $table->foreign('id_dependencia')->references('id')->on('dependencia');

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
        Schema::table('direccion', function (Blueprint $table) {
            //
        });
    }
}

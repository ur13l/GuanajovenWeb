<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePuesto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('puesto', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_area')->unsigned();
            $table->string('nombre');
            $table->string('clave');

            $table->foreign('id_area')->references('id')->on('area');

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
        Schema::table('puesto', function (Blueprint $table) {
            //
        });
    }
}

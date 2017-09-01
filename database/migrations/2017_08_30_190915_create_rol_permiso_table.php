<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolPermisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rol_permiso', function (Blueprint $table) {
            $table->integer('id_rol')->unsigned();
            $table->integer('id_permiso')->unsigned();

            $table->primary(['id_rol', 'id_permiso']);

            $table->foreign('id_rol')->references('id')->on('rol');
            $table->foreign('id_permiso')->references('id')->on('permiso');

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
        Schema::table('rol_permiso', function (Blueprint $table) {
            //
        });
    }
}

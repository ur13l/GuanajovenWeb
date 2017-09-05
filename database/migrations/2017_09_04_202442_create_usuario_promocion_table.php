<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioPromocionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_promocion', function (Blueprint $table) {
            $table->integer('id_usuario');
            $table->integer('id_empresa');
            $table->integer('id_promocion');
            $table->string('codigo_promocion');

            //$table->primary(['id_usuario', 'id_promocion']);


            $table->foreign('id_usuario')->references('id')->on('usuario');
            $table->foreign('id_promocion')->references('id_promocion')->on('promocion');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voidxD
     */
    public function down()
    {
        Schema::table('usuario_promocion', function (Blueprint $table) {
            //
        });
    }
}

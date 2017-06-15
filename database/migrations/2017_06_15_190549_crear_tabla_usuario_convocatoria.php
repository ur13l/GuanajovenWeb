<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaUsuarioConvocatoria extends Migration
{
    //Damos de alta la tabla
    public function up()
    {
        //crea la tabla usuario_convocatoria
        Schema::create('usuario_convocatoria', function (Blueprint $table) {
            //Llave primaria multivaluada
            $table->primary(['id_usuario', 'id_convocatoria']);
            //Se le agregan los campos de created y deleted at
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
        Schema::dropIfExists('usuario_convocatoria');
    }
}

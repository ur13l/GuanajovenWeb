<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('permiso')) {
            Schema::table('permiso', function (Blueprint $table) {
                $this->addOrUpdate($table);
            });
        } else {
            Schema::create('permiso', function (Blueprint $table) {
                $this->addOrUpdate($table);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permiso');
    }

    private function addOrUpdate(Blueprint $table) {
        $table->increments('id');

        $table->string('nombre');
        $table->string('nombre_vista');

        $table->timestamps();
        $table->softDeletes();
    }
}

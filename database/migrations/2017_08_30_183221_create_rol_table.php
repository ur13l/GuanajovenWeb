<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('rol')) {
            Schema::table('rol', function (Blueprint $table) {
                $this->addOrUptade($table);
            });
        } else {
            Schema::create('rol', function (Blueprint $table) {
               $this->addOrUptade($table);
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
        Schema::dropIfExists('rol');
    }

    private function addOrUptade(Blueprint $table) {
        $table->increments('id');

        $table->string('nombre');
        $table->string('nombre_vista');

        $table->timestamps();
        $table->softDeletes();
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogos', function (Blueprint $table) {
            $table->string('idCatalogo');
            $table->string('idUsuario');
            $table->string('empresa');
            $table->string('imagenPath');
            $table->date('fechaEmision');
            $table->date('vigencia');
            $table->string('estatus');

            $table->primary('idCatalogo');
            $table->foreign('idUsuario')->references('idUsuario')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogos');
    }
}

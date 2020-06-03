<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('idUsuario');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('alias');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->string('direccion');
            $table->string('tipo');
            $table->string('password');
            $table->string('api_token', 80)
                                ->unique()
                                ->nullable()
                                ->default(null);
            $table->rememberToken();
            $table->timestamps();

            $table->primary('idUsuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

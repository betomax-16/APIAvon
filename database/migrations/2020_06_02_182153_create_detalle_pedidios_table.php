<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePedidiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidios', function (Blueprint $table) {
            $table->string('idDetallePedido');
            $table->string('idPedido');
            $table->string('idProducto');
            $table->string('idCatalogo');
            $table->string('detalle');
            $table->integer('cantidad');
            $table->double('precioUnitario', 8, 2);
            $table->string('estatus');
            $table->timestamps();

            $table->primary('idDetallePedido');
            $table->foreign('idPedido')->references('idPedido')->on('pedidos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_pedidios');
    }
}

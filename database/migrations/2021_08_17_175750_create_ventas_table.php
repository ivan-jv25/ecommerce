<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rut', 12);
            $table->integer('folio');
            $table->integer('id_direccion');
            $table->integer('tipo_entrega');
            $table->integer('descuento');
            $table->integer('neto');
            $table->integer('neto_exento');
            $table->integer('iva');
            $table->integer('total_venta');
            $table->integer('tipo_documento');
            $table->integer('forma_pago');
            $table->integer('id_bodega');
            $table->integer('estado_pago');
            $table->integer('id_formapago');
            $table->string('codigo_pago', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_barras', 50);
            $table->string('nombre_comercial', 100);
            $table->string('nombre_generico', 100)->nullable();
            $table->string('fabricante', 100)->nullable();
            $table->string('presentacion', 50)->nullable();
            $table->string('concentracion', 50)->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->decimal('precio_compra', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->date('fecha_caducidad');
            $table->string('lote', 50)->nullable();
            $table->string('ubicacion', 50)->nullable();
            $table->string('imagen')->nullable();
            $table->string('estado', 10)->default('activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicamentos');
    }
};
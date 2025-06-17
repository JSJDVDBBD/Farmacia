<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicamento_id')->constrained()->onDelete('cascade');
            $table->string('tipo'); // stock_bajo, caducidad_proxima
            $table->string('nivel'); // bajo, medio, alto
            $table->text('mensaje');
            $table->dateTime('fecha_alerta');
            $table->dateTime('fecha_resolucion')->nullable();
            $table->string('estado')->default('activa');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alertas');
    }
};
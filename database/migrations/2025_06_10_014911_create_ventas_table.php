<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('medicamento_id')->constrained();
    $table->integer('cantidad_vendida');
    $table->decimal('precio_unitario', 8, 2);
    $table->decimal('total_venta', 8, 2);
    $table->timestamp('fecha_venta');
    $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};

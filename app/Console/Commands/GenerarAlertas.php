<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medicamento;
use App\Models\Alerta;
use Illuminate\Support\Facades\Auth;

class GenerarAlertas extends Command
{
    protected $signature = 'farmacia:generar-alertas';
    protected $description = 'Genera alertas por medicamentos con stock bajo o próximos a caducar';

    public function handle()
    {
        $user_id = 1; // Asignar usuario admin por defecto

        $this->info('Generando alertas de stock bajo...');

        $stock_bajo = Medicamento::whereColumn('stock_actual', '<', 'stock_minimo')->get();
        foreach ($stock_bajo as $med) {
            Alerta::firstOrCreate([
                'medicamento_id' => $med->id,
                'tipo' => 'stock_bajo',
                'estado' => 'activa',
            ], [
                'nivel' => 'alto',
                'mensaje' => 'El stock está por debajo del mínimo.',
                'fecha_alerta' => now(),
                'user_id' => $user_id,
            ]);
        }

        $this->info('Generando alertas por caducidad próxima...');

        $caducidad = Medicamento::where('fecha_caducidad', '<=', now()->addDays(10))->get();
        foreach ($caducidad as $med) {
            Alerta::firstOrCreate([
                'medicamento_id' => $med->id,
                'tipo' => 'caducidad',
                'estado' => 'activa',
            ], [
                'nivel' => 'medio',
                'mensaje' => 'Producto próximo a caducar.',
                'fecha_alerta' => now(),
                'user_id' => $user_id,
            ]);
        }

        $this->info('✅ Alertas generadas correctamente.');
    }
}

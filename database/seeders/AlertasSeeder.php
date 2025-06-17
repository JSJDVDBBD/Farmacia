<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Database\Seeder;

class AlertasSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar que existan medicamentos
        if (Medicamento::count() == 0 || User::count() == 0) {
            $this->command->error('No hay medicamentos o usuarios. Ejecuta primero esos seeders!');
            return;
        }

        $user = User::first();

        // Alertas por stock bajo (solo si hay medicamentos bajo stock mínimo)
        $bajoStock = Medicamento::whereColumn('stock_actual', '<', 'stock_minimo')->get();
        
        if ($bajoStock->isNotEmpty()) {
            $bajoStock->each(function ($med) use ($user) {
                Alerta::create([
                    'medicamento_id' => $med->id,
                    'tipo' => 'stock_bajo',
                    'nivel' => $med->stock_actual < ($med->stock_minimo / 2) ? 'alto' : 'medio',
                    'mensaje' => 'Stock actual: ' . $med->stock_actual . ' (Mínimo: ' . $med->stock_minimo . ')',
                    'fecha_alerta' => now(),
                    'estado' => 'activa',
                    'user_id' => $user->id
                ]);
            });
        }

        // Alertas por caducidad próxima
        $porCaducar = Medicamento::where('fecha_caducidad', '<=', now()->addDays(30))->get();
        
        if ($porCaducar->isNotEmpty()) {
            $porCaducar->each(function ($med) use ($user) {
                $dias = now()->diffInDays($med->fecha_caducidad);
                
                Alerta::create([
                    'medicamento_id' => $med->id,
                    'tipo' => 'caducidad',
                    'nivel' => $dias <= 7 ? 'alto' : ($dias <= 15 ? 'medio' : 'bajo'),
                    'mensaje' => 'Caduca en ' . $dias . ' días (' . $med->fecha_caducidad->format('d/m/Y') . ')',
                    'fecha_alerta' => now(),
                    'estado' => 'activa',
                    'user_id' => $user->id
                ]);
            });
        }

        $this->command->info('Alertas generadas: ' . ($bajoStock->count() + $porCaducar->count()));
    }
}
<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Database\Seeder;

class ComprasSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar datos requeridos
        if (Medicamento::count() == 0 || User::count() == 0) {
            $this->command->error('No hay medicamentos o usuarios. Ejecuta primero esos seeders!');
            return;
        }

        $user = User::first();
        $meds = Medicamento::all();
        $totalMeds = $meds->count();

        for ($i = 0; $i < 5; $i++) {
            $compra = Compra::create([
                'fecha_compra' => now()->subDays(rand(10, 30)),
                'numero_factura' => 'FAC-' . rand(1000, 9999),
                'total' => 0,
                'metodo_pago' => 'efectivo',
                'estado' => 'activo',
                'user_id' => $user->id
            ]);

            $total = 0;
            // Seleccionar entre 1 y min(3, total de medicamentos disponibles)
            $numItems = min(3, $totalMeds);
            foreach ($meds->random(rand(1, $numItems)) as $med) {
                $cantidad = rand(10, 30);
                $precio = $med->precio_compra;
                $total += $cantidad * $precio;

                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'medicamento_id' => $med->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'lote' => 'L-' . rand(100, 999),
                    'fecha_caducidad' => now()->addMonths(rand(3, 12))
                ]);

                $med->stock_actual += $cantidad;
                $med->save();
            }

            $compra->total = $total;
            $compra->save();
        }

        $this->command->info('Compras de ejemplo creadas!');
    }
}
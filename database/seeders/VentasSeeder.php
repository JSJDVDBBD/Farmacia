<?php

namespace Database\Seeders;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Database\Seeder;

class VentasSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar datos requeridos
        if (Medicamento::count() == 0 || User::count() == 0) {
            $this->command->error('No hay medicamentos o usuarios. Ejecuta primero esos seeders!');
            return;
        }

        $user = User::first();
        $meds = Medicamento::where('stock_actual', '>', 0)->get();

        if ($meds->isEmpty()) {
            $this->command->error('No hay medicamentos con stock disponible!');
            return;
        }

        for ($i = 0; $i < 7; $i++) {
            $fecha = now()->subDays($i);
            $folio = 'V-' . date('Ymd') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);

            $venta = Venta::create([
                'folio' => $folio,
                'fecha_venta' => $fecha,
                'subtotal' => 0,
                'total' => 0,
                'metodo_pago' => ['efectivo', 'tarjeta'][rand(0, 1)],
                'estado' => 'completada',
                'user_id' => $user->id
            ]);

            $subtotal = 0;
            foreach ($meds->random(min(3, $meds->count())) as $med) {
                $cantidad = rand(1, min(3, $med->stock_actual));
                $precio = $med->precio_venta;
                $importe = $cantidad * $precio;
                $subtotal += $importe;

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'medicamento_id' => $med->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'descuento' => 0,
                    'importe' => $importe
                ]);

                $med->stock_actual -= $cantidad;
                $med->save();
            }

            $venta->subtotal = $subtotal;
            $venta->total = $subtotal;
            $venta->save();
        }

        $this->command->info('Ventas de ejemplo creadas!');
    }
}
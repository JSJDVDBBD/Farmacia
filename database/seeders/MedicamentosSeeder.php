<?php

namespace Database\Seeders;

use App\Models\Medicamento;
use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicamentosSeeder extends Seeder
{
    public function run()
    {
        // Desactivar revisión de claves foráneas para mejor performance
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Medicamento::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Obtener categorías existentes
        $categorias = Categoria::all();

        if ($categorias->isEmpty()) {
            $this->command->info('No hay categorías disponibles. Creando medicamentos sin categoría.');
            $categoriaId = null;
        } else {
            $categoriaId = $categorias->random()->id;
        }

        // Array de medicamentos de ejemplo
        $medicamentos = [
            [
                'codigo_barras' => '7501234567890',
                'nombre_comercial' => 'Paracetamol',
                'nombre_generico' => 'Acetaminofén',
                'fabricante' => 'Genomma Lab',
                'presentacion' => 'Tabletas',
                'concentracion' => '500 mg',
                'categoria_id' => $categoriaId,
                'stock_actual' => 100,
                'stock_minimo' => 20,
                'precio_compra' => 5.50,
                'precio_venta' => 8.00,
                'fecha_caducidad' => now()->addYears(2)->format('Y-m-d'),
                'estado' => 'activo'
            ],
            [
                'codigo_barras' => '7501234567891',
                'nombre_comercial' => 'Ibuprofeno',
                'nombre_generico' => 'Ibuprofeno',
                'fabricante' => 'Chinoin',
                'presentacion' => 'Cápsulas',
                'concentracion' => '400 mg',
                'categoria_id' => $categoriaId,
                'stock_actual' => 80,
                'stock_minimo' => 15,
                'precio_compra' => 6.20,
                'precio_venta' => 9.50,
                'fecha_caducidad' => now()->addYears(3)->format('Y-m-d'),
                'estado' => 'activo'
            ],
            [
                'codigo_barras' => '7501234567892',
                'nombre_comercial' => 'Amoxicilina',
                'nombre_generico' => 'Amoxicilina',
                'fabricante' => 'Pfizer',
                'presentacion' => 'Cápsulas',
                'concentracion' => '500 mg',
                'categoria_id' => $categoriaId,
                'stock_actual' => 50,
                'stock_minimo' => 10,
                'precio_compra' => 12.50,
                'precio_venta' => 18.00,
                'fecha_caducidad' => now()->addYears(1)->format('Y-m-d'),
                'estado' => 'activo'
            ]
        ];

        // Insertar medicamentos
        foreach ($medicamentos as $medicamento) {
            Medicamento::create($medicamento);
        }

        $this->command->info('Medicamentos creados exitosamente!');
    }
}
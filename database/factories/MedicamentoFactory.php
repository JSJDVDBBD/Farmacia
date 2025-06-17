<?php

namespace Database\Factories;

use App\Models\Medicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicamentoFactory extends Factory
{
    protected $model = Medicamento::class;

    public function definition()
    {
        return [
            'codigo_barras' => $this->faker->ean13(),
            'nombre_comercial' => $this->faker->word(),
            'nombre_generico' => $this->faker->word(),
            'fabricante' => $this->faker->company,
            'presentacion' => $this->faker->randomElement(['Tableta', 'Jarabe', 'Ampolla']),
            'concentracion' => $this->faker->randomElement(['500mg', '250mg', '1g']),
            'stock_actual' => rand(1, 50),
            'stock_minimo' => rand(5, 15),
            'precio_compra' => $this->faker->randomFloat(2, 5, 30),
            'precio_venta' => $this->faker->randomFloat(2, 30, 70),
            'fecha_caducidad' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
            'lote' => 'L' . rand(100, 999),
            'ubicacion' => 'Estante ' . rand(1, 5),
            'imagen' => null,
            'estado' => 'activo',
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['Analgésicos', 'Antibióticos', 'Antiinflamatorios', 'Antigripales', 'Antipiréticos'];

        foreach ($categorias as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'description' => 'Categoría de ' . strtolower($nombre)
            ]);
        }
    }
}
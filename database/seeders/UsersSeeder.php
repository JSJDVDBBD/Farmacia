<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si el usuario admin ya existe
        if (!User::where('email', 'admin@farmacia.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@farmacia.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'telefono' => '7710000000'
            ]);
            $this->command->info('Usuario administrador creado!');
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Senha padrão
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Customer',
            'surname' => 'User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'), // Senha padrão
            'type' => 'customer',
        ]);
    }
}

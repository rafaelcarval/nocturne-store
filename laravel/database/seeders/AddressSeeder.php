<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'customer@example.com')->first();

        Address::create([
            'user_id' => $user->id,
            'cep' => '01001-000',
            'street' => 'Praça da Sé',
            'number' => '123',
            'neighborhood' => 'Centro',
            'city' => 'São Paulo',
            'state' => 'SP',
            'is_default' => true,
        ]);

        Address::create([
            'user_id' => $user->id,
            'cep' => '02011-000',
            'street' => 'Avenida Paulista',
            'number' => '456',
            'neighborhood' => 'Bela Vista',
            'city' => 'São Paulo',
            'state' => 'SP',
            'is_default' => false,
        ]);
    }
}

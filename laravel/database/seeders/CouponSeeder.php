<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [];

        for ($i = 0; $i < 30; $i++) {
            $coupons[] = [
                'code' => strtoupper(Str::random(8)), // Código aleatório
                'discount' => rand(10, 50), // Desconto entre R$ 10 e R$ 50
                'type' => rand(0, 1) ? 'fixed' : 'percentage', // Tipo aleatório
                'quantity' => rand(1, 10), // Quantidade permitida entre 1 e 10
                'used' => 0, // Inicialmente, nenhum cupom foi usado
                'expires_at' => now()->addDays(rand(10, 30)), // Data de expiração entre 10 e 30 dias
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('coupons')->insert($coupons);
    }
}

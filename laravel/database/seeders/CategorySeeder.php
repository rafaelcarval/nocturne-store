<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Camisetas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blusas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Camisas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tênis', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bermudas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Calças', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bonés', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exemplo de como rodar outros seeders manualmente
        $this->call([
            UserSeeder::class,
            AddressSeeder::class,
            CategorySeeder::class,
            CouponSeeder::class,
            ProductsSeeder::class,
            ProductImageSeeder::class,
            SalesTableSeeder::class,
        ]);
    }
}

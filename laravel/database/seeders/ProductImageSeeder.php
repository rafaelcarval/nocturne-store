<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $productImages = [];

        for ($i = 1; $i <= 30; $i++) {
            // Cada produto terá entre 1 e 3 imagens
            for ($j = 1; $j <= rand(1, 3); $j++) {
                $productImages[] = [
                    'product_id' => $i,
                    'image_path' => 'images/products/product_' . $i . '_image_' . $j . '.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('product_images')->insert($productImages);
    }
}

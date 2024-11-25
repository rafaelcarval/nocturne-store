<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Camisa Xadrez',
                'description' => 'Camisa xadrez clássica e confortável.',
                'price' => 34.90,
                'stock' => 18,
                'sizes' => 'P,M,G,GG',
                'type' => 'Thrift Store',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Camiseta Básica',
                'description' => 'Camiseta confortável e estilosa.',
                'price' => 49.90,
                'stock' => 50,
                'sizes' => 'P,M,G,GG',
                'type' => 'Store',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tênis Esportivo',
                'description' => 'Tênis perfeito para atividades físicas.',
                'price' => 199.90,
                'stock' => 30,
                'sizes' => '39,40,41,42',
                'type' => 'Store',
                'category_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jaqueta Jeans',
                'description' => 'Jaqueta estilosa para qualquer ocasião.',
                'price' => 79.90,
                'stock' => 15,
                'sizes' => 'P,M,G',
                'type' => 'Thrift Store',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Adicione mais produtos aqui...
        ];

        // Adiciona produtos adicionais para completar os 30
        for ($i = 5; $i <= 30; $i++) {
            $sizes = $i % 2 == 0 ? 'P,M,G,GG' : '39,40,41,42';
            $products[] = [
                'name' => 'Produto ' . $i,
                'description' => 'Descrição do Produto ' . $i,
                'price' => rand(30, 200) + 0.90,
                'stock' => rand(10, 50),
                'sizes' => $sizes,
                'type' => $i % 2 == 0 ? 'Store' : 'Thrift Store',
                'category_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}

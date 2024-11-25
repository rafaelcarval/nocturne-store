<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTableSeeder extends Seeder
{
    public function run()
    {
        // IDs de exemplo para clientes e produtos (garantir que existem no banco)
        $userIds = DB::table('users')->pluck('id')->toArray(); // Pega todos os IDs de clientes existentes
        $productIds = DB::table('products')->pluck('id')->toArray(); // Pega todos os IDs de produtos existentes

        if (empty($userIds) || empty($productIds)) {
            $this->command->warn('Nenhum cliente ou produto encontrado no banco de dados. Verifique os seeders.');
            return;
        }

        // Criar 10 vendas
        for ($i = 1; $i <= 10; $i++) {
            // Seleciona um cliente aleatório
            $userId = $userIds[array_rand($userIds)];

            // Insere a venda na tabela `sales`
            $saleId = DB::table('sales')->insertGetId([
                'user_id' => $userId,
                'total' => 0, // Total será calculado depois
                'status' => 'Pago',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Adiciona itens à venda
            $numItems = rand(1, 5); // Cada venda terá de 1 a 5 itens
            $total = 0;

            for ($j = 1; $j <= $numItems; $j++) {
                $productId = $productIds[array_rand($productIds)]; // Seleciona um produto aleatório
                $product = DB::table('products')->find($productId);

                if (!$product) {
                    $this->command->warn("Produto com ID $productId não encontrado. Ignorando item.");
                    continue;
                }

                $quantity = rand(1, 3); // Quantidade aleatória de 1 a 3
                $subtotal = $product->price * $quantity;

                // Insere o item na tabela `sale_items`
                DB::table('sale_items')->insert([
                    'sale_id' => $saleId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $total += $subtotal;
            }

            // Atualiza o total da venda
            DB::table('sales')->where('id', $saleId)->update(['total' => $total]);
        }
    }
}


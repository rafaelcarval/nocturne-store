<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade'); // Relaciona com vendas
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relaciona com produtos
            $table->string('size')->nullable(); // Tamanho do produto
            $table->integer('quantity')->default(1); // Valor padrão para quantidade
            $table->decimal('price', 10, 2); // Torne obrigatório (sem default)
            $table->decimal('subtotal', 10, 2); // Subtotal por item (quantidade * preço)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};

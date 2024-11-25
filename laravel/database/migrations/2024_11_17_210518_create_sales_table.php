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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2); // Total geral da venda
            $table->decimal('freight', 10, 2)->default(0); // Valor do frete
            $table->string('coupon')->nullable(); // Código do cupom usado
            $table->decimal('discount', 10, 2)->default(0); // Valor de desconto aplicado
            $table->enum('status', ['Pendente', 'Pago', 'Cancelado', 'Em Transporte', 'Entregue'])->default('Pendente');
            $table->enum('payment_method', ['Cartão', 'Boleto', 'Pix', 'Dinheiro'])->nullable();
            $table->date('delivery_date')->nullable(); // Data de entrega prevista
            $table->text('notes')->nullable(); // Observações adicionais
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

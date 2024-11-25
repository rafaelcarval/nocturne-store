<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount', 8, 2); // Desconto em reais ou porcentagem
            $table->enum('type', ['fixed', 'percentage']); // Tipo: fixo ou percentual
            $table->integer('quantity'); // Quantidade permitida
            $table->integer('used')->default(0); // Quantidade usada
            $table->date('expires_at')->nullable(); // Data de expiração
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('coupons');
    }
};

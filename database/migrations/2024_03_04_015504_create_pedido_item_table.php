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
        Schema::create('pedido_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('products', 'produto_id');
            $table->foreignId('pedido_id')->constrained('pedidos', 'pedido_id');
            $table->integer('qtd_pedida');
            $table->integer('qtd_atendida');
            $table->integer('tipo_desconto')->nullable();
            $table->double('valor_desconto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_item');
    }
};

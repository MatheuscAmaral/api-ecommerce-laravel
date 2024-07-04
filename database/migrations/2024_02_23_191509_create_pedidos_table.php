<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('pedido_id');
            $table->double('total');
            $table->double('descontos');
            $table->foreignId('cliente_id')->constrained('users', 'id');
            $table->double('valor_frete');
            $table->integer('formapag_id');
            $table->integer('cep');
            $table->string('rua');
            $table->string('cidade');
            $table->string('uf');
            $table->string('numero');
            $table->string('bairro');
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};

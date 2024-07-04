<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('produto_id');
            $table->string('image');
            $table->string('title');
            $table->double('price');
            $table->double('size');
            $table->string('category');
            $table->string('flavor');
            $table->string('type_pack');
            $table->integer('stock');
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

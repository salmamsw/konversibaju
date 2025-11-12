<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('konversi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('stock_products')->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('stock_attributes')->onDelete('cascade');
            $table->integer('jumlah_dibutuhkan'); // per 1 produk
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('konversi');
    }
};
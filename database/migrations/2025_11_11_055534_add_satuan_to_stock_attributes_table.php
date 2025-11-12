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
        Schema::table('stock_attributes', function (Blueprint $table) {
            $table->string('satuan')->default('unit')->after('nama_bahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_attributes', function (Blueprint $table) {
            $table->dropColumn('satuan');
        });
    }
};
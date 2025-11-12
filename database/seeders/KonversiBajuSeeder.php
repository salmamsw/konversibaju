<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockProduct;
use App\Models\StockAttribute;
use Illuminate\Support\Facades\DB;

class KonversiBajuSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        DB::table('stock_products')->delete();
        DB::table('stock_attributes')->delete();

        // === BAHAN (Atribut) ===
        $bahanList = [
            ['nama_bahan' => 'Kain Lexus', 'stok' => 300, 'satuan' => 'meter'],
            ['nama_bahan' => 'Kain Satin', 'stok' => 250, 'satuan' => 'meter'],
            ['nama_bahan' => 'Kain Crepe', 'stok' => 220, 'satuan' => 'meter'],
            ['nama_bahan' => 'Kain Maxmara', 'stok' => 200, 'satuan' => 'meter'],
            ['nama_bahan' => 'Renda Bordir', 'stok' => 120, 'satuan' => 'meter'],
            ['nama_bahan' => 'Resleting', 'stok' => 100, 'satuan' => 'pcs'],
            ['nama_bahan' => 'Benang Jahit', 'stok' => 300, 'satuan' => 'gulung'],
            ['nama_bahan' => 'Kancing Hias', 'stok' => 180, 'satuan' => 'buah'],
            ['nama_bahan' => 'Karet Pinggang', 'stok' => 130, 'satuan' => 'meter'],
            ['nama_bahan' => 'Label', 'stok' => 400, 'satuan' => 'pcs'],
            ['nama_bahan' => 'Plastik Packing', 'stok' => 400, 'satuan' => 'pcs'],
            ['nama_bahan' => 'Ongkir', 'stok' => 9999, 'satuan' => 'layanan']
        ];

        foreach ($bahanList as $bahan) {
            StockAttribute::create($bahan);
        }

        // === PRODUK ===
        StockProduct::create(['nama_produk' => 'Abaya Premium', 'stok' => 0]);
        StockProduct::create(['nama_produk' => 'Abaya Modern', 'stok' => 0]);
        StockProduct::create(['nama_produk' => 'Abaya Kaftan', 'stok' => 0]);
        StockProduct::create(['nama_produk' => 'Abaya Klasik', 'stok' => 0]);
    }
}
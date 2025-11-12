<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    protected $table = 'stock_products';

    protected $fillable = ['nama_produk', 'stok'];

    public function konversi()
    {
        return $this->hasMany(Konversi::class, 'produk_id');
    }
}
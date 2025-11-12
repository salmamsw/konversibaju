<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAttribute extends Model
{
    protected $table = 'stock_attributes';

    protected $fillable = ['nama_bahan', 'stok', 'satuan'];
}
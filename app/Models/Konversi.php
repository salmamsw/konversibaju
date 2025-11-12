<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konversi extends Model
{
    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'konversi';

    /**
     * Atribut yang dapat diisi (mass assignable).
     *
     * @var array
     */
    protected $fillable = ['produk_id', 'bahan_id', 'jumlah_dibutuhkan'];

    /**
     * Relasi ke model StockProduct (banyak ke satu).
     */
    public function produk()
    {
        return $this->belongsTo(StockProduct::class, 'produk_id');
    }

    /**
     * Relasi ke model StockAttribute (banyak ke satu).
     */
    public function bahan()
    {
        return $this->belongsTo(StockAttribute::class, 'bahan_id');
    }
}
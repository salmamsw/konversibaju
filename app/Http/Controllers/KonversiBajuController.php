<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockProduct;
use App\Models\StockAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KonversiBajuController extends Controller
{
    public function index()
    {
        $products = StockProduct::all();
        $bahanList = StockAttribute::all();
        return view('welcome', compact('products', 'bahanList'));
    }

    public function konversi(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:stock_products,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $produk = StockProduct::findOrFail($request->produk_id);
        $jumlah = $request->jumlah;
        $inputAtribut = $request->input('atribut', []);

        // Validasi stok cukup
        foreach ($inputAtribut as $bahanId => $jumlahPerUnit) {
            if ($jumlahPerUnit > 0) {
                $bahan = StockAttribute::findOrFail($bahanId);
                $totalButuh = $jumlahPerUnit * $jumlah;
                if ($bahan->stok < $totalButuh) {
                    return back()->withErrors([
                        'error' => "Stok bahan '{$bahan->nama_bahan}' tidak cukup! Butuh: {$totalButuh}, Tersedia: {$bahan->stok}"
                    ]);
                }
            }
        }

        // Proses konversi manual
        DB::beginTransaction();
        try {
            foreach ($inputAtribut as $bahanId => $jumlahPerUnit) {
                if ($jumlahPerUnit > 0) {
                    $bahan = StockAttribute::findOrFail($bahanId);
                    $bahan->decrement('stok', $jumlahPerUnit * $jumlah);
                }
            }
            $produk->increment('stok', $jumlah);
            DB::commit();

            return back()->with('success', "Berhasil membuat {$jumlah} unit {$produk->nama_produk}.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memproses konversi.']);
        }
    }

    // =============== PRODUK ===============

    public function storeProduk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255|unique:stock_products,nama_produk',
            'stok_awal' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['error' => $validator->errors()->first()]);
        }

        StockProduct::create([
            'nama_produk' => $request->nama_produk,
            'stok' => $request->stok_awal ?? 0
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:stock_products,nama_produk,' . $id,
            'stok' => 'required|integer|min:0'
        ]);

        $produk = StockProduct::findOrFail($id);
        $produk->update($request->only('nama_produk', 'stok'));

        return back()->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduk($id)
    {
        StockProduct::destroy($id);
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    // =============== ATRIBUT ===============

    public function storeBahan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bahan' => 'required|string|max:255|unique:stock_attributes,nama_bahan',
            'stok_awal' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['error' => $validator->errors()->first()]);
        }

        StockAttribute::create([
            'nama_bahan' => $request->nama_bahan,
            'stok' => $request->stok_awal ?? 0
        ]);

        return back()->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function updateBahan(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255|unique:stock_attributes,nama_bahan,' . $id,
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50'
        ]);

        $bahan = StockAttribute::findOrFail($id);
        $bahan->update($request->only('nama_bahan', 'stok', 'satuan'));

        return back()->with('success', 'Atribut berhasil diperbarui.');
    }

    public function destroyBahan($id)
    {
        StockAttribute::destroy($id);
        return back()->with('success', 'Atribut berhasil dihapus.');
    }
}
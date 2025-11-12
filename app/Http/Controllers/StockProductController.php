<?php

namespace App\Http\Controllers;
use App\Models\StockProduct;
use Illuminate\Http\Request;

class StockProductController extends Controller
{
    public function index()
    {
        return StockProduct::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0'
        ]);

        return StockProduct::create($request->only('nama_produk', 'stok'));
    }

    public function show($id)
    {
        return StockProduct::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $product = StockProduct::findOrFail($id);
        $request->validate([
            'nama_produk' => 'sometimes|string|max:255',
            'stok' => 'sometimes|integer|min:0'
        ]);

        $product->update($request->only('nama_produk', 'stok'));
        return $product;
    }

    public function destroy($id)
    {
        $product = StockProduct::findOrFail($id);
        $product->delete();
        return response()->noContent();
    }
}
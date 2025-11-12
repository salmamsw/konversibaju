<?php

namespace App\Http\Controllers;

use App\Models\StockAttribute;
use Illuminate\Http\Request;

class StockAttributeController extends Controller
{
    public function index()
    {
        return StockAttribute::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'stok' => 'required|integer|min:0'
        ]);

        return StockAttribute::create($request->only('nama_bahan', 'stok'));
    }

    public function show($id)
    {
        return StockAttribute::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $attribute = StockAttribute::findOrFail($id);
        $request->validate([
            'nama_bahan' => 'sometimes|string|max:255',
            'stok' => 'sometimes|integer|min:0'
        ]);

        $attribute->update($request->only('nama_bahan', 'stok'));
        return $attribute;
    }

    public function destroy($id)
    {
        $attribute = StockAttribute::findOrFail($id);
        $attribute->delete();
        return response()->noContent();
    }
}
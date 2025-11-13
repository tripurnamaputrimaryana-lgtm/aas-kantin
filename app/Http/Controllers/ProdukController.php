<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return Produk::with('kategori')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'kategori_id' => 'required|exists:kategori,id'
        ]);
        return Produk::create($request->all());
    }

    public function show($id)
    {
        return Produk::with('kategori')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->update($request->all());
        return $produk;
    }

    public function destroy($id)
    {
        return Produk::destroy($id);
    }
}

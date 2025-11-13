<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return Transaksi::with('detail.produk')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|unique:transaksi,kode_transaksi',
            'produk' => 'required|array'
        ]);

        $transaksi = Transaksi::create([
            'kode_transaksi' => $request->kode_transaksi,
            'tanggal' => now(),
            'total' => 0
        ]);

        $total = 0;
        foreach ($request->produk as $item) {
            $produk = Produk::findOrFail($item['produk_id']);
            $subtotal = $produk->harga * $item['jumlah'];
            $total += $subtotal;

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $produk->id,
                'jumlah' => $item['jumlah'],
                'subtotal' => $subtotal
            ]);

            // update stok produk
            $produk->decrement('stok', $item['jumlah']);
        }

        $transaksi->update(['total' => $total]);
        return $transaksi->load('detail.produk');
    }

    public function show($id)
    {
        return Transaksi::with('detail.produk')->findOrFail($id);
    }

    public function destroy($id)
    {
        return Transaksi::destroy($id);
    }
}

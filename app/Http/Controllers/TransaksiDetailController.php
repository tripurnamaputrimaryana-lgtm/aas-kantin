<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class TransaksiDetailController extends Controller
{
    public function index()
    {
        return DetailTransaksi::with(['transaksi','produk'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer',
            'subtotal' => 'required|numeric'
        ]);
        return DetailTransaksi::create($request->all());
    }

    public function show($id)
    {
        return DetailTransaksi::with(['transaksi','produk'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $detail = DetailTransaksi::findOrFail($id);
        $detail->update($request->all());
        return $detail;
    }

    public function destroy($id)
    {
        return DetailTransaksi::destroy($id);
    }
}

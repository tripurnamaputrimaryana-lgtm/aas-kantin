<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Produk;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('details.produk')->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $produk = Produk::all();
        return view('transaksi.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'           => 'required|date',
            'metode_pembayaran' => 'required|in:cash,debit',
            'bayar'             => 'required|numeric|min:0',
        ]);

        // Hitung total
        $total = 0;
        $produkIds = $request->produk_id ?? [];
        $jumlahArr = $request->jumlah ?? [];

        foreach ($produkIds as $index => $id) {
            $produk = Produk::findOrFail($id);
            $jumlah = isset($jumlahArr[$index]) ? (int)$jumlahArr[$index] : 1;
            $subtotal = $produk->harga * $jumlah;
            $total += $subtotal;
        }

        $bayar = (int)$request->bayar;
        $kembalian = $bayar - $total;

        // Validasi sesuai metode
        if ($request->metode_pembayaran === 'debit') {
            if ($bayar !== $total) {
                return back()->withErrors(['bayar' => 'Nominal bayar untuk debit harus sama dengan total transaksi.'])->withInput();
            }
            $kembalian = 0;
        } else if ($request->metode_pembayaran === 'cash') {
            if ($bayar < $total) {
                return back()->withErrors(['bayar' => 'Nominal bayar cash tidak boleh kurang dari total transaksi.'])->withInput();
            }
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi'    => $request->kode_transaksi,
            'tanggal'           => $request->tanggal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bayar'             => $bayar,
            'total'             => $total,
            'kembalian'         => $kembalian,
        ]);

        // Simpan detail
        foreach ($produkIds as $index => $id) {
            $produk = Produk::findOrFail($id);
            $jumlah = isset($jumlahArr[$index]) ? (int)$jumlahArr[$index] : 1;
            $subtotal = $produk->harga * $jumlah;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $id,
                'jumlah'       => $jumlah,
                'subtotal'     => $subtotal,
            ]);
        }

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil disimpan. Kembalian: Rp ' . number_format($kembalian,0,',','.'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'tanggal'           => 'required|date',
            'metode_pembayaran' => 'required|in:cash,debit',
            'bayar'             => 'required|numeric|min:0',
        ]);

        $bayar = (int)$request->bayar;
        $total = $transaksi->total;
        $kembalian = $bayar - $total;

        if ($request->metode_pembayaran === 'debit') {
            if ($bayar !== $total) {
                return back()->withErrors(['bayar' => 'Nominal bayar untuk debit harus sama dengan total transaksi.'])->withInput();
            }
            $kembalian = 0;
        } else if ($request->metode_pembayaran === 'cash') {
            if ($bayar < $total) {
                return back()->withErrors(['bayar' => 'Nominal bayar cash tidak boleh kurang dari total transaksi.'])->withInput();
            }
        }

        $transaksi->update([
            'tanggal'           => $request->tanggal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bayar'             => $bayar,
            'kembalian'         => $kembalian,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->details()->delete();
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}

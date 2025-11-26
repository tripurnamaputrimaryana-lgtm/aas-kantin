<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Tampilkan semua transaksi
    public function index()
    {
        $transaksi = Transaksi::with('details.produk')->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    // Form tambah transaksi
    public function create()
    {
        $produk = Produk::all();
        return view('transaksi.create', compact('produk'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        $total = 0;

        // Hitung total transaksi
        foreach ($request->produk_id as $index => $produk_id) {
            $jumlah = $request->jumlah[$index];
            $produk = Produk::find($produk_id);
            $total += $produk->harga * $jumlah;
        }

        // Hitung kembalian otomatis
        $kembalian = $request->bayar - $total;
        if ($kembalian < 0) {
            $kembalian = 0;
        }

        // Simpan transaksi
        $transaksi = Transaksi::create([
            'kode_transaksi'    => $request->kode_transaksi,
            'tanggal'           => $request->tanggal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bayar'             => $request->bayar,
            'total'             => $total,
            'kembalian'         => $kembalian,
        ]);

        foreach ($request->produk_id as $index => $produk_id) {
            $jumlah   = $request->jumlah[$index];
            $produk   = Produk::find($produk_id);
            $subtotal = $produk->harga * $jumlah;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $produk_id,
                'jumlah'       => $jumlah,
                'subtotal'     => $subtotal,
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);
        $produk    = Produk::all();
        return view('transaksi.edit', compact('transaksi', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->details()->delete();

        $total = 0;
        foreach ($request->produk_id as $index => $produk_id) {
            $jumlah   = $request->jumlah[$index];
            $produk   = Produk::find($produk_id);
            $subtotal = $produk->harga * $jumlah;

            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $produk_id,
                'jumlah'       => $jumlah,
                'subtotal'     => $subtotal,
            ]);

            $total += $subtotal;
        }

        $kembalian = $request->bayar - $total;
        if ($kembalian > 0) {
            $kembalian = 0;
        }

        // Update transaksi
        $transaksi->update([
            'tanggal'           => $request->tanggal,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bayar'             => $request->bayar,
            'total'             => $total,
            'kembalian'         => $kembalian,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function show($id)
    {
        $transaksi = Transaksi::with('details.produk')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->details()->delete();
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}

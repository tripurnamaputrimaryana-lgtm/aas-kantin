@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="fw-bold text-primary mb-4">Tambah Transaksi</h2>

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label text-primary">Kode Transaksi</label>
            <input type="text" name="kode_transaksi" class="form-control" value="TRX{{ time() }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label text-primary">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <h5 class="fw-bold text-primary mt-4">Detail Produk</h5>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Pilih</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produk as $p)
                <tr>
                    <td><input type="checkbox" name="produk_id[]" value="{{ $p->id }}"></td>
                    <td>{{ $p->nama_produk }}</td>
                    <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                    <td><input type="number" name="jumlah[]" class="form-control" min="1" value="1"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mb-3">
            <label class="form-label text-primary">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required>
                <option value="cash">Cash</option>
                <option value="debit">Debit</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label text-primary">Nominal Bayar</label>
            <input type="number" name="bayar" class="form-control" placeholder="Masukkan nominal bayar" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-primary">Password (hanya untuk debit)</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password debit">
        </div>

        @if(session('kembalian'))
        <div class="mb-3">
            <label class="form-label text-primary">Kembalian</label>
            <input type="text" class="form-control" value="Rp {{ number_format(session('kembalian'),0,',','.') }}" readonly>
        </div>
        @endif

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
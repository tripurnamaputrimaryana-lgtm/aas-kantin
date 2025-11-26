@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Detail Transaksi</h2>
    </div>
        <div class="card-body">
            <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($transaksi->total,0,',','.') }}</p>

            <h5 class="fw-bold text-primary mt-4">Detail Produk</h5>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->details as $d)
                    <tr>
                        <td>{{ $d->produk->nama_produk }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp {{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

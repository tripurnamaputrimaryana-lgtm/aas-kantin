@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Detail Produk</h2>
    </div>
        <div class="card-body">
            <p><strong>Nama Produk:</strong> {{ $produk->nama_produk }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($produk->harga,0,',','.') }}</p>
            <p><strong>Stok:</strong> {{ $produk->stok }}</p>
            <p><strong>Kategori:</strong> {{ $produk->kategori->nama_kategori }}</p>

            <a href="{{ route('produk.index') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

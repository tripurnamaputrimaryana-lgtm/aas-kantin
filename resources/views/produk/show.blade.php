@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold">
            Detail Produk
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

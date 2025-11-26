@extends('layouts.dashboard')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary">Detail Kategori Produk</h2>
        </a>
    </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $kategori->id }}</p>
            <p><strong>Nama Kategori:</strong> {{ $kategori->nama_kategori }}</p>

            <a href="{{ route('kategori.index') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-pencil-square"></i> Kembali
                </a>
        </div>
    </div>
</div>
@endsection
